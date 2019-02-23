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

 class Xmsocial_facebook
 {
	 
	/**
     * Disposition
     *
     * @var string
     */
    public $dataLayout = '';
	
	
	/**
	* Constructor
	*
	* @param CriteriaElement|null $ele
	* @param string $condition
	*/
    public function __construct()
    {

    }
	 
	 
	/**
	* Make the facebook plugin into a string
	*
	* @return string
	*/
    public static function render()
    {
		$ret  = '<!-- Load Facebook SDK for JavaScript -->
  <div id="fb-root"></div>
<script async defer src="https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v3.2"></script>';
		$ret  .= '<div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-layout="standard" data-action="recommend" data-size="small" data-show-faces="false" data-share="true"></div>';

        return $ret;
    }
	 
 }
