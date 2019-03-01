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

class SocialPlugin {
	
	private $socialNames;
	
	
	public function __construct()
    {
		$social_names = XoopsLists::getFileListByExtension(XOOPS_ROOT_PATH . '/modules/xmsocial/plugin/social/', array('php'));
		foreach ($social_names as $social_name) {
			echo 'class ' . $social_name . ' chargée<br>';
			$this->socialNames[] = basename($social_name, '.php');
			include_once XOOPS_ROOT_PATH . '/modules/xmsocial/plugin/social/' . $social_name;
		}
    }
	
	public function getSocialNames()
	{
		return $this->socialNames;
	}
	
	public function getOptionsEdit($social_name = '', $options)
	{
		if (in_array($social_name, $this->socialNames)) {			
			return basename ('Xmsocial' . $social_name)::optionsEdit($options);
		} else {			
			return '';
		}
	}
	
	public function render($social_name = '')
	{		
		if (in_array($social_name, $this->socialNames)) {			
			return basename ('Xmsocial' . $social_name)::render('');
		} else {			
			return '';
		}
	}
	
	public function renders()
	{
		
		foreach ($this->socialNames as $social_name) {
			
			echo '<br>prout ' . $social_name . ' chargée';
			echo basename ('Xmsocial' . $social_name)::render('jjj');
		}
	}
}
