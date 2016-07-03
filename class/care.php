<?php
/**
 * ****************************************************************************
 * XOOPSCARE - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 * ****************************************************************************
 */

defined('XOOPS_ROOT_PATH') || die('XOOPS root path not defined');

require_once XOOPS_ROOT_PATH . '/modules/xoopscare/admin/functions.php';

/**
 * Class XoopsCare
 */
class XoopsCare
{
    public $force;
    public $db;
    public $log;
    public $logfile;
    public $logdata;

    /**
     * XoopsCare constructor.
     * @param bool $force
     */
    public function __construct($force = false)
    {
        global $xoopsDB;
        $this->db    = $xoopsDB;
        $this->force = $force;
        if (xoops_trim(xoopscare_getmoduleoption('logfile')) != '') {
            $this->log     = true;
            $this->logfile = xoopscare_getmoduleoption('logfile');
            $this->logdata = array();
        } else {
            $this->log = false;
        }
    }

    /**
     * @param $data
     */
    public function addLog($data)
    {
        $this->logdata[] = formatTimestamp(time()) . ' - ' . $data;
    }

    public function cleanLog()
    {
        $this->logdata = array();
    }

    public function saveLog()
    {
        if (function_exists('file_put_contents')) {
            if (!file_exists($this->logfile)) {
                file_put_contents($this->logfile, '<?php exit(); ?>' . "\n");
            }
            file_put_contents($this->logfile, implode("\n", $this->logdata) . "\n", FILE_APPEND);
        } else {
            $fp = null;
            if (!file_exists($this->logfile)) {
                $fp = fopen($this->logfile, 'a+');
                if ($fp) {
                    fwrite($fp, '<?php exit(); ?>' . "\n");
                }
            } else {
                $fp = fopen($this->logfile, 'a+');
            }
            if ($fp) {
                fwrite($fp, implode("\n", $this->logdata) . "\n");
                fclose($fp);
            }
        }
    }

    /**
     * @param $result
     */
    public function _fetchLogResult(&$result)
    {
        while ($myrow = $this->db->fetchArray($result)) {
            $this->addLog($myrow['Table'] . ' - ' . $myrow['Op'] . ' - ' . $myrow['Msg_type'] . ' - ' . $myrow['Msg_text']);
        }
    }

    public function RunAll()
    {
        $this->ClearComments();
        $this->ClearSessions();
        $this->ClearCache();
        $this->RunPhp();
        $this->RunQueries();
        $this->DbMaintain();
    }

    public function ClearComments()
    {
        global $xoopsConfig;
        $every     = xoopscare_getmoduleoption('spamcomnt');
        $last_time = xoopscare_getmoduleoption('spamcomnt_l');
        if ($this->force || (($every > 0) && ((time() - $last_time) > ($every * 86400)))) {
            if (file_exists(XOOPS_ROOT_PATH . '/modules/xoopscare/language/' . $xoopsConfig['language'] . '/admin.php')) {
                require_once XOOPS_ROOT_PATH . '/modules/xoopscare/language/' . $xoopsConfig['language'] . '/admin.php';
            } else {
                require_once XOOPS_ROOT_PATH . '/modules/xoopscare/language/english/admin.php';
            }
            require_once XOOPS_ROOT_PATH . '/modules/xoopscare/class/xc_comment.php';
            $h_xc_comment = &xoops_getModuleHandler('XoopsComment', 'xoopscare');
            xc_set_module_option('spamcomnt_l', time(), true);
            if ($this->log) {
                $this->addLog('** ' . _AM_XC_SPAM_CMT . ' **');
            }
            $comment_handler = xoops_getHandler('comment');
            $stop_spammers   = xoopscare_getmoduleoption('blockspammers');

            $config_handler = xoops_getHandler('config');
            $censorConf     =& $config_handler->getConfigsByCat(XOOPS_CONF_CENSOR);
            $replacement    = $censorConf['censor_replace'];
            if ($stop_spammers) {
                $sql         = 'SELECT Distinct(com_ip) FROM ' . $this->db->prefix('xoopscomments') . " WHERE com_title LIKE '%" . $replacement . "%' OR com_text LIKE '%" . $replacement . "%'";
                $result      = $this->db->queryF($sql);
                $spammers_ip = array();
                while ($myrow = $this->db->fetchArray($result)) {
                    $spammers_ip[] = $myrow['com_ip'];
                }
                // Code "stolen" to GIJOE ;-)
                $rs = $this->db->query('SELECT conf_value FROM ' . $this->db->prefix('config') . " WHERE conf_name='bad_ips' AND conf_modid=0 AND conf_catid=1");
                list($bad_ips_serialized) = $this->db->fetchRow($rs);
                $bad_ips = unserialize($bad_ips_serialized);
                foreach ($spammers_ip as $item) {
                    $bad_ips[] = $item;
                    if ($this->log) {
                        $this->addLog(_AM_XC_BANNED_IP . $item);
                    }
                }
                $conf_value = addslashes(serialize(array_unique($bad_ips)));
                $this->db->queryF('UPDATE ' . $this->db->prefix('config') . " SET conf_value='$conf_value' WHERE conf_name='bad_ips' AND conf_modid=0 AND conf_catid=1");
            }

            if (xoopscare_getmoduleoption('spamstate') != 1) {    // If we don't keep spammed comments
                require_once XOOPS_ROOT_PATH . '/include/comment_constants.php';
                $criteria = new CriteriaCompo();
                $criteria->add(new Criteria('com_title', '%' . $replacement . '%', 'LIKE'));
                $criteria->add(new Criteria('com_text', '%' . $replacement . '%', 'LIKE'), 'OR');
                $tbl_comments = array();
                $tbl_comments = $comment_handler->getObjects($criteria);
                foreach ($tbl_comments as $item) {
                    switch (xoopscare_getmoduleoption('spamstate')) {
                        case 2:    // Unpublish
                            $item->setVar('com_status', XOOPS_COMMENT_PENDING);
                            $h_xc_comment->insert($item);
                            if ($this->log) {
                                $this->addLog(_AM_XC_SPAM_CMT . ' ' . _AM_XC_SPMSTATE_2 . ' - ' . _POSTEDBY . ' ' . $item->getVar('com_uid') . ' ' . $item->getVar('com_title') . ' -> ' . $item->getVar('com_text'));
                            }
                            break;
                        case 3: // Hide
                            $item->setVar('com_status', XOOPS_COMMENT_HIDDEN);
                            $h_xc_comment->insert($item);
                            if ($this->log) {
                                $this->addLog(_AM_XC_SPAM_CMT . ' ' . _AM_XC_SPMSTATE_3 . ' - ' . _POSTEDBY . ' ' . $item->getVar('com_uid') . ' ' . $item->getVar('com_title') . ' -> ' . $item->getVar('com_text'));
                            }
                            break;
                        case 4:    // Delete
                            if ($this->log) {
                                $this->addLog(_AM_XC_SPAM_CMT . ' ' . _AM_XC_SPMSTATE_4 . ' - ' . _POSTEDBY . ' ' . $item->getVar('com_uid') . ' ' . $item->getVar('com_title') . ' -> ' . $item->getVar('com_text'));
                            }
                            $h_xc_comment->delete($item);
                            break;
                    }
                }
            }
            if ($this->log) {
                $this->saveLog();
                $this->cleanLog();
            }
        }
    }

    public function ClearSessions()
    {
        $every     = xoopscare_getmoduleoption('templatesc');
        $last_time = xoopscare_getmoduleoption('templatesc_l');
        if ($this->force || (($every > 0) && ((time() - $last_time) > ($every * 86400)))) {
            xc_set_module_option('templatesc_l', time(), true);
            if ($this->log) {
                $this->addLog('** ' . _AM_XC_SESSIONS . ' **');
                $this->saveLog();
            }
            $result = $this->db->queryF('TRUNCATE TABLE ' . $this->db->prefix('session'));
        }
        $this->cleanLog();
    }

    public function cleanFastestCacheHack()
    {
        if (defined('XOOPS_TRUST_PATH')) {
            $path = XOOPS_TRUST_PATH . '/fullcache/';
            if (is_dir($path)) {
                $files = glob($path . '*');
                foreach ($files as $filename) {
                    if (basename(strtolower($filename)) !== 'result') {
                        unlink($filename);
                    }
                }
            }
        }
    }

    /**
     * Is Xoops 2.3.x ?
     *
     * @return boolean
     */
    public function isX23()
    {
        $x23 = false;
        $xv  = str_replace('XOOPS ', '', XOOPS_VERSION);
        if ((int)substr($xv, 2, 1) >= 3) {
            $x23 = true;
        }

        return $x23;
    }

    public function ClearCache()
    {
        $every     = xoopscare_getmoduleoption('templatesc');
        $last_time = xoopscare_getmoduleoption('templatesc_l');
        if ($this->force || (($every > 0) && ((time() - $last_time) > ($every * 86400)))) {
            xc_set_module_option('templatesc_l', time(), true);
            if ($this->log) {
                $this->addLog('** ' . _AM_XC_CACHE_TPL . ' **');
                $this->saveLog();
            }
            if (function_exists('glob')) {
                if ($this->isX23()) {
                    require XOOPS_ROOT_PATH . '/class/template.php';
                    $myXoTpl           = new XoopsTpl();
                    $templates_cFolder = $myXoTpl->cache_dir;
                    $cacheFolder       = $myXoTpl->compile_dir;
                    unset($myXoTpl);
                } else {
                    $templates_cFolder = XOOPS_COMPILE_PATH;
                    $cacheFolder       = XOOPS_CACHE_PATH;
                }
                $files = glob($templates_cFolder . '/*.*');
                foreach ($files as $filename) {
                    if (basename(strtolower($filename)) !== 'index.html') {
                        unlink($filename);
                    }
                }
                $files = glob($cacheFolder . '/*.*');
                foreach ($files as $filename) {
                    if (basename(strtolower($filename)) !== 'index.html' && basename(strtolower($filename)) !== 'adminmenu.php') {
                        unlink($filename);
                    }
                }
            }
            $this->cleanFastestCacheHack();
        }
        $this->cleanLog();
    }

    public function RunPhp()
    {
        $every     = xoopscare_getmoduleoption('phpcode');
        $last_time = xoopscare_getmoduleoption('phpcode_l');
        if ($this->force || (($every > 0) && ((time() - $last_time) > ($every * 86400)))) {
            xc_set_module_option('phpcode_l', time(), true);
            if ($this->log) {
                $this->addLog('** ' . _AM_XC_PHP . ' **');
                $this->addLog(xoopscare_getmoduleoption('phpscript'));
                $this->saveLog();
            }
            // And do the job
            eval(xoopscare_getmoduleoption('phpscript'));
        }
        $this->cleanLog();
    }

    public function RunQueries()
    {
        $every     = xoopscare_getmoduleoption('queries');
        $last_time = xoopscare_getmoduleoption('queries_l');
        if ($this->force || (($every > 0) && ((time() - $last_time) > ($every * 86400)))) {
            xc_set_module_option('queries_l', time(), true);
            if ($this->log) {
                $this->addLog('** ' . _AM_XC_QUERIES . ' **');
                $this->addLog(xoopscare_getmoduleoption('querieslist'));
                $this->saveLog();
            }
            // And do the job
            $tbl_tmp = @explode("\n", xoopscare_getmoduleoption('querieslist'));
            @array_walk($tbl_tmp, 'trim');
            foreach ($tbl_tmp as $line) {
                $result = $this->db->queryF($line);
            }
        }
        $this->cleanLog();
    }

    public function DbMaintain()
    {
        global $xoopsConfig;
        $every     = xoopscare_getmoduleoption('dbmaintain');
        $last_time = xoopscare_getmoduleoption('dbmaintain_l');
        if ($this->force || (($every > 0) && ((time() - $last_time) > ($every * 86400)))) {
            xc_set_module_option('dbmaintain_l', time(), true);
            // And do the job
            // First create a list of all the tables
            $tables = array();
            $result = $this->db->queryF('SHOW TABLES');
            while ($myrow = $this->db->fetchArray($result)) {
                $value    = array_values($myrow);
                $tables[] = $value[0];
            }
            $lst_tbl = implode(',', $tables);
            // Check tables
            $result = $this->db->queryF('CHECK TABLE ' . $lst_tbl);
            if ($this->log) {
                if (file_exists(XOOPS_ROOT_PATH . '/modules/xoopscare/language/' . $xoopsConfig['language'] . '/admin.php')) {
                    require_once XOOPS_ROOT_PATH . '/modules/xoopscare/language/' . $xoopsConfig['language'] . '/admin.php';
                } else {
                    require_once XOOPS_ROOT_PATH . '/modules/xoopscare/language/english/admin.php';
                }
                $this->addLog('** ' . _AM_XC_DBMAINTAIN . ' **');
                $this->_fetchLogResult($result);
            }

            // Repair
            $result = $this->db->queryF('REPAIR TABLE ' . $lst_tbl);
            if ($this->log) {
                $this->_fetchLogResult($result);
            }

            // Analyze
            $result = $this->db->queryF('ANALYZE TABLE ' . $lst_tbl);
            if ($this->log) {
                $this->_fetchLogResult($result);
            }
            // Optimize
            $result = $this->db->queryF('OPTIMIZE TABLE ' . $lst_tbl);
            if ($this->log) {
                $this->_fetchLogResult($result);
                $this->saveLog();
            }
        }
        $this->cleanLog();
    }
}
