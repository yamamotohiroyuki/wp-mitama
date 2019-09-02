<?php
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