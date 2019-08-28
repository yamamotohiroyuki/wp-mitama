<?php
// 固定ページ判別。bodyに固定ページのスラッグ名を追加
function pagename_class($classes = ''){
  if (is_page()) {
    $page = get_post();//get_page()は廃止されたので使わない
    $classes[] = 'is-' . $page->post_name;//スラッグ名取得
  }
  return $classes;
}
add_filter('body_class', 'pagename_class');

// ブラウザ判別。bodyにブラウザ名付
add_filter('body_class','browser_body_class');
function browser_body_class($classes) {
  global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

  if($is_lynx) $classes[] = 'lynx';
  elseif($is_gecko) $classes[] = 'gecko';
  elseif($is_opera) $classes[] = 'opera';
  elseif($is_NS4) $classes[] = 'ns4';
  elseif($is_safari) $classes[] = 'safari';
  elseif($is_chrome) $classes[] = 'chrome';
  elseif($is_IE) $classes[] = 'ie';
  else $classes[] = 'unknown';

  if($is_iphone) $classes[] = 'iphone';
  return $classes;
}


// WordPressのバージョン情報は削除したほうがいい
remove_action('wp_head', 'wp_generator');
// ブログ投稿ツール用
remove_action('wp_head', 'rsd_link');
// Windows Live Writerは使わないので削除
remove_action('wp_head', 'wlwmanifest_link');
// Embed WPのブログカード。他サイトのアイキャッチ画像や抜粋自動埋め込み
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('wp_head', 'wp_oembed_add_host_js');
// 管理画面絵文字削除
function disable_emoji()
{
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
add_action('init', 'disable_emoji');





//短縮URLの設定
function getTinyUrl($url) {
  $tinyurl = file_get_contents("http://tinyurl.com/api-create.php?url=".$url);
  return $tinyurl;
}

//現在のURL
function get_current_link() {
 return (is_ssl() ? 'https' : 'http') . '://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
}

// 子ページ判定
function is_subpage() {
  global $post; // $post には現在の固定ページの情報があります
  if ( is_page() && $post->post_parent ) : // 現在の固定ページが親ページを持つかどうかをチェックします
    $parentID = $post->post_parent; // 親ページの ID を取得します
    return $parentID; // 親ページの ID を返します
  else : // 親ページを持っていない場合
    return false; // false を返します
  endif;
}
/**
 * サブページまたはサブページを持っているかの判定
 */
function has_subpage() {
  global $post;
  if ( is_page() ) : // test to see if the page has a parent
    $ancestor = array_pop( get_post_ancestors( $post->ID ) );
    if( $ancestor ) :
      $parent = $ancestor;
    else :
      $parent = $post->ID;
    endif;
    $h = get_children("post_type=page&post_parent=" .$parent );
    if ( empty($h) ) :
      return false;
    else :
      return true;
    endif;

  else :  // there is no parent so ...
    return false;  // ... the answer to the question is false
  endif;
}

// 子カテゴリの有無
function category_has_children() {
  global $wpdb;
  $term = get_queried_object();
  $category_children_check = $wpdb->get_results("SELECT * FROM wp_term_taxonomy WHERE parent = '$term->term_id'" );
  if ($category_children_check):
    return true;
  else:
    return false;
  endif;
}

// 親ページのID取得
function get_top_parent_page_id() {
  global $post;
  $ancestors = $post->ancestors;
  if ($ancestors) {// 固定ページが子であるかどうかをチェック
    return end($ancestors); //一番上の階層の親のIDを取得
  } else { //　固定ページが親である場合は自分のそのID
    return $post->ID;
  }
}

// ループの最初を判別
function is_first() {
  global $wp_query;
  return ($wp_query->current_post === 0);
}
// ループの最後を判別
function is_last() {
  global $wp_query;
  return ($wp_query->current_post+1 === $wp_query->post_count);
}


// ページIDからスラッグ
function get_page_slug($page_id) {
  $str = get_page($page_id);
  return $str -> post_name;
}


/*
  アーカイブページで現在のカテゴリー・タグ・タームを取得する
*/
function get_current_term(){

  $id;
  $tax_slug;

  if(is_category()){
    $tax_slug = "category";
    $id = get_query_var('cat');	
  }else if(is_tag()){
    $tax_slug = "post_tag";
    $id = get_query_var('tag_id');	
  }else if(is_tax()){
    $tax_slug = get_query_var('taxonomy');	
    $term_slug = get_query_var('term');	
    $term = get_term_by("slug",$term_slug,$tax_slug);
    $id = $term->term_id;
  }

  return get_term($id,$tax_slug);
}



// （タクソノミーと）タームを取得する
function custom_taxonomies_terms_link(){
  // 投稿 ID から投稿オブジェクトを取得
  $post = get_post( $post->ID );

  // その投稿から投稿タイプを取得
  $post_type = $post->post_type;
  // その投稿タイプからタクソノミーを取得
  $taxonomies = get_object_taxonomies( $post_type, 'objects' );

  $out = array();
  foreach ( $taxonomies as $taxonomy_slug => $taxonomy ){
    // 投稿に付けられたタームを取得
    $terms = get_the_terms( $post->ID, $taxonomy_slug );
    if ( !empty( $terms ) ) {
      foreach ( $terms as $term ) {
        $out[] ='<a href="'.get_term_link( $term->slug, $taxonomy_slug ).'" class="term ' . $post_type . ' ' . $term->slug . '">' . $term->name . "</a>";
      }
    }
  }
  return implode('', $out );
}




?>