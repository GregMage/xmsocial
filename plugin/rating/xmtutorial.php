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
 * Plugin xmtutorial for xmsocial module
 *
 * @copyright       XOOPS Project (http://xoops.org)
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author          Mage Gregory (AKA Mage)
 */
 
use \Xmf\Request;
use Xmf\Module\Helper;

/**
 * Class Xmsocialxmtutorial
 */
 class Xmsocialxmtutorial
 {
     /**
      * @param $itemid
      * @param $options
      * @return string
      */
	public static function RedirectUrl($itemid, $options)
	{
		return XOOPS_URL . '/modules/xmtutorial/tutorial.php?tutorial_id=' . $itemid;
	}

     /**
      * @param $itemid
      * @param $rating
      * @param $votes
      * @return bool
      */
	public static function SaveRating($itemid, $rating, $votes)
	{
		$helper = Helper::getHelper('xmtutorial');
		$tutorialHandler  = $helper->getHandler('xmtutorial_tutorial');
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('tutorial_id', $itemid));
		if ($tutorialHandler->getcount($criteria) != 0) {
			$obj = $tutorialHandler->get($itemid);
			$obj->setVar('tutorial_rating', $rating);
			$obj->setVar('tutorial_votes', $votes);
			if ($tutorialHandler->insert($obj)) {
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
		return XOOPS_URL . '/modules/xmtutorial/tutorial.php?tutorial_id=' . $itemid;
	}

     /**
      * @param $itemids
      * @return array
      */
	public static function ItemNames($itemids)
	{
		$helper = Helper::getHelper('xmtutorial');
		$tutorialHandler  = $helper->getHandler('xmtutorial_tutorial');
		$criteria = new CriteriaCompo();
		$criteria->setSort('tutorial_title');
		$criteria->setOrder('ASC');
		$criteria->add(new Criteria('tutorial_id', '(' . implode(',', $itemids) . ')', 'IN'));
		$tutorial_arr = $tutorialHandler->getall($criteria);
		if (count($tutorial_arr) > 0){
			foreach (array_keys($tutorial_arr) as $i) {
				$item_arr[$i] = $tutorial_arr[$i]->getVar('tutorial_title');
			}
			return $item_arr;
		} else {
			return array();
		}
	}
	 
 }
