<?php

/**
 * Created by PhpStorm.
 * User: Burgy Benjamin
 * Date: 09.12.14
 * Time: 11:22
 */

namespace OCA\user_imapauth\App\Contracts;

interface IIMAPAuthenticatorApp
{
	/**
	 * Registers a new backend for authenticating users.
	 *
	 * @inheritdoc
	 */
	public function registerUserBackend();

	/**
	 * Initializes the application.
	 *
	 * @inheritdoc
	 */
	public function init();
} 