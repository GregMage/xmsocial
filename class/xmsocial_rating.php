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
 * Class xmsocial_rating
 */
class xmsocial_rating extends XoopsObject
{
    // constructor
    /**
     * xmsocial_rating constructor.
     */
    public function __construct()
    {
        $this->initVar('rating_id', XOBJ_DTYPE_INT, null, false, 8);
        $this->initVar('rating_itemid', XOBJ_DTYPE_INT, null, false, 5);
        $this->initVar('rating_modid', XOBJ_DTYPE_INT, null, false, 5);
        $this->initVar('rating_value', XOBJ_DTYPE_INT, null, false, 1);
        $this->initVar('rating_uid', XOBJ_DTYPE_INT, null, false, 5);        
        $this->initVar('rating_hostname', XOBJ_DTYPE_TXTBOX, null, false);
		$this->initVar('rating_date', XOBJ_DTYPE_INT, null, false, 10);

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
 * Class xmsocialxmsocial_ratingHandler
 */
class xmsocialxmsocial_ratingHandler extends XoopsPersistableObjectHandler
{
    /**
     * xmsocialxmsocial_ratingHandler constructor.
     * @param null|XoopsDatabase $db
     */
    public function __construct($db)
    {
        parent::__construct($db, 'xmsocial_rating', 'xmsocial_rating', 'rating_id', 'rating_itemid');
    }
}
