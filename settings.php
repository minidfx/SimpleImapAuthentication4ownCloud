<?php

/**
 * Created by PhpStorm.
 * User: Burgy Benjamin
 * Date: 22.11.14
 * Time: 21:20
 */

OC_Util::checkAdminUser();

/** @noinspection SpellCheckingInspection */
script('user_imapauth', 'jquery.ba-throttle-debounce.min');
/** @noinspection SpellCheckingInspection */
script('user_imapauth', 'settings-admin');
/** @noinspection SpellCheckingInspection */
style('user_imapauth', 'settings');

/** @var OC_Template $template */
$template = new OC_Template(APP_ID, 'settings');

$template->assign('imap_uri', OCP\Config::getAppValue(APP_ID, 'imap_uri'));
$template->assign('imap_port', OCP\Config::getAppValue(APP_ID, 'imap_port'));
$template->assign('imap_max_retries', OCP\Config::getAppValue(APP_ID, 'imap_max_retries'));

return $template->fetchPage();
