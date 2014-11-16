<?php

/**
 * ownCloud - user_imapauth
 *
 * @author    Burgy Benjamin
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

use OC;
use OC_User_Backend;
use OC_User_Database;
use OCA\user_imapauth\lib\iMAPAuthenticator;
use OCP\Config;
use OCP\ILogger;

/**
 * Class IMAP_AUTH for authenticating users with an IMAP server.
 * @package OCA\user_imapauth
 */
final class user_imapauth
	extends
	OC_User_Backend
{
	/**
	 * @var string
	 */
	protected $imapHost;

	/**
	 * @var int
	 */
	protected $imapPort;

	/**
	 * @var ILogger
	 */
	private $logger;

	/**
	 * @var OC_User_Database
	 */
	private $coreUserStorage;

	/**
	 * @var Config
	 */
	private $config;

	/**
	 * Initializes an instance of <b>user_imapauth</b>
	 *
	 * @param OC_User_Database $coreUserStorage
	 * @param Config           $config
	 * @param ILogger          $logger
	 */
	public function __construct(OC_User_Database $coreUserStorage, Config $config, ILogger $logger)
	{
		$this->imapHost = $config->getAppValue(APP_ID, 'user_imap_uri');
		$this->imapPort = $config->getAppValue(APP_ID, 'user_imap_port');

		$this->coreUserStorage = $coreUserStorage;
		$this->config          = $config;
		$this->logger          = $logger;

		$this->logger->debug('Instance IMAP Authentication without parameters.');
	}

	/**
	 * @param string $uid
	 * @param string $password
	 *
	 * @return bool
	 */
	public function setPassword(/** @noinspection PhpUnusedParameterInspection */
		$uid, $password)
	{
		$this->logger->debug('You cannot change the password of a user throught IMAP.');

		return FALSE;
	}

	/**
	 * @param string $uid      The login of the user.
	 * @param string $password The password for the user.
	 *
	 * @return bool <b>TRUE</b> whether credentials are successfully validated to the IMAP server.
	 */
	public function checkPassword($uid, $password)
	{
		$this->logger->debug("Try for authenticating the user $uid ...");

		if (empty($this->imapHost))
		{
			$this->logger->error('The IMAP host is missing. You have to configure the authenticator from the admin console.');

			return FALSE;
		}

		if (empty($this->imapPort))
		{
			$this->logger->error('The IMAP port is missing. You have to configure the authenticator from the admin console.');

			return FALSE;
		}

		/** @var iMAPAuthenticator $authenticator */
		$authenticator = new iMAPAuthenticator($this->imapHost, $this->imapPort, $uid, $password);

		if ($authenticator->validCredentials() === FALSE)
		{
			$this->logger->warning("Credentials invalid for the user $uid.");

			return FALSE;
		}

		$this->logger->info("Credentials for the $uid has been successfully validated.");

		return $uid;
	}

	/** @noinspection PhpUndefinedClassInspection */
	/**
	 * Check if backend implements actions
	 *
	 * @param int $actions bitwise-or'ed actions
	 *
	 * @return boolean
	 *
	 * Returns the supported actions as int to be
	 * compared with OC_USER_BACKEND_CREATE_USER etc.
	 */
	public function implementsActions($actions)
	{
		$this->logger->debug("Check whether the action is implemented by the authentication : $actions");

		return (bool)((OC_USER_BACKEND_CHECK_PASSWORD
		               | OC_USER_BACKEND_CREATE_USER
		               | OC_USER_BACKEND_SET_DISPLAYNAME
		               | OC_USER_BACKEND_GET_HOME)
		              & $actions);
	}

	/**
	 * delete a user
	 *
	 * @param string $uid The username of the user to delete
	 *
	 * @return bool
	 *
	 * Deletes a user
	 */
	public function deleteUser($uid)
	{
		$this->logger->debug("Try for deleting the user $uid ...");

		return $this->coreUserStorage->deleteUser($uid);
	}

	/**
	 * Get a list of all users
	 *
	 * @param string   $search
	 * @param int|null $limit
	 * @param int|null $offset
	 *
	 * @return array an array of all uids
	 *
	 * Get a list of all users.
	 */
	public function getUsers($search = '', $limit = NULL, $offset = NULL)
	{
		$this->logger->debug('Retrieving users from the core backend ...');

		return $this->coreUserStorage->getUsers($search, $limit, $offset);
	}

	/**
	 * check if a user exists
	 *
	 * @param string $uid the username
	 *
	 * @return boolean
	 */
	public function userExists($uid)
	{
		$this->logger->debug("Check whether the user $uid exists in the core storage.");

		return $this->coreUserStorage->userExists($uid);
	}

	/**
	 * get the user's home directory
	 *
	 * @param string $uid the username
	 *
	 * @return boolean
	 */
	public function getHome($uid)
	{
		$this->logger->warning("User home path not available with the IMAP authenticator.");

		return FALSE;
	}

	/**
	 * get display name of the user
	 *
	 * @param string $uid user ID of the user
	 *
	 * @return string display name
	 */
	public function getDisplayName($uid)
	{
		$this->logger->debug("Getting the display name of the user $uid from the core storage.");

		return $this->coreUserStorage->getDisplayName($uid);
	}

	/**
	 * @brief Get a list of all display names
	 *
	 * @param string   $search
	 * @param int|null $limit
	 * @param int|null $offset
	 *
	 * @returns array with all displayNames (value) and the corresponding uids (key)
	 *
	 * Get a list of all display names and user ids.
	 */
	public function getDisplayNames($search = '', $limit = NULL, $offset = NULL)
	{
		$this->logger->debug("Getting all display names from the core storage ...");

		return $this->coreUserStorage->getDisplayNames($search, $limit, $offset);
	}

	/**
	 * @brief Check if a user list is available or not
	 * @return boolean if users can be listed or not
	 */
	public function hasUserListings()
	{
		$this->logger->debug("Check whether a user list is available from the core storage.");

		return $this->coreUserStorage->hasUserListings();
	}
}
