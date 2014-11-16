<?php

namespace OCA\user_imapauth\lib;

	/**
	 * ownCloud - user_imapauth
	 *
	 * @author    Burgy Benjamin
	 * @copyright 2014 Burgy Benjamin <benjamin.burgy@gmail.com>
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

/**
 * Authenticator for validating credentials of a user.
 */
final class iMAPAuthenticator
{
	/**
	 * The username of the user.
	 * @var string
	 */
	private $userName;

	/**
	 * The password of the user.
	 * @var string
	 */
	private $password;

	/**
	 * The host of the IMAP server
	 * @var string
	 */
	private $host;

	/**
	 * The port of the IMAP server
	 * @var int
	 */
	private $port;

	/**
	 * The reference of the mailbox
	 * @var mixed
	 */
	private $mbox;

	/**
	 * Constructs a new authenticator to authentify a user by IMAP with SSL.
	 *
	 * @param string $host
	 * @param int    $port
	 * @param string $userName
	 * @param string $password
	 */
	public function __construct($host, $port, $userName, $password)
	{
		$this->host     = $host;
		$this->port     = $port;
		$this->userName = $userName;
		$this->password = $password;
	}

	/**
	 * Validates credentials of the user.
	 *
	 * @return bool
	 */
	public function validCredentials()
	{
		if ($this->login() !== FALSE)
		{
			$this->logout();

			return TRUE;
		}

		return FALSE;
	}

	/**
	 * Does a connection to the IMAP server.
	 *
	 * @return bool
	 */
	public function login()
	{
		$this->mbox = imap_open('{$this->host}:{$this->port}/imap/ssl}INBOX', $this->userName,
		                        $this->password, OP_READONLY,
		                        0);  // INFO: [MiniDfx 15-11-2014 07:32:12] Try to open the inbox in read only without retry.

		return $this->mbox !== FALSE;
	}

	/**
	 * Close the connection previously opened.
	 */
	public function logout()
	{
		if ($this->mbox !== FALSE)
			imap_close($this->mbox);
	}
}