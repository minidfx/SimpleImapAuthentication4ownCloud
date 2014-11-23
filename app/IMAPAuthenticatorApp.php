<?php
/**
 * Created by PhpStorm.
 * User: minidfx
 * Date: 23.11.14
 * Time: 11:07
 */

namespace OCA\user_imapauth\App;

use OCA\user_imapauth\controller\PageController;
use OCA\user_imapauth\lib\IMAPAuthenticator;
use OCP\AppFramework\App;
use OCP\AppFramework\IAppContainer;

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

		$container->registerService('Config', function (IAppContainer $c)
		{
			return $c->query('ServerContainer')->getConfig();
		});

		$container->registerService('Logger', function (IAppContainer $c)
		{
			return $c->query('ServerContainer')->getLogger();
		});

		$container->registerService('UserSession', function (IAppContainer $c)
		{
			return new IMAPAuthenticator($c->query('ServerContainer')->getUserManager(),
			                             $c->query('Config'),
			                             $c->query('Logger'));
		});

		$container->registerService('PageController', function (IAppContainer $c)
		{
			return new PageController($c->query('AppName'),
			                          $c->query('Logger'),
			                          $c->query('Request'),
			                          $c->query('ServerContainer')->getL10N($c->query('AppName')),
			                          $c->query('Config'));
		});
	}
}