<?php
namespace OCA\user_imapauth\lib;

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

use Exception;

/**
* This implementation of iAuthenticator use IMAP by SSL to valid credentials.
*/
class iMAPAuthenticator {

	/**
	* The username of the user.
	*/
	private $_userName;
	
	/**
	* The password of the user.
	*/
	private $_password;
	
	/**
	* The host of the IMAP server
	*/
	private $_host;
	
	/**
	* The port of the IMAP server
	*/
	private $_port;
	
	/**
	* The reference of the mailbox
	*/
	private $_mbox;

	/**
	* Constructs a new authenticator to authentify a user by IMAP with SSL.
	*/
	public function __construct($host, $port, $userName, $password) {
			$this->_host = $host;
			$this->_port = $port;
			$this->_userName = $userName;
			$this->_password = $password;
	}

	public function validCredentials() {
		// Try to login the user
		if($this->login() !== false) {
			$this->logout();
			return true;
		}
		
		return false;
	}
	
	public function login() {
		
		// Try to open the inbox in read only without retry
		$this->_mbox = imap_open('{'.$this->_host.':'.$this->_port.'/imap/ssl}INBOX', $this->_userName, $this->_password, OP_READONLY, 0);
		
		return $this->_mbox !== false;
	}
	
	public function logout() {
		
		if($this->_mbox !== false)
			imap_close($this->_mbox);
	}
}

?>