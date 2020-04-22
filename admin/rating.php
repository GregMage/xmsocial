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
        $xoTheme->addScript('modules/system/js/admin.js');
		// Get start pager
        $start = Request::getInt('start', 0);
        $xoopsTpl->assign('start', $start);
		
		$module_handler = xoops_getHandler('module');
		$modules_arr = $module_handler->getObjects();
		$modules = array();		
		foreach (array_keys($modules_arr) as $i) {
			$modules[$modules_arr[$i]->getVar('mid')]['name']    = $modules_arr[$i]->getVar('name');
			$modules[$modules_arr[$i]->getVar('mid')]['dirname'] = $modules_arr[$i]->getVar('dirname');
		}        
        // Criteria
        $criteria = new CriteriaCompo();
        $criteria->setSort('rating_date');
        $criteria->setOrder('DESC');
        $criteria->setStart($start);
        $criteria->setLimit($nb_limit);
		$rating_arr = $ratingHandler->getall($criteria);
        $rating_count = $ratingHandler->getCount($criteria);
        $xoopsTpl->assign('rating_count', $rating_count);
		$SocialPlugin = new SocialPlugin();
        if ($rating_count > 0) {
            foreach (array_keys($rating_arr) as $i) {
                $rating['id']          = $rating_arr[$i]->getVar('rating_id');
                $rating['itemid']      = $rating_arr[$i]->getVar('rating_itemid');
				if (empty($modules[$rating_arr[$i]->getVar('rating_modid')]['name'])){
					$rating['modulename']  = '/';
				} else {
					$rating['modulename']  = $modules[$rating_arr[$i]->getVar('rating_modid')]['name'];
				}                
                $rating['value']       = $rating_arr[$i]->getVar('rating_value');
                $rating['uid']         = XoopsUser::getUnameFromId($rating_arr[$i]->getVar('rating_uid'));
                $rating['hostname']    = $rating_arr[$i]->getVar('rating_hostname');
                
				$RatingPlugin = new RatingPlugin();
				if (empty($modules[$rating_arr[$i]->getVar('rating_modid')]['name'])){
					$rating['item']   = '';
				} else {
					if ($RatingPlugin->CheckPlugin($modules[$rating_arr[$i]->getVar('rating_modid')]['dirname']) == false){
						$rating['item']   = '';
					} else {
						$rating['item']   = $RatingPlugin->Url($modules[$rating_arr[$i]->getVar('rating_modid')]['dirname'], $rating_arr[$i]->getVar('rating_itemid'));
					}
				}
                $rating['date']		   = formatTimestamp($rating_arr[$i]->getVar('rating_date'), 'm');
                $xoopsTpl->append_by_ref('rating', $rating);
                unset($rating);
            }
            // Display Page Navigation
            if ($rating_count > $nb_limit) {
                $nav = new XoopsPageNav($rating_count, $nb_limit, $start, 'start');
                $xoopsTpl->assign('nav_menu', $nav->renderNav(4));
            }
        } else {
            $xoopsTpl->assign('error_message', _MA_XMSOCIAL_ERROR_NORATING);        
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
        
    }

$xoopsTpl->display("db:xmsocial_admin_rating.tpl");

require __DIR__ . '/admin_footer.php';
