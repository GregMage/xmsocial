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

if (!defined('XOOPS_ROOT_PATH')) {
    die('XOOPS root path not defined');
}

/**
 * Class xmsocial_social
 */
class xmsocial_social extends XoopsObject
{
    // constructor
    /**
     * xmsocial_social constructor.
     */
    public function __construct()
    {
        $this->initVar('social_id', XOBJ_DTYPE_INT, null, false, 3);
        $this->initVar('social_name', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('social_type', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('social_options', XOBJ_DTYPE_TXTBOX, null, false);;
        $this->initVar('social_weight', XOBJ_DTYPE_INT, 0, false, 3);
        $this->initVar('social_status', XOBJ_DTYPE_INT, 1, false, 1);
    }

    /**
     * @return mixed
     */
    public function get_new_enreg()
    {
        global $xoopsDB;
        $new_enreg = $xoopsDB->getInsertId();
        return $new_enreg;
    }

    /**
     * @return mixed
     */
    public function saveSocial($socialHandler, $action = false)
    {
        if ($action === false) {
            $action = $_SERVER['REQUEST_URI'];
        }
        include __DIR__ . '/../include/common.php';
		
		$error_message = '';
        
        $this->setVar('social_name', Xmf\Request::getString('social_name', ''));
        $this->setVar('social_type', Xmf\Request::getString('social_type', ''));
		$SocialPlugin = new SocialPlugin();
        $this->setVar('social_options',  $SocialPlugin->optionsSave(Xmf\Request::getString('social_type', '')));
        $this->setVar('social_status', Xmf\Request::getInt('social_status', 0));
		$this->setVar('social_weight', Xmf\Request::getInt('social_weight', 0));
		if ($socialHandler->insert($this)) {
			redirect_header($action, 2, _MA_XMSOCIAL_REDIRECT_SAVE);
		} else {
			$error_message =  $this->getHtmlErrors();
		}
        return $error_message;
    }
	
	    /**
     * @param bool $action
     * @return XoopsThemeForm
     */
    public function getFormSocial($action = false)
    {
        if ($action === false) {
            $action = $_SERVER['REQUEST_URI'];
        }
        include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
        include __DIR__ . '/../include/common.php';    
        
        $form = new XoopsThemeForm(_MA_XMSOCIAL_ADD, 'form', $action, 'post', true);
        // social      
        $social = new XoopsFormSelect(_MA_XMSOCIAL_SOCIAL_TYPE, 'social_type');
		$SocialPlugin = new SocialPlugin();
        $social_arr = $SocialPlugin->getSocialNames();
        if (count($social_arr) == 0 ){
            redirect_header('index.php', 3, _MA_XMSOCIAL_ERROR_NOSOCIAL);
        }
        foreach ($social_arr as $social_name) {
            $social->addOption($social_name, $social_name);
        }
        $form->addElement($social, true);
        
        $form->addElement(new XoopsFormHidden('op', 'loadsocial'));        
        // submit
        $form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
        return $form;
    }

    /**
     * @param bool $action
     * @return XoopsThemeForm
     */
    public function getForm($social_type = '', $action = false)
    {
        if ($action === false) {
            $action = $_SERVER['REQUEST_URI'];
        }
		include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
		include_once XOOPS_ROOT_PATH . '/modules/xmsocial/class/OptionsForm.php';
        include __DIR__ . '/../include/common.php';

        //form title
        $title = $this->isNew() ? sprintf(_MA_XMSOCIAL_ADD) : sprintf(_MA_XMSOCIAL_EDIT);
		
		if (!$this->isNew()) {
			$social_type = $this->getVar('social_type');
        }

        $form = new XoopsThemeForm($title, 'form', $action, 'post', true);

        // name
        $form->addElement(new XoopsFormText(_MA_XMSOCIAL_SOCIAL_NAME, 'social_name', 50, 50, $this->getVar('social_name')), true);
		
		//type
		$form->addElement(new xoopsFormLabel(_MA_XMSOCIAL_SOCIAL_TYPE, '<strong>' . $social_type . '</strong>'));
		$form->addElement(new XoopsFormHidden('social_type', $social_type));
		
		// options
		$SocialPlugin = new SocialPlugin();
		if ($this->getVar('social_options') == ''){
			$options = array();
		} else {
			$options = explode(',', $this->getVar('social_options'));
		}
		if ($SocialPlugin->getOptionsEdit($social_type, $options) != ''){
			$form->addElement(new xoopsFormLabel(_MA_XMSOCIAL_SOCIAL_OPTIONS, $SocialPlugin->getOptionsEdit($social_type, $options)));
		}

        // weight
        $form->addElement(new XoopsFormText(_MA_XMSOCIAL_SOCIAL_WEIGHT, 'social_weight', 5, 5, $this->getVar('social_weight')));

		// status
        $form_status = new XoopsFormRadio(_MA_XMSOCIAL_STATUS, 'social_status', $this->getVar('social_status'));
        $options = array(1 => _MA_XMSOCIAL_STATUS_A, 0 =>_MA_XMSOCIAL_STATUS_NA,);
        $form_status->addOptionArray($options);
        $form->addElement($form_status);

        $form->addElement(new XoopsFormHidden('op', 'save'));
        // submit
        $form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));

        return $form;
    }
}

/**
 * Class xmsocialxmsocial_socialHandler
 */
class xmsocialxmsocial_socialHandler extends XoopsPersistableObjectHandler
{
    /**
     * xmsocialxmsocial_socialHandler constructor.
     * @param null|XoopsDatabase $db
     */
    public function __construct($db)
    {
        parent::__construct($db, 'xmsocial_social', 'xmsocial_social', 'social_id', 'social_name');
    }
}
