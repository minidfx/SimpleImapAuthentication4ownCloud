<?php

/**
 * ownCloud - user_imapauth
 *
 * @author Burgy Benjamin
 * @copyright 2014 Burgy Benjamin b.burgy@abatys.ch
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU AFFERO GENERAL PUBLIC LICENSE for more details.
 *
 * You should have received a copy of the GNU Affero General Public
 * License along with this library.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

require_once OC_App::getAppPath('user_imapauth') .'/user_imapauth.php';
require_once OC_App::getAppPath('user_imapauth') .'/lib/iMAPAuthenticator.php';

OCP\App::registerAdmin('user_imapauth', 'settings');

// Debug
//OCP\Util::writeLog('USER_IMAPAUTH', "Load the app user_imapauth.", OCP\Util::DEBUG);

// Use injection dependencies pattern
OC_User::useBackend(new OCA\user_imapauth\IMAP_AUTH(new OC_User_Database(),
													\OC_Config::getValue("user_imap_uri"),
													\OC_Config::getValue("user_imap_port")
													));												
													
// add settings page to navigation
$entry = array(
	'id' => "user_imapauth_settings",
	'order'=>1,
	'href' => OCP\Util::linkTo( "user_imapauth", "settings.php" ),
	'name' => 'IMAP_AUTH'
);
