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
 * Plugin xmarticle for xmsocial module
 *
 * @copyright       XOOPS Project (http://xoops.org)
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author          Mage Gregory (AKA Mage)
 */
 
use \Xmf\Request;
use Xmf\Module\Helper;

/**
 * Class Xmsocialxmarticle
 */
 class Xmsocialxmarticle
 {
     /**
      * @param $itemid
      * @param $options
      * @return string
      */
	public static function RedirectUrl($itemid, $options)
	{
		return XOOPS_URL . '/modules/xmarticle/viewarticle.php?category_id=' . $options['cat'] . '&article_id=' . $itemid;
	}

     /**
      * @param $itemid
      * @param $rating
      * @param $votes
      * @return bool
      */
	public static function SaveRating($itemid, $rating, $votes)
	{
		$helper = Helper::getHelper('xmarticle');
		$articleHandler  = $helper->getHandler('xmarticle_article');
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('article_id', $itemid));
		if ($articleHandler->getcount($criteria) != 0) {
			$obj = $articleHandler->get($itemid);
			$obj->setVar('article_rating', $rating);
			$obj->setVar('article_votes', $votes);
			if ($articleHandler->insert($obj)) {
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
	public static function Url($itemid, $options)
	{
		return self::RedirectUrl($itemid, $options);
	}

     /**
      * @param $itemids
      * @return array
      */
	public static function ItemNames($itemids)
	{
		$helper = Helper::getHelper('xmarticle');
		$articleHandler  = $helper->getHandler('xmarticle_article');
		$criteria = new CriteriaCompo();
		$criteria->setSort('article_name');
		$criteria->setOrder('ASC');
		$criteria->add(new Criteria('article_id', '(' . implode(',', $itemids) . ')', 'IN'));
		$article_arr = $articleHandler->getall($criteria);
		if (count($article_arr) > 0){
			foreach (array_keys($article_arr) as $i) {
				$item_arr[$i] = $article_arr[$i]->getVar('article_name');
			}
			return $item_arr;
		} else {
			return array();
		}
	}
	 
 }
