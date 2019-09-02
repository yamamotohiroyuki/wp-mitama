<?php

//スクリプト・スタイルの読み込み

function add_scripts() {

  $rooter = get_template_directory_uri();

  $assets_assets = $rooter.'/assets';

  $assets_css = $assets_assets.'/css';
  $assets_js = $assets_assets.'/js';
  $assets_vendor = $assets_assets.'/vendor';
  $assets_basic_assets = $assets_vendor.'/basic-assets';

  wp_deregister_script('jquery');
  wp_enqueue_script('basic_adjust', $assets_basic_assets.'/js/basic-adjust.min.js', array(), '1.0', false);
  wp_enqueue_script('jquery', $assets_vendor.'/jquery.min.js', array(), '1.0', false);
  wp_enqueue_script('basic_bundle', $assets_basic_assets.'/js/basic-bundle.min.js', array(), '1.0', false);

  //reset css
  wp_enqueue_style ( 'basicstyle', $assets_basic_assets.'/css/basic-style.min.css');

}
add_action('wp_enqueue_scripts', 'add_scripts');

