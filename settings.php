<?php

OC_Util::checkAdminUser();

/** @noinspection SpellCheckingInspection */
script('user_imapauth', 'jquery.ba-throttle-debounce.min');
/** @noinspection SpellCheckingInspection */
script('user_imapauth', 'settings-admin');

/** @var OC_Template $template */
$template = new OC_Template(APP_ID, 'settings');

$template->assign('imap_uri', OCP\Config::getAppValue(APP_ID, 'imap_uri'));
$template->assign('imap_port', OCP\Config::getAppValue(APP_ID, 'imap_port'));

return $template->fetchPage();
