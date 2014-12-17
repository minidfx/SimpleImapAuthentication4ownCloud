<?php

/**
 * Created by PhpStorm.
 * User: Burgy Benjamin
 * Date: 09.12.14
 * Time: 10:42
 */

namespace OCA\user_imapauth\lib;

use OCA\user_imapauth\App\Contracts\IIMAPAuthenticatorApp;
use OCA\user_imapauth\lib\Contracts\IIMAPAuthBootstrapper;
use OCP\App;

/**
 * Implementations of the IMAP authenticator.
 * @package OCA\user_imapauth\lib
 */
final class IMAPAuthBootstrapper
	implements
	IIMAPAuthBootstrapper
{
	/**
	 * @var IIMAPAuthenticatorApp
	 */
	private $authenticator;

	/**
	 * Initializes an instance of <b>imapauthbootstrapper</b>
	 *
	 * @param IIMAPAuthenticatorApp $authenticator
	 */
	public function __construct(IIMAPAuthenticatorApp $authenticator)
	{
		$this->authenticator = $authenticator;
	}

	/**
	 * Initializes configuration of the IMAP authenticator.
	 *
	 * @inheritdoc
	 */
	public function init()
	{
		if (!defined('APP_ID'))
		{
			/** @noinspection SpellCheckingInspection */
			define('APP_ID', 'user_imapauth');
		}

		$this->authenticator->init();
		$this->authenticator->registerUserBackend();
	}

	/**
	 * Registers the configuration board in the ownCloud admin console.
	 *
	 * @inheritdoc
	 */
	public function registerAdminFunctionalities()
	{
		App::registerAdmin(APP_ID, 'settings');
	}
}