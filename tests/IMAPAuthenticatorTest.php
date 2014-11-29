<?php

/**
 * Created by PhpStorm.
 * User: Burgy Benjamin
 * Date: 29.11.14
 * Time: 08:12
 */

namespace OCA\user_imapauth\Tests;

use OCA\user_imapauth\lib\IMAPAuthenticator;
use OCP\IConfig;
use OCP\ILogger;
use OCP\IUserManager;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;

final class IMAPAuthenticatorTest
	extends
	PHPUnit_Framework_TestCase
{
	/**
	 * @var PHPUnit_Framework_MockObject_MockObject|IConfig
	 */
	private $injectedConfigMock;

	/**
	 * @var PHPUnit_Framework_MockObject_MockObject|IUserManager
	 */
	private $injectedUserManagerMock;

	/**
	 * @var PHPUnit_Framework_MockObject_MockObject|ILogger
	 */
	private $injectedLoggerMock;

	/**
	 * @var IMAPAuthenticator
	 */
	private $sut;

	/**
	 * @test
	 */
	public function when_checkPassword_is_called_without_host()
	{
		$this->createSut();
		$this->injectedLoggerMock->expects($this->once())
		                         ->method('error')
		                         ->with('The IMAP host is missing. You have to configure the authenticator from the admin console.',
		                                array('app' => APP_ID));

		$result = $this->sut->checkPassword('an uid', 'a password');

		$this->assertFalse($result);
	}

	private function createSut()
	{
		$this->sut = new IMAPAuthenticator($this->injectedUserManagerMock, $this->injectedConfigMock,
		                                   $this->injectedLoggerMock);
	}

	protected function setUp()
	{
		parent::setUp();

		$this->injectedConfigMock      = $this->getMock('\OCP\IConfig');
		$this->injectedUserManagerMock = $this->getMock('\OCP\IUserManager');
		$this->injectedLoggerMock      = $this->getMock('\OCP\ILogger');
	}
}
 