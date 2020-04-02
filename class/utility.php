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
	
	public static function renderRating($xoTheme, $modulename = '', $itemid = 0, $stars = 5, $rating = 0, $votes = 0, $options = array())
    {
        $xmsocial_rating = array();
		include __DIR__ . '/../include/common.php';
		$permHelper = new Helper\Permission('xmsocial');
		$xmsocialHelper = Helper::getHelper('xmsocial');
		$xmsocialHelper->loadLanguage('main');
		if ($stars > 10){			
			$stars = 10;
		}
		if ($stars < 3){			
			$stars = 3;
		}
		$options = serialize($options);
		$helper = Helper::getHelper($modulename);
		$moduleid = $helper->getModule()->getVar('mid');
		if ($permHelper->checkPermission('xmsocial_rating', $moduleid) === false){	
			$xmsocial_rating['perm'] = false;
		} else {    
			$xoTheme->addStylesheet( XOOPS_URL . '/modules/xmsocial/assets/css/rating.css', null );
			$xmsocial_rating['perm'] = true;			
			for ($count = 1; $count <= $stars; $count++){
				$count_stars = $count;
				$xmsocial_rating['stars'][] = $count_stars;
				unset($count_stars);
			}
			$xmsocial_rating['module'] = $modulename;
			$xmsocial_rating['size'] = (25 * number_format($rating, 1)) . 'px';
			$xmsocial_rating['itemid'] = $itemid;
		}			
		$xmsocial_rating['rating'] = XmsocialUtility::renderVotes($rating, $votes);
		$xmsocial_rating['options'] = $options;
		
		return $xmsocial_rating;
    }
	
	public static function renderVotes($rating = 0, $votes = 0)
    {
		$xmsocialHelper = Helper::getHelper('xmsocial');
		$xmsocialHelper->loadLanguage('main');	
		$xmsocial_rating = number_format($rating, 1) . ' ';;
		if ($votes < 2) {
			$xmsocial_rating .= sprintf(_MA_XMSOCIAL_RATING_VOTE, $votes);
		} else {		
			$xmsocial_rating .= sprintf(_MA_XMSOCIAL_RATING_VOTES, $votes);
		}
		
		return $xmsocial_rating;
    }
}
