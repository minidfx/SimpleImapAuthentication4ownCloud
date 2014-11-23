<?php

namespace OCA\user_imapauth\controller;

use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IL10N;
use OCP\ILogger;
use OCP\IRequest;

/**
 * Created by PhpStorm.
 * User: minidfx
 * Date: 23.11.14
 * Time: 11:41
 */

/**
 * Class PageController
 * @package OCA\user_imapauth\controller
 */
final class PageController
	extends
	Controller
{
	/**
	 * @var ILogger
	 */
	private $logger;

	/**
	 * @var IL10N
	 */
	private $l01n;

	/**
	 * Initializes an instance of <b>PageController</b>
	 *
	 * @param string   $appName
	 * @param ILogger  $logger
	 * @param IRequest $request
	 * @param IL10N    $l01n
	 */
	public function __construct($appName, ILogger $logger, IRequest $request, IL10N $l01n)
	{
		parent::__construct($appName, $request);

		$this->logger = $logger;
		$this->l01n   = $l01n;

		$this->logger->info('PageController has been accessed.');
	}

	/**
	 * The main page of the authenticator. Contains a small description how to use the configure the authenticator.
	 *
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function index()
	{
		return new TemplateResponse(APP_ID, 'main');
	}
}