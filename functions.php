<?php
/**
 * Functions
 */

/**
 * WordPress標準機能
 *
 * @codex https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/add_theme_support
 */
function my_setup() {
	add_theme_support( 'post-thumbnails' ); /* アイキャッチ */
	add_theme_support( 'automatic-feed-links' ); /* RSSフィード */
	add_theme_support( 'title-tag' ); /* タイトルタグ自動生成 */
	add_theme_support(
		'html5',
		array( /* HTML5のタグで出力 */
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);
}
add_action( 'after_setup_theme', 'my_setup' );

/**
 * CSSとJavaScriptの読み込み
 *
 * @codex https://wpdocs.osdn.jp/%E3%83%8A%E3%83%93%E3%82%B2%E3%83%BC%E3%82%B7%E3%83%A7%E3%83%B3%E3%83%A1%E3%83%8B%E3%83%A5%E3%83%BC
 */
function my_script_init()
{

	wp_enqueue_style( 'my', get_template_directory_uri() . '/css/styles.css');
	
	wp_enqueue_style( 'googlefont-notosans', '//fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;700&display=swap' );

	wp_enqueue_style( 'googlefont-notoserif', '//fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@300&display=swap' );

	wp_enqueue_style( 'adobe-swingking', '//use.typekit.net/adt3jyp.css' );

	wp_enqueue_script( 'my', get_template_directory_uri() . '/js/script.js', array( 'jquery' ), '1.0.1', true );
	
	wp_enqueue_script( 'fontawesome', '//kit.fontawesome.com/407aed272e.js');

}
add_action('wp_enqueue_scripts', 'my_script_init');


/**
 * メニューの登録
 *
 * @codex https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/register_nav_menus
 */
function my_menu_init() {
	register_nav_menus(
		array(
			'main' => 'メインメニュー',
			'footer' => 'フッターメニュー',
			// 'global'  => 'ヘッダーメニュー',
			// 'utility' => 'ユーティリティメニュー',
			// 'drawer'  => 'ドロワーメニュー',
		)
	);
}
add_action( 'init', 'my_menu_init' );
// add_action('after_setup_theme', 'register_my_menu_init');


/**
 * メニューの登録
 *
 * 参考：https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/register_nav_menus
 */


/**
 * ウィジェットの登録
 *
 * @codex http://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/register_sidebar
 */
// function my_widget_init() {
// 	register_sidebar(
// 		array(
// 			'name'          => 'サイドバー',
// 			'id'            => 'sidebar',
// 			'before_widget' => '<div id="%1$s" class="p-widget %2$s">',
// 			'after_widget'  => '</div>',
// 			'before_title'  => '<div class="p-widget__title">',
// 			'after_title'   => '</div>',
// 		)
// 	);
// }
// add_action( 'widgets_init', 'my_widget_init' );


/**
 * アーカイブタイトル書き換え
 *
 * @param string $title 書き換え前のタイトル.
 * @return string $title 書き換え後のタイトル.
 */
function my_archive_title( $title ) {

	if ( is_home() ) { /* ホームの場合 */
		$title = 'ブログ';
	} elseif ( is_category() ) { /* カテゴリーアーカイブの場合 */
		$title = '' . single_cat_title( '', false ) . '';
	} elseif ( is_tag() ) { /* タグアーカイブの場合 */
		$title = '' . single_tag_title( '', false ) . '';
	} elseif ( is_post_type_archive() ) { /* 投稿タイプのアーカイブの場合 */
		$title = '' . post_type_archive_title( '', false ) . '';
	} elseif ( is_tax() ) { /* タームアーカイブの場合 */
		$title = '' . single_term_title( '', false );
	} elseif ( is_search() ) { /* 検索結果アーカイブの場合 */
		$title = '「' . esc_html( get_query_var( 's' ) ) . '」の検索結果';
	} elseif ( is_author() ) { /* 作者アーカイブの場合 */
		$title = '' . get_the_author() . '';
	} elseif ( is_date() ) { /* 日付アーカイブの場合 */
		$title = '';
		if ( get_query_var( 'year' ) ) {
			$title .= get_query_var( 'year' ) . '年';
		}
		if ( get_query_var( 'monthnum' ) ) {
			$title .= get_query_var( 'monthnum' ) . '月';
		}
		if ( get_query_var( 'day' ) ) {
			$title .= get_query_var( 'day' ) . '日';
		}
	}
	return $title;
};
add_filter( 'get_the_archive_title', 'my_archive_title' );


/**
 * 抜粋文の文字数の変更
 *
 * @param int $length 変更前の文字数.
 * @return int $length 変更後の文字数.
 */
function my_excerpt_length( $length ) {
	return 80;
}
add_filter( 'excerpt_length', 'my_excerpt_length', 999 );


/**
 * 抜粋文の省略記法の変更
 *
 * @param string $more 変更前の省略記法.
 * @return string $more 変更後の省略記法.
 */
function my_excerpt_more( $more ) {
	return '...';

}
add_filter( 'excerpt_more', 'my_excerpt_more' );


/* ---------- カスタム投稿タイプを追加 （CPT UIを入れない）---------- */
// https://wordpress-web.and-ha.com/summary-add-custom-post-type/

add_action( 'init', 'create_post_type' );

function create_post_type() {

  register_post_type(
    'works',
    array(
      'label' => 'WORKS一覧',
      'public' => true,
      'has_archive' => true,
      'menu_position' => 5,
      'supports' => array(
        'title',
        'editor',
        'thumbnail',
        'revisions',
		'excerpt',
		'custom-fields',
      ),
    )
  );

  register_taxonomy(
    'works-cat',
    'works',
    array(
		'label' => 'カテゴリー',
		'singular_label' => 'カテゴリー',
		'labels' => array(
		  'all_items' => 'カテゴリ一覧',
		  'add_new_item' => 'カテゴリを追加'
		),
		'public' => true,
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'hierarchical' => true
		)
	  );

  register_taxonomy(
    'works-tag',
    'works',
    array(
		'label' => 'タグ',
		'singular_label' => 'タグ',
		'labels' => array(
		  'add_new_item' => 'タグを追加'
		),
		'public' => true,
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'hierarchical' => false
		)
	  );
};



//ページネーションのhtmlカスタマイズ
function custom_pagination_html( $template ) {
    $template = '
    <nav class="pagination" role="navigation">
        <h2 class="screen-reader-text">%2$s</h2>
        %3$s
    </nav>';
    return $template;
}
add_filter('navigation_markup_template','custom_pagination_html');



//画像の自動生成を止める
//   https://iwb.jp/wordpress-images-uploading-stop-automatic-generation/
function remove_image_sizes( $sizes ) {
//   unset( $sizes['thumbnail'] );
  unset( $sizes['medium'] );
  unset( $sizes['large'] );
  unset( $sizes['1536x1536'] );
  unset( $sizes['2048x2048'] );
  return $sizes;
}
add_filter( 'intermediate_image_sizes_advanced', 'remove_image_sizes' );
add_filter( 'big_image_size_threshold', '__return_false' );
update_option( 'medium_large_size_w', 0 );



?>