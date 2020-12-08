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

if (!defined('XOOPS_ROOT_PATH')) {
    die('XOOPS root path not defined');
}

/**
 * Class xmsocial_socialdata
 */
class xmsocial_socialdata extends XoopsObject
{
    // constructor
    /**
     * xmsocial_socialdata constructor.
     */
    public function __construct()
    {
        $this->initVar('socialdata_id', XOBJ_DTYPE_INT, null, false, 11);
		$this->initVar('socialdata_socialid', XOBJ_DTYPE_INT, null, false, 11);
		$this->initVar('socialdata_modid', XOBJ_DTYPE_INT, null, false, 11);
		$this->initVar('socialdata_itemid', XOBJ_DTYPE_INT, null, false, 11);
		$this->initVar('social_type', XOBJ_DTYPE_TXTBOX, null, false);
		$this->initVar('social_options', XOBJ_DTYPE_TXTBOX, null, false);
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
}

/**
 * Class xmsocialxmsocial_socialdataHandler
 */
class xmsocialxmsocial_socialdataHandler extends XoopsPersistableObjectHandler
{
    /**
     * xmsocialxmsocial_socialdataHandler constructor.
     * @param null|XoopsDatabase $db
     */
    public function __construct($db)
    {
        parent::__construct($db, 'xmsocial_socialdata', 'xmsocial_socialdata', 'socialdata_id', 'socialdata_socialid');
    }
}
