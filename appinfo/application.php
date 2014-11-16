<?php
/**
 * Created by PhpStorm.
 * User: MiniDfx
 * Date: 11/15/2014
 * Time: 19:17
 */

use OC\AppFramework\App;

define('APP_ID', 'user_imapauth', TRUE);

/** @noinspection PhpIncludeInspection */
require_once 'apps/' . APP_ID . '/lib/iMAPAuthenticator.php';
/** @noinspection PhpIncludeInspection */
require_once 'apps/' . APP_ID . '/lib/user_imapauth.php';

final class UserImapAuthentication
	extends
	App
{
	public function __construct(array $urlParams = array())
	{
		parent::__construct(APP_ID, $urlParams);
	}
}