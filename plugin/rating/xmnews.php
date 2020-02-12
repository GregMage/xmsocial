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
	
	private $dataLayout = '';
	
	
	public static function RedirectUrl($itemid)
	{
		return XOOPS_URL . '/modules/xmnews/article.php?news_id=' . $itemid;
	}
	
	public static function SaveRating($itemid, $rating, $votes)
	{
		$helper = Helper::getHelper('xmnews');
		$newsHandler  = $helper->getHandler('xmnews_news');
		$obj = $newsHandler->get($itemid);
		$obj->setVar('news_rating', $rating);
		$obj->setVar('news_votes', $votes);
		if ($newsHandler->insert($obj)) {
			return True;
		} else {
			return $obj->getHtmlErrors();
		}
	}
	 
 }
