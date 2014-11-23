<?php
/**
 * Created by PhpStorm.
 * User: minidfx
 * Date: 23.11.14
 * Time: 00:08
 */

namespace OCA\user_imapauth\App;

/** @var IMAPAuthenticatorApp $application */
$application = new IMAPAuthenticatorApp();

$application->registerRoutes($this, array(
	'routes' => array(
		array('name' => 'page#index',
		      'url'  => '/',
		      'verb' => 'GET'),
	)
));