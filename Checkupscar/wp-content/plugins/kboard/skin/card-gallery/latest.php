<div id="kboard-card-gallery-latest">
	<ul class="kboard-list">
		<?php while($content = $list->hasNextNotice()):?>
		<li class="kboard-list-item">
			<a href="<?php echo $url->getDocumentURLWithUID($content->uid)?>">
				<?php if($content->getThumbnail(70, 50)):?>
					<div class="kboard-list-thumbnail" style="background-image:url(<?php echo $content->getThumbnail(70, 50)?>)"></div>
				<?php endif?>
				
				<div class="kboard-list-title">
					[<?php echo __('Notice', 'kboard')?>]
					<?php echo $content->title?>
					<?php echo $content->getCommentsCount()?>
					<?php if($content->secret):?><img src="<?php echo $skin_path?>/images/icon-lock.png" alt="<?php echo __('Secret', 'kboard')?>"><?php endif?>
				</div>
			</a>
		</li>
		<?php endwhile?>
		<?php while($content = $list->hasNext()):?>
		<li class="kboard-list-item">
			<a href="<?php echo $url->getDocumentURLWithUID($content->uid)?>">
				<?php if($content->getThumbnail(70, 50)):?>
					<div class="kboard-list-thumbnail" style="background-image:url(<?php echo $content->getThumbnail(70, 50)?>)"></div>
				<?php endif?>
				
				<div class="kboard-list-title">
					<?php echo $content->title?>
					<?php echo $content->getCommentsCount()?>
					<?php if($content->secret):?><img src="<?php echo $skin_path?>/images/icon-lock.png" alt="<?php echo __('Secret', 'kboard')?>"><?php endif?>
				</div>
			</a>
		</li>
		<?php endwhile?>
	</ul>
</div>