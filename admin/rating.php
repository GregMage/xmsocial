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
		
		
		$uname = Request::getInt('uname', -1);
		// Criteria
        $criteria = new CriteriaCompo();
		$rating_arr = $ratingHandler->getall($criteria);
		if (count($rating_arr) > 0) {
			foreach (array_keys($rating_arr) as $i) {
				$uname_arr[$rating_arr[$i]->getVar('rating_uid')] = XoopsUser::getUnameFromId($rating_arr[$i]->getVar('rating_uid'));
			}
		}
		asort($uname_arr);
		if (count($uname_arr) > 0) {
			$uname_options = '<option value="-1"' . ($uname == -1 ? ' selected="selected"' : '') . '>' . _ALL .'</option>';
			foreach (array_keys($uname_arr) as $i) {
				$uname_options .= '<option value="' . $i . '"' . ($uname == $i ? ' selected="selected"' : '') . '>' . $uname_arr[$i] . '</option>';
			}				
			$xoopsTpl->assign('uname_options', $uname_options);
		}
		
		$module_handler = xoops_getHandler('module');
		$modules_arr = $module_handler->getObjects();
		$modules = array();		
		foreach (array_keys($modules_arr) as $i) {
			$modules[$modules_arr[$i]->getVar('mid')]['name']    = $modules_arr[$i]->getVar('name');
			$modules[$modules_arr[$i]->getVar('mid')]['dirname'] = $modules_arr[$i]->getVar('dirname');
		}
		$xoopsTpl->assign('filter', true);
        // Criteria
        $criteria = new CriteriaCompo();
        $criteria->setSort('rating_date');
        $criteria->setOrder('DESC');
        $criteria->setStart($start);
        $criteria->setLimit($nb_limit);
		if ($uname != -1){
			$criteria->add(new Criteria('rating_uid', $uname));
		}
		$rating_arr = $ratingHandler->getall($criteria);
        $rating_count = $ratingHandler->getCount($criteria);
        $xoopsTpl->assign('rating_count', $rating_count);
		$RatingPlugin = new RatingPlugin();
		$uname_arr = array();
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
						$itemidString = '<a href="' . $RatingPlugin->Url($modules[$obj->getVar('rating_modid')]['dirname'], $obj->getVar('rating_itemid')) . '" title="' . _MA_XMSOCIAL_RATING_VIEW . '" target="_blank">' . $obj->getVar('rating_itemid') . '</a>';
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
