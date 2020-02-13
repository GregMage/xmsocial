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
use Xmf\Module\Helper;
/**
 * Class XmsocialUtility
 */

class XmsocialUtility{
	
	public static function renderRating($xoopsTpl, $xoTheme, $modulename = '', $itemid = 0, $stars = 5, $rating = 0, $votes = 0)
    {
        include __DIR__ . '/../include/common.php';
		$permHelper = new Helper\Permission();
		$xmsocialHelper = Helper::getHelper('xmsocial');
		$xmsocialHelper->loadLanguage('main');
		if ($stars > 10){			
			$stars = 10;
		}
		if ($stars < 3){			
			$stars = 3;
		}
		$helper = Helper::getHelper($modulename);
		$moduleid = $helper->getModule()->getVar('mid');
		if ($permHelper->checkPermission('xmsocial_rating',$moduleid) === false){	
			$xoopsTpl->assign('xmsocial_perm', false);
		} else {        
			$xoTheme->addStylesheet( XOOPS_URL . '/modules/xmsocial/assets/css/rating.css', null );
			$xoopsTpl->assign('xmsocial_perm', true);			
			
			for ($count = 1; $count <= $stars; $count++){
				$count_stars = $count;
				$xoopsTpl->append_by_ref('xmsocial_stars', $count_stars);
				unset($count_stars);
			}			
			$xoopsTpl->assign('xmsocial_module', $modulename);	
			$xoopsTpl->assign('xmsocial_size', (25 * number_format($rating, 1)) . 'px');	
			$xoopsTpl->assign('xmsocial_itemid', $itemid);
		}			
		$xoopsTpl->assign('xmsocial_rating', number_format($rating, 1));
		$xoopsTpl->assign('xmsocial_total', $stars);
		$xoopsTpl->assign('xmsocial_votes', sprintf(_MA_XMSOCIAL_RATING_VOTES, $votes));
    }
}
