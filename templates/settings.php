<div id="imapauth" class="section" ng-controller="groupsController">
	<form id="imapauth">
		<h2><?php p($l->t('IMAP User Authentication')); ?></h2>

		<p>
			<label for="imap_uri"><?php p($l->t('Server Host')); ?></label>
			<input type="text" id="imap_uri" name="imap_uri"
			       value="<?php p($_['imap_uri']); ?>">
		</p>

		<p>
			<label for="imap_port"><?php p($l->t('Server Port')); ?></label>
			<input type="password" id="imap_port" name="imap_port"
			       value="<?php p($_['imap_port']); ?>">
		</p>

		<input type="hidden" name="requesttoken" value="<?php p($_['requesttoken']) ?>" id="requesttoken">

		<p>
			<?php p($l->t('ownCloud will send the user credentials to this Host. This plugin check it can open the INBOX of the user.')); ?>
			<span id="imap_settings_msg" class="msg success" style="display: none;">Saved</span>
		</p>
	</form>
</div>