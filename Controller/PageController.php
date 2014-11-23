<?php

namespace OCA\user_imapauth\controller;

use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IConfig;
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
	private $l10n;

	/**
	 * @var IConfig
	 */
	private $config;

	/**
	 * Initializes an instance of <b>PageController</b>
	 *
	 * @param string   $appName
	 * @param ILogger  $logger
	 * @param IRequest $request
	 * @param IL10N    $l10n
	 * @param IConfig  $config
	 */
	public function __construct($appName, ILogger $logger, IRequest $request, IL10N $l10n, IConfig $config)
	{
		parent::__construct($appName, $request);

		$this->logger = $logger;
		$this->l10n   = $l10n;
		$this->config = $config;

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
		$imapUri  = $this->config->getAppValue($this->appName, 'imap_uri', '');
		$imapPort = $this->config->getAppValue($this->appName, 'imap_port', '');

		return new TemplateResponse(APP_ID, 'main', array('imap_uri'  => $imapUri,
		                                                  'imap_port' => $imapPort));
	}
}