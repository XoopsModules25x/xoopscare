<?php
/**
 * ****************************************************************************
 * XOOPSCARE - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 * ****************************************************************************
 */

function xc_adminMenu($currentoption = 0, $breadcrumb = '')
{
	global $xoopsConfig, $xoopsModule;
	$filename = XOOPS_ROOT_PATH.'/modules/xoopscare/language/'.$xoopsConfig['language'].'/modinfo.php';
	if(file_exists($filename)) {
		include_once $filename;
	} else {
		include_once XOOPS_ROOT_PATH.'/modules/xoopscare/language/english/modinfo.php';
	}

	require XOOPS_ROOT_PATH.'/modules/xoopscare/admin/menu.php';

	echo "<style type=\"text/css\">\n";
	echo "#buttontop { float:left; width:100%; background: #e7e7e7; font-size:93%; line-height:normal; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; margin: 0; }\n";
	echo "#buttonbar { float:left; width:100%; background: #e7e7e7 url('../images/modadminbg.gif') repeat-x left bottom; font-size:93%; line-height:normal; border-left: 1px solid black; border-right: 1px solid black; margin-bottom: 12px; }\n";
	echo "#buttonbar ul { margin:0; margin-top: 15px; padding:10px 10px 0; list-style:none; }\n";
	echo "#buttonbar li { display:inline; margin:0; padding:0; }";
	echo "#buttonbar a { float:left; background:url('../images/left_both.gif') no-repeat left top; margin:0; padding:0 0 0 9px; border-bottom:1px solid #000; text-decoration:none; }\n";
	echo "#buttonbar a span { float:left; display:block; background:url('../images/right_both.gif') no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; }\n";
	echo "/* Commented Backslash Hack hides rule from IE5-Mac \*/\n";
	echo "#buttonbar a span {float:none;}\n";
	echo "/* End IE5-Mac hack */\n";
	echo "#buttonbar a:hover span { color:#333; }\n";
	echo "#buttonbar .current a { background-position:0 -150px; border-width:0; }\n";
	echo "#buttonbar .current a span { background-position:100% -150px; padding-bottom:5px; color:#333; }\n";
	echo "#buttonbar a:hover { background-position:0% -150px; }\n";
	echo "#buttonbar a:hover span { background-position:100% -150px; }\n";
	echo "</style>\n";

	echo "<div id=\"buttontop\">\n";
	echo "<table style=\"width: 100%; padding: 0; \" cellspacing=\"0\">\n";
	echo "<tr>\n";
	echo "<td style=\"width: 70%; font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;\">\n";
	echo "</td>\n";
	echo "<td style=\"width: 30%; font-size: 10px; text-align: right; color: #2F5376; padding: 0 6px; line-height: 18px;\">\n";
	echo "<b>".$xoopsModule->getVar('name')."&nbsp;"._AM_XC_ADMINISTRATION."</b>&nbsp;".$breadcrumb."\n";
	echo "</td>\n";
	echo "</tr>\n";
	echo "</table>\n";
	echo "</div>\n";
	echo "<div id=\"buttonbar\">\n";
	echo "<ul>\n";
	foreach($adminmenu as $key=>$link) {
		if($key == $currentoption) {
			echo "<li class=\"current\">\n";
		} else {
			echo "<li>\n";
		}
		echo "<a href=\"".XOOPS_URL."/modules/xoopscare/".$link['link']."\"><span>".$link['title']."</span></a>\n";
		echo "</li>\n";
	}
	echo "</ul>\n";
	echo "</div>\n";
	echo "<br style=\"clear:both;\" />\n";
}

/**
 * Internal function
 */
function xc_get_mid() {
	$module_handler =& xoops_gethandler('module');
	$module =& $module_handler->getByDirname('xoopscare');
	return $module->getVar('mid');

}

/**
 * Internal function
 */
function xc_get_config_handler()
{
	$config_handler = null;
	$config_handler =& xoops_gethandler('config');
	if(!is_object($config_handler)) {
		trigger_error("Error, unable to get and handler on the Config object");
		exit;
	} else {
		return $config_handler;
	}

}

/**
 * Returns a module option
 */
function xc_get_module_option($option_name = '', $as_object = false)
{
	$tbl_options = array();
	$mid = xc_get_mid();
	$config_handler = xc_get_config_handler();
	$critere = new CriteriaCompo();
	$critere->add(new Criteria('conf_modid', $mid, '='));
	$critere->add(new Criteria('conf_name', $option_name, '='));
	$tbl_options = $config_handler->getConfigs($critere, false, false);
	if(count($tbl_options) >0 ) {
		$option = $tbl_options[0];
		if(!$as_object) {
			return $option->getVar('conf_value');
		} else {
			return $option;
		}
	}
}



/**
 * Returns a module's option
 */
function xoopscare_getmoduleoption($option, $repmodule='xoopscare')
{
	global $xoopsModuleConfig, $xoopsModule;

	$retval = false;
	if (isset($xoopsModuleConfig) && (is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $repmodule && $xoopsModule->getVar('isactive'))) {
		if(isset($xoopsModuleConfig[$option])) {
			$retval= $xoopsModuleConfig[$option];
		}
	} else {
		$module_handler =& xoops_gethandler('module');
		$module =& $module_handler->getByDirname($repmodule);
		$config_handler =& xoops_gethandler('config');
		if ($module) {
		    $moduleConfig =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));
	    	if(isset($moduleConfig[$option])) {
	    		$retval= $moduleConfig[$option];
	    	}
		}
	}
	return $retval;
}


/**
 * Set a module's option
 */
function xc_set_module_option($option_name = '', $option_value = '', $force = false)
{
	$mid = xc_get_mid();
	$retval = true;
	$config_handler = xc_get_config_handler();
	$option = xc_get_module_option($option_name, true);
	$option->setVar('conf_value', $option_value);
	if(!$force) {
		$retval = $config_handler->insertConfig($option, true);
	} else {
		global $xoopsDB;
		$sql = sprintf("UPDATE %s SET conf_value = %s WHERE conf_id = %u", $xoopsDB->prefix('config'), $xoopsDB->quoteString($option_value),  $option->getVar('conf_id'));
		$result = $xoopsDB->queryF($sql);
	}
	return $retval;
}


/**
 * Create an html title
 */
function xc_htitle($title = '', $level = 5) {
	 return sprintf("<h%01d>%s</h%01d>",$level,$title,$level);
}

/**
 * Create an inline dhtml help with a picture and a text
 */
function xc_help($text) {
	$p_text = str_replace("'",' ', $text);
	return "<img src='../images/help.png' border='0' alt='' onmouseout=\"hideTooltip()\" onmouseover=\"showTooltip(event,'".$p_text."');return false\" /> ";
}


/**
 * Redirect user with a message
 *
 * @param string $message message to display
 * @param string $url The place where to go
 * @param integer timeout Time to wait before to redirect
 */
function xc_redirect($message = '', $url = 'index.php', $time = 2)
{
	redirect_header($url, $time, $message);
	exit();
}

/**
 * Create (in a link) a javascript confirmation's box
 *
 * @package Bookshop
 * @author Instant Zero http://www.instant-zero.com
 * @copyright	(c) Instant Zero http://www.instant-zero.com
 *
 * @param string $msg	Message to display
 * @param boolean $form	Is it a confirmation for a form ?
 * @return string the command to include
 */
function xc_JavascriptLinkConfirm($msg, $form = false)
{
	if(!$form) {
		return "onclick=\"javascript:return confirm('".str_replace("'"," ",$msg)."')\"";
	} else {
		return "onSubmit=\"javascript:return confirm('".str_replace("'"," ",$msg)."')\"";
	}
}

?>