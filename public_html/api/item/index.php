<?php
require_once(dirname(__DIR__,3) . "/vender/autoload.php";
require_once(dirname(__DIR__,3) . "/php/classes/autoload.php");
require_once(dirname(__DIR__, 3) . "php/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\DataDesign\ {
	Item
};

/**
 * api for the Item class
 *
 * @authoer Shihlin Lu <slu5@cnm.edu>
 */