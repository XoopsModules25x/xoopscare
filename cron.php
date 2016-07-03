<?php
/**
 * ****************************************************************************
 * XOOPSCARE - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 * ****************************************************************************
 */

require_once dirname(dirname(__DIR__)) . '/mainfile.php';

define('_MODULE_NAME_', $GLOBALS['xoopsModule']->getVar('dirname'));
require_once XOOPS_ROOT_PATH . '/modules/' . _MODULE_NAME_ . '/admin/functions.php';
require_once XOOPS_ROOT_PATH . '/modules/' . _MODULE_NAME_ . '/class/care.php';

$cronpassword = '';
$cronpassword = xoopscare_getmoduleoption('cronpassword');
if (xoops_trim($cronpassword) == '') {
    exit;
}
if (isset($_GET['password'])) {
    if ($cronpassword != $_GET['password']) {
        exit;
    }
} else {
    exit;
}

$care_class = new XoopsCare(true);
$care_class->RunAll();
