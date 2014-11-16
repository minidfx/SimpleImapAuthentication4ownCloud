<?php
/**
 * Created by PhpStorm.
 * User: MiniDfx
 * Date: 11/15/2014
 * Time: 19:25
 */

namespace OCA\MyApp\AppInfo;

$application = new Application();
$application->registerRoutes($this, array(
	'routes' => array(
		array('name' => 'page#index', 'url' => '/', 'verb' => 'GET'),
	)
));