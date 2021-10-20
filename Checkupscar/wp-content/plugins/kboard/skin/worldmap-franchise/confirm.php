<?php
if(isset($_GET['kboard-content-remove-nonce']) && $_GET['kboard-content-remove-nonce']){
	$confirm_url = $url->getContentRemove(kboard_uid());
}
else{
	$confirm_url = $url->set('mod', kboard_mod())->set('uid', kboard_uid())->toString();
}
?>
<div id="kboard-worldmap-franchise-editor">
	<form method="post" action="<?php echo $confirm_url?>">
		<div class="kboard-attr-row kboard-confirm-row kboard-attr-title">
			<label class="attr-name"><?php echo __('Password', 'kboard')?></label>
			<div class="attr-value">
				<input type="password" name="password" placeholder="<?php echo __('Password', 'kboard')?>..." autofocus required>
				<?php if($board->isConfirmFailed()):?>
					<div class="description"><?php echo __('※ Your password is incorrect.', 'kboard')?></div>
				<?php endif?>
			</div>
		</div>
		<div class="kboard-control">
			<div class="left">
				<?php if($content->uid):?>
				<a href="<?php echo $url->getDocumentURLWithUID($content->uid)?>" class="kboard-worldmap-franchise-button-small" title="<?php echo __('Document', 'kboard')?>"><?php echo __('Document', 'kboard')?></a>
				<?php endif?>
				<a href="<?php echo $url->set('mod', 'list')->toString()?>" class="kboard-worldmap-franchise-button-small" title="<?php echo __('List', 'kboard')?>"><?php echo __('List', 'kboard')?></a>
			</div>
			<div class="right">
				<button type="submit" class="kboard-worldmap-franchise-button-small"><?php echo __('Password confirm', 'kboard')?></button>
			</div>
		</div>
	</form>
</div>