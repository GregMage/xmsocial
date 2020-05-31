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
 * Plugin xmnews for xmsocial module
 *
 * @copyright       XOOPS Project (http://xoops.org)
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author          Mage Gregory (AKA Mage)
 */
 
use \Xmf\Request;
use Xmf\Module\Helper;

 class Xmsocialxmnews
 {
	
	public static function RedirectUrl($itemid, $options)
	{
		return XOOPS_URL . '/modules/xmnews/article.php?news_id=' . $itemid;
	}
	
	public static function SaveRating($itemid, $rating, $votes)
	{
		$helper = Helper::getHelper('xmnews');
		$newsHandler  = $helper->getHandler('xmnews_news');
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('news_id', $itemid));
		if ($newsHandler->getcount($criteria) != 0) {
			$obj = $newsHandler->get($itemid);
			$obj->setVar('news_rating', $rating);
			$obj->setVar('news_votes', $votes);
			if ($newsHandler->insert($obj)) {
				return true;
			} else {
				return $obj->getHtmlErrors();
			}
		}
		return false;
	}
	
	public static function Url($itemid)
	{
		return XOOPS_URL . '/modules/xmnews/article.php?news_id=' . $itemid;
	}
	
	public static function ItemNames($itemids)
	{
		$helper = Helper::getHelper('xmnews');
		$newsHandler  = $helper->getHandler('xmnews_news');
		$criteria = new CriteriaCompo();
		$criteria->setSort('news_title');
		$criteria->setOrder('ASC');
		$criteria->add(new Criteria('news_id', '(' . implode(',', $itemids) . ')', 'IN'));
		$news_arr = $newsHandler->getall($criteria);
		if (count($news_arr) > 0){
			foreach (array_keys($news_arr) as $i) {
				$item_arr[$i] = $news_arr[$i]->getVar('news_title');
			}
			return $item_arr;
		} else {
			return array();
		}
	}
	 
 }
