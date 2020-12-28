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

/**
 * Class SocialPlugin
 */
class SocialPlugin {
	
	private $socialNames;

    /**
     * SocialPlugin constructor.
     */
	public function __construct()
    {
		$social_names = XoopsLists::getFileListByExtension(XOOPS_ROOT_PATH . '/modules/xmsocial/plugin/social/', array('php'));
		foreach ($social_names as $social_name) {
			$this->socialNames[] = basename($social_name, '.php');
			include_once XOOPS_ROOT_PATH . '/modules/xmsocial/plugin/social/' . $social_name;
		}
    }

    /**
     * @return mixed
     */
	public function getSocialNames()
	{
		return $this->socialNames;
	}

    /**
     * @param string $social_name
     * @param array $options
     * @return string
     */
	public function getOptionsEdit($social_name = '', $options = array())
	{
		$this->loadLanguage($social_name);
		if (in_array($social_name, $this->socialNames)) {			
			return basename ('Xmsocial' . $social_name)::optionsEdit($options);
		} else {			
			return '';
		}
	}

    /**
     * @param string $social_name
     * @return string
     */
	public function optionsSave($social_name = '')
	{
		if (in_array($social_name, $this->socialNames)) {			
			return basename ('Xmsocial' . $social_name)::optionsSave();
		} else {			
			return '';
		}
	}

    /**
     * @param string $social_name
     * @param string $url
     * @param array $options
     * @return string
     */
	public function render($social_name = '', $url = '', $options = array())
	{		
		if (in_array($social_name, $this->socialNames)) {			
			return basename ('Xmsocial' . $social_name)::render($url, $options);
		} else {			
			return '';
		}
	}

    /**
     * @param string $social_name
     * @return bool|mixed
     */
	public function loadLanguage($social_name = '')
    {
        $language = $GLOBALS['xoopsConfig']['language'];
        if (!file_exists($fileinc = XOOPS_ROOT_PATH . "/modules/xmsocial/plugin/social/language/{$language}/{$social_name}.php")) {
            if (!file_exists($fileinc = XOOPS_ROOT_PATH . "/modules/xmsocial/plugin/social/language/english/{$social_name}.php")) {
                return false;
            }
        }
        $ret = include_once $fileinc;

        return $ret;
    }
}
