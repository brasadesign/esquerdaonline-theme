<?php
/**
 * Odin functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * For more information on hooks, actions, and filters,
 * see http://codex.wordpress.org/Plugin_API
 *
 * @package Odin
 * @since 2.2.0
 */

/**
 * Sets content width.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 600;
}

/**
 * Odin Classes.
 */
require_once get_template_directory() . '/core/classes/class-bootstrap-nav.php';
require_once get_template_directory() . '/core/classes/class-shortcodes.php';
//require_once get_template_directory() . '/core/classes/class-shortcodes-menu.php';
require_once get_template_directory() . '/core/classes/class-thumbnail-resizer.php';
// require_once get_template_directory() . '/core/classes/class-theme-options.php';
// require_once get_template_directory() . '/core/classes/class-options-helper.php';
// require_once get_template_directory() . '/core/classes/class-post-type.php';
// require_once get_template_directory() . '/core/classes/class-taxonomy.php';
// require_once get_template_directory() . '/core/classes/class-metabox.php';
// require_once get_template_directory() . '/core/classes/abstracts/abstract-front-end-form.php';
// require_once get_template_directory() . '/core/classes/class-contact-form.php';
// require_once get_template_directory() . '/core/classes/class-post-form.php';
// require_once get_template_directory() . '/core/classes/class-user-meta.php';
// require_once get_template_directory() . '/core/classes/class-post-status.php';
//require_once get_template_directory() . '/core/classes/class-term-meta.php';

/**
 * Odin Widgets.
 */
require_once get_template_directory() . '/core/classes/widgets/class-widget-like-box.php';

if ( ! function_exists( 'odin_setup_features' ) ) {

	/**
	 * Setup theme features.
	 *
	 * @since 2.2.0
	 */
	function odin_setup_features() {

		/**
		 * Add support for multiple languages.
		 */
		load_theme_textdomain( 'odin', get_template_directory() . '/languages' );

		/**
		 * Register nav menus.
		 */
		register_nav_menus(
			array(
				'main-menu' => __( 'Main Menu', 'eol' ),
				'menu-institucional' => __( 'Menu no topo (institucional)', 'eol' ),
				'menu-footer-1' => __( 'Menu Rodapé 1', 'eol' ),
				'menu-footer-2' =>  __( 'Menu Rodapé 2', 'eol' ),
				'menu-footer-3' =>  __( 'Menu Rodapé 3', 'eol' ),
				'menu-footer-4' =>  __( 'Menu Rodapé 4', 'eol' ),

			)
		);

		/*
		 * Add post_thumbnails suport.
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'quadrada-icone', 80, 60, true );
		add_image_size( 'post-default-thumbnail', 330, 185, true );
		// add_image_size( 'retangular-p', 330, 185, true );
		add_image_size( 'retangular-p', 400, 225, true );
		add_image_size( 'retangular-g', 800, 461, true );
		add_image_size( 'quadrada-p', 300, 300, true );
		add_image_size( 'quadrada-g', 800, 800, true );
		/**
		 * Add feed link.
		 */
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Support Custom Header.
		 */
		$default = array(
			'width'         => 0,
			'height'        => 0,
			'flex-height'   => false,
			'flex-width'    => false,
			'header-text'   => false,
			'default-image' => '',
			'uploads'       => true,
		);

		add_theme_support( 'custom-header', $default );

		/**
		 * Support Custom Background.
		 */
		$defaults = array(
			'default-color' => '',
			'default-image' => '',
		);

		add_theme_support( 'custom-background', $defaults );

		/**
		 * Support Custom Editor Style.
		 */
		add_editor_style( 'assets/css/style.css' );

		/**
		 * Add support for infinite scroll.
		 */
		add_theme_support(
			'infinite-scroll',
			array(
				'type'           => 'scroll',
				'footer_widgets' => false,
				'container'      => 'content',
				'wrapper'        => false,
				'render'         => false,
				'posts_per_page' => get_option( 'posts_per_page' )
			)
		);

		/**
		 * Add support for Post Formats.
		 */
		// add_theme_support( 'post-formats', array(
		//     'aside',
		//     'gallery',
		//     'link',
		//     'image',
		//     'quote',
		//     'status',
		//     'video',
		//     'audio',
		//     'chat'
		// ) );

		/**
		 * Support The Excerpt on pages.
		 */
		// add_post_type_support( 'page', 'excerpt' );

		/**
		 * Switch default core markup for search form, comment form, and comments to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption'
			)
		);

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for custom logo.
		 *
		 *  @since Odin 2.2.10
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 240,
			'width'       => 240,
			'flex-height' => true,
		) );
	}
}

add_action( 'after_setup_theme', 'odin_setup_features' );

/**
 * Register widget areas.
 *
 * @since 2.2.0
 */
function odin_widgets_init() {
	register_sidebar(
		array(
			'name' => __( 'Main Sidebar', 'odin' ),
			'id' => 'main-sidebar',
			'description' => __( 'Site Main Sidebar', 'odin' ),
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<h3 class="widgettitle widget-title">',
			'after_title' => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name' => __( 'Vídeos Sidebar', 'odin' ),
			'id' => 'videos-sidebar',
			'description' => __( 'Vídeos Sidebar', 'odin' ),
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<h3 class="widgettitle widget-title">',
			'after_title' => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name' => __( 'Home', 'odin' ),
			'id' => 'home-widgets',
			'description' => __( 'Home', 'odin' ),
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<h3 class="widgettitle widget-title">',
			'after_title' => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name' => __( 'Colunistas Sidebar', 'odin' ),
			'id' => 'colunistas-sidebar',
			'description' => __( 'Barra lateral da página de arquivo de colunistas', 'odin' ),
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<h3 class="widgettitle widget-title">',
			'after_title' => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name' => __( 'Sidebar de cada colunista', 'odin' ),
			'id' => 'colunistas-single-sidebar',
			'description' => __( 'Barra lateral da página e cada colunista', 'odin' ),
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<h3 class="widgettitle widget-title">',
			'after_title' => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name' => __( 'Área do topo das editorias', 'odin' ),
			'id' => 'editorias-archive-topo',
			'description' => __( 'Área do topo das editorias onde fica o widget com os destaques da editoria.', 'odin' ),
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<h3 class="widgettitle widget-title">',
			'after_title' => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name' => __( 'Área lateral das editorias', 'odin' ),
			'id' => 'editorias-archive-sidebar',
			'description' => __( 'Área de barra lateral das editorias.', 'odin' ),
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<h3 class="widgettitle widget-title">',
			'after_title' => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name' => __( 'Home - Area de Baixo', 'odin' ),
			'id' => 'home-widgets-baixo',
			'description' => __( 'Home - Area de Baixo', 'odin' ),
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<h3 class="widgettitle widget-title">',
			'after_title' => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name' => __( 'Area - Single noticias interno', 'odin' ),
			'id' => 'single-interno-widgets',
			'description' => __( 'Area - Topo single noticias', 'odin' ),
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<h3 class="widgettitle widget-title">',
			'after_title' => '</h3>',
		)
	);

}

add_action( 'widgets_init', 'odin_widgets_init' );

/**
 * Flush Rewrite Rules for new CPTs and Taxonomies.
 *
 * @since 2.2.0
 */
function odin_flush_rewrite() {
	flush_rewrite_rules();
}

add_action( 'after_switch_theme', 'odin_flush_rewrite' );

/**
 * Load site scripts.
 *
 * @since 2.2.0
 */
function odin_enqueue_scripts() {
	$template_url = get_template_directory_uri();

	// Loads fonts
	wp_enqueue_style( 'google-font-roboto', 'https://fonts.googleapis.com/css?family=Heebo:400,700|Merriweather|Bitter:400,700|Lora:400,700|Suez+One:400,700|Libre+Franklin:400,700|Roboto:400,500,600,700|Roboto+Condensed:400,700|Roboto+Slab:400,700|Source+Code+Pro:400,700|Source+Sans+Pro:400,700', array(), null, 'all' );
	// Loads Odin main stylesheet.
	wp_enqueue_style( 'odin-style', get_stylesheet_uri(), array(), null, 'all' );

	// jQuery.
	wp_enqueue_script( 'jquery' );

	// Html5Shiv
	wp_enqueue_script( 'html5shiv', $template_url . '/assets/js/html5.js' );
	wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );

	// Grunt main file with Bootstrap, FitVids and others libs.
	wp_enqueue_script( 'odin-main-min', $template_url . '/assets/js/main.min.js');
	wp_localize_script( 'odin-main-min', 'odinAjax', array(
		'ajax_url' => admin_url( 'admin-ajax.php' )
	));
	// Grunt watch livereload in the browser.
	// wp_enqueue_script( 'odin-livereload', 'http://localhost:35729/livereload.js?snipver=1', array(), null, true );

	// Load Thread comments WordPress script.
	if ( is_singular() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'odin_enqueue_scripts', 1 );

/**
 * Load admin (dashboard/customizer) scripts and styles
 */
function odin_admin_enqueue_scripts() {
	$template_url = get_template_directory_uri();


	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-ui-sortable' );
	wp_enqueue_script( 'wp-api' );

	wp_enqueue_script( 'odin-admin', $template_url . '/assets/js/admin.min.js', array(), null, true );

	// Loads Odin main stylesheet.
	wp_enqueue_style( 'odin-admin-css', $template_url . '/assets/css/style-admin.css', array(), null, 'all' );

}

add_action( 'admin_enqueue_scripts', 'odin_admin_enqueue_scripts', 1 );

/**
 * Odin custom stylesheet URI.
 *
 * @since  2.2.0
 *
 * @param  string $uri Default URI.
 * @param  string $dir Stylesheet directory URI.
 *
 * @return string      New URI.
 */
function odin_stylesheet_uri( $uri, $dir ) {
	return $dir . '/assets/css/style.min.css';
}

add_filter( 'stylesheet_uri', 'odin_stylesheet_uri', 10, 2 );

/**
 * Query WooCommerce activation
 *
 * @since  2.2.6
 *
 * @return boolean
 */
if ( ! function_exists( 'is_woocommerce_activated' ) ) {
	function is_woocommerce_activated() {
		return class_exists( 'woocommerce' ) ? true : false;
	}
}

/**
 * Core Helpers.
 */
require_once get_template_directory() . '/core/helpers.php';

/**
 * WP Custom Admin.
 */
require_once get_template_directory() . '/inc/admin.php';

/**
 * Comments loop.
 */
require_once get_template_directory() . '/inc/comments-loop.php';

/**
 * WP optimize functions.
 */
require_once get_template_directory() . '/inc/optimize.php';

/**
 * Custom template tags.
 */
require_once get_template_directory() . '/inc/template-tags.php';

/**
 * WooCommerce compatibility files.
 */
if ( is_woocommerce_activated() ) {
	add_theme_support( 'woocommerce' );
	require get_template_directory() . '/inc/woocommerce/hooks.php';
	require get_template_directory() . '/inc/woocommerce/functions.php';
	require get_template_directory() . '/inc/woocommerce/template-tags.php';
}

/**
 * Load customizer fields + Kirki
 */
require_once get_template_directory() . '/inc/customizer.php';

/**
 * Load Advanced Custom Fields
 */
require_once get_template_directory() . '/inc/fields.php';

/**
 * Load Widgets
 */
 $widgets_dir = get_template_directory() . '/inc/widgets/';
 foreach ( glob( $widgets_dir . '*.php' ) as $filename ){
 	include $filename;
 }

/**
 * Load Shortcodes
 */
 $shortcode_dir = get_template_directory() . '/inc/shortcode/';
 foreach ( glob( $shortcode_dir . '*.php' ) as $filename ){
 	include $filename;
 }

 // galeria brasa slider
 include get_template_directory() . '/inc/galeria/brasa-slider.php';

/**
 * Load custom taxonomies
 */
require_once get_template_directory() . '/inc/custom-taxonomies.php';

/**
 * Load CPTs
 */
require_once get_template_directory() . '/inc/custom-post-types.php';

function eol_jp_remove_share() {
    remove_filter( 'the_content', 'sharing_display', 19 );
    remove_filter( 'the_excerpt', 'sharing_display', 19 );
    if ( class_exists( 'Jetpack_Likes' ) ) {
        remove_filter( 'the_content', array( Jetpack_Likes::init(), 'post_likes' ), 30, 1 );
    }
}
add_action( 'loop_start', 'eol_jp_remove_share' );

add_filter( 'get_the_archive_title', function ( $title ) {
	if ( is_post_type_archive() || is_tax() ||is_tag( ) ) {
	        /* translators: Post type archive title. 1: Post type name */
	        $title = sprintf( __( 'Índice <span>%s</span> &#62;' ), ($title  = post_type_archive_title( '', false ))? $title : single_term_title('',false) );
	    }
    return $title;

});

add_filter( 'dynamic_sidebar_params', 'check_sidebar_params' );
function check_sidebar_params( $params ) {
		// print_r($params);
		$new_params = $params;
		$new_params[0][ 'before_widget' ] = '<div class="widget-content">' ;
		$new_params[0][ 'after_widget' ] = '</div>' ;

    return $new_params;
}
function atualiza_data_colunista( $post_id ) {
	if ( wp_is_post_revision( $post_id ) || get_post_type($post_id) != 'post' || !$colunista = wp_get_post_terms($post_id,'colunistas_tax')){
		return;
	}
	remove_action( 'save_post', 'atualiza_data_colunista' );
	$colunista_obj = get_page_by_path($colunista[0]->slug, OBJECT,'colunistas');
	$colunista_id = $colunista_obj->ID;
	// print_r($colunista );
	// wp_die();


	// $post_date = gmdate('Y-m-d H:i:s', time());
	// echo "<br>post_date<br>".$post_date."<br><br>";
	$post_date = get_the_date('Y-m-d H:i:s', $post_id);
	// echo "<br>post_date2<br>".$post_date."<br><br>";
	// wp_die();

	$args = array(
               'ID' => $colunista_id,
							 'post_date' => $post_date
            );
 	wp_update_post( $args );
	add_action( 'save_post', 'atualiza_data_colunista' );
}
add_action( 'save_post', 'atualiza_data_colunista' );

function wpb_add_google_fonts() {

	wp_enqueue_style( 'wpb-google-fonts', 'https://fonts.googleapis.com/css?family=Lato:400,700', false );
}

add_action( 'wp_enqueue_scripts', 'wpb_add_google_fonts' );


// add classes to body based on custom taxonomy ('sections')
// examples: section-about-us, section-start, section-nyc
function colunistas_class($classes) {
	global $post;
	if (is_object($post)) {
		if( !is_tax() && !is_tag() && isset($post) && has_term( '', 'colunistas_tax', $post->ID ) ) {
			$classes[] .= " single-colunistas ";
		}
		$section_terms = get_the_terms( $post->ID, 'editorias' );
		if ( $section_terms && ! is_wp_error( $section_terms ) ) {
			foreach ($section_terms as $term) {
				if ($term->slug == 'editorial') {
					$classes[] = $term->slug;
				} else{
					$classes[] .= ' editoria editoria-' . $term->slug;
				}
			}
		}
		$section_terms = get_the_terms( $post->ID, 'especiais' );
		if ( $section_terms && ! is_wp_error( $section_terms ) ) {
			foreach ($section_terms as $term) {
				$classes[] .= ' especial especial-' . $term->slug;
			}
		}
	}
	return $classes;
}
add_filter('body_class', 'colunistas_class');


function single_colunistas_redirect() {

    // Only modify custom taxonomy template redirect
    if ( is_single() ) {
        // Get the queried term
        $post = get_queried_object();
        // Determine if term has a parent;
        // I *think* this will work; if not see above
				if( has_term( '', 'colunistas_tax', $post) ) {
					include(get_template_directory() . '/single-noticia-colunista.php');
					exit;
				}
    }
}
add_action( 'template_redirect', 'single_colunistas_redirect' );

// Remove destacadas do loop principal de editorias;
// Remove destacadas do loop principal de editorias;
add_action( 'pre_get_posts', 'remove_editoria' );
function remove_editoria( $query ) {
    if( $query->is_main_query() && is_tax( 'editorias') ) {
    	ob_start();
    	dynamic_sidebar( 'editorias-archive-topo' );
    	ob_end_clean();
    	if ( isset( $GLOBALS[ 'featured_posts_editorias'] ) && is_array( $GLOBALS[ 'featured_posts_editorias'] ) ) {
    		$query->set( 'post__not_in', $GLOBALS[ 'featured_posts_editorias'] );
    		unset( $GLOBALS[ 'featured_posts_editorias' ] );
    	}

    }
}
// Remove destacadas do loop principal de editorias;
// Remove destacadas do loop principal de editorias;




function de_cat_pra_edi(){

	$posts = new WP_Query( array(
		'posts_per_page' => 999,
		'tax_query' => array(
			array(
				'taxonomy' => '_featured_eo',
				'field'    => 'slug',
				'terms'    => array( 'sim' ),
			),
		),
	));
	// print_r($posts);
	// die;
	foreach ($posts->posts as $post) {
		$post_id = $post->ID;
		echo $post_id;
		echo '<br>';
		print_r($term = get_term_by('slug','destaque','_featured_eo'));
		print_r(wp_set_post_terms( $post_id, $term->term_id,'_featured_eo',false));
	}
}
// add_action('wp_head', 'de_cat_pra_edi');

function eol_pre_update_page_on_front( $value, $old_value ) {
	$post = get_post( $value );
	if ( ! $post || is_wp_error( $post ) ) {
		return $value;
	}
	$widget = eol_get_widget_object_id( get_permalink( $post->ID ) );
	$widgets_table = get_option( 'sidebars_widgets', false );
	if ( $widgets_table && isset( $widgets_table[ $widget ] ) ) {
		$widgets_table[ 'home-widgets' ] = $widgets_table[ $widget ];
		update_option( 'sidebars_widgets', $widgets_table );
		update_post_meta( $post->ID, '_wp_page_template', 'page-home.php' );
	}
	return $value;
}
add_filter( 'pre_update_option_page_on_front', 'eol_pre_update_page_on_front', 10, 2 );
/**
 * Retorna o ID da widget area de termos de acordo com o URL do mesmo
 * @see eol_register_widget_area_by_object_id()
 * @return string
 */
function eol_get_widget_object_id( $url_arg = false ) {
	if ( ! $url_arg ) {
		$url = str_replace( '?' . $_SERVER[ 'QUERY_STRING'], '', $_SERVER[ 'REQUEST_URI'] );
	} else {
		$url = $url_arg;
		$url = str_replace( array( $_SERVER[ 'SERVER_NAME'], $_SERVER[ 'REQUEST_SCHEME'], '://'), '', $url );
		$url = trim( $url );
	}
	if ( false != strpos( $url, 'customize.php') ) {
		if ( isset( $_GET[ 'url'] ) && !empty( $_GET[ 'url'] ) ) {
			$url = str_replace( array( $_SERVER[ 'SERVER_NAME'], $_SERVER[ 'REQUEST_SCHEME'] . '://' ), '', $_GET[ 'url' ] );
			return 'widget_' . str_replace( '/', '_', $url );
		}
	}
	return 'widget_' . str_replace( '/', '_', $url );
}

/**
 * Registra widget area para posts/paginas/termos de acordo com o 'slug' do mesmo
 * Em caso de termo, usa a função "eol_get_widget_term_id()"
 * @see eol_get_widget_term_id()
 *
 */
function eol_register_widget_area_by_object_id() {
	register_sidebar( array(
		'name'          => 'Widgets da página',
		'id'            => eol_get_widget_object_id(),
		'before_widget' => '',
		'after_widget'  => '',
		'before_title' => '<h3 class="widgettitle widget-title">',
		'after_title' => '</h3>',
    ) );
}
add_action( 'widgets_init', 'eol_register_widget_area_by_object_id' );

add_filter( 'body_class', 'section_id_class' );
// add classes to body based on custom taxonomy ('sections')
// examples: section-about-us, section-start, section-nyc
function section_id_class( $classes ) {
	global $post;

	return $classes;
}

add_filter('widget_text', 'do_shortcode');


// imprime credito na foto dentro da single
add_filter('the_content', 'gs_add_img_lazy_markup', 15);  // hook into filter and use priority 15 to make sure it is run after the srcset and sizes attributes have been added.

function gs_add_img_lazy_markup($the_content) {

    libxml_use_internal_errors(true);

    $post = new DOMDocument();
		if (!is_singular( ) || $post =='' || $the_content =="" ) {
			return;
		}
    $post->loadHTML(mb_convert_encoding($the_content, 'HTML-ENTITIES', 'UTF-8'));

    $imgs = $post->getElementsByTagName('img');

    // Iterate each img tag
    foreach( $imgs as $img ) {
				$class = $img->getAttribute('class');
				$img_id = explode('-',$class);
				$autor = get_post_meta( end($img_id), 'image_author', true );
				if ($autor) {
					$i = $post->createElement("i",'');
					$i->setAttribute('class','fas fa-camera');
					$span = $post->createElement("span",'');
					$span->setAttribute('class','image-author');
					$span->appendChild($i);
					$autor = $post->createTextNode($autor);
					$span->appendChild($autor);
					$img->parentNode->insertBefore($span, $img->nextSibling);
				}

    };
    return $post->saveHTML($post->documentElement);
}

add_filter('pre_get_posts','eol_exclude_destaques');

function eol_exclude_destaques( $query ) {

    if ( $query->is_tax( 'editorias' ) && $query->is_main_query() ) {
        $query_not_args = array(
			'tax_query' => array(
	            array(
	                'taxonomy' 		 => '_featured_eo',
	                'field' 		 => 'slug',
	                'terms' 		 => 'destaque',
	            )
	        ),
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'posts_per_page' => 5
	 	);
    }
	$query_not = new WP_Query( $query_not_args);
	$post_ids = wp_list_pluck($query_not->posts , 'ID' );
	$query->set_query_var('post__not_in', $post_ids);
    return $query;
}

// altera query do archive especiais
function archive_especiais($query) {
  if ( !is_admin() && $query->is_main_query() && is_post_type_archive('especiais') ) {
		$tax_query = array(
			'taxonomy' => 'tipo',
			'field' => 'slug',
			'terms' => array('dossies'),
						'operator'=> 'IN'
		);
		$query->tax_query->queries[] = $tax_query;
		$query->query_vars['tax_query'] = $query->tax_query->queries;
  }
}

add_action('pre_get_posts','archive_especiais');


// Remove páginas do archive de search
function eol_search_remove_pages($query) {
  if ( !is_admin() && $query->is_main_query() && isset( $_GET[ 's'] ) ) {
  	$query->set( 'post_type', array( 'post', 'especiais', 'videos', 'brasa_slider_cpt' ) );
  }
}

add_action('pre_get_posts','eol_search_remove_pages');




//
//
// $embed = wp_oembed_get( $url );
// if ( $embed ) {
// 	echo $embed;
// }

function get_video() {
	$id = $_POST['id'];
	$data = file_get_contents("https://graph.facebook.com/$id/thumbnails?access_token=$facebook_access_token");
	if ($data !== FALSE)
	{
		 $result=json_decode($data);
		 $thumbnail=$result->data[0]->uri;
		 print_r($result);
	}
	// echo wp_oembed_get($_POST['url'], array( 'width' => $_POST[ 'width'], 'height' => $_POST[ 'height' ] ) );
	return;
}
add_action( 'wp_ajax_nopriv_get_video', 'get_video' );
add_action( 'wp_ajax_get_video', 'get_video' );


function eol_filter_post_type_by_taxonomies( $post_type, $which ) {

	// Apply this only on a specific post type
	if ( 'post' !== $post_type )
		return;

	// A list of taxonomy slugs to filter by
	$taxonomies = array( 'editorias' );

	foreach ( $taxonomies as $taxonomy_slug ) {

		// Retrieve taxonomy data
		$taxonomy_obj = get_taxonomy( $taxonomy_slug );
		$taxonomy_name = $taxonomy_obj->labels->name;

		// Retrieve taxonomy terms
		$terms = get_terms( $taxonomy_slug );

		// Display filter HTML
		echo "<select name='{$taxonomy_slug}' id='{$taxonomy_slug}' class='postform'>";
		echo '<option value="">' . sprintf( esc_html__( 'Show All %s', 'text_domain' ), $taxonomy_name ) . '</option>';
		foreach ( $terms as $term ) {
			printf(
				'<option value="%1$s" %2$s>%3$s (%4$s)</option>',
				$term->slug,
				( ( isset( $_GET[$taxonomy_slug] ) && ( $_GET[$taxonomy_slug] == $term->slug ) ) ? ' selected="selected"' : '' ),
				$term->name,
				$term->count
			);
		}
		echo '</select>';
	}

}
add_action( 'restrict_manage_posts', 'eol_filter_post_type_by_taxonomies' , 10, 2);

// adiciona o duplicador revolucionario
require_once get_template_directory() . '/inc/class-duplicador.php';

// adiciona classe para baixar thumbnail de acordo com vídeo do youtube
require_once get_template_directory() . '/inc/class-yt-thumbnail.php';


//adiciona "fork" do brasa slider para servir como CPT de galeria
require_once get_template_directory() . '/inc/galeria/brasa-slider.php';

function my_increase_oembed_timeout($args) {
	$args["timeout"] = 30;
	return $args;
}
add_filter( 'oembed_remote_get_args', 'my_increase_oembed_timeout');
