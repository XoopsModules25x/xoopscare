<?php
//  ------------------------------------------------------------------------ //
//                      XOOPSCARE - MODULE FOR XOOPS 2                		 //
//                  Copyright (c) 2007, 2008 Instant Zero                    //
//                     <http://www.instant-zero.com/>                        //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

define('_MI_XC_ADMENU1', 'Settings/ Actions');
define('_MI_XC_ADMENU2', 'Log');
define('_MI_XC_ADMENU3', 'Extra');

define('_MI_XC_NAME', 'Xoops Care');
define('_MI_XC_DESC', 'A module to take care of your site');
define('_MI_XC_LOGFILE', 'Log file');
define('_MI_XC_LOGFILE_DSC', "Select a filename to use to log module's actions");
define('_MI_XC_CRON_PASS', 'CRON Password');
define('_MI_XC_CRON_PASS_DSC', 'Select a password that your CRON will pass to the module to launch cleaning');
define('_MI_XC_MAINTAIN', 'Maintain database every');
define('_MI_XC_MAINTAIN_DSC', 'This will verify, repair, analyze and optimize your database every ... days');
define('_MI_XC_QUERIES', 'Run queries');
define('_MI_XC_QUERIES_DSC', 'Run queries every ... days');
define('_MI_XC_QUERIES_LST', 'Queries list');
define('_MI_XC_QUERIES_LST_DSC', 'Type the queries to execute');
define('_MI_XC_TPL', 'Cache and Templates_c');
define('_MI_XC_TPL_DSC', 'Clean your cache and templates_c folders every ... days');
define('_MI_XC_SPAMCMNT', 'Spamed comments');
define('_MI_XC_SPAMCMNT_DSC', 'Removed spamed comments every ... days');
define('_MI_XC_SPAMSTATE', 'What to do with spammed comments ?');
define('_MI_XC_SPAMSTATE_DSC', 'Keep, unpublish, hide, delete spamed comments');
define('_MI_XC_SPAMBLOCK', 'Block spammers ?');
define('_MI_XC_SPAMBLOCK_DSC', 'Do you want to block spammers ?');
define('_MI_XC_SESSIONS', 'Empty Sessions');
define('_MI_XC_SESSIONS_DSC', 'empty sessions every ... days');
define('_MI_XC_MAINTIAN_L', 'Last time the database was maintained');
define('_MI_XC_QUERIES_L', 'Last times queries were launched');
define('_MI_XC_TPL_L', 'Last time cache and templates_c were cleaned');
define('_MI_XC_SPAMCMNT_L', 'Last time the spamed comments were deleted');
define('_MI_XC_SESSIONS_L', 'Last time the sessions were cleaned');
define('_MI_XC_PHP', 'Execute Php code ');
define('_MI_XC_PHP_DSC', 'Type some Php code to execute every ... days');
define('_MI_XC_PHP_L', 'Last time the Php code was executed');
define('_MI_XC_PHP_SCRIPT', 'Php code to execute');
define('_MI_XC_PHP_SCRIPT_DSC', 'Type the code to execute');
define('_MI_XC_HELP', 'Help');
define('_MI_XC_BNAME1', 'Site maintenance');

//Help
define('_MI_XC_DIRNAME', basename(dirname(dirname(__DIR__))));
define('_MI_XC_HELP_HEADER', __DIR__ . '/help/helpheader.html');
define('_MI_XC_BACK_2_ADMIN', 'Back to Administration of ');
define('_MI_XC_HELP_OVERVIEW', 'Overview');
