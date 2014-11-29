<?php

/**
 * Created by PhpStorm.
 * User: Burgy Benjamin
 * Date: 22.11.14
 * Time: 21:20
 */

namespace OCA\user_imapauth\lib;

use Exception;
use OC;
use OCP\IConfig;
use OCP\ILogger;
use OCP\IUserManager;
use OCP\UserInterface;

/**
 * Class IMAP_AUTH for authenticating users with an IMAP server.
 * @package OCA\user_imapauth\lib
 */

/** @noinspection SpellCheckingInspection */
final class IMAPAuthenticator
	implements
	UserInterface
{
	/**
	 * @var string
	 */
	private $host;

	/**
	 * @var int
	 */
	private $port;

	/**
	 * @var ILogger
	 */
	private $logger;

	/**
	 * @var IUserManager
	 */
	private $userManager;

	/**
	 * @var IConfig
	 */
	private $config;

	/** @noinspection SpellCheckingInspection */

	/**
	 * Initializes an instance of <b>user_imapauth</b>
	 *
	 * @param IUserManager $userManager
	 * @param IConfig      $config
	 * @param ILogger      $logger
	 *
	 * @internal param IUserSession $userSession
	 */
	public function __construct(IUserManager $userManager, IConfig $config, ILogger $logger)
	{
		$this->host = $config->getAppValue(APP_ID, 'imap_uri');
		$this->port = $config->getAppValue(APP_ID, 'imap_port');

		$this->userManager = $userManager;
		$this->config      = $config;
		$this->logger      = $logger;
	}

	/**
	 * Check if the password is correct
	 *
	 * @param string $uid      The username
	 * @param string $password The password
	 *
	 * @return string
	 *
	 * Check if the password is correct without logging in the user
	 * returns the user id or false
	 */
	public function checkPassword($uid, $password)
	{
		if (empty($this->host))
		{
			$this->logger->error('The IMAP host is missing. You have to configure the authenticator from the admin console.',
			                     array('app' => APP_ID));

			return FALSE;
		}

		if (empty($this->port))
		{
			$this->logger->error('The IMAP port is missing. You have to configure the authenticator from the admin console.',
			                     array('app' => APP_ID));

			return FALSE;
		}

		// INFO: [MiniDfx 15-11-2014 07:32:12] Try to open the inbox in read only with 3 retry.
		$loginResult = imap_open("{{$this->host}:{$this->port}/imap/ssl/debug}INBOX", $uid, $password, OP_READONLY, 3);

		if ($loginResult === FALSE)
		{
			$this->logger->warning(implode(';', imap_errors()), array('app' => APP_ID));

			return FALSE;
		}
		else
		{
			if (!$this->userManager->userExists($uid))
			{
				// INFO: [minidfx 28-11-2014 09:16:03] Whether the user doesn't exists, create it on the local storage.
				$this->userManager->createUser($uid, $password);
			}
			else
			{
				// INFO: [minidfx 28-11-2014 09:13:13] The user password is updated whether the login is successful.
				$this->userManager->get($uid)->setPassword($password);
				$this->logger->info("The user password of the user $uid has been updated in the local storage.",
				                    array('app' => APP_ID));
			}

			return $uid;
		}
	}

	/** @noinspection PhpUndefinedClassInspection */

	/**
	 * Check if backend implements actions
	 *
	 * @param $actions bitwise-or'ed actions
	 *
	 * @return boolean
	 *
	 * Returns the supported actions as int to be
	 * compared with OC_USER_BACKEND_CREATE_USER etc.
	 */
	public function implementsActions($actions)
	{
		$result = boolval((bool)(OC_USER_BACKEND_CHECK_PASSWORD & $actions));

		return $result;
	}

	/**
	 * delete a user
	 *
	 * @param string $uid The username of the user to delete
	 *
	 * @throws Exception
	 * @return bool
	 */
	public function deleteUser($uid)
	{
		return FALSE;
	}

	/**
	 * Get a list of all users
	 *
	 * @param string $search
	 * @param null   $limit
	 * @param null   $offset
	 *
	 * @throws Exception
	 * @return array an array of all uids
	 *
	 * Get a list of all users.
	 */
	public function getUsers($search = '', $limit = NULL, $offset = NULL)
	{
		return FALSE;
	}

	/**
	 * check if a user exists
	 *
	 * @param string $uid the username
	 *
	 * @throws Exception
	 * @return boolean
	 */
	public function userExists($uid)
	{
		return FALSE;
	}

	/**
	 * get display name of the user
	 *
	 * @param string $uid user ID of the user
	 *
	 * @throws Exception
	 * @return string display name
	 */
	public function getDisplayName($uid)
	{
		return FALSE;
	}

	/**
	 * Get a list of all display names
	 *
	 * @param string $search
	 * @param null   $limit
	 * @param null   $offset
	 *
	 * @throws Exception
	 * @return array an array of  all displayNames (value) and the corresponding uids (key)
	 *
	 * Get a list of all display names and user ids.
	 */
	public function getDisplayNames($search = '', $limit = NULL, $offset = NULL)
	{
		return FALSE;
	}

	/**
	 * Check if a user list is available or not
	 * @throws Exception
	 * @return boolean if users can be listed or not
	 */
	public function hasUserListings()
	{
		return FALSE;
	}
}
