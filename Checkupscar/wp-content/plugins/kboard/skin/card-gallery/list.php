<div id="kboard-card-gallery-list">

	<div class="kboard-header">
		<!-- 카테고리 시작 -->
		<?php
		if($board->use_category == 'yes'){
			if($board->isTreeCategoryActive()){
				$category_type = 'tree-select';
			}
			else{
				$category_type = 'default';
			}
			$category_type = apply_filters('kboard_skin_category_type', $category_type, $board, $boardBuilder);
			echo $skin->load($board->skin, "list-category-{$category_type}.php", $vars);
		}
		?>
		<!-- 카테고리 끝 -->
	</div>
	
	<!-- 리스트 시작 -->
	<ul class="kboard-list">
		<?php while($content = $list->hasNextNotice()):?>
		<li class="kboard-list-item">
			<a href="<?php echo $url->getDocumentURLWithUID($content->uid)?>">
				
				<?php if($content->getThumbnail(330, 160)):?>
					<div class="kboard-list-thumbnail" style="background-image:url(<?php echo $content->getThumbnail(330, 160)?>)"></div>
				<?php else:?>
					<div class="kboard-list-thumbnail" style=""></div>
				<?php endif?>
				
				<div class="kboard-list-title"><div class="kboard-card-gallery-cut-strings">
					<?php echo $content->title?>
					<?php echo $content->getCommentsCount()?>
					<?php if($content->secret):?><img src="<?php echo $skin_path?>/images/icon-lock.png" alt="<?php echo __('Secret', 'kboard')?>"><?php endif?>
				</div></div>
				
				<div class="kboard-list-summary"><?php echo trim(strip_tags($content->content))?></div>
				
				<div class="kboard-list-catetory">
				<?php if($content->category1):?>
				<?php echo $content->category1?>
				<?php endif?>
				<?php if($content->category2):?>
				<?php echo $content->category2?>
				<?php endif?>
				<?php if($content->option->tree_category_1):?>
				<?php for($i=1; $i<=$content->getTreeCategoryDepth(); $i++):?>
				<?php echo $content->option->{'tree_category_'.$i}?>
				<?php endfor?>
				<?php endif?>
				</div>

				<div class="kboard-list-user"><?php echo $content->getUserDisplay()?></div>
				
				<?php if($content->vote):?>
				<div class="kboard-list-vote"><img src="<?php echo $skin_path?>/images/icon-heart.png" alt="<?php echo __('Vote', 'kboard')?>"> <?php echo intval($content->vote)?></div>
				<?php endif?>
			</a>
		</li>
		<?php endwhile?>
		<?php while($content = $list->hasNext()):?>
		<li class="kboard-list-item">
			<a href="<?php echo $url->getDocumentURLWithUID($content->uid)?>">
				
				<?php if($content->getThumbnail(330, 160)):?>
					<div class="kboard-list-thumbnail" style="background-image:url(<?php echo $content->getThumbnail(330, 160)?>)"></div>
				<?php else:?>
					<div class="kboard-list-thumbnail" style=""></div>
				<?php endif?>
				
				<div class="kboard-list-title"><div class="kboard-card-gallery-cut-strings">
					<?php echo $content->title?>
					<?php echo $content->getCommentsCount()?>
					<?php if($content->secret):?><img src="<?php echo $skin_path?>/images/icon-lock.png" alt="<?php echo __('Secret', 'kboard')?>"><?php endif?>
				</div></div>
				
				<div class="kboard-list-summary"><?php echo trim(strip_tags($content->content))?></div>
				
				<div class="kboard-list-catetory">
				<?php if($content->category1):?>
				<?php echo $content->category1?>
				<?php endif?>
				<?php if($content->category2):?>
				<?php echo $content->category2?>
				<?php endif?>
				<?php if($content->option->tree_category_1):?>
				<?php for($i=1; $i<=$content->getTreeCategoryDepth(); $i++):?>
				<?php echo $content->option->{'tree_category_'.$i}?>
				<?php endfor?>
				<?php endif?>
				</div>
				
				<div class="kboard-list-user"><?php echo $content->getUserDisplay()?></div>
				
				<?php if($content->vote):?>
				<div class="kboard-list-vote"><img src="<?php echo $skin_path?>/images/icon-heart.png" alt="<?php echo __('Vote', 'kboard')?>"> <?php echo intval($content->vote)?></div>
				<?php endif?>
			</a>
		</li>
		<?php endwhile?>
		
	</ul>
	<!-- 리스트 끝 -->
	
	<!-- 페이징 시작 -->
	<div class="kboard-pagination">
		<ul class="kboard-pagination-pages">
			<?php echo kboard_pagination($list->page, $list->total, $list->rpp)?>
		</ul>
	</div>
	<!-- 페이징 끝 -->
	
	<!-- 검색폼 시작 -->
	<form id="kboard-search-form-<?php echo $board->id?>" method="get" action="<?php echo $url->toString()?>">
		<?php echo $url->set('pageid', '1')->set('target', '')->set('keyword', '')->set('mod', 'list')->toInput()?>
		
		<div class="kboard-search">
			<select name="target">
				<option value=""><?php echo __('All', 'kboard')?></option>
				<option value="title"<?php if(kboard_target() == 'title'):?> selected<?php endif?>><?php echo __('Title', 'kboard')?></option>
				<option value="content"<?php if(kboard_target() == 'content'):?> selected<?php endif?>><?php echo __('Content', 'kboard')?></option>
				<option value="member_display"<?php if(kboard_target() == 'member_display'):?> selected<?php endif?>><?php echo __('Author', 'kboard')?></option>
			</select>
			<input type="text" name="keyword" value="<?php echo kboard_keyword()?>" placeholder="<?php echo __('Search', 'kboard')?>...">
			<button type="submit" class="kboard-card-gallery-button-small"><?php echo __('Search', 'kboard')?></button>
		</div>
	</form>
	<!-- 검색폼 끝 -->
	
	<?php if($board->isWriter()):?>
	<!-- 버튼 시작 -->
	<div class="kboard-control">
		<a href="<?php echo $url->getContentEditor()?>" class="kboard-card-gallery-button-small"><?php echo __('New', 'kboard')?></a>
	</div>
	<!-- 버튼 끝 -->
	<?php endif?>
	
	<?php if($board->contribution()):?>
	<div class="kboard-card-gallery-poweredby">
		<a href="https://www.cosmosfarm.com/products/kboard" onclick="window.open(this.href);return false;" title="<?php echo __('KBoard is the best community software available for WordPress', 'kboard')?>">Powered by KBoard</a>
	</div>
	<?php endif?>
</div>