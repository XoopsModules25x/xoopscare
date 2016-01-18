<?php
/**
 * ****************************************************************************
 * XOOPSCARE - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 * ****************************************************************************
 */

function b_xc_clean_show($options)
{
	include_once XOOPS_ROOT_PATH.'/modules/xoopscare/class/care.php';
	$care_class = new XoopsCare();
	$care_class->RunAll();
	return '';
}
?>