<?php

namespace OCA\user_imapauth\controller;

use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\TemplateResponse;
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
	 * Initializes an instance of <b>PageController</b>
	 *
	 * @param string   $appName
	 * @param ILogger  $logger
	 * @param IRequest $request
	 */
	public function __construct($appName, ILogger $logger, IRequest $request)
	{
		parent::__construct($appName, $request);

		$this->logger = $logger;

		$this->logger->info('PageController has been accessed.');
	}

	/**
	 * The main page of the authenticator. Contains a small description how to use the configure the authenticator.
	 *
	 * @NoAdminRequired
	 */
	public function index()
	{
		$this->logger->info('Returning the template index.');

		return new TemplateResponse($this->appName, 'index', array());
	}
}