<?php

/**
 * Created by PhpStorm.
 * User: Burgy Benjamin
 * Date: 09.12.14
 * Time: 10:42
 */

namespace OCA\user_imapauth\lib\Contracts;

/**
 * Bootstrapper of the IMAP authenticator.
 * @package OCA\user_imapauth\lib\Contracts
 */
interface IIMAPAuthBootstrapper
{
	/**
	 * Initializes configuration of the IMAP authenticator.
	 *
	 * @inheritdoc
	 */
	public function init();

	/**
	 * Registers the configuration board in the ownCloud admin console.
	 *
	 * @inheritdoc
	 */
	public function registerAdminFunctionalities();
}