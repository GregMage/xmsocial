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
use Xmf\Module\Helper;

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
		
		$RatingPlugin = new RatingPlugin();
		$plugin_error = false;
		
		$module_handler = xoops_getHandler('module');
		$modules_arr = $module_handler->getObjects();
		$modules = array();		
		foreach (array_keys($modules_arr) as $i) {
			$modules[$modules_arr[$i]->getVar('mid')]['name']    = $modules_arr[$i]->getVar('name');
			$modules[$modules_arr[$i]->getVar('mid')]['dirname'] = $modules_arr[$i]->getVar('dirname');
			$modules[$modules_arr[$i]->getVar('mid')]['isactive'] = $modules_arr[$i]->getVar('isactive');
		}
		// filtres
		$xoopsTpl->assign('filter', true);
		$uname  = Request::getInt('uname', -1);
		$module = Request::getInt('module', 0);
		$item   = Request::getInt('item', 0);
		$xoopsTpl->assign('uname', $uname);
		$xoopsTpl->assign('module', $module);
		$xoopsTpl->assign('item', $item);
		// Criteria
        $criteria = new CriteriaCompo();
		$rating_arr = $ratingHandler->getall($criteria);
		if (count($rating_arr) > 0) {
			foreach (array_keys($rating_arr) as $i) {
				$uname_arr[$rating_arr[$i]->getVar('rating_uid')] = XoopsUser::getUnameFromId($rating_arr[$i]->getVar('rating_uid'));
				$module_arr[$rating_arr[$i]->getVar('rating_modid')] = $modules[$rating_arr[$i]->getVar('rating_modid')]['name'];
				if ($module != 0){
					if ($rating_arr[$i]->getVar('rating_modid') == $module){
						$item_temp_arr[] = $rating_arr[$i]->getVar('rating_itemid');
					}					
				}
			}
			// filtre uname
			asort($uname_arr);
			if (count($uname_arr) > 0) {
				$uname_options = '<option value="-1"' . ($uname == -1 ? ' selected="selected"' : '') . '>' . _ALL .'</option>';
				foreach (array_keys($uname_arr) as $i) {
					$uname_options .= '<option value="' . $i . '"' . ($uname == $i ? ' selected="selected"' : '') . '>' . $uname_arr[$i] . '</option>';
				}				
				$xoopsTpl->assign('uname_options', $uname_options);
			}		
			// filtre module		
			if (count($module_arr) > 0) {
				$module_options = '<option value="0"' . ($module == 0 ? ' selected="selected"' : '') . '>' . _ALL .'</option>';
				foreach (array_keys($module_arr) as $i) {
					$module_options .= '<option value="' . $i . '"' . ($module == $i ? ' selected="selected"' : '') . '>' . $module_arr[$i] . '</option>';
				}				
				$xoopsTpl->assign('module_options', $module_options);
			}
			// filtre item
			if ($module != 0){
				if (count($item_temp_arr) > 0) {
					$item_temp_arr = array_unique($item_temp_arr);
					if ($RatingPlugin->CheckPlugin($modules[$module]['dirname']) == true){
						$item_arr = $RatingPlugin->ItemNames($modules[$module]['dirname'], $item_temp_arr);
						$item_options = '<option value="0"' . ($item == 0 ? ' selected="selected"' : '') . '>' . _ALL .'</option>';
						foreach (array_keys($item_arr) as $i) {
							if (strlen($item_arr[$i]) > 30){
								$item_name = substr($item_arr[$i],0 , 30) . '...';
							} else {
								$item_name = $item_arr[$i];
							}	
							$item_options .= '<option value="' . $i . '"' . ($item == $i ? ' selected="selected"' : '') . '>' . $item_name . '</option>';
						}				
						$xoopsTpl->assign('item_options', $item_options);
						$xoopsTpl->assign('view_item', true);
					} else {
						$item == 0;
						$plugin_error = true;
					}					
				}
			}
			// Criteria
			$criteria = new CriteriaCompo();
			$criteria->setSort('rating_date');
			$criteria->setOrder('DESC');
			$criteria->setStart($start);
			$criteria->setLimit($nb_limit);
			if ($uname != -1){
				$criteria->add(new Criteria('rating_uid', $uname));
			}
			if ($module != 0){
				$criteria->add(new Criteria('rating_modid', $module));
				if ($item != 0){
					$criteria->add(new Criteria('rating_itemid', $item));
				}
			}
			$rating_arr = $ratingHandler->getall($criteria);
			$rating_count = $ratingHandler->getCount($criteria);
			$xoopsTpl->assign('rating_count', $rating_count);
			$uname_arr = array();        
            foreach (array_keys($rating_arr) as $i) {
                $rating['id']          = $rating_arr[$i]->getVar('rating_id');
                $rating['itemid']      = $rating_arr[$i]->getVar('rating_itemid');
				if (empty($modules[$rating_arr[$i]->getVar('rating_modid')]['name'])){
					$rating['modulename']  = '/';
				} else {
					$rating['modulename']  = $modules[$rating_arr[$i]->getVar('rating_modid')]['name'];
					$rating['isactive']    = $modules[$rating_arr[$i]->getVar('rating_modid')]['isactive'];
				}                
                $rating['value']       = $rating_arr[$i]->getVar('rating_value');
                $rating['uid']         = XoopsUser::getUnameFromId($rating_arr[$i]->getVar('rating_uid'));				
                $rating['hostname']    = $rating_arr[$i]->getVar('rating_hostname');
				if ($module != 0 && $plugin_error == false){
					$rating['title']       = $item_arr[$rating_arr[$i]->getVar('rating_itemid')];
				}
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
                $nav = new XoopsPageNav($rating_count, $nb_limit, $start, 'start', 'module=' . $module . '&item=' . $item . '&uname=' . $uname);
                $xoopsTpl->assign('nav_menu', $nav->renderNav(4));
            }
        } else {
            $xoopsTpl->assign('error_message', _MA_XMSOCIAL_ERROR_NORATING);        
		}
        
        break;
            
    // del
    case 'del':    
        $rating_id = Request::getInt('rating_id', 0);		
        if ($rating_id == 0) {
            $xoopsTpl->assign('error_message', _MA_XMSOCIAL_ERROR_NORATING);
        } else {
            $surdel = Request::getBool('surdel', false);
            $obj  = $ratingHandler->get($rating_id);
            if ($surdel === true) {
                if (!$GLOBALS['xoopsSecurity']->check()) {
                    redirect_header('rating.php', 3, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
                }
                if ($ratingHandler->delete($obj)) {
					$modulename = Request::getString('mod', '');
					$itemid = Request::getInt('itemid', 0);
					if ($modulename == '' || $itemid == 0){
						redirect_header('rating.php', 2, _MA_XMSOCIAL_REDIRECT_SAVE);
					} else {
						$helper = Helper::getHelper($modulename);
						$moduleid = $helper->getModule()->getVar('mid');
						XmsocialUtility::updateRating($modulename, $itemid, $moduleid);
						redirect_header('rating.php', 2, _MA_XMSOCIAL_REDIRECT_SAVE);
					}
                } else {
                    $xoopsTpl->assign('error_message', $obj->getHtmlErrors());
                }
            } else {
				$module_handler = xoops_getHandler('module');
				$modules_arr = $module_handler->getObjects();
				$modules = array();		
				foreach (array_keys($modules_arr) as $i) {
					$modules[$modules_arr[$i]->getVar('mid')]['name']    = $modules_arr[$i]->getVar('name');
					$modules[$modules_arr[$i]->getVar('mid')]['dirname'] = $modules_arr[$i]->getVar('dirname');
				}
				$RatingPlugin = new RatingPlugin();
				if (empty($modules[$obj->getVar('rating_modid')]['dirname'])){
					$itemidString = $obj->getVar('rating_itemid');
					$modulename = '';
				} else {
					if ($RatingPlugin->CheckPlugin($modules[$obj->getVar('rating_modid')]['dirname']) == false){
						$itemidString = $obj->getVar('rating_itemid');
						$modulename = '';
					} else {
						$item_name = $RatingPlugin->ItemNames($modules[$obj->getVar('rating_modid')]['dirname'], array($obj->getVar('rating_itemid')));
						$itemidString = '<a href="' . $RatingPlugin->Url($modules[$obj->getVar('rating_modid')]['dirname'], $obj->getVar('rating_itemid')) . '" title="' . _MA_XMSOCIAL_RATING_VIEW . '" target="_blank">' . $item_name[$obj->getVar('rating_itemid')] . '</a>';
						$modulename = $modules[$obj->getVar('rating_modid')]['dirname'];
					}
				}			
                xoops_confirm(array('surdel' => true, 'rating_id' => $rating_id, 'op' => 'del', 'mod' => $modulename, 'itemid' => $obj->getVar('rating_itemid')), $_SERVER['REQUEST_URI'], 
                                    sprintf(_MA_XMSOCIAL_RATING_SUREDEL, '<br>' . $itemidString));
            }
        }
        
        break;
        
    }

$xoopsTpl->display("db:xmsocial_admin_rating.tpl");

require __DIR__ . '/admin_footer.php';
