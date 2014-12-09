<div id="imapauth" class="section" ng-controller="groupsController">
	<form id="imapauth">
		<h2><?php p($l->t('IMAP User Authentication')); ?></h2>

		<p>
			<label for="imap_uri"><?php p($l->t('Server Host')); ?></label>
			<input type="text" class="imap_uri" name="imap_uri" value="<?php p($_['imap_uri']); ?>"
			       original-title="<?php p($l->t('The host of the IMAP server. i.e. mail.domain.com')); ?>">
		</p>

		<p>
			<label for="imap_port"><?php p($l->t('Server Port')); ?></label>
			<input type="number" name="imap_port" class="imap_port" value="<?php p($_['imap_port']); ?>"
			       original-title="<?php p($l->t('The port of the IMAP server. i.e. 143')) ?>">
		</p>

		<p>
			<label for="imap_max_retries"><?php p($l->t('Max retries')); ?></label>
			<input type="number" name="imap_max_retries" value="<?php p($_['imap_max_retries']); ?>"
			       class="imap_max_retries" maxlength="1"
			       original-title="<?php p($l->t('The number of retries for reaching the IMAP server.')) ?>"/>
			<span id="imap_settings_msg" class="msg success" style="display: none;">Saved</span>
		</p>

		<input type="hidden" name="requesttoken" value="<?php p($_['requesttoken']) ?>" id="requesttoken">

		<p>
			<?php p($l->t('ownCloud will send the user credentials to this Host. This plugin check it can open the INBOX of the user.')); ?>
		</p>
	</form>
</div>