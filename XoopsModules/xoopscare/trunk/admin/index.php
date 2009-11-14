<?php
/**
 * ****************************************************************************
 * XOOPSCARE - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 * ****************************************************************************
 */

require_once '../../../include/cp_header.php';
define('_MODULE_NAME_', $xoopsModule->getVar('dirname'));

require_once XOOPS_ROOT_PATH.'/modules/'._MODULE_NAME_.'/admin/functions.php';
require_once XOOPS_ROOT_PATH.'/modules/'._MODULE_NAME_.'/class/care.php';

$op = 'prefs';
if (isset($_POST['op'])) {
 $op=$_POST['op'];
} elseif ( isset($_GET['op'])) {
   	$op = $_GET['op'];
}

// ******************************************************************************************************************************************
// **** Main ********************************************************************************************************************************
// ******************************************************************************************************************************************
switch ($op)
{

	// ****************************************************************************************************************
	case 'saveprefs':	// Save preferences
	// ****************************************************************************************************************
		xc_set_module_option('cronpassword',$_POST['cronpassword']);
		xc_set_module_option('logfile',$_POST['logfile']);
		xc_set_module_option('dbmaintain',$_POST['dbmaintain']);
		xc_set_module_option('queries',$_POST['queries']);
		xc_set_module_option('querieslist',$_POST['querieslist']);
		xc_set_module_option('phpcode',$_POST['phpcode']);
		xc_set_module_option('phpscript',$_POST['phpscript']);
		xc_set_module_option('templatesc',$_POST['templatesc']);
		xc_set_module_option('spamcomnt',$_POST['spamcomnt']);
		xc_set_module_option('blockspammers', isset($_POST['blockspammers']) ? $_POST['blockspammers'] : 0);
		xc_set_module_option('spamstate',$_POST['spamstate']);
		xc_set_module_option('sessions',$_POST['sessions']);
		xc_redirect(_AM_XC_OPERATION_MADE);
		break;

	// ****************************************************************************************************************
	case 'prefs':	// Show preferences
	// ****************************************************************************************************************
        xoops_cp_header();
        include 'tooltip.php';

        xc_adminMenu(1);
        $filename = XOOPS_ROOT_PATH.'/modules/'._MODULE_NAME_.'/language/'.$xoopsConfig['language'].'/modinfo.php';
		if (file_exists($filename)) {
			require_once $filename;
		} else {
			require_once XOOPS_ROOT_PATH.'/modules/'._MODULE_NAME_.'/language/english/modinfo.php';
		}
		$confirm = xc_JavascriptLinkConfirm(_AM_XC_DONT_FORGET);

		echo "<form method='post' name='frmpref' id='frmpref' action='index.php'>";
		echo "<input type='hidden' name='op' id='op' value='saveprefs' />";
		echo "<table border='0' class='outer' width='100%'>";
		echo "<tr><td colspan='2'>".xc_htitle(_AM_XC_GENERALSET).'</td></tr>';
		echo "<tr><td class='even'>".xc_help(_AM_XC_HELP1)._MI_XC_CRON_PASS.'<br />'._MI_XC_CRON_PASS_DSC."</td><td class='odd'><input type='text' name='cronpassword' id='cronpassword' value='".xoopscare_getmoduleoption('cronpassword')."' size='50' maxlength='255' /></td></tr>";
		echo "<tr><td class='even'>".xc_help(_AM_XC_HELP2)._MI_XC_LOGFILE."<br />"._MI_XC_LOGFILE_DSC."</td><td class='odd'><input type='text' name='logfile' id='logfile' value='".xoopscare_getmoduleoption('logfile')."' size='50' maxlength='255' /></td></tr>";

		echo "<tr><td colspan='2'>".xc_htitle(_AM_XC_DBMAINTAIN).'</td></tr>';
		echo "<tr><td class='even'>".xc_help(_AM_XC_HELP3)._MI_XC_MAINTAIN."<br />"._MI_XC_MAINTAIN_DSC."</td><td class='odd'><input type='text' name='dbmaintain' id='dbmaintain' value='".xoopscare_getmoduleoption('dbmaintain')."' size='4' maxlength='10' /></td></tr>";
		echo "<tr><td class='even' colspan='2' align='center'><a href='index.php?op=dbmaintain'".$confirm.">"._AM_XC_DOIT_NOW."</a></td></tr>";

		echo "<tr><td colspan='2'>".xc_htitle(_AM_XC_QUERIES).'</td></tr>';
		echo "<tr><td class='even'>".xc_help(_AM_XC_HELP4)._MI_XC_QUERIES."<br />"._MI_XC_QUERIES_DSC."</td><td class='odd'><input type='text' name='queries' id='queries' value='".xoopscare_getmoduleoption('queries')."' size='4' maxlength='10' /></td></tr>";
		echo "<tr><td class='even' colspan='2' align='left'>".xc_help(_AM_XC_HELP5)._MI_XC_QUERIES_LST.', '._MI_XC_QUERIES_LST_DSC."</td></tr>";
		echo "<tr><td class='even' colspan='2' align='left'><textarea rows='6' cols='80' name='querieslist' id='querieslist'>".xoopscare_getmoduleoption('querieslist')."</textarea></td></tr>";
		echo "<tr><td class='even' colspan='2' align='center'><a href='index.php?op=runqueries'".$confirm.">"._AM_XC_DOIT_NOW."</a></td></tr>";

		echo "<tr><td colspan='2'>".xc_htitle(_AM_XC_PHP).'</td></tr>';
		echo "<tr><td class='even'>".xc_help(_AM_XC_HELP11)._MI_XC_PHP."<br />"._MI_XC_PHP_DSC."</td><td class='odd'><input type='text' name='phpcode' id='phpcode' value='".xoopscare_getmoduleoption('phpcode')."' size='4' maxlength='10' /></td></tr>";
		echo "<tr><td class='even' colspan='2' align='left'>".xc_help(_AM_XC_HELP12)._MI_XC_PHP_SCRIPT.', '._MI_XC_PHP_SCRIPT_DSC."</td></tr>";
		echo "<tr><td class='even' colspan='2' align='left'><textarea rows='6' cols='80' name='phpscript' id='phpscript'>".xoopscare_getmoduleoption('phpscript')."</textarea></td></tr>";
		echo "<tr><td class='even' colspan='2' align='center'><a href='index.php?op=runphp'".$confirm.">"._AM_XC_DOIT_NOW."</a></td></tr>";

		echo "<tr><td colspan='2'>".xc_htitle(_AM_XC_CACHE_TPL).'</td></tr>';
		echo "<tr><td class='even'>".xc_help(_AM_XC_HELP6)._MI_XC_TPL."<br />"._MI_XC_TPL_DSC."</td><td class='odd'><input type='text' name='templatesc' id='templatesc' value='".xoopscare_getmoduleoption('templatesc')."' size='4' maxlength='10' /></td></tr>";
		echo "<tr><td class='even' colspan='2' align='center'><a href='index.php?op=clearcache'".$confirm.">"._AM_XC_DOIT_NOW."</a></td></tr>";

		$config_handler =& xoops_gethandler('config');
		$censorConf =& $config_handler->getConfigsByCat(XOOPS_CONF_CENSOR);
		$replacement = $censorConf['censor_replace'];
		$spam_note = sprintf(_AM_XC_HELP7, $replacement);

		echo "<tr><td colspan='2'>".xc_htitle(_AM_XC_SPAM_CMT).'</td></tr>';
		echo "<tr><td class='even'>".xc_help($spam_note)._MI_XC_SPAMCMNT."<br />"._MI_XC_SPAMCMNT_DSC."</td><td class='odd'><input type='text' name='spamcomnt' id='spamcomnt' value='".xoopscare_getmoduleoption('spamcomnt')."' size='4' maxlength='10' /></td></tr>";
		$checked1 = '';
		if(xoopscare_getmoduleoption('blockspammers')) {
			$checked1 = "checked='checked'";
		}
		echo "<tr><td class='even'>".xc_help(_AM_XC_HELP8)._MI_XC_SPAMBLOCK."<br />"._MI_XC_SPAMBLOCK_DSC."</td><td class='odd'><input type='checkbox' name='blockspammers' id='blockspammers' value='1' ".$checked1." /> "._YES."</td></tr>";
		echo "<tr><td class='even'>".xc_help(_AM_XC_HELP9)._MI_XC_SPAMSTATE."</td><td class='odd'>";
		$spamstate = array('','','','','');
		$spamstate[xoopscare_getmoduleoption('spamstate')] = "checked='checked'";
		echo "<input type='radio' name='spamstate' id='spamstate' value='1' ".$spamstate[1]." /> "._AM_XC_SPMSTATE_1;
		echo "<br /><input type='radio' name='spamstate' id='spamstate' value='2' ".$spamstate[2]." /> "._AM_XC_SPMSTATE_2;
		echo "<br /><input type='radio' name='spamstate' id='spamstate' value='3' ".$spamstate[3]." /> "._AM_XC_SPMSTATE_3;
		echo "<br /><input type='radio' name='spamstate' id='spamstate' value='4' ".$spamstate[4]." /> "._AM_XC_SPMSTATE_4;
		echo "</td></tr>";
		echo "<tr><td class='even' colspan='2' align='center'><a href='index.php?op=clearcomments'".$confirm.">"._AM_XC_DOIT_NOW."</a></td></tr>";

		echo "<tr><td colspan='2'>".xc_htitle(_AM_XC_SESSIONS).'</td></tr>';
		echo "<tr><td class='even'>".xc_help(_AM_XC_HELP10)._MI_XC_SESSIONS."<br />"._MI_XC_SESSIONS_DSC."</td><td class='odd'><input type='text' name='sessions' id='sessions' value='".xoopscare_getmoduleoption('sessions')."' size='4' maxlength='10' /></td></tr>";
		echo "<tr><td class='even' colspan='2' align='center'><a href='index.php?op=clearsessions'".$confirm.">"._AM_XC_DOIT_NOW."</a></td></tr>";
		echo "<tr><td class='odd' colspan='2' align='center'><br /><input type='submit' name='btngo' id='btngo' value='"._AM_XC_SAVE."' /><br /><br /></td></tr>";
		echo "</table>";

		echo "</form>";
		echo "<br /><div align='center'><a href='http://xoops.instant-zero.com' target='_blank'><img src='../images/instantzero.gif'></a></div>";
		break;


	// ****************************************************************************************************************
	case 'dbmaintain':
	// ****************************************************************************************************************
		$care_class = new XoopsCare(true);
		$care_class->DbMaintain();
		xc_redirect(_AM_XC_OPERATION_MADE);
		break;

	// ****************************************************************************************************************
	case 'runqueries':
	// ****************************************************************************************************************
		$care_class = new XoopsCare(true);
		$care_class->RunQueries();
		xc_redirect(_AM_XC_OPERATION_MADE);
		break;

	// ****************************************************************************************************************
	case 'runphp':
	// ****************************************************************************************************************
		$care_class = new XoopsCare(true);
		$care_class->RunPhp();
		xc_redirect(_AM_XC_OPERATION_MADE);
		break;

	// ****************************************************************************************************************
	case 'clearcache':
	// ****************************************************************************************************************
		$care_class = new XoopsCare(true);
		$care_class->ClearCache();
		xc_redirect(_AM_XC_OPERATION_MADE);
		break;

	// ****************************************************************************************************************
	case 'clearcomments':
	// ****************************************************************************************************************
		$care_class = new XoopsCare(true);
		$care_class->ClearComments();
		xc_redirect(_AM_XC_OPERATION_MADE);
		break;

	// ****************************************************************************************************************
	case 'clearsessions':
	// ****************************************************************************************************************
		$care_class = new XoopsCare(true);
		$care_class->ClearSessions();
		xc_redirect(_AM_XC_OPERATION_MADE);
		break;

	// ****************************************************************************************************************
	case 'help':	// Show help if it exists
	// ****************************************************************************************************************
        xoops_cp_header();
        xc_adminMenu(3);
        $filename = XOOPS_ROOT_PATH.'/modules/'._MODULE_NAME_.'/language/'.$xoopsConfig['language'].'/help.php';
		if (file_exists($filename)) {
			require_once $filename;
		} else {
			require_once XOOPS_ROOT_PATH.'/modules/'._MODULE_NAME_.'/language/english/help.php';
		}
		echo nl2br($help);
		echo "<br /><div align='center'><a href='http://xoops.instant-zero.com' target='_blank'><img src='../images/instantzero.gif'></a></div>";
		break;


	// ****************************************************************************************************************
	case 'extra':	// Extra
	// ****************************************************************************************************************
		xc_redirect("Not Yet");
		break;

}
xoops_cp_footer();
?>