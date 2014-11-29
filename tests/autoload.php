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
	$fileToLoad = str_replace('\\', '/', $class);

	if ($startsWith === 'OCA')
	{
		$fileToLoad = str_replace('OCA/user_imapauth/', '', $fileToLoad);
		require_once __DIR__ . "/../$fileToLoad.php";
	}
	else if ($startsWith === 'OCP')
	{
		$fileToLoad = str_replace('OCP/', '', $fileToLoad);
		require_once __DIR__ . "/Interfaces/$fileToLoad.php";
	}
	else if ($startsWith === 'OC_')
	{
		require_once __DIR__ . "/Interfaces/$fileToLoad.php";
	}
});