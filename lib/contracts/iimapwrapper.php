<?php

/**
 * Created by PhpStorm.
 * User: Burgy Benjamin
 * Date: 30.11.14
 * Time: 11:25
 */

namespace OCA\user_imapauth\lib\Contracts;

/**
 * Wrappers for IMAP methods.
 * @package OCA\user_imapauth\lib\Contracts
 */
interface IIMAPWrapper
{
	/**
	 * Wraps the method <b>imap_open</b>.
	 *
	 * @param string $mailbox
	 * @param string $username
	 * @param string $password
	 * @param int    $options
	 * @param int    $retries
	 *
	 * @return mixed
	 * @inheritdoc
	 */
	public function open($mailbox, $username, $password, $options, $retries);

	/**
	 * Returns last errors.
	 *
	 * @return array
	 * @inheritdoc
	 */
	public function getLastErrors();
} 