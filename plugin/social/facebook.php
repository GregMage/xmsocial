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

 class XmsocialFacebook
 {
	
	private $dataLayout = '';
	
	
	public static function optionsEdit($options)
	{
		$form = new XmsocialOptionsForm();
		// Data layout
		$formDataLayout = new XoopsFormSelect('Data layout', 'options[0]', $options[0], 5, true);
		$formDataLayout->addOption(0, 'Standard');
		$formDataLayout->addOption(1, 'box_count');
		$formDataLayout->addOption(2, 'button_count');
		$formDataLayout->addOption(3, 'button');
		$form->addElement($formDataLayout);		
		// Data size
		$formSizeLayout = new XoopsFormSelect('Data size', 'options[1]', $options[1], 5, true);
		$formSizeLayout->addOption(0, 'Small');
		$formSizeLayout->addOption(1, 'Large');
		$form->addElement($formSizeLayout);
		return $form->render();
	}
	 
	 
	/**
	* Make the facebook plugin into a string
	*
	* @return string
	*/
    public static function render($url)
    {
		$ret  = '<!-- Load Facebook SDK for JavaScript -->';
		$ret .= '<div id="fb-root"></div>';
		$ret .= '<script async defer src="https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v3.2"></script>';
		$ret .= '<div class="fb-like" data-href="' . $url . '" data-layout="standard" data-action="recommend" data-size="small" data-show-faces="false" data-share="true"></div>';

        return $ret;
    }
	 
 }
