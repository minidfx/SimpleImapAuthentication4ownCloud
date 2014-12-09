<?php

/**
 * Created by PhpStorm.
 * User: Burgy Benjamin
 * Date: 23.11.14
 * Time: 11:07
 */

namespace OCA\user_imapauth\App;

use Exception;
use OCA\user_imapauth\App\Contracts\IIMAPAuthenticatorApp;
use OCA\user_imapauth\lib\IMAPAuthenticator;
use OCA\user_imapauth\lib\IMAPWrapper;
use OCP\AppFramework\App;
use OCP\AppFramework\IAppContainer;
use OCP\ILogger;
use OCP\IUserManager;

final class IMAPAuthenticatorApp
	extends
	App
	implements
	IIMAPAuthenticatorApp
{
	/**
	 * @var App
	 */
	private $app;

	/**
	 * @var array
	 */
	private $urlParams;

	/**
	 * Initializes an instance of <b>IMAPAuthenticatorApp</b>
	 *
	 * @param array $urlParams
	 */
	public function __construct(array $urlParams = array())
	{
		$this->urlParams = $urlParams;
	}

	public function registerUserBackend()
	{
		if ($this->app === NULL)
		{
			throw new Exception('Invalid operation, the app must be initialized!');
		}

		/** @var IAppContainer $container */
		$container = $this->app->getContainer();

		/** @var IUserManager $userManager */
		$userManager = $container->query('UserManager');

		/** @var IMAPAuthenticator $imapUserManager */
		$imapUserManager = $container->query('IMAPUserManager');

		$userManager->registerBackend($imapUserManager);
	}

	/**
	 * Initializes the application.
	 *
	 * @inheritdoc
	 */
	public function init()
	{
		$this->app = new App(APP_ID, $this->urlParams);

		/** @var IAppContainer $container */
		$container = $this->app->getContainer();

		$container->registerService('L10N', function (IAppContainer $c)
		{
			return $c->query('ServerContainer')->getL10N($c->query('AppName'));
		});

		$container->registerService('UserManager', function (IAppContainer $c)
		{
			return $c->query('ServerContainer')->getUserManager();
		});

		$container->registerService('Config', function (IAppContainer $c)
		{
			return $c->query('ServerContainer')->getConfig();
		});

		$container->registerService('Logger', function (IAppContainer $c)
		{
			return $c->query('ServerContainer')->getLogger();
		});

		/** @noinspection PhpUnusedParameterInspection */
		$container->registerService('IMAPWrapper', function (IAppContainer $c)
		{
			return new IMAPWrapper();
		});

		$container->registerService('IMAPUserManager', function (IAppContainer $c)
		{
			return new IMAPAuthenticator($c->query('UserManager'), $c->query('Config'), $c->query('Logger'),
			                             $c->query('IMAPWrapper'));
		});
	}
}