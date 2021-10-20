<div id="kboard-ocean-rating-list">
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
	<?php while($content = $list->hasNext()):?>
		<li class="kboard-list-item">
			<div class="kboard-wrap-left">
				<?php if($content->getThumbnail(70, 70)):?>
					<img src="<?php echo $content->getThumbnail(70, 70)?>" alt="<?php echo esc_attr($content->title)?>">
				<?php else:?>
					<?php echo get_avatar($content->member_uid, 70, '', $content->member_display)?>
				<?php endif?>
			</div>
			<div class="kboard-wrap-center">
				<div class="kboard-item-title kboard-ocean-rating-cut-strings"><a href="<?php echo $url->getDocumentURLWithUID($content->uid)?>"><?php echo $content->title?> <span class="kboard-rating value-<?php echo $content->option->rating?>" title="<?php echo $content->option->rating?>"></span></a></div>
				<div class="kbaord-item-rating"><span class="kboard-rating value-<?php echo $content->option->rating?>" title="<?php echo $content->option->rating?>"></span></div>
				<div class="kboard-item-content kboard-ocean-rating-cut-strings"><a href="<?php echo $url->getDocumentURLWithUID($content->uid)?>"><?php echo strip_tags($content->content)?></a></div>
				<div class="kboard-item-info">
					<span><?php echo apply_filters('kboard_user_display', $content->getUserName(), $content->getUserID(), $content->getUserName(), 'kboard', $boardBuilder)?></span> |
					<?php echo date("Y.m.d", strtotime($content->date))?>
				</div>
			</div>
			<div class="kboard-wrap-right">
				<div class="kboard-right kboard-item-like"><div class="kboard-item-padding"><?php echo __('Votes', 'kboard')?> : <span class="kboard-count-bold"><?php echo $content->like?></span></div></div>
				<div class="kboard-right kboard-item-comment"><div class="kboard-item-padding">답변 : <span class="kboard-count-bold"><?php $comment = $content->getCommentsCount('',''); echo $comment?$comment:'0';?></span></div></div>
				<div class="kboard-right kboard-item-view"><div class="kboard-item-padding"><?php echo __('Views', 'kboard')?> : <span class="kboard-count-bold"><?php echo $content->view?></span></div></div>
			</div>
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
	<div class="kboard-search">
		<form id="kboard-search-form-<?php echo $board->id?>" method="get" action="<?php echo $url->toString()?>">
			<?php echo $url->set('pageid', '1')->set('target', '')->set('keyword', '')->set('mod', 'list')->toInput()?>
			
			<select name="target">
				<option value=""><?php echo __('All', 'kboard')?></option>
				<option value="title"<?php if(kboard_target() == 'title'):?> selected<?php endif?>><?php echo __('Title', 'kboard')?></option>
				<option value="content"<?php if(kboard_target() == 'content'):?> selected<?php endif?>><?php echo __('Content', 'kboard')?></option>
				<option value="member_display"<?php if(kboard_target() == 'member_display'):?> selected<?php endif?>><?php echo __('Author', 'kboard')?></option>
			</select>
			<input type="text" name="keyword" value="<?php echo kboard_keyword()?>">
			<button type="submit" class="kboard-ocean-rating-button-small"><?php echo __('Search', 'kboard')?></button>
		</form>
	</div>
	<!-- 검색폼 끝 -->
	
	<?php if($board->isWriter()):?>
	<!-- 버튼 시작 -->
	<div class="kboard-control">
		<a href="<?php echo $url->getContentEditor()?>" class="kboard-ocean-rating-button-small"><?php echo __('New', 'kboard')?></a>
	</div>
	<!-- 버튼 끝 -->
	<?php endif?>
	
	<?php if($board->contribution()):?>
	<div class="kboard-ocean-rating-poweredby">
		<a href="https://www.cosmosfarm.com/products/kboard" onclick="window.open(this.href);return false;" title="<?php echo __('KBoard is the best community software available for WordPress', 'kboard')?>">Powered by KBoard</a>
	</div>
	<?php endif?>
</div>