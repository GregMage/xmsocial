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

	public static function renderRating($modulename = '', $itemid = 0, $stars = 5, $rating = 0, $votes = 0, $options = array())
    {
		$xmsocial_rating = array();
		global $xoTheme;
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
		$options = json_encode($options);
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
			$xmsocial_rating['size'] = number_format(25 * $rating, 1) . 'px';
			$xmsocial_rating['itemid'] = $itemid;
		}
		$xmsocial_rating['votes'] = $votes;
		$xmsocial_rating['rating'] = number_format($rating, 1);
		if ($votes < 2) {
			$xmsocial_rating['text'] = _MA_XMSOCIAL_RATING_VOTE;
		} else {
			$xmsocial_rating['text'] = _MA_XMSOCIAL_RATING_VOTES;
		}
		$xmsocial_rating['options'] = $options;

		return $xmsocial_rating;
    }

    /**
     * @param int $rating
     * @param int $votes
     * @return string
     */
	public static function renderVotes($rating = 0, $votes = 0)
    {
		$xmsocialHelper = Helper::getHelper('xmsocial');
		$xmsocialHelper->loadLanguage('main');
		$xmsocial_rating = number_format($rating, 1) . ' ';
		if ($votes < 2) {
			$xmsocial_rating .= '(' . $votes . ' ' . _MA_XMSOCIAL_RATING_VOTE .')';
		} else {
			$xmsocial_rating .= '(' . $votes . ' ' . _MA_XMSOCIAL_RATING_VOTES .')';
		}

		return $xmsocial_rating;
    }

    /**
     * @param $modulename
     * @param $itemid
     * @param $moduleid
     * @return bool
     */
	public static function updateRating($modulename, $itemid, $moduleid)
    {
		include __DIR__ . '/../include/common.php';
		$RatingPlugin = new RatingPlugin();
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
		if ($votes != 0) {
			$rating = number_format($rating/$votes, 4);
		} else {
			$rating = 0;
		}
		if ($RatingPlugin->SaveRating($modulename, $itemid, $rating, $votes) == true){
			return true;
		} else {
			return false;
		}
    }

    /**
     * @param string $modulename
     * @param int $itemid
     * @return string
     */
	public static function delRatingdata($modulename = '', $itemid = 0)
    {
        include __DIR__ . '/../include/common.php';
		$helper = Helper::getHelper($modulename);
		$moduleid = $helper->getModule()->getVar('mid');
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('rating_modid', $moduleid));
		$criteria->add(new Criteria('rating_itemid', $itemid));
		$ratingHandler->deleteAll($criteria);
        return '';
    }

    /**
     * @param $form
     * @param string $modulename
     * @param int $itemid
     * @return mixed
     */
    public static function renderSocialForm($form, $modulename = '', $itemid = 0)
    {
        include __DIR__ . '/../include/common.php';
		include_once __DIR__ . '/SocialPlugin.php';
		$xmsocialHelper = Helper::getHelper('xmsocial');
		$xmsocialHelper->loadLanguage('main');
		// module id
		$helper = Helper::getHelper($modulename);
		$moduleid = $helper->getModule()->getVar('mid');
		// Criteria
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('socialdata_modid', $moduleid));
		$criteria->add(new Criteria('socialdata_itemid', $itemid));
		$socialdata_arr = $socialdataHandler->getall($criteria);
		if (count($socialdata_arr) > 0) {
			foreach (array_keys($socialdata_arr) as $i) {
				$value[] = $socialdata_arr[$i]->getVar('socialdata_socialid');
			}
		} else {
			$value = array();
		}
		// Criteria
        $criteria = new CriteriaCompo();
		$criteria->add(new Criteria('social_status', 1));
        $criteria->setSort('social_weight ASC, social_name');
        $criteria->setOrder('ASC');
		$social_arr = $socialHandler->getall($criteria);
		if (count($social_arr) > 0) {
			$SocialPlugin = new SocialPlugin();
			$social = new XoopsFormCheckBox(_MA_XMSOCIAL_SOCIAL_FORM, 'socials', $value);
			$social->columns = 3;
			foreach (array_keys($social_arr) as $i) {
				$options = explode(',', $social_arr[$i]->getVar('social_options'));
				$social->addOption($i, $SocialPlugin->render($social_arr[$i]->getVar('social_type'), '', $options));
			}
			$form->addElement($social, false);
		}
		return $form;
    }

    /**
     * @param string $modulename
     * @param int $itemid
     * @return string
     */
	public static function saveSocial($modulename = '', $itemid = 0)
    {
        include __DIR__ . '/../include/common.php';
		$error_message = '';
		// module id
		$helper = Helper::getHelper($modulename);
		$moduleid = $helper->getModule()->getVar('mid');
		if (isset($_REQUEST['socials'])) {
			if (is_array($_REQUEST['socials']) == true){
				$socials = $_REQUEST['socials'];
			} else {
				$socials[] = $_REQUEST['socials'];
			}
			// Criteria
			$criteria = new CriteriaCompo();
			$social_arr = $socialHandler->getall($criteria);
			if (count($social_arr) > 0) {
				foreach (array_keys($social_arr) as $i) {
					if (in_array($i, $socials)) {
						// vérification pour savoir si le media social est déjà existant et création de l'entrée si pas existant
						$criteria = new CriteriaCompo();
						$criteria->add(new Criteria('socialdata_socialid', $i));
						$criteria->add(new Criteria('socialdata_modid', $moduleid));
						$criteria->add(new Criteria('socialdata_itemid', $itemid));
						$socialdata_count = $socialdataHandler->getCount($criteria);
						if ($socialdata_count == 0) {
							$obj  = $socialdataHandler->create();
							$obj->setVar('socialdata_socialid', $i);
							$obj->setVar('socialdata_modid', $moduleid);
							$obj->setVar('socialdata_itemid', $itemid);
							if ($socialdataHandler->insert($obj)){
								$error_message .= '';
							} else {
								$error_message .= 'socialdata socialid: ' . $i . '<br>' . $obj->getHtmlErrors();
							}
						}
					} else {
						// Suppression du media social si il est existant
						$criteria = new CriteriaCompo();
						$criteria->add(new Criteria('socialdata_socialid', $i));
						$criteria->add(new Criteria('socialdata_modid', $moduleid));
						$criteria->add(new Criteria('socialdata_itemid', $itemid));
						$socialdataHandler->deleteAll($criteria);
					}
				}
			}
		} else {
			$criteria = new CriteriaCompo();
			$criteria->add(new Criteria('socialdata_modid', $moduleid));
			$criteria->add(new Criteria('socialdata_itemid', $itemid));
			$socialdataHandler->deleteAll($criteria);
		}
        return $error_message;
    }

    /**
     * @param string $modulename
     * @param int $itemid
     * @return string
     */
	public static function delSocialdata($modulename = '', $itemid = 0)
    {
        include __DIR__ . '/../include/common.php';

		$helper = Helper::getHelper($modulename);
		$moduleid = $helper->getModule()->getVar('mid');
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('socialdata_modid', $moduleid));
		$criteria->add(new Criteria('socialdata_itemid', $itemid));
		$socialdataHandler->deleteAll($criteria);
        return '';
    }

    /**
     * @param $xoopsTpl
     * @param string $modulename
     * @param int $itemid
     * @param string $url
     */
	public static function renderSocial($modulename = '', $itemid = 0, $url = '')
    {
        include __DIR__ . '/../include/common.php';
		include_once __DIR__ . '/SocialPlugin.php';
		global $xoopsTpl;

		$helper = Helper::getHelper($modulename);
		$moduleid = $helper->getModule()->getVar('mid');
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('socialdata_modid', $moduleid));
		$criteria->add(new Criteria('socialdata_itemid', $itemid));
		$criteria->add(new Criteria('social_status', 1));
		$criteria->setSort('social_weight ASC, social_name');
		$criteria->setOrder('ASC');

		$socialdataHandler->table_link = $socialdataHandler->db->prefix("xmsocial_social");
		$socialdataHandler->field_link = "social_id";
		$socialdataHandler->field_object = "socialdata_socialid";
		$social_arr = $socialdataHandler->getByLink($criteria);
		if (count($social_arr) > 0) {
			$SocialPlugin = new SocialPlugin();
			foreach (array_keys($social_arr) as $i) {
				$options = explode(',', $social_arr[$i]->getVar('social_options'));
				$social = $SocialPlugin->render($social_arr[$i]->getVar('social_type'), $url, $options);
                $xoopsTpl->appendByRef('social_arr', $social);
                unset($social);
			}
		} else {
			$xoopsTpl->assign('social_arr', array());
		}
    }
}
