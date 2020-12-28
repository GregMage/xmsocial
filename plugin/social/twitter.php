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
 * Plugin Twitter for xmsocial module
 *
 * @copyright       XOOPS Project (http://xoops.org)
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author          Mage Gregory (AKA Mage)
 */
 
use \Xmf\Request;

 class XmsocialTwitter
 {
	
	private $dataLayout = '';
	
	
	public static function optionsEdit($options)
	{
		if (empty($options)){
			$options[] = '';
			$options[] = '';
			$options[] = '';
			$options[] = '';
			$options[] = 'small';
		}
		$form = new XmsocialOptionsForm();
		// Prefil
		$form->addElement(new XoopsFormText(_AM_TWITTER_PREFIL, 'prefil', 50, 255, $options[0]));
		// URL
		$form->addElement(new XoopsFormText(_AM_TWITTER_URL, 'url', 50, 255, $options[1]));
		// hashtag
		$form->addElement(new XoopsFormText(_AM_TWITTER_HASHTAG, 'hashtag', 50, 255, $options[2]));
		// Language
		$formLanguage = new XoopsFormSelect(_AM_TWITTER_LANGUAGE, 'language', $options[3], 1, false);
		$formLanguage->addOption('', _AM_TWITTER_LANGUAGE_AUT);
		$formLanguage->addOption('en', 'English');
		$formLanguage->addOption('ar', 'Arabic');
		$formLanguage->addOption('bn', 'Bengali');
		$formLanguage->addOption('cs', 'Czech');
		$formLanguage->addOption('da', 'Danish');
		$formLanguage->addOption('de', 'German');
		$formLanguage->addOption('el', 'Greek');
		$formLanguage->addOption('es', 'Spanish');
		$formLanguage->addOption('fa', 'Persian');
		$formLanguage->addOption('fi', 'Finnish');
		$formLanguage->addOption('fil', 'Filipino');
		$formLanguage->addOption('fr', 'French');
		$formLanguage->addOption('he', 'Hebrew');
		$formLanguage->addOption('hi', 'Hindi');
		$formLanguage->addOption('hu', 'Hungarian');
		$formLanguage->addOption('id', 'Indonesian');
		$formLanguage->addOption('it', 'Italian');
		$formLanguage->addOption('ja', 'Japanese');
		$formLanguage->addOption('ko', 'Korean');
		$formLanguage->addOption('msa', 'Malay');
		$formLanguage->addOption('nl', 'Dutch');
		$formLanguage->addOption('no', 'Norwegian');
		$formLanguage->addOption('pl', 'Polish');
		$formLanguage->addOption('pt', 'Portuguese');
		$formLanguage->addOption('ro', 'Romanian');
		$formLanguage->addOption('ru', 'Rusian');
		$formLanguage->addOption('sv', 'Swedish');
		$formLanguage->addOption('th', 'Thai');
		$formLanguage->addOption('tr', 'Turkish');
		$formLanguage->addOption('uk', 'UKrainian');
		$formLanguage->addOption('ur', 'Urdu');
		$formLanguage->addOption('vi', 'Vietnamese');
		$formLanguage->addOption('zh-cn', 'Chinese (simplified)');
		$formLanguage->addOption('zh-tw', 'Chinese (Traditional)');
		$form->addElement($formLanguage);		
		// size
		$formSize = new XoopsFormSelect(_AM_TWITTER_SIZE, 'size', $options[4], 2, false);
		$formSize->addOption('small', 'Small');
		$formSize->addOption('large', 'Large');
		$form->addElement($formSize);		
		return $form->render();	
	}
	
	public static function optionsSave()
	{
		$return = Request::getString('prefil', '') . ',';
		$return .= Request::getString('url', '') . ',';
		$return .= Request::getString('hashtag', '') . ',';
		$return .= Request::getString('language', '') . ',';
		$return .= Request::getString('size', '');
		return $return;
	}
	 
	 
	/**
	* Make the facebook plugin into a string
	*
	* @return string
	*/
    public static function render($url, $options)
    {		
		$ret  = '<a href="https://twitter.com/share?ref_src=' . $url . '" class="twitter-share-button" data-show-count="false" ';
		$ret .= 'data-size="' . $options[4] . '" ';
		if ($options[0] != ''){
			$ret .= 'data-text="' . $options[0] . '" ';
		}
		if ($options[1] != ''){
			$ret .= 'data-url="' . $options[1] . '" ';
		}
		if ($options[2] != ''){
			$ret .= 'data-hashtags="' . $options[2] . '" ';
		}
		if ($options[3] != ''){
			$ret .= 'data-lang="' . $options[3] . '" ';
		}
		$ret .= '></a>';
		$ret .= '<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>';

        return $ret;
    }
	 
 }
