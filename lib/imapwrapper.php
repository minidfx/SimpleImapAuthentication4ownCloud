<?php

/**
 * Created by PhpStorm.
 * User: Burgy Benjamin
 * Date: 30.11.14
 * Time: 11:24
 */

namespace OCA\user_imapauth\lib;

use OCA\user_imapauth\lib\Contracts\IIMAPWrapper;

/**
 * Wrappers of methods <b>imap_open</b> and <b>imap_errors()</b>.
 * @package OCA\user_imapauth\lib
 */
final class IMAPWrapper
	implements
	IIMAPWrapper
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
	 */
	public function open($mailbox, $username, $password, $options, $retries)
	{
		return @imap_open($mailbox, $username, $password, $options, $retries);
	}

	/**
	 * Returns last errors.
	 *
	 * @return array
	 */
	public function getLastErrors()
	{
		return imap_errors();
	}
}