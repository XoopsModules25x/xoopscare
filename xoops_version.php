<?php
/**
 * ****************************************************************************
 * XOOPSCARE - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 * ****************************************************************************
 */

defined('XOOPS_ROOT_PATH') || die('XOOPS root path not defined');

$modversion['name']        = _MI_XC_NAME;
$modversion['version']     = 1.4;
$modversion['description'] = _MI_XC_DESC;
$modversion['author']      = 'Hervé Thouzard';
$modversion['credits']     = 'GIJOE, irmtfan, JulioNC, DefianceB0y, Giba, koumed, Erol, Defkon1, Fooups';
$modversion['help']        = 'page=help';
$modversion['license']     = 'GNU GPL 2.0 or later';
$modversion['license_url'] = 'www.gnu.org/licenses/gpl-2.0.html';

$moduleDirName         = basename(__DIR__);
$modversion['dirname'] = $moduleDirName;

$modversion['official'] = 1;
$modversion['image']    = 'assets/images/logo_module.png';

$modversion['dirmoduleadmin']      = 'Frameworks/moduleclasses/moduleadmin';
$modversion['sysicons16']          = 'Frameworks/moduleclasses/icons/16';
$modversion['sysicons32']          = 'Frameworks/moduleclasses/icons/32';
$modversion['modicons16']          = 'assets/images/icons/16';
$modversion['modicons32']          = 'assets/images/icons/32';
$modversion['module_status']       = 'Beta 1';
$modversion['release_date']        = '2016/07/02';
$modversion['module_website_url']  = 'www.xoops.org';
$modversion['module_website_name'] = 'XOOPS';
$modversion['min_php']             = '5.5';
$modversion['min_xoops']           = '2.5.8';
$modversion['min_admin']           = '1.2';
$modversion['min_db']              = array(
    'mysql'  => '5.0.7',
    'mysqli' => '5.0.7'
);

$modversion['hasAdmin']    = 1;
$modversion['system_menu'] = 1;
$modversion['adminindex']  = 'admin/index.php';
$modversion['adminmenu']   = 'admin/menu.php';

// Blocks
$modversion['blocks'][1]['file']        = 'xc_cron.php';
$modversion['blocks'][1]['name']        = _MI_XC_BNAME1;
$modversion['blocks'][1]['description'] = 'Launch cleaning';
$modversion['blocks'][1]['show_func']   = 'b_xc_clean_show';
$modversion['blocks'][1]['options']     = '';
$modversion['blocks'][1]['template']    = 'xc_block_clean.html';

// Menu
$modversion['hasMain'] = 1;

// Search
$modversion['hasSearch'] = 0;

// Comments
$modversion['hasComments'] = 0;

// ********************************************************************************************************************
// ****************************************** SETTINGS ****************************************************************
// ********************************************************************************************************************
$cpto = 0;

/**
 * Log File
 */
++$cpto;
$modversion['config'][$cpto]['name']        = 'logfile';
$modversion['config'][$cpto]['title']       = '_MI_XC_LOGFILE';
$modversion['config'][$cpto]['description'] = '_MI_XC_LOGFILE_DSC';
$modversion['config'][$cpto]['formtype']    = 'textbox';
$modversion['config'][$cpto]['valuetype']   = 'text';
$modversion['config'][$cpto]['default']     = XOOPS_UPLOAD_PATH . '/' . xoops_makepass() . '.php';

/**
 * Password for CRON
 */
++$cpto;
$modversion['config'][$cpto]['name']        = 'cronpassword';
$modversion['config'][$cpto]['title']       = '_MI_XC_CRON_PASS';
$modversion['config'][$cpto]['description'] = '_MI_XC_CRON_PASS_DSC';
$modversion['config'][$cpto]['formtype']    = 'textbox';
$modversion['config'][$cpto]['valuetype']   = 'text';
$modversion['config'][$cpto]['default']     = '';

/**
 * Maintain Database every ... days
 */
++$cpto;
$modversion['config'][$cpto]['name']        = 'dbmaintain';
$modversion['config'][$cpto]['title']       = '_MI_XC_MAINTAIN';
$modversion['config'][$cpto]['description'] = '_MI_XC_MAINTAIN_DSC';
$modversion['config'][$cpto]['formtype']    = 'textbox';
$modversion['config'][$cpto]['valuetype']   = 'int';
$modversion['config'][$cpto]['default']     = 7;

/**
 * Execute this queries every ... days
 */
++$cpto;
$modversion['config'][$cpto]['name']        = 'queries';
$modversion['config'][$cpto]['title']       = '_MI_XC_QUERIES';
$modversion['config'][$cpto]['description'] = '_MI_XC_QUERIES_DSC';
$modversion['config'][$cpto]['formtype']    = 'textbox';
$modversion['config'][$cpto]['valuetype']   = 'int';
$modversion['config'][$cpto]['default']     = 2;

/**
 * Queries list
 */
++$cpto;
$modversion['config'][$cpto]['name']        = 'querieslist';
$modversion['config'][$cpto]['title']       = '_MI_XC_QUERIES_LST';
$modversion['config'][$cpto]['description'] = '_MI_XC_QUERIES_LST_DSC';
$modversion['config'][$cpto]['formtype']    = 'textarea';
$modversion['config'][$cpto]['valuetype']   = 'text';
$modversion['config'][$cpto]['default']     = '';

/**
 * Clear cache & templates_c every ... days
 */
++$cpto;
$modversion['config'][$cpto]['name']        = 'templatesc';
$modversion['config'][$cpto]['title']       = '_MI_XC_TPL';
$modversion['config'][$cpto]['description'] = '_MI_XC_TPL_DSC';
$modversion['config'][$cpto]['formtype']    = 'textbox';
$modversion['config'][$cpto]['valuetype']   = 'int';
$modversion['config'][$cpto]['default']     = 15;

/**
 * Remove spamed comments every ... days
 */
++$cpto;
$modversion['config'][$cpto]['name']        = 'spamcomnt';
$modversion['config'][$cpto]['title']       = '_MI_XC_SPAMCMNT';
$modversion['config'][$cpto]['description'] = '_MI_XC_SPAMCMNT_DSC';
$modversion['config'][$cpto]['formtype']    = 'textbox';
$modversion['config'][$cpto]['valuetype']   = 'int';
$modversion['config'][$cpto]['default']     = 1;

/**
 * Keep, unpublish, hide, delete spamed comments
 */
++$cpto;
$modversion['config'][$cpto]['name']        = 'spamstate';
$modversion['config'][$cpto]['title']       = '_MI_XC_SPAMSTATE';
$modversion['config'][$cpto]['description'] = '_MI_XC_SPAMSTATE_DSC';
$modversion['config'][$cpto]['formtype']    = 'textbox';
$modversion['config'][$cpto]['valuetype']   = 'int';
$modversion['config'][$cpto]['default']     = 0;

/**
 * Block spammers ?
 */
++$cpto;
$modversion['config'][$cpto]['name']        = 'blockspammers';
$modversion['config'][$cpto]['title']       = '_MI_XC_SPAMBLOCK';
$modversion['config'][$cpto]['description'] = '_MI_XC_SPAMBLOCK_DSC';
$modversion['config'][$cpto]['formtype']    = 'yesno';
$modversion['config'][$cpto]['valuetype']   = 'int';
$modversion['config'][$cpto]['default']     = 0;

/**
 * Empty sessions every ... days
 */
++$cpto;
$modversion['config'][$cpto]['name']        = 'sessions';
$modversion['config'][$cpto]['title']       = '_MI_XC_SESSIONS';
$modversion['config'][$cpto]['description'] = '_MI_XC_SESSIONS_DSC';
$modversion['config'][$cpto]['formtype']    = 'textbox';
$modversion['config'][$cpto]['valuetype']   = 'int';
$modversion['config'][$cpto]['default']     = 15;

/**
 * Execute Php code every ... days
 */
++$cpto;
$modversion['config'][$cpto]['name']        = 'phpcode';
$modversion['config'][$cpto]['title']       = '_MI_XC_PHP';
$modversion['config'][$cpto]['description'] = '_MI_XC_PHP_DSC';
$modversion['config'][$cpto]['formtype']    = 'textbox';
$modversion['config'][$cpto]['valuetype']   = 'int';
$modversion['config'][$cpto]['default']     = 15;

/**
 * Php code to execute
 */
++$cpto;
$modversion['config'][$cpto]['name']        = 'phpscript';
$modversion['config'][$cpto]['title']       = '_MI_XC_PHP_SCRIPT';
$modversion['config'][$cpto]['description'] = '_MI_XC_PHP_SCRIPT_DSC';
$modversion['config'][$cpto]['formtype']    = 'textarea';
$modversion['config'][$cpto]['valuetype']   = 'text';
$modversion['config'][$cpto]['default']     = '';

// ************************************************************************************************
// ************************* Hidden settings ******************************************************
// ************************************************************************************************

/**
 * Last time the DB was verified
 */
++$cpto;
$modversion['config'][$cpto]['name']        = 'dbmaintain_l';
$modversion['config'][$cpto]['title']       = '_MI_XC_MAINTIAN_L';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype']    = 'hidden';
$modversion['config'][$cpto]['valuetype']   = 'int';
$modversion['config'][$cpto]['default']     = 0;

/**
 * Last time the DB was verified
 */
++$cpto;
$modversion['config'][$cpto]['name']        = 'queries_l';
$modversion['config'][$cpto]['title']       = '_MI_XC_QUERIES_L';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype']    = 'hidden';
$modversion['config'][$cpto]['valuetype']   = 'int';
$modversion['config'][$cpto]['default']     = 0;

/**
 * Last time the cache and templates_c were cleaned
 */
++$cpto;
$modversion['config'][$cpto]['name']        = 'templatesc_l';
$modversion['config'][$cpto]['title']       = '_MI_XC_TPL_L';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype']    = 'hidden';
$modversion['config'][$cpto]['valuetype']   = 'int';
$modversion['config'][$cpto]['default']     = 0;

/**
 * Last time the spamed comments were deleted
 */
++$cpto;
$modversion['config'][$cpto]['name']        = 'spamcomnt_l';
$modversion['config'][$cpto]['title']       = '_MI_XC_SPAMCMNT_L';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype']    = 'hidden';
$modversion['config'][$cpto]['valuetype']   = 'int';
$modversion['config'][$cpto]['default']     = 0;

/**
 * Last time the sessions were cleaned
 */
++$cpto;
$modversion['config'][$cpto]['name']        = 'sessions_l';
$modversion['config'][$cpto]['title']       = '_MI_XC_SESSIONS_L';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype']    = 'hidden';
$modversion['config'][$cpto]['valuetype']   = 'int';
$modversion['config'][$cpto]['default']     = 0;

/**
 * Last time the Php code was executed
 */
++$cpto;
$modversion['config'][$cpto]['name']        = 'phpcode_l';
$modversion['config'][$cpto]['title']       = '_MI_XC_PHP_L';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype']    = 'hidden';
$modversion['config'][$cpto]['valuetype']   = 'int';
$modversion['config'][$cpto]['default']     = 0;

// Notification
$modversion['hasNotification'] = 0;
