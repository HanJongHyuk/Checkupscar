<div id="kboard-worldmap-franchise-editor">
	<form class="kboard-form" method="post" action="<?php echo $url->getContentEditorExecute()?>" enctype="multipart/form-data" onsubmit="return kboard_editor_execute(this);">
		<?php wp_nonce_field('kboard-editor-execute', 'kboard-editor-execute-nonce');?>
		<input type="hidden" name="action" value="kboard_editor_execute">
		<input type="hidden" name="mod" value="editor">
		<input type="hidden" name="uid" value="<?php echo $content->uid?>">
		<input type="hidden" name="board_id" value="<?php echo $content->board_id?>">
		<input type="hidden" name="parent_uid" value="<?php echo $content->parent_uid?>">
		<input type="hidden" name="member_uid" value="<?php echo $content->member_uid?>">
		<input type="hidden" name="member_display" value="<?php echo $content->member_display?>">
		<input type="hidden" name="date" value="<?php echo $content->date?>">
		<input type="hidden" name="user_id" value="<?php echo get_current_user_id()?>">
		
		<h4 class="kboard-attr-wrap-title">
			<?php if($content->uid):?>
				<?php echo __('Edit Place', 'kboard-worldmap-franchise')?>
			<?php else:?>
				<?php echo __('Register Place', 'kboard-worldmap-franchise')?>
			<?php endif?>
		</h4>
		
		<div class="kboard-attr-row">
			<div class="attr-name"><?php echo __('Options', 'kboard')?></div>
			<div class="attr-value">
				<label class="attr-value-option"><input type="checkbox" name="secret" value="true" onchange="kboard_toggle_password_field(this)"<?php if($content->secret):?> checked<?php endif?>> <?php echo __('Secret', 'kboard')?></label>
				<?php if($board->isAdmin()):?>
				<label class="attr-value-option"><input type="checkbox" name="notice" value="true"<?php if($content->notice):?> checked<?php endif?>> <?php echo __('Notice', 'kboard')?></label>
				<?php endif?>
				<?php do_action('kboard_skin_editor_option', $content, $board, $boardBuilder)?>
			</div>
		</div>
		
		<?php if($board->viewUsernameField()):?>
		<div class="kboard-attr-row">
			<label class="attr-name" for="kboard-input-password"><?php echo __('Password', 'kboard')?></label>
			<div class="attr-value"><input type="password" id="kboard-input-password" name="password" value="<?php echo $content->password?>" placeholder="<?php echo __('Password', 'kboard')?>..."></div>
		</div>
		<?php else:?>
		<input style="display:none" type="text" name="fake-autofill-fields">
		<input style="display:none" type="password" name="fake-autofill-fields">
		<!-- 비밀글 비밀번호 필드 시작 -->
		<div class="kboard-attr-row secret-password-row"<?php if(!$content->secret):?> style="display:none"<?php endif?>>
			<label class="attr-name" for="kboard-input-password"><?php echo __('Password', 'kboard')?></label>
			<div class="attr-value"><input type="password" id="kboard-input-password" name="password" value="<?php echo $content->password?>" placeholder="<?php echo __('Password', 'kboard')?>..."></div>
		</div>
		<!-- 비밀글 비밀번호 필드 끝 -->
		<?php endif?>
		
		<div class="kboard-attr-row kboard-attr-title">
			<label class="attr-name"><?php echo __('Title', 'kboard')?> <span class="attr-required-text">*</span></label>
			<div class="attr-value">
				<input type="text" name="title" value="<?php echo $content->title?>">
			</div>
		</div>
		
		<div class="kboard-attr-row">
			<label class="attr-name"><?php echo __('Area', 'kboard-worldmap-franchise')?></label>
			<div class="attr-value">
				<select name="category1">
					<option value=""><?php echo __('Select', 'kboard')?></option>
					<?php foreach(kboard_worldmap_franchise_branch_list() as $key=>$item):?>
					<option value="<?php echo $key?>"<?php if($content->category1 == $key):?> selected<?php endif?>><?php echo $item['name']?></option>
					<?php endforeach?>
				</select>
			</div>
		</div>
		
		<?php if($board->use_category == 'yes' && $board->initCategory2()):?>
			<div class="kboard-attr-row">
				<label class="attr-name" for="kboard-select-category2"><?php echo __('Category', 'kboard')?></label>
				<div class="attr-value">
					<select id="kboard-select-category2" name="category2">
						<option value=""><?php echo __('Category', 'kboard')?> <?php echo __('Select', 'kboard')?></option>
						<?php while($board->hasNextCategory()):?>
						<option value="<?php echo $board->currentCategory()?>"<?php if($content->category2 == $board->currentCategory()):?> selected<?php endif?>><?php echo $board->currentCategory()?></option>
						<?php endwhile?>
					</select>
				</div>
			</div>
		<?php endif?>
		
		<div class="kboard-attr-row">
			<label class="attr-name"><?php echo __('Branch', 'kboard-worldmap-franchise')?></label>
			<div class="attr-value"><input type="text" name="kboard_option_branch" value="<?php echo $content->option->branch?>" placeholder="(예제) 강남역점"></div>
		</div>
		
		<div class="kboard-attr-row kboard-attr-title">
			<label class="attr-name"><?php echo __('Address', 'kboard-worldmap-franchise')?></label>
			<div class="attr-value">
				<input type="text" name="kboard_option_address" value="<?php echo $content->option->address?>" placeholder="(예제) 서울특별시 강남구 강남대로 396">
				<div class="description">※ 게시판에 표시되는 주소를 입력해주세요.</div>
			</div>
		</div>
		
		<div class="kboard-attr-row kboard-attr-title">
			<label class="attr-name">지도 표시 주소 <span class="attr-required-text">*</span></label>
			<div class="attr-value">
				<input type="text" name="kboard_option_map_address" value="<?php echo $content->option->map_address?>" placeholder="(예제) 서울특별시 강남구 강남대로 396">
				<div class="description">※ 주소 입력시 구글지도가 자동으로 표시되며 위치는 일부 오차가 발생할 수 있습니다. (지번주소 또는 도로명주소 입력)</div>
				<div class="description"><button type="button" class="kboard-worldmap-franchise-button-small" onclick="kboard_worldmap_franchise_gps_to_address(this.form)">지도 표시 좌표 → 지도 표시 주소 입력</button></div>
			</div>
		</div>
		
		<div class="kboard-attr-row kboard-attr-title">
			<label class="attr-name">지도 표시 좌표 (위도) <span class="attr-required-text">*</span></label>
			<div class="attr-value">
				<input type="text" name="kboard_option_map_location_lat" value="<?php echo $content->option->map_location_lat?>" placeholder="(예제) 37.497913">
			</div>
		</div>
		
		<div class="kboard-attr-row kboard-attr-title">
			<label class="attr-name">지도 표시 좌표 (경도) <span class="attr-required-text">*</span></label>
			<div class="attr-value">
				<input type="text" name="kboard_option_map_location_lng" value="<?php echo $content->option->map_location_lng?>" placeholder="(예제) 127.027574">
				<div class="description">※ 좌표 입력시 구글지도가 자동으로 표시되며 위치는 일부 오차가 발생할 수 있습니다. 잘못된 좌표입력시 오류가 발생됩니다.</div>
				<div class="description"><button type="button" class="kboard-worldmap-franchise-button-small" onclick="kboard_worldmap_franchise_address_to_gps(this.form)">지도 표시 주소 → 지도 표시 좌표 입력</button></div>
			</div>
		</div>
		
		<div class="kboard-attr-row">
			<label class="attr-name"><?php echo __('Contact', 'kboard-worldmap-franchise')?></label>
			<div class="attr-value"><input type="text" name="kboard_option_tel" value="<?php echo $content->option->tel?>" placeholder="(예제) 02-0000-0000"></div>
		</div>
		
		<div class="kboard-attr-row">
			<label class="attr-name"><?php echo __('Homepage', 'kboard-worldmap-franchise')?></label>
			<div class="attr-value"><input type="text" name="kboard_option_homepage" value="<?php echo $content->option->homepage?>" placeholder="(예제) <?php echo esc_attr(home_url())?>"></div>
		</div>
		
		<?php if($board->useCAPTCHA() && !$content->uid):?>
			<?php if(kboard_use_recaptcha()):?>
				<div class="kboard-attr-row">
					<label class="attr-name"></label>
					<div class="attr-value"><div class="g-recaptcha" data-sitekey="<?php echo kboard_recaptcha_site_key()?>"></div></div>
				</div>
			<?php else:?>
				<div class="kboard-attr-row">
					<label class="attr-name" for="kboard-input-captcha"><img src="<?php echo kboard_captcha()?>" alt=""></label>
					<div class="attr-value"><input type="text" id="kboard-input-captcha" name="captcha" value="" placeholder="<?php echo __('CAPTCHA', 'kboard')?>..."></div>
				</div>
			<?php endif?>
		<?php endif?>
		
		<div class="kboard-attr-row kboard-content">
			<?php if($board->use_editor):?>
				<?php wp_editor($content->content, 'kboard_content', array('media_buttons'=>$board->isAdmin(), 'editor_height'=>400))?>
			<?php else:?>
				<textarea name="kboard_content" id="kboard_content"><?php echo $content->content?></textarea>
			<?php endif?>
		</div>
		
		<div class="kboard-attr-row">
			<label class="attr-name"><?php echo __('Photos', 'kboard')?></label>
			<div class="attr-value">
				<a href="#" onclick="kboard_editor_open_media();return false;"><?php echo __('KBoard Add Media', 'kboard')?></a>
			</div>
		</div>
		
		<div class="kboard-attr-row">
			<label class="attr-name"><?php echo __('Thumbnail', 'kboard')?></label>
			<div class="attr-value">
				<?php if($content->thumbnail_file):?><?php echo $content->thumbnail_name?> - <a href="<?php echo $url->getDeleteURLWithAttach($content->uid);?>" onclick="return confirm('<?php echo __('Are you sure you want to delete?', 'kboard')?>');"><?php echo __('Delete file', 'kboard')?></a><?php endif?>
				<input type="file" name="thumbnail">
			</div>
		</div>
		
		<?php if($board->meta->max_attached_count > 0):?>
			<!-- 첨부파일 시작 -->
			<?php for($attached_index=1; $attached_index<=$board->meta->max_attached_count; $attached_index++):?>
			<div class="kboard-attr-row">
				<label class="attr-name" for="kboard-input-file<?php echo $attached_index?>"><?php echo __('Attachment', 'kboard')?><?php echo $attached_index?></label>
				<div class="attr-value">
					<?php if(isset($content->attach->{"file{$attached_index}"})):?><?php echo $content->attach->{"file{$attached_index}"}[1]?> - <a href="<?php echo $url->getDeleteURLWithAttach($content->uid, "file{$attached_index}")?>" onclick="return confirm('<?php echo __('Are you sure you want to delete?', 'kboard')?>');"><?php echo __('Delete file', 'kboard')?></a><?php endif?>
					<input type="file" id="kboard-input-file<?php echo $attached_index?>" name="kboard_attach_file<?php echo $attached_index?>">
				</div>
			</div>
			<?php endfor?>
			<!-- 첨부파일 끝 -->
		<?php endif?>
		
		<div class="kboard-attr-row">
			<label class="attr-name" for="kboard-select-wordpress-search"><?php echo __('WP Search', 'kboard')?></label>
			<div class="attr-value">
				<select id="kboard-select-wordpress-search" name="wordpress_search">
					<option value="1"<?php if($content->search == '1'):?> selected<?php endif?>><?php echo __('Public', 'kboard')?></option>
					<option value="2"<?php if($content->search == '2'):?> selected<?php endif?>><?php echo __('Only title (secret document)', 'kboard')?></option>
					<option value="3"<?php if($content->search == '3'):?> selected<?php endif?>><?php echo __('Exclusion', 'kboard')?></option>
				</select>
			</div>
		</div>
		
		<div class="kboard-attr-row kboard-control">
			<div class="left">
				<?php if($content->uid):?>
				<a href="<?php echo $url->getDocumentURLWithUID($content->uid)?>" class="kboard-worldmap-franchise-button-small"><?php echo __('Back', 'kboard')?></a>
				<a href="<?php echo $url->set('mod', 'list')->toString()?>" class="kboard-worldmap-franchise-button-small"><?php echo __('List', 'kboard')?></a>
				<?php else:?>
				<a href="<?php echo $url->set('mod', 'list')->toString()?>" class="kboard-worldmap-franchise-button-small"><?php echo __('Back', 'kboard')?></a>
				<?php endif?>
			</div>
			<div class="right">
				<?php if($board->isWriter()):?>
				<button type="submit" class="kboard-worldmap-franchise-button-small"><?php echo __('Save', 'kboard')?></button>
				<?php endif?>
			</div>
		</div>
	</form>
</div>

<script>
var worldmap_franchise_editor = {
	board_id:'<?php echo intval($board->id)?>',
	permalink:'<?php echo get_permalink()?>',
	security:'<?php echo wp_create_nonce('kboard_worldmap_franchise_geocode')?>'
}
</script>
<?php wp_enqueue_script('kboard-worldmap-franchise-script', "{$skin_path}/script.js", array(), KBOARD_VERSION, true)?>