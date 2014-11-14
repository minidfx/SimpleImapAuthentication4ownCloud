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
 
namespace OCA\user_imapauth;

require_once \OC_App::getAppPath('user_imapauth') .'/lib/iMAPAuthenticator.php';

class IMAP_AUTH implements \OCP\UserInterface {
	protected $imapauth_uri;
	protected $imapauth_port;
	
	protected $db_user;

	public function __construct() {
		$this->db_user = new \OC_User_Database();
		$this->imapauth_uri = \OC_Config::getValue("user_imap_uri");
		$this->imapauth_port = \OC_Config::getValue("user_imap_port");
		
		\OC_Log::write('USER_IMAPAUTH', 'Instance IMAP Authentication without parameters.', \OC_Log::DEBUG);
	}

	public function setPassword ( $uid, $password ) {
		// We can't change user password
		\OC_Log::write('USER_IMAPAUTH', 'Not possible to change password for users from web frontend using IMAP user backend', \OC_Log::INFO);
		return false;
	}

	public function checkPassword( $uid, $password ) {
	
		// Debug
		\OC_Log::write('USER_IMAPAUTH', "Use IMAP authentication for $uid.", \OC_Log::DEBUG);
	
		// Return an error if the IMAP host is empty
		if(empty($this->imapauth_uri)) {
			\OC_Log::write('USER_IMAPAUTH', 'The IMAP host is empty, please fill it before!', \OC_Log::ERROR);
			return false;
		}
		
		// Return an error if the IMAP port is empty
		if(empty($this->imapauth_port)) {
			\OC_Log::write('USER_IMAPAUTH', 'The IMAP port is empty, please fill it before!', \OC_Log::ERROR);
			return false;
		}
		
		// Init the authenticator
		$authenticator = new \OCA\user_imapauth\lib\iMAPAuthenticator($this->imapauth_uri, $this->imapauth_port, $uid, $password);
	
		// Check credentials
		if($authenticator->validCredentials() === false) {
			\OC_Log::write('USER_IMAPAUTH', "Credentials not valid.", \OC_Log::ERROR);
			return false;
		}
		
		\OC_Log::write('USER_IMAPAUTH', "Login valid for $uid.", \OC_Log::DEBUG);
		return $uid;
	}
	
	/**
	* @brief Check if backend implements actions
	* @param $actions bitwise-or'ed actions
	* @returns boolean
	*
	* Returns the supported actions as int to be
	* compared with OC_USER_BACKEND_CREATE_USER etc.
	*/
	public function implementsActions($actions) {
		
		\OC_Log::write('USER_IMAPAUTH', "Check implementations with action : $actions", \OC_Log::DEBUG);
	
		return (bool)((OC_USER_BACKEND_CHECK_PASSWORD
					| OC_USER_BACKEND_CREATE_USER
					| OC_USER_BACKEND_GET_DISPLAYNAME
					| OC_USER_BACKEND_SET_DISPLAYNAME
					| OC_USER_BACKEND_GET_HOME)
					& $actions);
	}
	
	/**
	* @brief delete a user
	* @param $uid The username of the user to delete
	* @returns true/false
	*
	* Deletes a user
	*/
	public function deleteUser($uid) {
		// Debug
		\OC_Log::write('USER_IMAPAUTH', "Try to delete the user $uid.", \OC_Log::DEBUG);
	
		return $this->db_user->deleteUser($uid);
	}

	/**
	* @brief Get a list of all users
	* @returns array with all uids
	*
	* Get a list of all users.
	*/
	public function getUsers($search = '', $limit = null, $offset = null) {
		// Debug
		\OC_Log::write('USER_IMAPAUTH', "Retrieve users from the backend.", \OC_Log::DEBUG);	
	
		return $this->db_user->getUsers($search, $limit, $offset);
	}

	/**
	* @brief check if a user exists
	* @param string $uid the username
	* @return boolean
	*/
	public function userExists($uid) {
		// Debug
		\OC_Log::write('USER_IMAPAUTH', "Check if the user $uid exists.", \OC_Log::DEBUG);
	
		return $this->db_user->userExists($uid);
	}

	/**
	 * @brief get display name of the user
	 * @param $uid user ID of the user
	 * @return display name
	 */
	public function getDisplayName($uid) {
	
		// Debug
		\OC_Log::write('USER_IMAPAUTH', "Get the display name of the user $uid.", \OC_Log::DEBUG);
	
		return $this->db_user->getDisplayName($uid);
	}

	/**
	 * @brief Get a list of all display names
	 * @returns array with  all displayNames (value) and the corresponding uids (key)
	 *
	 * Get a list of all display names and user ids.
	 */
	public function getDisplayNames($search = '', $limit = null, $offset = null) {
		// Debug
		\OC_Log::write('USER_IMAPAUTH', "Get all display names.", \OC_Log::DEBUG);
	
		return $this->db_user->getDisplayNames($search, $limit, $offset);
	}

	/**
	 * @brief Check if a user list is available or not
	 * @return boolean if users can be listed or not
	 */
	public function hasUserListings() {
		// Debug
		\OC_Log::write('USER_IMAPAUTH', "Check if a user list is available.", \OC_Log::DEBUG);
	
		return $this->db_user->hasUserListings();
	}
}
