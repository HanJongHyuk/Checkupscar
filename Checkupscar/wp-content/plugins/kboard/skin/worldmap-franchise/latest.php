<div id="kboard-worldmap-franchise-list">
	<ul class="kboard-list">
		<?php while($content = $list->hasNext()):?>
		<li class="kboard-list-item<?php if($content->uid == kboard_uid()):?> kboard-list-selected<?php endif?>">
			<a href="<?php echo $url->set('uid', $content->uid)->set('mod', 'document')->toStringWithPath($board_url)?>" title="<?php echo esc_attr($content->title)?>">
				<div class="kboard-worldmap-franchise-thumbnail">
				<?php if($content->getThumbnail(600, 600)):?>
					<img src="<?php echo $content->getThumbnail(600, 600)?>" alt="<?php echo esc_attr($content->title)?>">
				<?php else:?>
					<div class="kboard-worldmap-franchise-no-image"></div>
				<?php endif?>
				</div>
			</a>
			<div class="kboard-worldmap-franchise-wrap">
				<a href="<<?php echo $url->set('uid', $content->uid)->set('mod', 'document')->toStringWithPath($board_url)?>" title="<?php echo esc_attr($content->getUserName())?>">
					<div class="kboard-worldmap-franchise-title">
						<?php if($content->isNew()):?><span class="kboard-worldmap-franchise-new-notify">New</span><?php endif?>
						<?php if($content->secret):?><img src="<?php echo $skin_path?>/images/icon-lock.png" alt="<?php echo __('Secret', 'kboard')?>"><?php endif?>
						<?php echo $content->title?>
					</div>
				</a>
				
				<?php if($content->category1):?>
				<div class="kboard-worldmap-franchise-area"><?php echo __('Area', 'kboard-worldmap-franchise')?> : <?php echo kboard_worldmap_franchise_branch($content->category1)?></div>
				<?php endif?>
				
				<?php if($content->option->branch):?>
				<div class="kboard-worldmap-franchise-branch"><?php echo __('Branch', 'kboard-worldmap-franchise')?> : <?php echo $content->option->branch?></div>
				<?php endif?>
				
				<?php if($content->option->address):?>
				<div class="kboard-worldmap-franchise-address"><?php echo __('Address', 'kboard-worldmap-franchise')?> : <?php echo $content->option->address?></div>
				<?php endif?>
				
				<?php if($content->option->tel):?>
				<div class="kboard-worldmap-franchise-tel"><?php echo __('Contact', 'kboard-worldmap-franchise')?> : <a href="tel:<?php echo esc_attr($content->option->tel)?>" title="<?php echo esc_attr($content->option->tel)?>"><?php echo $content->option->tel?></a></div>
				<?php endif?>
				
				<?php if($content->option->homepage): $kboard_homepage = kboard_worldmap_franchise_homepage($content->option->homepage)?>
				<div class="kboard-worldmap-franchise-homepage"><?php echo __('Homepage', 'kboard-worldmap-franchise')?> : <a href="<?php echo esc_attr($kboard_homepage)?>" title="" onclick="window.open(this.href); return false;"><?php echo $kboard_homepage?></a></div>
				<?php endif?>
			</div>
		</li>
		<?php endwhile?>
	</ul>
</div>