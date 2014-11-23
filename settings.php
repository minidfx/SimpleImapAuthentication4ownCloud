<?php

OC_Util::checkAdminUser();

if ($_POST)
{
	OCP\JSON::callCheck();

	if (isset($_POST['imap_uri']))
		OC_Config::setValue('user_imap_uri', strip_tags($_POST['imap_uri']));

	if (isset($_POST['imap_port']))
		OC_Config::setValue('user_imap_port', strip_tags($_POST['imap_port']));
}

/** @var OC_Template $template */
$template = new OC_Template(APP_ID, 'settings');

$template->assign('imap_uri', OC_Config::getValue('user_imap_uri'));
$template->assign('imap_port', OC_Config::getValue('user_imap_port'));

return $template->fetchPage();
