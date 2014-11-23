<form id="imapauth" action="#" method="post">
	<fieldset class="personalblock">
		<legend><strong><?php p($l->t('IMAP Authentication')); ?></strong></legend>
		<p>
			<label for="imap_uri"><?php p($l->t('Host')); ?><input type="text" id="imap_uri" name="imap_uri"
			                                                       value="<?php p($_['imap_uri']); ?>"></label>
		</p>

		<p>
			<label for="imap_port"><?php p($l->t('Port')); ?><input type="text" id="imap_port" name="imap_port"
			                                                        value="<?php p($_['imap_port']); ?>"></label>
		</p>

		<p>
			<input type="hidden" name="requesttoken" value="<?php p($_['requesttoken']) ?>" id="requesttoken">
			<input type="submit" value="Save"/>
		</p>

		<p>
			<?php p($l->t('ownCloud will send the user credentials to this Host. This plugin check it can open the INBOX of the user.')); ?>
		</p>
	</fieldset>
</form>
