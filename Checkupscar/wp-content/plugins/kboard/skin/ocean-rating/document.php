<div id="kboard-document">
	<div id="kboard-ocean-rating-document">
		<div class="kboard-document-wrap" itemscope itemtype="http://schema.org/Article">
			<div class="kboard-title" itemprop="name">
				<p><?php echo $content->title?> <span class="kboard-rating value-<?php echo $content->option->rating?>" title="<?php echo $content->option->rating?>"></span></p>
			</div>
			
			<div class="kboard-detail">
				<?php if($content->category1):?>
				<div class="detail-attr detail-category1">
					<div class="detail-name"><?php echo $content->category1?></div>
				</div>
				<?php endif?>
				<?php if($content->category2):?>
				<div class="detail-attr detail-category2">
					<div class="detail-name"><?php echo $content->category2?></div>
				</div>
				<?php endif?>
				<?php if($content->option->tree_category_1):?>
				<?php for($i=1; $i<=$content->getTreeCategoryDepth(); $i++):?>
				<div class="detail-attr detail-tree-category-<?php echo $i?>">
					<div class="detail-name"><?php echo $content->option->{'tree_category_'.$i}?></div>
				</div>
				<?php endfor?>
				<?php endif?>
				<div class="detail-attr detail-writer">
					<div class="detail-name"><?php echo __('Author', 'kboard')?></div>
					<div class="detail-value"><?php echo apply_filters('kboard_user_display', $content->getUserName(), $content->getUserID(), $content->getUserName(), 'kboard', $boardBuilder)?></div>
				</div>
				<div class="detail-attr detail-date">
					<div class="detail-name"><?php echo __('Date', 'kboard')?></div>
					<div class="detail-value"><?php echo date("Y-m-d H:i", strtotime($content->date))?></div>
				</div>
				<div class="detail-attr detail-view">
					<div class="detail-name"><?php echo __('Views', 'kboard')?></div>
					<div class="detail-value"><?php echo $content->view?></div>
				</div>
			</div>
			
			<div class="kboard-content" itemprop="description">
				<div class="content-view">
					<?php foreach($content->getAttachmentList() as $key=>$attach): $extension = strtolower(pathinfo($attach[0], PATHINFO_EXTENSION));?>
						<?php if(in_array($extension, array('gif','jpg','jpeg','png'))):?>
							<p class="thumbnail-area"><img src="<?php echo site_url($attach[0])?>" alt="<?php echo $attach[1]?>"></p>
						<?php else: $download[$key] = $attach; endif?>
					<?php endforeach?>
					
					<?php echo $content->content?>
					
					<div class="like-area">
						<a href="#" onclick="return kboard_document_like(this);" data-uid="<?php echo $content->uid?>" class="kboard-item-like">
							<div class="kboard-item-padding"><?php echo __('Votes', 'kboard')?> : <span class="kboard-document-like-count"><?php echo $content->like?></span></div>
						</a>
					</div>
				</div>
			</div>
			
			<?php if(isset($download) && $download): foreach($download as $key=>$value):?>
			<div class="kboard-attach">
				<?php echo __('Attachment', 'kboard')?> : <button type="button" class="kboard-button-download" onclick="window.location.href='<?php echo $url->getDownloadURLWithAttach($content->uid, $key)?>'" title="<?php echo sprintf(__('Download %s', 'kboard'), $content->attach->{$key}[1])?>"><?php echo $content->attach->{$key}[1]?></button>
			</div>
			<?php endforeach; endif;?>
		</div>
		
		<?php if($content->visibleComments()):?>
		<div class="kboard-comments-area"><?php echo $board->buildComment($content->uid)?></div>
		<?php endif?>
		
		<div class="kboard-control">
			<div class="left">
				<a href="<?php echo $url->getBoardList()?>" class="kboard-ocean-rating-button-small"><?php echo __('List', 'kboard')?></a>
				<a href="<?php echo $url->getDocumentURLWithUID($content->getPrevUID())?>" class="kboard-ocean-rating-button-small"><?php echo __('Prev', 'kboard')?></a>
				<a href="<?php echo $url->getDocumentURLWithUID($content->getNextUID())?>" class="kboard-ocean-rating-button-small"><?php echo __('Next', 'kboard')?></a>
			</div>
			<?php if($content->isEditor() || $board->permission_write=='all'):?>
			<div class="right">
				<a href="<?php echo $url->getContentEditor($content->uid)?>" class="kboard-ocean-rating-button-small"><?php echo __('Edit', 'kboard')?></a>
				<a href="<?php echo $url->getContentRemove($content->uid)?>" class="kboard-ocean-rating-button-small" onclick="return confirm('<?php echo __('Are you sure you want to delete?', 'kboard')?>');"><?php echo __('Delete', 'kboard')?></a>
			</div>
			<?php endif?>
		</div>
		
		<?php if($board->contribution() && !$board->meta->always_view_list):?>
		<div class="kboard-ocean-rating-poweredby">
			<a href="https://www.cosmosfarm.com/products/kboard" onclick="window.open(this.href);return false;" title="<?php echo __('KBoard is the best community software available for WordPress', 'kboard')?>">Powered by KBoard</a>
		</div>
		<?php endif?>
	</div>
</div>