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
use Xmf\Module\Admin; 

require __DIR__ . '/admin_header.php';
//include '../plugin/social/facebook.php';
//include '../class/interface.php';
//include '../plugin/social/fac.php';

$moduleAdmin = Admin::getInstance();
$moduleAdmin->displayNavigation('index.php');
$moduleAdmin->addConfigModuleVersion('system', 214);
$moduleAdmin->displayIndex();
//$test = new FacebookSocialPlugin('mage');
//echo $test . '<br>';
//echo 'prout <br>';
//echo Xmsocial_facebook::render();


/*interface SocialPluginInterface {
  public function social($message);
}

class SocialPlugin {
  public function info() {
    echo "Nom {$this->name}<br>";
  }
}

class FacebookSocialPlugin extends SocialPlugin
{
	var $name = "Facebook";
	
	public function social($message)
    {
		//$test .= ' hfdhdfhfdh';
		echo "I fly " . $message;
        //return $test;
    }
}

$test = new FacebookSocialPlugin();

$test->info();
$test->social('prout');*/

$test = new SocialPlugin();
$test->renders();









require __DIR__ . '/admin_footer.php';