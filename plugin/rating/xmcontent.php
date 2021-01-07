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
 * Plugin xmcontent for xmsocial module
 *
 * @copyright       XOOPS Project (http://xoops.org)
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author          Mage Gregory (AKA Mage)
 */
 
use \Xmf\Request;
use Xmf\Module\Helper;

/**
 * Class Xmsocialxmcontent
 */
 class Xmsocialxmcontent
 {
     /**
      * @param $itemid
      * @param $options
      * @return string
      */
	public static function RedirectUrl($itemid, $options)
	{
		return XOOPS_URL . '/modules/xmcontent/viewcontent.php?content_id=' . $itemid;
	}

     /**
      * @param $itemid
      * @param $rating
      * @param $votes
      * @return bool
      */
	public static function SaveRating($itemid, $rating, $votes)
	{
		$helper = Helper::getHelper('xmcontent');
		$contentHandler  = $helper->getHandler('xmcontent_content');
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('content_id', $itemid));
		if ($contentHandler->getcount($criteria) != 0) {
			$obj = $contentHandler->get($itemid);
			$obj->setVar('content_rating', $rating);
			$obj->setVar('content_votes', $votes);
			if ($contentHandler->insert($obj)) {
				return true;
			} else {
				return $obj->getHtmlErrors();
			}
		}
		return false;
	}

     /**
      * @param $itemid
      * @return string
      */
	public static function Url($itemid)
	{
		return XOOPS_URL . '/modules/xmcontent/viewcontent.php?content_id=' . $itemid;
	}

     /**
      * @param $itemids
      * @return array
      */
	public static function ItemNames($itemids)
	{
		$helper = Helper::getHelper('xmcontent');
		$contentHandler  = $helper->getHandler('xmcontent_content');
		$criteria = new CriteriaCompo();
		$criteria->setSort('content_title');
		$criteria->setOrder('ASC');
		$criteria->add(new Criteria('content_id', '(' . implode(',', $itemids) . ')', 'IN'));
		$content_arr = $contentHandler->getall($criteria);
		if (count($content_arr) > 0){
			foreach (array_keys($content_arr) as $i) {
				$item_arr[$i] = $content_arr[$i]->getVar('content_title');
			}
			return $item_arr;
		} else {
			return array();
		}
	}
	 
 }
