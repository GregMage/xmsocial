<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * xmsocial module
 *
 * @copyright       XOOPS Project (https://xoops.org)
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author          Mage Gregory (AKA Mage)
 */

use Xmf\Module\Admin; 
use Xmf\Request;

require __DIR__ . '/admin_header.php';
include_once XOOPS_ROOT_PATH.'/class/xoopsform/grouppermform.php';
$moduleAdmin = Admin::getInstance();
$moduleAdmin->displayNavigation('permission.php');

// Get permission
$permission = Request::getInt('permission', 1);

$RatingPlugin = new RatingPlugin();
$plugin_arr = $RatingPlugin->ListPlugin();

// Plugin
if (count($plugin_arr) > 0) {
	$formTitle = _MA_XMSOCIAL_PERMISSION_RATING;
	$permissionName = 'xmsocial_rating';
	$permissionDescription = _MA_XMSOCIAL_PERMISSION_RATING_DSC;
	foreach (array_keys($plugin_arr) as $i) {
		$global_perms_array[$plugin_arr[$i]['id']] = $plugin_arr[$i]['name'];		
	}
			
	$permissionsForm = new XoopsGroupPermForm($formTitle, $helper->getModule()->getVar('mid'), $permissionName, $permissionDescription, 'admin/permission.php?permission=' . $permission);
	foreach ($global_perms_array as $perm_id => $permissionName) {
		$permissionsForm->addItem($perm_id , $permissionName) ;
	}
	$xoopsTpl->assign('form', $permissionsForm->render());
} else {
	$xoopsTpl->assign('error_message', _MA_XMSOCIAL_ERROR_NOPLUGIN);
}


$xoopsTpl->display("db:xmsocial_admin_permission.tpl");

require __DIR__ . '/admin_footer.php';
