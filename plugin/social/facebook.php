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
 * Plugin Facebook for xmsocial module
 *
 * @copyright       XOOPS Project (http://xoops.org)
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author          Mage Gregory (AKA Mage)
 */
 
use \Xmf\Request;

/**
 * Class XmsocialFacebook
 */
 class XmsocialFacebook
 {
	
	private $dataLayout = '';

     /**
      * @param $options
      * @return string
      */
	public static function optionsEdit($options)
	{
		if (empty($options)){
			echo 'vide';
			$options[] = 'like';
			$options[] = 'standard';
			$options[] = 'small';
			$options[] = '';
			$options[] = 1;
			$options[] = 0;
		}
		$form = new XmsocialOptionsForm();
		// Data action
		$formDataAction = new XoopsFormSelect(_AM_FACEBOOK_ACTION, 'Data_action', $options[0], 2, false);
		$formDataAction->addOption('like', 'Like');
		$formDataAction->addOption('recommend', 'recommend');
		$form->addElement($formDataAction);
		// Data layout
		$formDataLayout = new XoopsFormSelect(_AM_FACEBOOK_LAYOUT, 'Data_layout', $options[1], 4, false);
		$formDataLayout->addOption('standard', 'Standard');
		$formDataLayout->addOption('box_count', 'box_count');
		$formDataLayout->addOption('button_count', 'button_count');
		$formDataLayout->addOption('button', 'button');
		$form->addElement($formDataLayout);		
		// Data size
		$formSizeLayout = new XoopsFormSelect(_AM_FACEBOOK_SIZE, 'Data_size', $options[2], 2, false);
		$formSizeLayout->addOption('small', 'Small');
		$formSizeLayout->addOption('large', 'Large');
		$form->addElement($formSizeLayout);
		// Data width
		$form->addElement(new XoopsFormText(_AM_FACEBOOK_WIDTH, 'Data_width', 50, 255, $options[3]));
		// Data share
		if ($options[4] == 'true'){
			$share = 1;
		} else {
			$share = 0;
		}
		$form->addElement(new XoopsFormRadioYN(_AM_FACEBOOK_SHARE, 'Data_share', $share));
		// Data face
		if ($options[5] == 'true'){
			$face = 1;
		} else {
			$face = 0;
		}
		$form->addElement(new XoopsFormRadioYN(_AM_FACEBOOK_FACE, 'Data_face', $face));
		
		return $form->render();
	}

     /**
      * @return string
      */
	public static function optionsSave()
	{
		$return = Request::getString('Data_action', '') . ',';
		$return .= Request::getString('Data_layout', '') . ',';
		$return .= Request::getString('Data_size', '') . ',';
		if (Request::getInt('Data_width', 0) == 0){
			$return .= ',';
		} else {
			$return .= Request::getInt('Data_width', 0) . ',';
		}
		if (Request::getInt('Data_share', 0) == 0){
			$return .= 'false,';
		} else {
			$return .= 'true,';
		}
		if (Request::getInt('Data_face', 0) == 0){
			$return .= 'false';
		} else {
			$return .= 'true';
		}
		return $return;
	}

     /**
      * @param $url
      * @param $options
      * @return string
      */
    public static function render($url, $options)
    {
		$ret  = "<!-- Load Facebook SDK for JavaScript -->";
		$ret .= "<div id='fb-root'></div>";
		$ret .= "<script async defer src='https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v3.2'></script>";
		$ret .= '<div class="fb-like" data-href="' . $url . '" data-width="' . $options[3] . '" data-layout="' . $options[1] . '" data-action="' . $options[0] . '" data-size="' . $options[2] . '" data-show-faces="' . $options[5] . '" data-share="' . $options[4] . '"></div>';

        return $ret;
    }
	 
 }
