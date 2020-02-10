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
$moduleAdmin = Admin::getInstance();
$moduleAdmin->displayNavigation('rating.php');

// Get Action type
$op = Request::getCmd('op', 'list');
switch ($op) {
    case 'list':
        // Define Stylesheet
        $xoTheme->addStylesheet(XOOPS_URL . '/modules/system/css/admin.css');
        //$xoTheme->addStylesheet(XOOPS_URL . '/modules/xmsocial/assets/css/rating.css');
        $xoTheme->addScript('modules/system/js/admin.js');
		
		xoops_load('utility', 'xmsocial');
		XmsocialUtility::renderRating($xoopsTpl, $xoTheme, 'xmsocial', 12, 5, 3.5, 3, 'xmsocial');
        // Module admin
        
        break;
            
    // del
    case 'del':    
        $social_id = Request::getInt('social_id', 0);
        if ($social_id == 0) {
            $xoopsTpl->assign('error_message', _MA_XMSOCIAL_ERROR_NOSOCIAL);
        } else {
            $surdel = Request::getBool('surdel', false);
            $obj  = $socialHandler->get($social_id);
            if ($surdel === true) {
                if (!$GLOBALS['xoopsSecurity']->check()) {
                    redirect_header('social.php', 3, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
                }
                if ($socialHandler->delete($obj)) {
                    redirect_header('social.php', 2, _MA_XMSOCIAL_REDIRECT_SAVE);
                } else {
                    $xoopsTpl->assign('error_message', $obj->getHtmlErrors());
                }
            } else {
                xoops_confirm(array('surdel' => true, 'social_id' => $social_id, 'op' => 'del'), $_SERVER['REQUEST_URI'], 
                                    sprintf(_MA_XMSOCIAL_SOCIAL_SUREDEL, '<br>' . $obj->getVar('social_name')));
            }
        }
        
        break;
        
    }

$xoopsTpl->display("db:xmsocial_admin_rating.tpl");

require __DIR__ . '/admin_footer.php';
