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

function xoops_module_update_xmsocial(XoopsModule $module, $previousVersion = null) {
	// Passage de la version 1.0 à 1.1
    if ($previousVersion <= 100) {
        $db = XoopsDatabaseFactory::getDatabaseConnection();
		$sql = "ALTER TABLE `" . $db->prefix('xmsocial_rating') . "` ADD `rating_options` varchar(255) NOT NULL DEFAULT '' AFTER `rating_date`;";
        $db->query($sql);
    }
    return true;
}