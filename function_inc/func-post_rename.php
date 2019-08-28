<?php

//「投稿」を「投資先新着情報」に
function change_post_menu_label() {
	global $menu;
	global $submenu;
	$menu[5][0] = rename_text();
	$submenu['edit.php'][5][0] = rename_text().'一覧';
	$submenu['edit.php'][10][0] = '新しい'.rename_text();
	$submenu['edit.php'][16][0] = 'タグ';
	//echo ";
}
function change_post_object_label() {
	global $wp_post_types;
	$labels = &$wp_post_types['post']->labels;
	$labels->name = rename_text();
	$labels->singular_name = rename_text();
	$labels->add_new = _x('追加', rename_text());
	$labels->add_new_item = rename_text().'の新規追加';
	$labels->edit_item = rename_text().'の編集';
	$labels->new_item = rename_text();
	$labels->view_item = rename_text().'を表示';
	$labels->search_items = rename_text().'を検索';
	$labels->not_found = '記事が見つかりませんでした';
	$labels->not_found_in_trash = 'ゴミ箱に記事は見つかりませんでした';
}
add_action( 'init', 'change_post_object_label' );
add_action( 'admin_menu', 'change_post_menu_label' );


?>