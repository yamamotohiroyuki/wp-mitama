<?php

add_theme_support( 'menus' );

//カテゴリー説明文でHTMLタグを使う
remove_filter( 'pre_term_description', 'wp_filter_kses' );

function rss_post_thumbnail($content) {
	global $post;
	if(has_post_thumbnail($post->ID)) {
		$content = '<div>' . get_the_post_thumbnail($post->ID) . '</div>' . $content;
	}
	return $content;
}
add_filter('the_excerpt_rss', 'rss_post_thumbnail');
add_filter('the_content_feed', 'rss_post_thumbnail');


function parse_query_ex() {
	if (!is_super_admin() && !get_query_var('post_status') && !is_singular()) {
		set_query_var('post_status', 'publish');
	}
}
add_action('parse_query', 'parse_query_ex');



function basic_custom_init() {
	//固定ページにも概要
	add_post_type_support( 'page', 'excerpt' );
	// titleタグの出力
	add_theme_support( 'title-tag' );
	// HTML5のサポート
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
	// アイキャッチのサポート
	add_theme_support( 'post-thumbnails' );
}
add_action('init', 'basic_custom_init');



?>