<?php
// update checker
/*
require_once get_stylesheet_directory_uri( 'function_inc/update-checker.php' );*/
$update_json_path = 'https://raw.githubusercontent.com/yamamotohiroyuki/wp-mitama/master/theme.json';
$thema_name = 'mitama';
require get_template_directory() . '/plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
  $update_json_path, // (A)
    __FILE__,
    $thema_name // (B)
);

// 基本的な関数
require_once get_parent_theme_file_path( 'function_inc/func-basic.php' );
// スタイルとスクリプトの読み込み
require_once get_parent_theme_file_path( 'function_inc/func-stylescripts.php' );

//テンプレートアドレス
function temp_add($temp_type) {
  $temp_src = get_stylesheet_directory_uri().'/assets';
  if($temp_type == ''):
    $temp_type_add = $temp_src;
  else:
    $temp_type_add = $temp_src.'/'.$temp_type;
  endif;
  return $temp_type_add;
}


// よく使う関数
require_once get_parent_theme_file_path( 'function_inc/func-tools.php' );