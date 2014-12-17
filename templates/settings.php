<div id="imapauth" class="section" ng-controller="groupsController">
	<form id="imapauth_form">
		<h2><?php p($l->t('IMAP User Authentication')); ?></h2>

		<p class="imap_uri">
			<label for="imap_uri">
				<?php p($l->t('Server Host')); ?>
				<input type="text" name="imap_uri" value="<?php p($_['imap_uri']); ?>"
				       original-title="<?php p($l->t('The host of the IMAP server. i.e. mail.domain.com')); ?>">
			</label>
		</p>

		<div class="imap_port_ssl">
			<div class="imap_port">
				<label for="imap_port">
					<?php p($l->t('Server Port')); ?>
					<input type="number" name="imap_port" value="<?php p($_['imap_port']); ?>"
					       maxlength="5"
					       original-title="<?php p($l->t('The port of the IMAP server. i.e. 143')) ?>">
				</label>
			</div>
			<div class="imap_ssl">
				<label for="imap_use_ssl">
					<input type="checkbox" name="imap_use_ssl"
					       value="true"
						<?php if ($_['imap_use_ssl'] === TRUE) echo 'checked="checked"'; ?>
					       original-title="<?php p($l->t('If the provider of your IMAP server supports SSL.')); ?>"/>
					<?php p($l->t('Use SSL')); ?>
				</label>
			</div>
			<div class="clear"></div>
		</div>

		<p class="imap_max_retries">
			<label for="imap_max_retries">
				<?php p($l->t('Max retries')); ?>
				<input type="number" name="imap_max_retries" value="<?php p($_['imap_max_retries']); ?>"
				       maxlength="1"
				       original-title="<?php p($l->t('The number of retries for reaching the IMAP server.')) ?>"/>
			</label>
			<span id="imap_settings_msg" class="msg success" style="display: none;">Saved</span>
		</p>

		<input type="hidden" name="requesttoken" value="<?php p($_['requesttoken']) ?>" id="requesttoken">

		<p>
			<?php p($l->t('ownCloud will send the user credentials to the host. This plugin will check whether it can open the INBOX of the user.')); ?>
		</p>
	</form>
</div>