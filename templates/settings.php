<?php

script('user_imapauth', 'settings-admin');

?>

<div id="imapauth" class="section" ng-controller="groupsController">
	<form id="imapaut">
		<h2><?php p($l->t('IMAP User Authentication')); ?></h2>

		<p>
			<label for="imap_uri"><?php p($l->t('Server IMAP Host')); ?></label>
			<input type="text" id="imap_uri" name="imap_uri"
			       value="<?php p($_['imap_uri']); ?>">
		</p>

		<p>
			<label for="imap_port"><?php p($l->t('Server Port')); ?></label>
			<input type="text" id="imap_port" name="imap_port"
			       value="<?php p($_['imap_port']); ?>">
		</p>

		<p>
			<input type="hidden" name="requesttoken" value="<?php p($_['requesttoken']) ?>" id="requesttoken">
			<input type="submit" value="Save"/>
		</p>

		<p>
			<?php p($l->t('ownCloud will send the user credentials to this Host. This plugin check it can open the INBOX of the user.')); ?>
		</p>
	</form>
</div>