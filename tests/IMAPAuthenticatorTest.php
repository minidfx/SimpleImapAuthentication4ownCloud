<?php

/**
 * Created by PhpStorm.
 * User: Burgy Benjamin
 * Date: 29.11.14
 * Time: 08:12
 */

namespace OCA\user_imapauth\Tests;

use OCA\user_imapauth\lib\Contracts\IIMAPWrapper;
use OCA\user_imapauth\lib\IMAPAuthenticator;
use OCP\IConfig;
use OCP\ILogger;
use OCP\IUser;
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
	 * @var PHPUnit_Framework_MockObject_MockObject|IIMAPWrapper
	 */
	private $injectedIMAPWrapperMock;

	/**
	 * @var IMAPAuthenticator
	 */
	private $sut;

	/**
	 * @var PHPUnit_Framework_MockObject_MockObject|IUser
	 */
	private $returnedUserMock;

	/**
	 * @test
	 */
	public function when_checkPassword_is_called_without_host()
	{
		$this->injectedConfigMock->expects($this->exactly(2))
		                         ->method('getAppValue')
		                         ->will($this->returnValue(NULL));

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
		                                   $this->injectedLoggerMock, $this->injectedIMAPWrapperMock);
	}

	/**
	 * @test
	 */
	public function when_checkPassword_is_called_without_port()
	{
		$this->injectedConfigMock->expects($this->at(0))
		                         ->method('getAppValue')
		                         ->will($this->returnValue('an host'));

		$this->createSut();
		$this->injectedLoggerMock->expects($this->once())
		                         ->method('error')
		                         ->with('The IMAP port is missing. You have to configure the authenticator from the admin console.',
		                                array('app' => APP_ID));

		$result = $this->sut->checkPassword('an uid', 'a password');

		$this->assertFalse($result);
	}

	/**
	 * @test
	 */
	public function when_checkPassword_is_called_with_wrong_credentials()
	{
		/** @var string $returnedHost */
		$returnedHost = 'an host';
		/** @var string $returnedPort */
		$returnedPort = 'a port';

		/** @var array $returnedIMAPErrors */
		$returnedIMAPErrors = array('error 1',
		                            'error 2');

		/** @var string $specifiedUsername */
		$specifiedUsername = 'an uid';
		/** @var string $specifiedPassword */
		$specifiedPassword = 'a password';

		$this->injectedConfigMock->expects($this->at(0))
		                         ->method('getAppValue')
		                         ->will($this->returnValue($returnedHost));

		$this->injectedConfigMock->expects($this->at(1))
		                         ->method('getAppValue')
		                         ->will($this->returnValue($returnedPort));

		$this->createSut();

		$this->injectedIMAPWrapperMock->expects($this->once())
		                              ->method('open')
		                              ->with("{{$returnedHost}:{$returnedPort}/imap/ssl}INBOX", $specifiedUsername,
		                                     $specifiedPassword, OP_READONLY, 3)
		                              ->will($this->returnValue(FALSE));

		$this->injectedIMAPWrapperMock->expects($this->once())
		                              ->method('getLastErrors')
		                              ->will($this->returnValue($returnedIMAPErrors));

		$this->injectedLoggerMock->expects($this->once())
		                         ->method('warning')
		                         ->with(implode(';', $returnedIMAPErrors), array('app' => APP_ID));

		$result = $this->sut->checkPassword($specifiedUsername, $specifiedPassword);

		$this->assertFalse($result);
	}

	/**
	 * @test
	 */
	public function when_checkPassword_is_called_with_valid_credentials_and_user_dont_exists()
	{
		/** @var string $returnedHost */
		$returnedHost = 'an host';
		/** @var string $returnedPort */
		$returnedPort = 'a port';

		/** @var string $specifiedUsername */
		$specifiedUsername = 'an uid';
		/** @var string $specifiedPassword */
		$specifiedPassword = 'a password';

		$this->injectedConfigMock->expects($this->at(0))
		                         ->method('getAppValue')
		                         ->will($this->returnValue($returnedHost));

		$this->injectedConfigMock->expects($this->at(1))
		                         ->method('getAppValue')
		                         ->will($this->returnValue($returnedPort));

		$this->createSut();

		$this->injectedIMAPWrapperMock->expects($this->once())
		                              ->method('open')
		                              ->with("{{$returnedHost}:{$returnedPort}/imap/ssl}INBOX", $specifiedUsername,
		                                     $specifiedPassword, OP_READONLY, 3)
		                              ->will($this->returnValue(TRUE));

		$this->injectedUserManagerMock->expects($this->once())
		                              ->method('userExists')
		                              ->with($specifiedUsername)
		                              ->will($this->returnValue(FALSE));

		$this->injectedUserManagerMock->expects($this->once())
		                              ->method('createUser')
		                              ->with($specifiedUsername, $specifiedPassword);

		$result = $this->sut->checkPassword($specifiedUsername, $specifiedPassword);

		$this->assertEquals($specifiedUsername, $result);
	}

	/**
	 * @test
	 */
	public function when_checkPassword_is_called_with_valid_credentials_and_user_exists()
	{
		/** @var string $returnedHost */
		$returnedHost = 'an host';
		/** @var string $returnedPort */
		$returnedPort = 'a port';

		/** @var string $specifiedUsername */
		$specifiedUsername = 'an uid';
		/** @var string $specifiedPassword */
		$specifiedPassword = 'a password';

		$this->injectedConfigMock->expects($this->at(0))
		                         ->method('getAppValue')
		                         ->will($this->returnValue($returnedHost));

		$this->injectedConfigMock->expects($this->at(1))
		                         ->method('getAppValue')
		                         ->will($this->returnValue($returnedPort));

		$this->createSut();

		$this->injectedIMAPWrapperMock->expects($this->once())
		                              ->method('open')
		                              ->with("{{$returnedHost}:{$returnedPort}/imap/ssl}INBOX", $specifiedUsername,
		                                     $specifiedPassword, OP_READONLY, 3)
		                              ->will($this->returnValue(TRUE));

		$this->injectedUserManagerMock->expects($this->once())
		                              ->method('userExists')
		                              ->with($specifiedUsername)
		                              ->will($this->returnValue(TRUE));

		$this->returnedUserMock->expects($this->once())
		                       ->method('setPassword')
		                       ->with($specifiedPassword);

		$this->injectedUserManagerMock->expects($this->once())
		                              ->method('get')
		                              ->with($specifiedUsername)
		                              ->will($this->returnValue($this->returnedUserMock));

		$this->injectedLoggerMock->expects($this->once())
		                         ->method('info')
		                         ->with("The user password of the user $specifiedUsername has been updated in the local storage.",
		                                array('app' => APP_ID));

		$result = $this->sut->checkPassword($specifiedUsername, $specifiedPassword);

		$this->assertEquals($specifiedUsername, $result);
	}

	/**
	 * @test
	 */
	public function when_implementsActions_is_called_with_OC_USER_BACKEND_CHECK_PASSWORD()
	{
		$this->createSut();

		/** @noinspection PhpParamsInspection */
		$result = $this->sut->implementsActions(OC_USER_BACKEND_CHECK_PASSWORD);

		$this->assertTrue($result);
	}

	/**
	 * @test
	 */
	public function when_implementsActions_is_called_with_different_OC_USER_BACKEND_CHECK_PASSWORD_as_actions()
	{
		$this->createSut();

		foreach (array(OC_USER_BACKEND_CREATE_USER,
		               OC_USER_BACKEND_SET_PASSWORD,
		               OC_USER_BACKEND_GET_HOME,
		               OC_USER_BACKEND_GET_DISPLAYNAME,
		               OC_USER_BACKEND_SET_DISPLAYNAME,
		               OC_USER_BACKEND_PROVIDE_AVATAR,
		               OC_USER_BACKEND_COUNT_USERS
		         ) as $constant)
		{
			/** @noinspection PhpParamsInspection */
			$result = $this->sut->implementsActions($constant);

			$this->assertFalse($result);
		}
	}

	/**
	 * @test
	 */
	public function when_deleteUser_is_called()
	{
		$this->createSut();

		$result = $this->sut->deleteUser('an uid');

		$this->assertFalse($result);
	}

	/**
	 * @test
	 */
	public function when_getUsers_is_called()
	{
		$this->createSut();

		$result = $this->sut->getUsers('a search query', 'a limit', 'an offset');

		$this->assertFalse($result);
	}

	/**
	 * @test
	 */
	public function when_userExists_is_called()
	{
		$this->createSut();

		$result = $this->sut->userExists('an uid');

		$this->assertFalse($result);
	}

	/**
	 * @test
	 */
	public function when_getDisplayName_is_called()
	{
		$this->createSut();

		$result = $this->sut->getDisplayName('an uid');

		$this->assertFalse($result);
	}

	/**
	 * @test
	 */
	public function when_getDisplayNames_is_called()
	{
		$this->createSut();

		$result = $this->sut->getDisplayNames('a search query', 'a limit', 'an offset');

		$this->assertFalse($result);
	}

	/**
	 * @test
	 */
	public function when_hasUserListings_is_called()
	{
		$this->createSut();

		$result = $this->sut->hasUserListings();

		$this->assertFalse($result);
	}

	protected function setUp()
	{
		parent::setUp();

		$this->injectedConfigMock      = $this->getMock('\OCP\IConfig');
		$this->injectedUserManagerMock = $this->getMock('\OCP\IUserManager');
		$this->injectedLoggerMock      = $this->getMock('\OCP\ILogger');
		$this->injectedIMAPWrapperMock = $this->getMock('\OCA\user_imapauth\lib\Contracts\IIMAPWrapper');
		$this->returnedUserMock        = $this->getMock('\OCP\IUser');
	}
}
 