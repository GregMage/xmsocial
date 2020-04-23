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
 * Plugin xmdoc for xmsocial module
 *
 * @copyright       XOOPS Project (http://xoops.org)
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author          Mage Gregory (AKA Mage)
 */
 
use \Xmf\Request;
use Xmf\Module\Helper;

 class Xmsocialxmdoc
 {
	
	public static function RedirectUrl($itemid, $options)
	{
		if ($options['mod'] == 'xmnews'){
			return XOOPS_URL . '/modules/xmnews/article.php?news_id=' . $options['id'];
		}
		
		if ($options['mod'] == 'xmdoc_document'){
			return XOOPS_URL . '/modules/xmdoc/document.php?doc_id=' . $options['id'];
		}
		
		return XOOPS_URL . '/modules/xmdoc/index.php';
	}
	
	public static function SaveRating($itemid, $rating, $votes)
	{
		$helper = Helper::getHelper('xmdoc');
		$documentHandler = $helper->getHandler('xmdoc_document');
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('document_id', $itemid));
		if ($documentHandler->getcount($criteria) != 0) {
			$obj = $documentHandler->get($itemid);
			$obj->setVar('document_rating', $rating);
			$obj->setVar('document_votes', $votes);
			if ($documentHandler->insert($obj)) {
				return true;
			} else {
				return $obj->getHtmlErrors();
			}
		}
		return false;
	}
	
	public static function Url($itemid)
	{
		return XOOPS_URL . '/modules/xmdoc/admin/document.php?op=edit&document_id=' . $itemid;
	}
	 
 }
