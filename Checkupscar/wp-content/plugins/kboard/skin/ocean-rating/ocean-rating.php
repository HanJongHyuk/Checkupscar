<?php
/*
Plugin Name: KBoard 오션 별점 스킨
Plugin URI: https://www.cosmosfarm.com/wpstore/product/kboard-ocean-rating-skin
Description: KBoard 오션 별점 스킨
Version: 2.1
Author: 코스모스팜 - Cosmosfarm
Author URI: https://www.cosmosfarm.com/
*/

if(!defined('ABSPATH')) exit;

add_filter('kboard_skin_list', 'kboard_skin_list_ocean_rating', 10, 1);
function kboard_skin_list_ocean_rating($list){

	$skin = new stdClass();
	$skin->dir = dirname(__FILE__);
	$skin->url = plugins_url('', __FILE__);
	$skin->name = basename($skin->dir);

	$list[$skin->name] = $skin;

	return $list;
}