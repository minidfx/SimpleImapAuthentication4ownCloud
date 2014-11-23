<?php

/**
 * Created by PhpStorm.
 * User: minidfx
 * Date: 22.11.14
 * Time: 21:20
 */

namespace OCA\user_imapauth\lib;

use OC;
use OCP\IConfig;
use OCP\ILogger;
use OCP\IUserManager;
use OCP\IUserSession;
use OCP\User;

/**
 * Class IMAP_AUTH for authenticating users with an IMAP server.
 * @package OCA\user_imapauth\lib
 */

/** @noinspection SpellCheckingInspection */
final class IMAPAuthenticator
	implements
	IUserSession
{
	/**
	 * @var string
	 */
	protected $host;

	/**
	 * @var int
	 */
	protected $port;

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
	 * @var User
	 */
	private $user;

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

		$this->logger->debug('Instance IMAP authenticator without parameters.');
	}

	/**
	 * Do a user login
	 *
	 * @param string $user     the username
	 * @param string $password the password
	 *
	 * @return bool true if successful
	 */
	public function login($user, $password)
	{
		$this->logger->debug("Try for authenticating the user $user ...");

		if (empty($this->host))
		{
			$this->logger->error('The IMAP host is missing. You have to configure the authenticator from the admin console.');

			return FALSE;
		}

		if (empty($this->port))
		{
			$this->logger->error('The IMAP port is missing. You have to configure the authenticator from the admin console.');

			return TRUE;
		}

		// INFO: [MiniDfx 15-11-2014 07:32:12] Try to open the inbox in read only without retry.
		$loginResult = imap_open("{$this->host}:{$this->port}/imap/ssl}INBOX", $user, $password, OP_READONLY, 0);

		if ($loginResult === FALSE)
		{
			$this->logger->warning("Credentials invalid for the user $user.");

			return FALSE;
		}
		else
		{
			$this->logger->info("Credentials for the $user has been successfully validated.");

			return TRUE;
		}
	}

	public function logout()
	{
		$this->user = NULL;

		return TRUE;
	}

	/**
	 * set the currently active user
	 *
	 * @param User|null $user
	 */
	public function setUser($user)
	{
		$this->logger->info("Save the user {$user->getUser()} authenticated.");

		$this->user = $user;
	}

	/**
	 * get the current active user
	 *
	 * @return User
	 */
	public function getUser()
	{
		if ($this->user === NULL)
		{
			$this->logger->warning('The user is not authenticated.');

			return NULL;
		}

		return $this->user;
	}
}
