<?php

\OCP\App::addNavigationEntry(array(

	                             // the string under which your app will be referenced in owncloud
	                             'id'    => APP_ID,

	                             // sorting weight for the navigation. The higher the number, the higher
	                             // will it be listed in the navigation
	                             'order' => 1,

	                             // the route that will be shown on startup
	                             'href'  => \OCP\Util::linkToRoute('myapp.page.index'),

	                             // the icon that will be shown in the navigation
	                             // this file needs to exist in img/example.png
	                             'icon'  => \OCP\Util::imagePath('myapp', 'app.svg'),

	                             // the title of your application. This will be used in the
	                             // navigation or on the settings page of your app
	                             'name'  => \OC_L10N::get(APP_ID)->t('User authentication IMAP')
                             ));

// execute OCA\MyApp\Hooks\User::deleteUser before a user is being deleted
\OCP\Util::connectHook('OC_User', 'preLogin', 'OCA\ImapAuth', 'preLogin');
