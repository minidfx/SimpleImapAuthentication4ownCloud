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
use OCA\user_imapauth\lib\Contracts\IIMAPWrapper;
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

	/**
	 * @var IIMAPWrapper
	 */
	private $imapWrapper;

	/**
	 * @var int
	 */
	private $maxRetries;

	/** @noinspection SpellCheckingInspection */

	/**
	 * Initializes an instance of <b>user_imapauth</b>
	 *
	 * @param IUserManager $userManager
	 * @param IConfig      $config
	 * @param ILogger      $logger
	 * @param IIMAPWrapper $imapWrapper
	 *
	 * @internal param IUserSession $userSession
	 */
	public function __construct(IUserManager $userManager, IConfig $config, ILogger $logger, IIMAPWrapper $imapWrapper)
	{
		$host       = $config->getAppValue(APP_ID, 'imap_uri', NULL);
		$port       = $config->getAppValue(APP_ID, 'imap_port', NULL);
		$maxRetries = $config->getAppValue(APP_ID, 'imap_max_retries', NULL);

		if ($host === NULL)
		{
			$config->setAppValue(APP_ID, 'imap_uri', $host = 'localhost');
		}

		if ($port === NULL)
		{
			$config->setAppValue(APP_ID, 'imap_port', $port = 993);
		}

		if ($maxRetries === NULL)
		{
			$config->setAppValue(APP_ID, 'max_retries', $maxRetries = 2);
		}

		$this->host       = $host;
		$this->port       = intval($port);
		$this->maxRetries = intval($maxRetries);

		$this->userManager = $userManager;
		$this->config      = $config;
		$this->logger      = $logger;
		$this->imapWrapper = $imapWrapper;
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

		if ($this->port === 0)
		{
			$this->logger->error("The IMAP port is not a valid value. You have to configure the authenticator from the admin console.",
			                     array('app' => APP_ID));

			return FALSE;
		}

		if ($this->maxRetries === 0)
		{
			$this->logger->error("The max retries is not a valid value. You have to configure the authenticator from the admin console.",
			                     array('app' => APP_ID));

			return FALSE;
		}

		// INFO: [MiniDfx 15-11-2014 07:32:12] Try to open the inbox in read only.
		$loginResult = $this->imapWrapper->open("{{$this->host}:{$this->port}/imap/ssl}INBOX", $uid, $password,
		                                        OP_READONLY, $this->maxRetries);

		if ($loginResult === FALSE)
		{
			$this->logger->warning(implode(';', $this->imapWrapper->getLastErrors()), array('app' => APP_ID));

			return FALSE;
		}
		else
		{
			if (!$this->userManager->userExists($uid))
			{
				// INFO: [minidfx 28-11-2014 09:16:03] Whether the user doesn't exist, create it on the local storage.
				$this->userManager->createUser($uid, $password);
			}
			else
			{
				// INFO: [minidfx 28-11-2014 09:13:13] Update the user password saved in the local storage.
				$this->userManager->get($uid)->setPassword($password);
				$this->logger->info("The password of the user $uid has been updated in the local storage.",
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
		$result = (bool)(OC_USER_BACKEND_CHECK_PASSWORD & $actions);

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
