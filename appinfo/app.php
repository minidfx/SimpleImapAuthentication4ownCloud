<?php

/**
 * Created by PhpStorm.
 * User: Burgy Benjamin
 * Date: 22.11.14
 * Time: 23:34
 */

namespace OCA\user_imapauth\AppInfo;

use OCA\user_imapauth\App\Contracts\IIMAPAuthenticatorApp;
use OCA\user_imapauth\App\IMAPAuthenticatorApp;
use OCA\user_imapauth\lib\Contracts\IIMAPAuthBootstrapper;
use OCA\user_imapauth\lib\IMAPAuthBootstrapper;

/** @var IIMAPAuthenticatorApp $app */
$app = new IMAPAuthenticatorApp();

/** @var IIMAPAuthBootstrapper $bootstrapper */
$bootstrapper = new IMAPAuthBootstrapper($app);

$bootstrapper->init();
$bootstrapper->registerAdminFunctionalities();