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
$moduleAdmin->displayNavigation('social.php');

// Get Action type
$op = Request::getCmd('op', 'list');
switch ($op) {
    case 'list':
        // Define Stylesheet
        $xoTheme->addStylesheet(XOOPS_URL . '/modules/system/css/admin.css');
        $xoTheme->addScript('modules/system/js/admin.js');
        // Module admin
        $moduleAdmin->addItemButton(_MA_XMSOCIAL_SOCIAL_ADD, 'social.php?op=add', 'add');
        $xoopsTpl->assign('renderbutton', $moduleAdmin->renderButton());        
        // Get start pager
        $start = Request::getInt('start', 0);
        $xoopsTpl->assign('start', $start);
        
        // Criteria
        $criteria = new CriteriaCompo();
        $criteria->setSort('social_weight ASC, social_name');
        $criteria->setOrder('ASC');
        $criteria->setStart($start);
        $criteria->setLimit($nb_limit);
		$social_arr = $socialHandler->getall($criteria);
        $social_count = $socialHandler->getCount($criteria);
        $xoopsTpl->assign('social_count', $social_count);
		$SocialPlugin = new SocialPlugin();
        if ($social_count > 0) {
            foreach (array_keys($social_arr) as $i) {
                $social['id']          = $social_arr[$i]->getVar('social_id');
				$options = explode(',', $social_arr[$i]->getVar('social_options'));
                $social['render']      = $SocialPlugin->render($social_arr[$i]->getVar('social_type'), '', $options);
                $social['name']        = $social_arr[$i]->getVar('social_name');
                $social['type']        = $social_arr[$i]->getVar('social_type');
                $social['weight']      = $social_arr[$i]->getVar('social_weight');
                $social['status']      = $social_arr[$i]->getVar('social_status');
                $xoopsTpl->append_by_ref('social', $social);
                unset($social);
            }
            // Display Page Navigation
            if ($social_count > $nb_limit) {
                $nav = new XoopsPageNav($social_count, $nb_limit, $start, 'start');
                $xoopsTpl->assign('nav_menu', $nav->renderNav(4));
            }
        } else {
            $xoopsTpl->assign('error_message', _MA_XMSOCIAL_ERROR_NOSOCIAL);
        }
        break;
    
    // Add
    case 'add':
        // Module admin
		$moduleAdmin->addItemButton(_MA_XMSOCIAL_SOCIAL_LIST, 'social.php', 'list');
        $xoopsTpl->assign('renderbutton', $moduleAdmin->renderButton());
		$obj  = $socialHandler->create();
		$form = $obj->getFormSocial();
		$xoopsTpl->assign('form', $form->render());
        break;
		
	// Loadsocial
    case 'loadsocial':
        // Module admin
        $moduleAdmin->addItemButton(_MA_XMSOCIAL_SOCIAL_LIST, 'social.php', 'list');
        $xoopsTpl->assign('renderbutton', $moduleAdmin->renderButton());  
        $social_type = Request::getString('social_type', '');
        if ($social_type == '') {
            $xoopsTpl->assign('error_message', _MA_XMSOCIAL_ERROR_NOSOCIAL);
        } else {
			$obj  = $socialHandler->create();
			$form = $obj->getForm($social_type);
			$xoopsTpl->assign('form', $form->render());
        }
        break;
        
    // Edit
    case 'edit':
        // Module admin
        $moduleAdmin->addItemButton(_MA_XMSOCIAL_SOCIAL_LIST, 'social.php', 'list');
        $xoopsTpl->assign('renderbutton', $moduleAdmin->renderButton());        
        // Form
        $social_id = Request::getInt('social_id', 0);
        if ($social_id == 0) {
            $xoopsTpl->assign('error_message', _MA_XMSOCIAL_ERROR_NOSOCIAL);
        } else {
            $obj = $socialHandler->get($social_id);
            $form = $obj->getForm();
            $xoopsTpl->assign('form', $form->render()); 
        }

        break;
    // Save
    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('social.php', 3, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        $social_id = Request::getInt('social_id', 0);
        if ($social_id == 0) {
            $obj = $socialHandler->create();            
        } else {
            $obj = $socialHandler->get($social_id);
        }
        $error_message = $obj->saveSocial($socialHandler, 'social.php');
        if ($error_message != ''){
            $xoopsTpl->assign('error_message', $error_message);
            $form = $obj->getForm('social.php');
            $xoopsTpl->assign('form', $form->render());
        }
        
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
        
    // Update status
    case 'social_update_status':
        $social_id = Request::getInt('social_id', 0);
        if ($social_id > 0) {
            $obj = $socialHandler->get($social_id);
            $old = $obj->getVar('social_status');
            $obj->setVar('social_status', !$old);
            if ($socialHandler->insert($obj)) {
                exit;
            }
            $xoopsTpl->assign('error_message', $obj->getHtmlErrors());
        }
        break;
}

$xoopsTpl->display("db:xmsocial_admin_social.tpl");

require __DIR__ . '/admin_footer.php';
