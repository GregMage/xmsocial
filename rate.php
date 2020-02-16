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

use \Xmf\Request;
use Xmf\Module\Helper;

include_once __DIR__ . '/header.php';
include_once XOOPS_ROOT_PATH . '/header.php';

$modulename = Request::getString('mod', '');
$itemid = Request::getInt('itemid', 0);
$rating = Request::getInt('rating', 0);
$options = unserialize(Request::getString('opt', ''));

if ($modulename == '' || $itemid == 0 || $rating < 1 || $rating > 10){
	redirect_header(XOOPS_URL, 2, _NOPERM);
}
if (!xoops_isActiveModule($modulename)){
	redirect_header(XOOPS_URL, 10,  _MA_XMSOCIAL_RATE_ERRORMODULE);
}
$RatingPlugin = new RatingPlugin();
if ($RatingPlugin->CheckPlugin($modulename) == false){
	redirect_header(XOOPS_URL, 10, _MA_XMSOCIAL_RATE_ERRORPLUGIN);
}
$redirect_url = $RatingPlugin->RedirectUrl($modulename, $itemid, $options);
$helper = Helper::getHelper($modulename);
$moduleid = $helper->getModule()->getVar('mid');
if ($permHelper->checkPermission('xmsocial_rating',$moduleid) === false){	
	redirect_header($redirect_url, 3, _NOPERM);
}
$userid = !empty($xoopsUser) ? $xoopsUser->getVar('uid') : 0;
$criteria = new CriteriaCompo();
$criteria->add(new Criteria('rating_itemid', $itemid));
$criteria->add(new Criteria('rating_modid', $moduleid));
if ($xoopsUser){
	$criteria->add(new Criteria('rating_uid', $xoopsUser->getVar('uid')));
} else {
	$criteria->add(new Criteria('rating_hostname', getenv("REMOTE_ADDR")));
}
$rating_count = $ratingHandler->getCount($criteria);
if ($rating_count > 0) {	
		redirect_header($redirect_url, 5, _MA_XMSOCIAL_RATE_ALREADYVOTED);
}
$obj = $ratingHandler->create();
$obj->setVar('rating_itemid', $itemid);
$obj->setVar('rating_modid', $moduleid);
$obj->setVar('rating_value', $rating);
$obj->setVar('rating_uid', !empty($xoopsUser) ? $xoopsUser->getVar('uid') : 0);
$obj->setVar('rating_hostname', getenv("REMOTE_ADDR"));
$obj->setVar('rating_date', time());
if ($ratingHandler->insert($obj)){
	$criteria = new CriteriaCompo();
	$criteria->add(new Criteria('rating_itemid', $itemid));
	$criteria->add(new Criteria('rating_modid', $moduleid));
	$rating_arr = $ratingHandler->getall($criteria);
	$votes = 0;
	$rating = 0;
	foreach (array_keys($rating_arr) as $i) {
		$votes++;
		$rating = $rating + $rating_arr[$i]->getVar('rating_value');
	}
	$rating = number_format($rating/$votes);	
	if ($RatingPlugin->SaveRating($modulename, $itemid, $rating, $votes) == true){
		redirect_header($redirect_url, 3, _MA_XMSOCIAL_RATE_RATED);
	} else {
		redirect_header($redirect_url, 5, _MA_XMSOCIAL_RATE_NOTRATED);
	}	
} else {
	$obj->getHtmlErrors();
}

include XOOPS_ROOT_PATH . '/footer.php';



