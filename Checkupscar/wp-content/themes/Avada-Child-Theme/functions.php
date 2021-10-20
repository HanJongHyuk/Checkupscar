<?php

function theme_enqueue_styles() {
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'avada-stylesheet' ) );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function avada_lang_setup() {
	$lang = get_stylesheet_directory() . '/languages';
	load_child_theme_textdomain( 'Avada', $lang );
}
add_action( 'after_setup_theme', 'avada_lang_setup' );

add_filter('kboard_worldmap_franchise_default_location', 'my_kboard_worldmap_franchise_default_location', 10, 2);
function my_kboard_worldmap_franchise_default_location($default_location, $board){
	if($board->id == '10'){
		$default_location = '36.642174, 127.488805';
	}
	return $default_location;
}

add_filter('kboard_worldmap_franchise_default_zoom', 'my_kboard_worldmap_franchise_default_zoom', 10, 2);
function my_kboard_worldmap_franchise_default_zoom($default_zoom, $board){
	if($board->id == '10'){
		$default_zoom = '11';
	}
	return $default_zoom;
}