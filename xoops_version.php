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
 * @copyright       XOOPS Project (http://xoops.org)
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author          Mage Gregory (AKA Mage)
 */
$modversion['dirname']     = basename(__DIR__);
$modversion['name']        = ucfirst(basename(__DIR__));
$modversion['version']     = '1.0';
$modversion['description'] = _MI_XMSOCIAL_DESC;
$modversion['author']      = 'Grégory Mage (Mage)';
$modversion['url']         = 'https://github.com/GregMage';
$modversion['credits']     = 'Mage';

$modversion['help']        = 'page=help';
$modversion['license']     = 'GNU GPL 2 or later';
$modversion['license_url'] = 'http://www.gnu.org/licenses/gpl-2.0.html';
$modversion['official']    = 0;
$modversion['image']       = 'assets/images/xmsocial_logo.png';

// Menu
$modversion['hasMain'] = 1;

// Admin things
$modversion['hasAdmin']    = 1;
$modversion['system_menu'] = 1;
$modversion['adminindex']  = 'admin/index.php';
$modversion['adminmenu']   = 'admin/menu.php';

// Install and update
//$modversion['onInstall']        = 'include/install.php';
//$modversion['onUpdate']         = 'include/update.php';

// Tables
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';

$modversion['tables'][1] = 'xmsocial_social';
$modversion['tables'][2] = 'xmsocial_rating';
$modversion['tables'][3] = 'xmsocial_socialdata';


// Admin Templates
$modversion['templates'][] = array('file' => 'xmsocial_admin_social.tpl', 'description' => '', 'type' => 'admin');
$modversion['templates'][] = array('file' => 'xmsocial_admin_rating.tpl', 'description' => '', 'type' => 'admin');
$modversion['templates'][] = array('file' => 'xmsocial_admin_permission.tpl', 'description' => '', 'type' => 'admin');

// User Templates
$modversion['templates'][] = array('file' => 'xmsocial_rating.tpl', 'description' => '');



// Configs
$modversion['config'] = array();

$modversion['config'][] = array(
    'name'        => 'break',
    'title'       => '_MI_XMSOCIAL_PREF_HEAD_ADMIN',
    'description' => '',
    'formtype'    => 'line_break',
    'valuetype'   => 'text',
    'default'     => 'head',
);

$modversion['config'][] = array(
    'name'        => 'admin_perpage',
    'title'       => '_MI_XMSOCIAL_PREF_ITEMPERPAGE',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 15
);

// About stuff
$modversion['module_status'] = 'Alpha';
$modversion['release_date']  = '2019/02/12';

$modversion['developer_lead']      = 'Mage';
$modversion['module_website_url']  = 'www.monxoops.fr/';
$modversion['module_website_name'] = 'MonXoops';

$modversion['min_xoops'] = '2.5.10';
$modversion['min_php']   = '7.0';
$modversion['min_db']    = ['mysql' => '5.5'];
