<?php
/**
 * ****************************************************************************
 * XOOPSCARE - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 * ****************************************************************************
 * @param int    $currentoption
 * @param string $breadcrumb
 */

/**
 * Internal function
 */
function xc_get_mid()
{
    $module_handler = xoops_getHandler('module');
    $module         =& $module_handler->getByDirname('xoopscare');

    return $module->getVar('mid');
}

/**
 * Internal function
 */
function xc_get_config_handler()
{
    $config_handler = null;
    $config_handler = xoops_getHandler('config');
    if (!is_object($config_handler)) {
        trigger_error('Error, unable to get and handler on the Config object');
        exit;
    } else {
        return $config_handler;
    }
}

/**
 * Returns a module option
 * @param string $option_name
 * @param bool   $as_object
 * @return
 */
function xc_get_module_option($option_name = '', $as_object = false)
{
    $tbl_options    = array();
    $mid            = xc_get_mid();
    $config_handler = xc_get_config_handler();
    $criteria       = new CriteriaCompo();
    $criteria->add(new Criteria('conf_modid', $mid, '='));
    $criteria->add(new Criteria('conf_name', $option_name, '='));
    $tbl_options = $config_handler->getConfigs($criteria, false, false);
    if (count($tbl_options) > 0) {
        $option = $tbl_options[0];
        if (!$as_object) {
            return $option->getVar('conf_value');
        } else {
            return $option;
        }
    }
}

/**
 * Returns a module's option
 * @param        $option
 * @param string $repmodule
 * @return bool
 */
function xoopscare_getmoduleoption($option, $repmodule = 'xoopscare')
{
    global $xoopsModuleConfig, $xoopsModule;

    $retval = false;
    if (isset($xoopsModuleConfig) && (is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $repmodule && $xoopsModule->getVar('isactive'))) {
        if (isset($xoopsModuleConfig[$option])) {
            $retval = $xoopsModuleConfig[$option];
        }
    } else {
        $module_handler = xoops_getHandler('module');
        $module         =& $module_handler->getByDirname($repmodule);
        $config_handler = xoops_getHandler('config');
        if ($module) {
            $moduleConfig =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));
            if (isset($moduleConfig[$option])) {
                $retval = $moduleConfig[$option];
            }
        }
    }

    return $retval;
}

/**
 * Set a module's option
 * @param string $option_name
 * @param string $option_value
 * @param bool   $force
 * @return bool
 */
function xc_set_module_option($option_name = '', $option_value = '', $force = false)
{
    $mid            = xc_get_mid();
    $retval         = true;
    $config_handler = xc_get_config_handler();
    $option         = xc_get_module_option($option_name, true);
    $option->setVar('conf_value', $option_value);
    if (!$force) {
        $retval = $config_handler->insertConfig($option, true);
    } else {
        global $xoopsDB;
        $sql    = sprintf('UPDATE %s SET conf_value = %s WHERE conf_id = %u', $xoopsDB->prefix('config'), $xoopsDB->quoteString($option_value), $option->getVar('conf_id'));
        $result = $xoopsDB->queryF($sql);
    }

    return $retval;
}

/**
 * Create an html title
 * @param string $title
 * @param int    $level
 * @return string
 */
function xc_htitle($title = '', $level = 5)
{
    return sprintf('<h%01d>%s</h%01d>', $level, $title, $level);
}

/**
 * Create an inline dhtml help with a picture and a text
 * @param $text
 * @return string
 */
function xc_help($text)
{
    $p_text = str_replace("'", ' ', $text);

    return "<img src='../assets/images/help.png' border='0' alt='' onmouseout=\"hideTooltip()\" onmouseover=\"showTooltip(event,'" . $p_text . "');return false\" /> ";
}

/**
 * Redirect user with a message
 *
 * @param string $message message to display
 * @param string $url     The place where to go
 * @param        integer  timeout Time to wait before to redirect
 */
function xc_redirect($message = '', $url = 'index.php', $time = 2)
{
    redirect_header($url, $time, $message);
    exit();
}

/**
 * Create (in a link) a javascript confirmation's box
 *
 * @package          Bookshop
 * @author           Instant Zero http://www.instant-zero.com
 * @copyright    (c) Instant Zero http://www.instant-zero.com
 *
 * @param  string  $msg  Message to display
 * @param  boolean $form Is it a confirmation for a form ?
 * @return string  the command to include
 */
function xc_JavascriptLinkConfirm($msg, $form = false)
{
    if (!$form) {
        return "onclick=\"javascript:return confirm('" . str_replace("'", ' ', $msg) . "')\"";
    } else {
        return "onSubmit=\"javascript:return confirm('" . str_replace("'", ' ', $msg) . "')\"";
    }
}
