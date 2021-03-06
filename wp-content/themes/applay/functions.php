<?php
/*
 * Applay functions
 */
if ( ! isset( $content_width ) ) $content_width = 900;
/**
 * Load core
 */
require_once get_parent_theme_file_path('inc/starter/leaf-core.php');
require_once get_parent_theme_file_path('inc/option-tree-hook.php');
require_once get_parent_theme_file_path('inc/starter/twenty-core.php');

/* Define list of recommended and required plugins */
global $__required_plugins;
$__required_plugins = array(
		array(
            'name'      => 'WooCommerce',
            'slug'      => 'woocommerce',
            'required'  => false
        ),
		array(
            'name'      => 'Black Studio TinyMCE Widget',
            'slug'      => 'black-studio-tinymce-widget',
            'required'  => false
        ),
		array(
            'name'      => 'Contact Form 7',
            'slug'      => 'contact-form-7',
            'required'  => false
        ),
		array(
            'name'      => 'Flickr Badges Widget',
            'slug'      => 'flickr-badges-widget',
            'required'  => false
        ),
		array(
            'name'      => 'Custom Sidebars',
            'slug'      => 'custom-sidebars',
            'required'  => false
        ),
		array(
            'name'      => 'WP Pagenavi',
            'slug'      => 'wp-pagenavi',
            'required'  => false
        ),
    );

require_once get_parent_theme_file_path('/inc/tgm/class-tgm-plugin-activation.php' );

if( !defined('PARENT_THEME') )
{
	define('PARENT_THEME','Applay');
}

function leafcolor_custom_excerpt_length( $length ) {
	return 35;
}
add_filter( 'excerpt_length', 'leafcolor_custom_excerpt_length', 999 );

/**
 * Registers the WordPress features
 */
function leafcolor_setup() {
	/*
	 * Makes theme available for translation.
	 */
	load_theme_textdomain( 'applay', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// Post formats.
	add_theme_support( 'post-formats', array( 'gallery', 'video', 'audio' ) );
	
	// Register menus.
	register_nav_menu( 'primary-menus', esc_html__( 'Primary Menus', 'applay' ) );
	register_nav_menu( 'off-canvas-menus', esc_html__( 'Off Canvas Menus', 'applay' ) );

	// Featured images.
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	
	// Supports woocommerce.
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'leafcolor_setup' );

function leaf_get_option($options, $default = NULL){
	if(function_exists('ot_get_option')){
		global $post;
	    global $wp_query;
	    if(is_singular()){
	        if(is_singular('tribe_events')){
	            global $wp_query;
	            global $post;
	            $post = $wp_query->post;
	        }
	        if(isset($post->ID)){
	            $meta = get_post_meta($post->ID,$options,true);
	        }
	        return $meta != '' ?$meta:ot_get_option($options, $default);
	    }
	    return ot_get_option($options, $default);
	}else{
		return $default;
	}
    
}
/**
 * Enqueues scripts and styles
 */
function leafcolor_scripts_styles() {
	/*
	 * Loads js.
	 */	
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '', true );
	wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/js/owl-carousel/owl.carousel.min.js', array('jquery'), '', true );
	wp_enqueue_script( 'applay-js', get_template_directory_uri() . '/js/applay.js', array('jquery'), '', true );
	/*
	 * Loads css
	 */
	$all_font = array();
	if(leaf_get_option('main_font','Open Sans') || leaf_get_option( 'heading_font','Oswald:400' )){
		if(leaf_get_option('main_font','Open Sans') && leaf_get_option('main_font')!='custom-font-1' && leaf_get_option('main_font')!='custom-font-2'){
			$all_font[] = leaf_get_option( 'main_font','Open Sans' );
		}
		if(leaf_get_option('heading_font','Oswald:400') && leaf_get_option('heading_font')!='custom-font-1' && leaf_get_option('heading_font')!='custom-font-2'){
			$all_font[] = leaf_get_option( 'heading_font','Oswald:400' );
		}
		$all_font=implode('|',$all_font);
		if((leaf_get_option('main_font','Open Sans') && leaf_get_option('main_font')!='custom-font-1' && leaf_get_option('main_font')!='custom-font-2') || (leaf_get_option('heading_font','Oswald:400') && leaf_get_option('heading_font')!='custom-font-1' && leaf_get_option('heading_font')!='custom-font-2')){
			wp_enqueue_style( 'applay-google-font', '//fonts.googleapis.com/css?family='.$all_font );
		}
	}
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css');
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() .'/css/fa/css/font-awesome.min.css');
	wp_enqueue_style( 'owl-carousel', get_template_directory_uri() .'/js/owl-carousel/owl.carousel.css');
	wp_enqueue_style( 'owl-carousel-theme', get_template_directory_uri() .'/js/owl-carousel/owl.theme.css');
	wp_enqueue_style( 'lightbox2', get_template_directory_uri() . '/js/colorbox/colorbox.css');
	wp_enqueue_style( 'applay-style', get_stylesheet_directory_uri() . '/style.css');
	$dynamic_css_hook = 'applay-style';
	if(class_exists('bbPress')){
		wp_enqueue_style( 'applay-bbpress', get_template_directory_uri() . '/css/app-bbpress.css');
	}
	if(leaf_get_option( 'app-theme-style', 1)!=2){
		wp_enqueue_style( 'applay-modern-style', get_template_directory_uri() . '/css/modern-style.css');
		$dynamic_css_hook = 'applay-modern-style';
	}
	if(is_page_template('page-templates/tpl-demo-classic.php')){
		$dynamic_css_hook = 'applay-style';
	}
	
	ob_start();
		require get_parent_theme_file_path('/css/dynamic_css.php');
	$custom_css = ob_get_clean();
	wp_add_inline_style( $dynamic_css_hook, $custom_css );

	if(leaf_get_option( 'right_to_left', 0)){
		wp_enqueue_style( 'applay-rtl', get_template_directory_uri() . '/rtl.css');
	}
	
	if(is_singular() ) wp_enqueue_script( 'comment-reply' );
}
add_action( 'wp_enqueue_scripts', 'leafcolor_scripts_styles' );

/* Enqueues for Admin */
function leafcolor_admin_scripts_styles() {
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() .'/css/fa/css/font-awesome.min.css');
}
add_action( 'admin_enqueue_scripts', 'leafcolor_admin_scripts_styles' );

/**
 * Registers our main widget area and the front page widget areas.
 *
 */
function leafcolor_widgets_init() {
	$rtl = leaf_get_option( 'righttoleft', 0);

	register_sidebar( array(
		'name' => esc_html__( 'Main Sidebar', 'applay' ),
		'id' => 'main_sidebar',
		'description' => esc_html__( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'applay' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',
		'after_widget' => '</div></div>',
		'before_title' => $rtl ? '<h2 class="widget-title maincolor2">' : '<h2 class="widget-title maincolor2">',
		'after_title' => $rtl ? '</h2>' : '</h2>',
	));
	register_sidebar( array(
		'name' => esc_html__( 'Pathway Sidebar', 'applay' ),
		'id' => 'pathway_sidebar',
		'description' => esc_html__( 'Replace Pathway (Breadcrumbs) with your widgets', 'applay' ),
		'before_widget' => '<div id="%1$s" class="pathway-widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	register_sidebar( array(
		'name' => esc_html__( 'Front Page Sidebar ', 'applay' ),
		'id' => 'frontpage_sidebar',
		'description' => esc_html__( 'Used in Front Page templates only', 'applay' ),
		'before_widget' => '<div id="%1$s" class="widget frontpage-widget %2$s"><div class="widget-inner">',
		'after_widget' => '</div></div>',
		'before_title' => $rtl ? '<h2 class="widget-title maincolor2">' : '<h2 class="widget-title maincolor2">',
		'after_title' => $rtl ? '</h2>' : '</h2>',
	));
	register_sidebar( array(
		'name' => esc_html__( 'Bottom Sidebar', 'applay' ),
		'id' => 'bottom_sidebar',
		'description' => '',
		'before_widget' => '<div id="%1$s" class="col-md-3 widget %2$s"><div class="widget-inner">',
		'after_widget' => '</div></div>',
		'before_title' => '<h2 class="widget-title maincolor1">',
		'after_title' => '</h2>',
	));
	register_sidebar( array(
		'name' => esc_html__( 'Footer Sidebar', 'applay' ),
		'id' => 'footer_sidebar',
		'description' => '',
		'before_widget' => '<div id="%1$s" class="col-md-3 widget %2$s"><div class="widget-inner">',
		'after_widget' => '</div></div>',
		'before_title' => '<h2 class="widget-title maincolor1">',
		'after_title' => '</h2>',
	));
	if (class_exists('Woocommerce')) {
	register_sidebar( array(
		'name' => esc_html__( 'Woocommerce Sidebar', 'applay' ),
		'id' => 'woocommerce_sidebar',
		'description' => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',
		'after_widget' => '</div></div>',
		'before_title' => $rtl ? '<h2 class="widget-title maincolor2">' : '<h2 class="widget-title maincolor2">',
		'after_title' => $rtl ? '</h2>' : '</h2>',
	));
	}
}
add_action( 'widgets_init', 'leafcolor_widgets_init' );

add_image_size('applay_thumb_80x80',80, 80, true); //widget
add_image_size('applay_thumb_263x263',263,263, true); 
add_image_size('applay_thumb_409x258',409,258, true); //blog listing
//Retina
add_image_size('applay_thumb_500x500',500, 500, true); //GRID
add_image_size('applay_thumb_800x400',800, 400, true); //GRID Featured

//Hook widget 'SEARCH'
add_filter('get_search_form', 'leaf_search_form'); 
function leaf_search_form($text) {
	$text = str_replace('value=""', 'placeholder="'.esc_attr__("SEARCH", 'applay').'"', $text);
    return $text;
}
function leaf_global_title(){
	if(is_search()){
		$page_title = esc_html__('Search Result: ','applay').(isset($_GET['s'])?$_GET['s']:'');
	}elseif(is_category()){
		$page_title = single_cat_title('',false);
	}elseif(is_tag()){
		$page_title = single_tag_title('',false);
	}elseif(is_tax()){
		$page_title = single_term_title('',false);
	}elseif(is_author()){
		$page_title = esc_html__("Author: ",'applay') . get_the_author();
	}elseif(is_day()){
		$page_title = esc_html__("Archives for ",'applay') . date_i18n(get_option('date_format') ,strtotime(get_the_date()));
	}elseif(is_month()){
		$page_title = esc_html__("Archives for ",'applay') . get_the_date('F, Y');
	}elseif(is_year()){
		$page_title = esc_html__("Archives for ",'applay') . get_the_date('Y');
	}elseif(is_home()){
		if(get_option('page_for_posts')){ $page_title = get_the_title(get_option('page_for_posts'));
		}else{
			$page_title = esc_html__('Blog','applay');
		}
	}elseif(is_404()){
		$page_title = leaf_get_option('page404_title','404 - Page Not Found');
	}else if(  function_exists ( "is_shop" ) && is_shop()){
			$page_title = woocommerce_page_title($echo = false);
    }else{
		global $post;
		if($post){$page_title = $post->post_title;}
	}
	return $page_title;
}
if(!function_exists('leafcolor_breadcrumbs')){
	function leafcolor_breadcrumbs(){
		/* === OPTIONS === */
		$text['home']     = esc_html__('Home','applay'); // text for the 'Home' link
		$text['category'] = '%s'; // text for a category page
		$text['search']   = esc_html__('Search Results for','applay').' "%s"'; // text for a search results page
		$text['tag']      = esc_html__('Tag','applay').' "%s"'; // text for a tag page
		$text['author']   = esc_html__('Author','applay').' %s'; // text for an author page
		$text['404']      = esc_html__('404','applay'); // text for the 404 page

		$show_current   = 0; // 1 - show current post/page/category title in breadcrumbs, 0 - don't show
		$show_on_home   = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
		$show_home_link = 1; // 1 - show the 'Home' link, 0 - don't show
		$show_title     = 1; // 1 - show the title for the links, 0 - don't show
		$delimiter      = ' &rsaquo; '; // delimiter between crumbs
		$before         = '<span class="current">'; // tag before the current crumb
		$after          = '</span>'; // tag after the current crumb
		/* === END OF OPTIONS === */

		global $post;
		$home_link    = esc_url( home_url('/') );
		$link_before  = '<span typeof="v:Breadcrumb">';
		$link_after   = '</span>';
		$link_attr    = ' rel="v:url" property="v:title"';
		$link         = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
		$parent_id    = $parent_id_2 = ($post) ? $post->post_parent : 0;
		$frontpage_id = get_option('page_on_front');

		if (is_front_page()) {

			if ($show_on_home == 1) echo '<div class="breadcrumbs"><a href="' . esc_url($home_link) . '">' . esc_html($text['home']) . '</a></div>';

		}elseif(is_home()){
			$title = get_option('page_for_posts')?get_the_title(get_option('page_for_posts')):esc_html__('Blog','applay');
			echo '<div class="breadcrumbs"><a href="' . esc_url($home_link) . '">' . esc_html($text['home']) . '</a> &rsaquo; '.esc_html($title).'</div>';
		} else {

			echo '<div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">';
			if ($show_home_link == 1) {
				if(function_exists ( "is_shop" ) && is_shop()){
					
				}else{
					echo '<a href="' . esc_url($home_link) . '" rel="v:url" property="v:title">' . esc_html($text['home']) . '</a>';
					if ($frontpage_id == 0 || $parent_id != $frontpage_id) echo wp_kses_post($delimiter);
				}
			}

			if ( is_category() ) {
				$this_cat = get_category(get_query_var('cat'), false);
				if ($this_cat->parent != 0) {
					$cats = get_category_parents($this_cat->parent, TRUE, $delimiter);
					if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
					$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
					$cats = str_replace('</a>', '</a>' . $link_after, $cats);
					if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
					echo wp_kses_post($cats);
				}
				if ($show_current == 1) echo wp_kses_post($before) . sprintf($text['category'], single_cat_title('', false)) . $after;

			} elseif ( is_search() ) {
				echo wp_kses_post($before) . sprintf($text['search'], get_search_query()) . $after;

			} elseif ( is_day() ) {
				echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
				echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
				echo wp_kses_post($before) . get_the_time('d') . $after;

			} elseif ( is_month() ) {
				echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
				echo wp_kses_post($before) . get_the_time('F') . $after;

			} elseif ( is_year() ) {
				echo wp_kses_post($before) . get_the_time('Y') . $after;

			} elseif ( is_single() && !is_attachment() ) {
				if ( get_post_type() != 'post' ) {
					$post_type = get_post_type_object(get_post_type());
					$slug = $post_type->rewrite;
					printf($link, $home_link . $slug['slug'] . '/', $post_type->labels->singular_name);
					if ($show_current == 1) echo wp_kses_post($delimiter) . $before . get_the_title() . $after;
				} else {
					$cat = get_the_category(); $cat = $cat[0];
					$cats = get_category_parents($cat, TRUE, $delimiter);
					if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
					$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
					$cats = str_replace('</a>', '</a>' . $link_after, $cats);
					if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
					echo wp_kses_post($cats);
					if ($show_current == 1) echo wp_kses_post($before) . get_the_title() . $after;
				}

			} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
				if(function_exists ( "is_shop" ) && is_shop()){
					do_action( 'woocommerce_before_main_content' );
					do_action( 'woocommerce_after_main_content' );
				}else{
					$post_type = get_post_type_object(get_post_type());
					echo wp_kses_post($before) . $post_type->labels->singular_name . $after;
				}

			} elseif ( is_attachment() ) {
				$parent = get_post($parent_id);
				$cat = get_the_category($parent->ID); $cat = isset($cat[0])?$cat[0]:'';
				if($cat){
					$cats = get_category_parents($cat, TRUE, $delimiter);
					$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
					$cats = str_replace('</a>', '</a>' . $link_after, $cats);
					if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
					echo wp_kses_post($cats);
				}
				printf($link, get_permalink($parent), $parent->post_title);
				if ($show_current == 1) echo wp_kses_post($delimiter) . $before . get_the_title() . $after;

			} elseif ( is_page() && !$parent_id ) {
				if ($show_current == 1) echo wp_kses_post($before) . get_the_title() . $after;

			} elseif ( is_page() && $parent_id ) {
				if ($parent_id != $frontpage_id) {
					$breadcrumbs = array();
					while ($parent_id) {
						$page = get_page($parent_id);
						if ($parent_id != $frontpage_id) {
							$breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
						}
						$parent_id = $page->post_parent;
					}
					$breadcrumbs = array_reverse($breadcrumbs);
					for ($i = 0; $i < count($breadcrumbs); $i++) {
						echo wp_kses_post($breadcrumbs[$i]);
						if ($i != count($breadcrumbs)-1) echo wp_kses_post($delimiter);
					}
				}
				if ($show_current == 1) {
					if ($show_home_link == 1 || ($parent_id_2 != 0 && $parent_id_2 != $frontpage_id)) echo wp_kses_post($delimiter);
					echo wp_kses_post($before) . get_the_title() . $after;
				}

			} elseif ( is_tag() ) {
				echo wp_kses_post($before) . sprintf($text['tag'], single_tag_title('', false)) . $after;

			} elseif ( is_author() ) {
				global $author;
				$userdata = get_userdata($author);
				echo wp_kses_post($before) . sprintf($text['author'], $userdata->display_name) . $after;

			} elseif ( is_404() ) {
				echo wp_kses_post($before) . $text['404'] . $after;
			}

			if ( get_query_var('paged') ) {
				if(function_exists ( "is_shop" ) && is_shop()){
				}else{
					if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() || is_home() ) echo ' (';
					echo esc_html__('Page','applay') . ' ' . get_query_var('paged');
					if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() || is_home() ) echo ')';
				}
			}

			echo '</div>';

		}
	}
}


/*Default image*/
if(!function_exists('leafcolor_print_default_thumbnail')){
	function leafcolor_print_default_thumbnail($thumb = ''){
		return array(get_template_directory_uri().'/images/default-photo.png',500,500);
	}
}

/*Hook Row Visual Composer*/
function vc_theme_before_vc_row($atts, $content = null) {
	$style = isset($atts['ia_row_style'])?$atts['ia_row_style']:0; //style full width or not
	$paralax = isset($atts['ia_row_paralax'])?$atts['ia_row_paralax']:0;
	$scheme = isset($atts['ia_row_scheme'])?$atts['ia_row_scheme']:0;
	global $global_page_layout;
	ob_start(); 
	?>
		<div class="ia_row<?php if ($style || $global_page_layout=='true-full'){?> ia_full_row <?php } if($scheme){?> dark-div <?php } if($paralax){?> ia_paralax <?php }?>">
        <?php if(!$style && $global_page_layout=='true-full'){ ?>
        	<div class="container">
        <?php }?>
	<?php
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}
function vc_theme_after_vc_row($atts, $content = null) {
	$style = isset($atts['ia_row_style'])?$atts['ia_row_style']:0; //style full width or not
	global $global_page_layout;
	ob_start(); ?>
    	<?php if(!$style && $global_page_layout=='true-full'){ ?>
        	</div>
        <?php }?>
		</div><!--/ia_row-->
	<?php
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}


add_action( 'after_setup_theme', 'leafcolor_extend_vc_row_param' );
function leafcolor_extend_vc_row_param(){
	$attributes = array(
		'type' => 'dropdown',
		'heading' => "Row Style",
		'param_name' => 'ia_row_style',
		'value' => array(
			esc_html__('Default (In container)', 'applay') => 0,
			esc_html__('Full-width (Side to side)', 'applay') => 1,
		 ),
		'description' => esc_html__("Choose row width (In page template Front Page, this is used for row's content)", 'applay')
	);
	if(function_exists('vc_add_param')){
		vc_add_param('vc_row', $attributes);
	}
}

add_action( 'after_setup_theme', 'leafcolor_extend_vc_row_param2', 10, 15 );
function leafcolor_extend_vc_row_param2(){
	$attributes = array(
		'type' => 'dropdown',
		'heading' => "Row Parallax Effect",
		'param_name' => 'ia_row_paralax',
		'value' => array(
			esc_html__('No', 'applay') => 0,
			esc_html__('Yes', 'applay') => 1,
		 ),
		'description' => esc_html__("Enable parallax effect for row's background", 'applay')
	);
	if(function_exists('vc_add_param')){
		vc_add_param('vc_row', $attributes);
	}
}

add_action( 'after_setup_theme', 'leafcolor_extend_vc_row_param3', 10, 20 );
function leafcolor_extend_vc_row_param3(){
	$attributes = array(
		'type' => 'dropdown',
		'heading' => "Row Scheme",
		'param_name' => 'ia_row_scheme',
		'value' => array(
			esc_html__('Default', 'applay') => 0,
			esc_html__('Dark', 'applay') => 1,
		 ),
		'description' => esc_html__("Choose row scheme (in Dark, default text, buttons will have white color)", 'applay')
	);
	if(function_exists('vc_add_param')){
		vc_add_param('vc_row', $attributes);
	}
}

//mime type
function leafcolor_upload_mimes( $existing_mimes=array() ) {
	$existing_mimes['webp'] = 'image/webp';
	$existing_mimes['apk'] = 'application/vnd.android.package-archive';
	return $existing_mimes;
}
add_filter('upload_mimes', 'leafcolor_upload_mimes');

//image url to id
function leafcolor_get_attachment_id_from_url( $attachment_url = '' ) {
	global $wpdb;
	$attachment_id = false;
	// If there is no url, return.
	if ( '' == $attachment_url )
		return;
	// Get the upload directory paths
	$upload_dir_paths = wp_upload_dir();
	// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
	if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {
		// If this is the URL of an auto-generated thumbnail, get the URL of the original image
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );
		// Remove the upload path base directory from the attachment URL
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );
		// Finally, run a custom database query to get the attachment ID from the modified attachment URL
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
	}
	return $attachment_id;
}
function leafcolor_woo_related_products() {
  global $product;
	
	$args['posts_per_page'] = 3;
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'leafcolor_woo_related_products' );
function leafcolor_get_app_icon($post_id, $size = 'thumbnail'){
	$icon = get_post_meta($post_id,'app-icon',true);
	if($icon_id = leafcolor_get_attachment_id_from_url($icon)){
		$thumbnail = wp_get_attachment_image_src($icon_id, $size, true);
		$icon = isset($thumbnail[0])?$thumbnail[0]:$icon;
	}
	return $icon;
}

/* Functions, Hooks, Filters and Registers in Admin */
require_once get_parent_theme_file_path('inc/starter/functions-admin.php');

if(!function_exists('leafcolor_add_query_ct')) {
	add_action( 'pre_get_posts', 'leafcolor_add_query_ct' );
	/**
	 * add custom post type to main cat query
	 */
	function leafcolor_add_query_ct( $query ) {
		if ($query->is_main_query() && is_category()) {
			$query->set( 'post_type', array( 'post', 'app_portfolio' ) );
		}
		return $query;
	}
}

//////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////

//Esta funci??n est?? provocando que no cargue la biblioteca
//Es para tener el correo del usuario para usarlo en los mapas
/*
add_action("init", "loadUserInfo");
function loadUserInfo(){
    $current_user = wp_get_current_user();
    $email = $current_user->user_email;
    if(is_rest()===false && wp_doing_ajax()===false)
        echo '<input type="text" id="userEmail" value="'.$email.'" hidden>';
}
*/

add_action('get_header', function() {
    if ( is_page('3841') && !is_user_logged_in() || is_page('3784') && !is_user_logged_in() ) {
    wp_redirect( '/' );
    exit;
  }  
});

if ( !function_exists( 'is_rest' ) ) {
    /**
     * Checks if the current request is a WP REST API request.
     *
     * Case #1: After WP_REST_Request initialisation
     * Case #2: Support "plain" permalink settings
     * Case #3: It can happen that WP_Rewrite is not yet initialized,
     *          so do this (wp-settings.php)
     * Case #4: URL Path begins with wp-json/ (your REST prefix)
     *          Also supports WP installations in subfolders
     *
     * @returns boolean
     * @author matzeeable
     */
    function is_rest() {
        $prefix = rest_get_url_prefix( );
        if (defined('REST_REQUEST') && REST_REQUEST // (#1)
                || isset($_GET['rest_route']) // (#2)
                        && strpos( trim( $_GET['rest_route'], '\\/' ), $prefix , 0 ) === 0)
                return true;
        // (#3)
        global $wp_rewrite;
        if ($wp_rewrite === null) $wp_rewrite = new WP_Rewrite();

        // (#4)
        $rest_url = wp_parse_url( trailingslashit( rest_url( ) ) );
        $current_url = wp_parse_url( add_query_arg( array( ) ) );
        return strpos( $current_url['path'], $rest_url['path'], 0 ) === 0;
    }
}
add_filter( 'show_admin_bar', '__return_false' );