<?php

/**
 * Created by PhpStorm.
 * User: Burgy Benjamin
 * Date: 23.11.14
 * Time: 11:07
 */

namespace OCA\user_imapauth\App;

use OCA\user_imapauth\lib\IMAPAuthenticator;
use OCA\user_imapauth\lib\IMAPWrapper;
use OCP\AppFramework\App;
use OCP\AppFramework\IAppContainer;
use OCP\ILogger;
use OCP\IUserManager;

final class IMAPAuthenticatorApp
	extends
	App
{
	/**
	 * Initializes an instance of <b>IMAPAuthenticatorApp</b>
	 *
	 * @param array $urlParams
	 */
	public function __construct(array $urlParams = array())
	{
		parent::__construct(APP_ID, $urlParams);

		$container = $this->getContainer();

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

		$container->registerService('IMAPUserManager', function (IAppContainer $c)
		{
			return new IMAPAuthenticator($c->query('UserManager'), $c->query('Config'), $c->query('Logger'),
			                             new IMAPWrapper());
		});

		/** @var IUserManager $userManager */
		$userManager = $container->query('UserManager');

		/** @var IMAPAuthenticator $imapUserManager */
		$imapUserManager = $container->query('IMAPUserManager');

		$userManager->registerBackend($imapUserManager);
	}
}