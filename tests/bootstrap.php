<?php

/**
 * Created by PhpStorm.
 * User: Burgy Benjamin
 * Date: 29.11.14
 * Time: 08:15
 */

/** @noinspection SpellCheckingInspection */
define('APP_ID', 'user_imapauth');

define('OC_USER_BACKEND_CREATE_USER', 0x00000001);
define('OC_USER_BACKEND_SET_PASSWORD', 0x00000010);
define('OC_USER_BACKEND_CHECK_PASSWORD', 0x00000100);
define('OC_USER_BACKEND_GET_HOME', 0x00001000);
define('OC_USER_BACKEND_GET_DISPLAYNAME', 0x00010000);
define('OC_USER_BACKEND_SET_DISPLAYNAME', 0x00100000);
define('OC_USER_BACKEND_PROVIDE_AVATAR', 0x01000000);
define('OC_USER_BACKEND_COUNT_USERS', 0x10000000);

spl_autoload_register(function ($class)
{
	/** @var string $startsWith */
	$startsWith = substr($class, 0, 3);
	/** @var string $fileToLoad */
	$fileToLoad = NULL;

	if ($startsWith === 'OCA')
	{
		$fileToLoad = str_replace('\\', '/', $class);
		$fileToLoad = str_replace('OCA/user_imapauth/', '', $fileToLoad);
		$fileToLoad = __DIR__ . "/../$fileToLoad.php";
	}
	else if ($startsWith === 'OCP')
	{
		$fileToLoad = str_replace('\\', '/', $class);
		$fileToLoad = str_replace('OCP/', '', $fileToLoad);
		$fileToLoad = __DIR__ . "/interfaces/$fileToLoad.php";
	}
	else if ($startsWith === 'OC_')
	{
		$fileToLoad = str_replace('\\', '/', $class);
		$fileToLoad = __DIR__ . "/interfaces/$fileToLoad.php";
	}

	if ($fileToLoad !== NULL)
	{
		$fileToLoad = strtolower($fileToLoad);

		/** @noinspection PhpIncludeInspection */
		require_once $fileToLoad;
	}
});