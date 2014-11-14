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

OC_Util::checkAdminUser();

if($_POST) {
	// CSRF check
	OCP\JSON::callCheck();

	if(isset($_POST['imap_uri']))
		\OC_Config::setValue('user_imap_uri', strip_tags($_POST['imap_uri']));
	
	if(isset($_POST['imap_port']))
		\OC_Config::setValue('user_imap_port', strip_tags($_POST['imap_port']));
}

// fill template
$tmpl = new OC_Template('user_imapauth', 'settings');
$tmpl->assign('imap_uri', \OC_Config::getValue("user_imap_uri"));
$tmpl->assign('imap_port', \OC_Config::getValue("user_imap_port"));

return $tmpl->fetchPage();
