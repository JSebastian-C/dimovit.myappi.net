<?php
   /*
   Plugin Name: Applay - Shortcodes
   Plugin URI: http://www.leafcolor.com
   Description: Applay - Shortcodes
   Version: 3.4
   Author: Leafcolor
   Author URI: http://www.leafcolor.com
   License: GPL2
   */

if ( ! defined( 'IA_SHORTCODE_BASE_FILE' ) )
    define( 'IA_SHORTCODE_BASE_FILE', __FILE__ );
if ( ! defined( 'IA_SHORTCODE_BASE_DIR' ) )
    define( 'IA_SHORTCODE_BASE_DIR', dirname( IA_SHORTCODE_BASE_FILE ) );
if ( ! defined( 'IA_SHORTCODE_PLUGIN_URL' ) )
    define( 'IA_SHORTCODE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/* 
 * Add button to tinyMCE editor
 */
class LeafColorShortcodes{
	
	function __construct()
	{
		$this->includes();
		add_action('init',array(&$this, 'init'));
	}
	function includes(){
		include('shortcodes/icon_box.php');
		include('shortcodes/button.php');
		include('shortcodes/dropcap.php');
		include('shortcodes/heading.php');
		include('shortcodes/testimonial.php');
		include('shortcodes/blog.php');
		include('shortcodes/countdown_clock.php');
		include('shortcodes/post-carousel.php');
		include('shortcodes/post-grid.php');
		include('shortcodes/post-slider.php');
		include('shortcodes/app-woo.php');
		include('shortcodes/pricing-table.php');
		
		//Widgets
		include('widgets/widgets.php');

		//Fetch
		include('fetch/fetch.php');

		//optionTree
		include('option-tree/ot-loader.php' );

		//widget param
		include('widgets/widget_param.php');

		//mobile detect
		if(!class_exists('Mobile_Detect')){
			include('widgets/mobile-detect.php');
		}
		$detect = new Mobile_Detect;
		global $_device_, $_device_name_, $__check_retina;
		$_device_ = $detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'mobile') : 'pc';
		$_device_name_ = $detect->mobileGrade();
		$__check_retina = $detect->isRetina();

		//Metadata boxes
		include('meta/meta-boxes.php');
	}
	function init(){		
		if(is_admin()){
			// CSS for button styling
			wp_enqueue_style("ia_shortcode_admin_style", IA_SHORTCODE_PLUGIN_URL . '/shortcodes/shortcodes.css');
		}

		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
	    	return;
		}
	 
		if ( get_user_option('rich_editing') == 'true' ) {
			add_filter( 'mce_external_plugins', array(&$this, 'regplugins'));
			add_filter( 'mce_buttons_3', array(&$this, 'regbtns') );
			
			// remove a button. Used to remove a button created by another plugin
			remove_filter('mce_buttons_3', array(&$this, 'remobtns'));
		}
	}
	
	function remobtns($buttons){
		// add a button to remove
		// array_push($buttons, 'ia_shortcode_collapse');
		return $buttons;	
	}
	
	function regbtns($buttons)
	{
		array_push($buttons, 'shortcode_button');
		array_push($buttons, 'shortcode_blog');
		array_push($buttons, 'shortcode_post_carousel');
		array_push($buttons, 'shortcode_post_grid');
		array_push($buttons, 'shortcode_testimonial');
		array_push($buttons, 'shortcode_dropcap');
		array_push($buttons, 'shortcode_iconbox');
		array_push($buttons, 'shortcode_member');	
		array_push($buttons, 'shortcode_heading');
		array_push($buttons, 'shortcode_countdown');	
		array_push($buttons, 'shortcode_woo');	
		array_push($buttons, 'shortcode_post_silder');	
		return $buttons;
	}
	
	function regplugins($button_js)
	{
		$button_js['shortcode_button'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/button.js';
		$button_js['shortcode_blog'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/blog.js';
		$button_js['shortcode_post_carousel'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/post-carousel.js';
		$button_js['shortcode_post_grid'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/post-grid.js';
		$button_js['shortcode_iconbox'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/iconbox.js';
		$button_js['shortcode_testimonial'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/testimonial.js';
		$button_js['shortcode_dropcap'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/dropcap.js';
		$button_js['shortcode_member'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/member.js';
		$button_js['shortcode_heading'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/heading.js';
		$button_js['shortcode_countdown'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/shortcode_countdown.js';
		$button_js['shortcode_woo'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/app-woo.js';
		$button_js['shortcode_post_silder'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/post-slider.js';
		return $button_js;
	}
}

$lcshortcode = new LeafColorShortcodes();
include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); //for check plugin status
//add animation param
function ia_add_param() {
	if(class_exists('WPBMap')){
		//get default textblock params
		$shortcode_vc_column_text_tmp = WPBMap::getShortCode('vc_column_text');
		//get animation params
		$attributes = array();
		foreach($shortcode_vc_column_text_tmp['params'] as $param){
			if($param['param_name']=='css_animation'){
				$attributes = $param;
				break;
			}
		}
		if(!empty($attributes)){
			//add animation param
			vc_add_param('ia_iconbox', $attributes);
			vc_add_param('ia_button', $attributes);
			vc_add_param('ia_heading', $attributes);
			vc_add_param('ia_testimonial', $attributes);
			vc_add_param('ia_blog', $attributes);
			vc_add_param('ia_countdown', $attributes);
			vc_add_param('ia_post_carousel', $attributes);
			vc_add_param('ia_post_grid', $attributes);
			vc_add_param('ia_member', $attributes);
			vc_add_param('ia_woo', $attributes);
		}
		//delay param
		$delay = array(
			'type' => 'textfield',
			'heading' => __("Animation Delay",'applay'),
			'param_name' => 'animation_delay',
			'description' => __("Enter Animation Delay in second (ex: 1.5)",'applay')
		);
		vc_add_param('ia_iconbox', $delay);
		vc_add_param('ia_button', $delay);
		vc_add_param('ia_heading', $delay);
		vc_add_param('ia_testimonial', $delay);
		vc_add_param('ia_blog', $delay);
		vc_add_param('ia_countdown', $delay);
		vc_add_param('ia_post_carousel', $delay);
		vc_add_param('ia_post_grid', $delay);
		vc_add_param('ia_member', $delay);
		vc_add_param('ia_woo', $delay);
	}
}
add_action('wp_loaded', 'ia_add_param');

//load animation js
function ia_animation_scripts_styles() {
	global $wp_styles;
	wp_enqueue_script( 'waypoints' );
}
add_action( 'wp_enqueue_scripts', 'ia_animation_scripts_styles' );

//function
if(!function_exists('leaf_hex2rgb')){
	function leaf_hex2rgb($hex) {
	   $hex = str_replace("#", "", $hex);
	
	   if(strlen($hex) == 3) {
		  $r = hexdec(substr($hex,0,1).substr($hex,0,1));
		  $g = hexdec(substr($hex,1,1).substr($hex,1,1));
		  $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	   } else {
		  $r = hexdec(substr($hex,0,2));
		  $g = hexdec(substr($hex,2,2));
		  $b = hexdec(substr($hex,4,2));
	   }
	   $rgb = array($r, $g, $b);
	   //return implode(",", $rgb); // returns the rgb values separated by commas
	   return $rgb; // returns an array with the rgb values
	}
}
function ia_shortcode_query($post_type='',$cat='',$tag='',$ids='',$count='',$order='',$orderby='',$meta_key='',$custom_args=''){
	if($post_type==''){ $post_type='post';}
	$args = array();
	if($custom_args!=''){ //custom array
		$args = $custom_args;
	}elseif($ids!=''){ //specify IDs
		$ids = explode(",", $ids);
		$args = array(
			'post_type' => $post_type,
			'posts_per_page' => $count,
			'order' => $order,
			'orderby' => $orderby,
			'meta_key' => $meta_key,
			'post__in' => $ids,
			'ignore_sticky_posts' => 1,
		);
	}elseif($ids=='' && $post_type!='product'){
		$args = array(
			'post_type' => $post_type,
			'posts_per_page' => $count,
			'order' => $order,
			'orderby' => $orderby,
			'meta_key' => $meta_key,
			'tag' => $tag,
			'ignore_sticky_posts' => 1,
		);
		if(!is_array($cat)) {
			$cats = explode(",",$cat);
			if(is_numeric($cats[0])){
				$args['category__in'] = $cats;
			}else{			 
				$args['category_name'] = $cat;
			}
		}elseif(count($cat) > 0){
			$args['category__in'] = $cat;
		}
	}else if($post_type=='product'){
		if($tag!=''){
			$tags = explode(",",$tag);
			if(is_numeric($tags[0])){$field_tag = 'term_id'; }
			else{ $field_tag = 'slug'; }
			if(count($tags)>1){
				  $texo = array(
					  'relation' => 'OR',
				  );
				  foreach($tags as $iterm) {
					  $texo[] = 
						  array(
							  'taxonomy' => 'product_tag',
							  'field' => $field_tag,
							  'terms' => $iterm,
						  );
				  }
			  }else{
				  $texo = array(
					  array(
							  'taxonomy' => 'product_tag',
							  'field' => $field_tag,
							  'terms' => $tags,
						  )
				  );
			}
		}
		//cats
		if($cat!=''){
			$cats = explode(",",$cat);
			if(is_numeric($cats[0])){$field = 'term_id'; }
			else{ $field = 'slug'; }
			if(count($cats)>1){
				  $texo = array(
					  'relation' => 'OR',
				  );
				  foreach($cats as $iterm) {
					  $texo[] = 
						  array(
							  'taxonomy' => 'product_cat',
							  'field' => $field,
							  'terms' => $iterm,
						  );
				  }
			  }else{
				  $texo = array(
					  array(
							  'taxonomy' => 'product_cat',
							  'field' => $field,
							  'terms' => $cats,
						  )
				  );
			}
		}
		$args = array(
			'post_type' => $post_type,
			'posts_per_page' => $count,
			'order' => $order,
			'orderby' => $orderby,
			'meta_key' => $meta_key,
			'ignore_sticky_posts' => 1,
		);
		if(isset($texo)){
			$args += array('tax_query' => $texo);
		}
		
	}
	$args['post_status'] = $post_type=='attachment'?'inherit':'publish';
	
	$shortcode_query = new WP_Query($args);
	return $shortcode_query;
}


//mail after publish submitted app
add_action( 'save_post', 'notify_user_submit');
function notify_user_submit( $post_id ) {
	if ( wp_is_post_revision( $post_id ) || !ot_get_option('user_submit_notify',1) )
		return;
	$notified = get_post_meta($post_id,'notified',true);
	$email = get_post_meta($post_id,'tm_user_submit',true);
	if(!$notified && $email && get_post_status($post_id)=='publish'){
		$subject = __('Your app submission has been approved','applay');
		$message = __('Your app ','applay').' '.__('has been approved. You can see it here','applay').' '.get_permalink($post_id);
		wp_mail( $email, $subject, $message );
		update_post_meta( $post_id, 'notified', 1);
	}
}

/* Display Icon Links to some social networks */
if(!function_exists('leafcolor_social_share')){
function leafcolor_social_share($id=false){
	if(!$id){ $id = get_the_ID(); }
	?>
	<?php if(ot_get_option('share_facebook','on')!='off'){ ?>
	<li><a class="btn btn-default btn-lighter social-icon" title="<?php esc_html_e('Share on Facebook','applay');?>" href="#" target="_blank" rel="nofollow" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+'<?php echo urlencode(get_permalink($id)); ?>','facebook-share-dialog','width=626,height=436');return false;"><i class="fa fa-facebook"></i></a></li>
    <?php } ?>
    <?php if(ot_get_option('share_twitter','on')!='off'){ ?>
    <li><a class="btn btn-default btn-lighter social-icon" href="#" title="<?php esc_html_e('Share on Twitter','applay');?>" rel="nofollow" target="_blank" onclick="window.open('http://twitter.com/share?text=<?php echo urlencode(get_the_title($id)); ?>&url=<?php echo urlencode(get_permalink($id)); ?>','twitter-share-dialog','width=626,height=436');return false;"><i class="fa fa-twitter"></i></a></li>
    <?php } ?>
    <?php if(ot_get_option('share_linkedin','on')!='off'){ ?>
    <li><a class="btn btn-default btn-lighter social-icon" href="#" title="<?php esc_html_e('Share on LinkedIn','applay');?>" rel="nofollow" target="_blank" onclick="window.open('http://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(get_permalink($id)); ?>&title=<?php echo urlencode(get_the_title($id)); ?>&source=<?php echo urlencode(get_bloginfo('name')); ?>','linkedin-share-dialog','width=626,height=436');return false;"><i class="fa fa-linkedin"></i></a></li>
    <?php } ?>
    <?php if(ot_get_option('share_tumblr','on')!='off'){ ?>
    <li><a class="btn btn-default btn-lighter social-icon" href="#" title="<?php esc_html_e('Share on Tumblr','applay');?>" rel="nofollow" target="_blank" onclick="window.open('http://www.tumblr.com/share/link?url=<?php echo urlencode(get_permalink($id)); ?>&name=<?php echo urlencode(get_the_title($id)); ?>','tumblr-share-dialog','width=626,height=436');return false;"><i class="fa fa-tumblr"></i></a></li>
    <?php } ?>
    <?php if(ot_get_option('share_google_plus','on')!='off'){ ?>
    <li><a class="btn btn-default btn-lighter social-icon" href="#" title="<?php esc_html_e('Share on Google Plus','applay');?>" rel="nofollow" target="_blank" onclick="window.open('https://plus.google.com/share?url=<?php echo urlencode(get_permalink($id)); ?>','googleplus-share-dialog','width=626,height=436');return false;"><i class="fa fa-google-plus"></i></a></li>
    <?php } ?>
    <?php if(ot_get_option('share_pinterest','on')!='off'){ ?>
    <li><a class="btn btn-default btn-lighter social-icon" href="#" title="<?php esc_html_e('Pin this','applay');?>" rel="nofollow" target="_blank" onclick="window.open('//pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink($id)) ?>&media=<?php echo urlencode(wp_get_attachment_url( get_post_thumbnail_id($id))); ?>&description=<?php echo urlencode(get_the_title($id)) ?>','pin-share-dialog','width=626,height=436');return false;"><i class="fa fa-pinterest"></i></a></li>
    <?php } ?>
    <?php if(ot_get_option('share_email','on')!='off'){ ?>
    <li><a class="btn btn-default btn-lighter social-icon" href="mailto:?subject=<?php echo esc_attr(get_the_title($id)) ?>&body=<?php echo urlencode(get_permalink($id)) ?>" title="<?php esc_html_e('Email this','applay');?>"><i class="fa fa-envelope"></i></a></li>
    <?php } ?>
<?php }
}

//Submit contact form 7 hook
function leafcolor_contactform7_hook($WPCF7_ContactForm) {
	if(ot_get_option('user_submit',1)){
		$submission = WPCF7_Submission::get_instance();
		if($submission) {
			$posted_data = $submission->get_posted_data();
			//error_log(print_r($posted_data, true));
			if(isset($posted_data['store-link-apple']) || isset($posted_data['store-link-google']) || isset($posted_data['app-url'])){
				if(!isset($posted_data['app-url']) && isset($posted_data['store-link-apple'])){
					$app_url = $posted_data['store-link-apple'];
				}else{
					$app_url = $posted_data['app-url'];
					if(strpos($app_url, 'apple.com') !== false){
						$_POST['store-link-apple'] = $app_url;
					}elseif(strpos($app_url, 'google.com') !== false){
						$_POST['store-link-google'] = $app_url;
					}
				}
				$app_title = isset($posted_data['app-title'])?$posted_data['app-title']:'';
				$app_description = isset($posted_data['app-description'])?$posted_data['app-description']:'';
				$app_excerpt = isset($posted_data['app-excerpt'])?$posted_data['app-excerpt']:'';
				$app_user = isset($posted_data['your-email'])?$posted_data['your-email']:'';
				$app_cat = isset($posted_data['cat'])?$posted_data['cat']:'';
				$app_tag = isset($posted_data['tag'])?$posted_data['tag']:'';
				$app_status = ot_get_option('user_submit_status','pending');
				$app_tag = explode(",",$app_tag);
				$app_post = array(
				  'post_content'   => $app_description,
				  'post_excerpt'   => $app_excerpt,
				  'post_name' 	   => sanitize_title($app_title), //slug
				  'post_title'     => $app_title,
				  'post_status'    => $app_status,
				  'post_type'      => 'product'
				);
				if($new_ID = wp_insert_post( $app_post, $wp_error )){
					if(strpos($app_url, 'apple.com') !== false){
						add_post_meta( $new_ID, 'store-link-apple', $app_url );
					}elseif(strpos($app_url, 'google.com') !== false){
						add_post_meta( $new_ID, 'store-link-google', $app_url );
					}elseif(strpos($app_url, 'windowsphone.com') !== false){
						add_post_meta( $new_ID, 'store-link-windows', $app_url );
					}
					if(!ot_get_option('user_submit_fetch',0)){
						$_POST['fetch_data_itunes']='off';
						$_POST['set-post-thumb']='off';
					}
					add_post_meta( $new_ID, 'user_submit', $app_user );
					$app_post['ID'] = $new_ID;
					wp_set_object_terms( $new_ID, $app_cat, 'product_cat' );
					wp_set_object_terms( $new_ID, $app_tag, 'product_tag' );
					wp_update_post( $app_post );
				}
			}
		}//if submission
	}
}
add_action("wpcf7_before_send_mail", "leafcolor_contactform7_hook");

function leafcolor_wpcf7_add_shortco(){
	if(function_exists('wpcf7_add_form_tag')){
		wpcf7_add_form_tag(array('category','category*'), 'leafcolor_catdropdown', true);
	}
}
add_action( 'init', 'leafcolor_wpcf7_add_shortco' );
function leafcolor_catdropdown($tag){
	$class = '';
	$is_required = 0;
	if(class_exists('WPCF7_FormTag')){
		$tag = new WPCF7_FormTag( $tag );
		if ( $tag->is_required() ){
			$is_required = 1;
			$class .= ' required-cat';
		}
	}
	$cargs = array(
		'hide_empty'    => false, 
		'exclude'       => explode(",",ot_get_option('user_submit_cat_exclude',''))
	); 
	$cats = get_terms( 'product_cat', $cargs );
	if($cats){
		$output = '<div class="wpcf7-form-control-wrap cat"><div class="row wpcf7-form-control wpcf7-checkbox wpcf7-validates-as-required'.$class.'">';
		foreach ($cats as $acat){
			$output .= '<label class="col-md-4 wpcf7-list-item"><input type="checkbox" name="cat[]" value="'.$acat->slug.'" /> '.$acat->name.'</label>';
		}
		$output .= '</div></div>';
	}
	ob_start();
	if($is_required){
	?>
    <script>
	jQuery(document).ready(function(e) {
		jQuery("form.wpcf7-form").submit(function (e) {
			var checked = 0;
			jQuery.each(jQuery("input[name='cat[]']:checked"), function() {
				checked = jQuery(this).val();
			});
			if(checked == 0){
				if(jQuery('.cat-alert').length==0){
					jQuery('.wpcf7-form-control-wrap.cat').append('<span role="alert" class="wpcf7-not-valid-tip cat-alert"><?php esc_html_e('Please choose a category','applay') ?>.</span>');
				}
				return false;
			}else{
				return true;
			}
		});
	});
	</script>
	<?php
	}
	$js_string = ob_get_contents();
	ob_end_clean();
	return $output.$js_string;
}

add_action( 'login_enqueue_scripts', 'ia_login_logo' );
function ia_login_logo() {
	if( function_exists('leaf_get_option') && ($img = leaf_get_option('login_logo')) ){
	?>
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo esc_url($img) ?>);
			width: 320px;
			height: 120px;
			background-size:auto;
			background-position:center;
        }
    </style>
<?php }
}