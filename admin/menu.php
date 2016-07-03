<?php
/**
 * ****************************************************************************
 * XOOPSCARE - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 * ****************************************************************************
 */

$moduleDirName = basename(dirname(__DIR__));

$moduleHandler = xoops_getHandler('module');
$module        = $moduleHandler->getByDirname($moduleDirName);
$pathIcon32    = '../../' . $module->getInfo('sysicons32');
$pathModIcon32 = './' . $module->getInfo('modicons32');
xoops_loadLanguage('modinfo', $module->dirname());

$xoopsModuleAdminPath = XOOPS_ROOT_PATH . '/' . $module->getInfo('dirmoduleadmin');
include_once $xoopsModuleAdminPath . '/language/english/main.php';

$adminmenu[] = array(
    'title' => _AM_MODULEADMIN_HOME,
    'link'  => 'admin/index.php',
    'icon'  => $pathIcon32 . '/home.png'
);

$adminmenu[] = array(
    'title' => _MI_XC_ADMENU1,
    'link'  => 'admin/main.php?op=prefs',
    'icon'  => $pathIcon32 . '/manage.png'
);

$adminmenu[] = array(
    'title' => _AM_MODULEADMIN_ABOUT,
    'link'  => 'admin/about.php',
    'icon'  => $pathIcon32 . '/about.png'
);
