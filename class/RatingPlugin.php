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
 * Class RatingPlugin
 */
class RatingPlugin {
    /**
     * @var
     */
	private $ratingNames;

    /**
     * RatingPlugin constructor.
     */
	public function __construct()
    {
		$rating_names = XoopsLists::getFileListByExtension(XOOPS_ROOT_PATH . '/modules/xmsocial/plugin/rating/', array('php'));
		foreach ($rating_names as $rating_name) {
			$this->ratingNames[] = basename($rating_name, '.php');
			include_once XOOPS_ROOT_PATH . '/modules/xmsocial/plugin/rating/' . $rating_name;
		}
    }

    /**
     * @return mixed
     */
	public function getRatingNames()
	{
		return $this->ratingNames;
	}

    /**
     * @param string $rating_name
     * @return bool
     */
	public function CheckPlugin($rating_name = '')
	{
		if (in_array($rating_name, $this->ratingNames)) {
			if (xoops_isActiveModule($rating_name)){
				return true;
			} else {
				return false;
			}		
		} else {			
			return false;
		}
	}

    /**
     * @return array
     */
	public function ListPlugin()
	{
		$active_plugin = array();
		foreach ($this->ratingNames as $rating_name) {
			if (xoops_isActiveModule($rating_name)){
				$helper = Helper::getHelper($rating_name);
				$moduleid = $helper->getModule()->getVar('mid');
				$active_plugin[] = ['name' => $rating_name, 'id' => $moduleid];
			}			
		}
		return $active_plugin;
	}

    /**
     * @param string $rating_name
     * @param int $itemid
     * @param array $options
     * @return string
     */
	public function RedirectUrl($rating_name = '', $itemid = 0, $options = array())
	{
		if (in_array($rating_name, $this->ratingNames)) {
			return basename ('Xmsocial' . $rating_name)::RedirectUrl($itemid, $options);
		} else {			
			return '';
		}
	}

    /**
     * @param string $rating_name
     * @param int $itemid
     * @return string
     */
	public function Url($rating_name = '', $itemid = 0, $options = array())
	{
		if (in_array($rating_name, $this->ratingNames)) {
			return basename ('Xmsocial' . $rating_name)::Url($itemid, $options);
		} else {			
			return '';
		}
	}

    /**
     * @param $rating_name
     * @param $itemids
     * @return string
     */
	public function ItemNames($rating_name, $itemids)
	{
		if (in_array($rating_name, $this->ratingNames)) {
			return basename ('Xmsocial' . $rating_name)::ItemNames($itemids);
		} else {			
			return '';
		}
	}

    /**
     * @param $rating_name
     * @param $itemid
     * @param $rating
     * @param $vote
     * @return string
     */
	public function SaveRating($rating_name, $itemid, $rating, $vote)
	{
		if (in_array($rating_name, $this->ratingNames)) {			
			return basename ('Xmsocial' . $rating_name)::SaveRating($itemid, $rating, $vote);
		} else {			
			return '';
		}
	}
}
