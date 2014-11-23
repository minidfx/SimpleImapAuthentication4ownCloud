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

		$container->registerService('UserSession', function (IAppContainer $c)
		{
			return new IMAPAuthenticator($c->query('ServerContainer')->getUserManager(),
			                             $c->query('ServerContainer')->getConfig(),
			                             $c->query('ServerContainer')->getLogger());
		});

		$container->registerService('PageController', function (IAppContainer $c)
		{
			return new PageController($c->query('AppName'),
			                          $c->query('ServerContainer')->getLogger(),
			                          $c->query('Request'),
			                          $c->query('ServerContainer')->getL10N($c->query('AppName')));
		});
	}
}