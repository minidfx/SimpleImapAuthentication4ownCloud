<?php
/**
 * Created by PhpStorm.
 * User: minidfx
 * Date: 22.11.14
 * Time: 23:34
 */

namespace OCA\user_imapauth\AppInfo;

use OCP\App;
use OCP\Util;

/** @noinspection SpellCheckingInspection */
define('APP_ID', 'user_imapauth');

App::addNavigationEntry(array(

	                        // the string under which your app will be referenced in owncloud
	                        'id'    => APP_ID,

	                        // sorting weight for the navigation. The higher the number, the higher
	                        // will it be listed in the navigation
	                        'order' => 10,

	                        // the route that will be shown on startup
	                        'href'  => Util::linkToRoute(APP_ID . '.page.index'),

	                        // the icon that will be shown in the navigation
	                        // this file needs to exist in img/example.png
	                        'icon'  => Util::imagePath(APP_ID, 'nav-icon.png'),

	                        // the title of your application. This will be used in the
	                        // navigation or on the settings page of your app
	                        'name'  => 'IMAP User Authentication'
                        ));

Util::writeLog(APP_ID, 'Entry point of the imap user authentication accessed.', Util::INFO);