<?php

/**
 * Created by PhpStorm.
 * User: Burgy Benjamin
 * Date: 29.11.14
 * Time: 08:15
 */

/** @noinspection SpellCheckingInspection */
define('APP_ID', 'user_imapauth');

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
		$fileToLoad = "/../$fileToLoad.php";
	}

	if ($fileToLoad !== NULL)
	{
		$fileToLoad = strtolower($fileToLoad);

		/** @noinspection PhpIncludeInspection */
		require_once __DIR__ . $fileToLoad;
	}
});

require_once __DIR__ . '/../vendor/autoload.php';