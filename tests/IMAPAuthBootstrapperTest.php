<?php

use OCA\user_imapauth\App\Contracts\IIMAPAuthenticatorApp;
use OCA\user_imapauth\lib\Contracts\IIMAPAuthBootstrapper;
use OCA\user_imapauth\lib\IMAPAuthBootstrapper;

/**
 * Created by PhpStorm.
 * User: Burgy Benjamin
 * Date: 09.12.14
 * Time: 11:53
 */
final class IMAPAuthBootstrapperTest
	extends
	PHPUnit_Framework_TestCase
{
	/**
	 * @var IIMAPAuthBootstrapper
	 */
	private $sut;

	/**
	 * @var PHPUnit_Framework_MockObject_MockObject|IIMAPAuthenticatorApp
	 */
	private $injectedApp;

	/**
	 * @test
	 */
	public function when_init_is_called()
	{
		$this->createSut();

		$this->injectedApp->expects($this->once())
		                  ->method('registerUserBackend');

		$this->sut->init();

		$this->assertTrue(defined('APP_ID'));
	}

	private function createSut()
	{
		$this->injectedApp = $this->getMock('OCA\user_imapauth\App\Contracts\IIMAPAuthenticatorApp');

		$this->sut = new IMAPAuthBootstrapper($this->injectedApp);
	}
}
 