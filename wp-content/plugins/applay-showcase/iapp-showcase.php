<?php
/*
Plugin Name: Applay Showcase
Plugin URI: http://www.leafcolor.com
Description: Applay Showcase plugin
Version: 3.4
Author: LeafColor
Author URI: http://www.leafcolor.com
License: GPL2
*/

define( 'IAS_PATH', plugin_dir_url( __FILE__ ) );

//load option tree for post meta
//include_once ('option-tree/ot-loader.php');

//load plugin option
//require_once ('admin/plugin-options.php');

//template loader
require_once ('iapp-showcase-template-loader.class.php');

//VC shortcode
require_once ('iapp-showcase-shortcode.php');

// Make sure we don't expose any info if called directly
if ( !defined('ABSPATH') ){
	die('-1');
}

class iAppShowcase{ //change this class name
	public function __construct()
    {
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );
		add_action( 'after_setup_theme', array( $this, 'post_meta' ) );
		add_filter( 'the_content', array( $this, 'filter_showcase_content' ));
		add_shortcode( 'iapp_showcase', array( $this, 'shortcode' ) ); //change shortcode name
    }
	
	/*
	 * Load js and css
	 */
	function frontend_scripts(){
		wp_enqueue_style( 'owl-carousel', IAS_PATH.'js/owl-carousel/owl.carousel.css');
		wp_enqueue_style( 'owl-carousel-theme', IAS_PATH.'js/owl-carousel/owl.theme.css');
		wp_enqueue_style('ias-css', IAS_PATH.'style.css');
		wp_enqueue_style('ias-devide', IAS_PATH.'devices/assets/style.css');
		wp_enqueue_style('ias-devide-new', IAS_PATH.'devices/new/devices.min.css');
		$options = $this->get_all_option();
		if($options['no_fontawesome']==0){
			wp_enqueue_style('font-awesome', IAS_PATH.'font-awesome/css/font-awesome.min.css');
		}
		wp_enqueue_script('owl-carousel', IAS_PATH.'js/owl-carousel/owl.carousel.min.js', array('jquery'),1, true );
		wp_enqueue_script('ias-devide-new', IAS_PATH.'devices/new/devices.js', array('jquery'),1, true );
		wp_enqueue_script('ias-js', IAS_PATH.'js/main.js',array('jquery'),1,true);
	}
	
	/*
	 * Setup and do shortcode
	 */
	function shortcode($atts,$content=""){
		//get shortcode parameter
		$atts['id'] = isset($atts['id'])?$atts['id']:1;
		$atts['showcase_id'] = isset($atts['showcase_id'])?$atts['showcase_id']:'';
		//display
		ob_start(); ?>
        <section class="iapp-showcase">
        	<?php require_once ('views/devide_iphone5s.php'); ?>
        </section>
		<?php
		//return
		$output_string=ob_get_contents();
		ob_end_clean();
		return $output_string;
	}
	
	/*
	 * Post type
	 */
	function register_post_type(){
		$labels = array(
			'name'               => 'Showcase',
			'singular_name'      => 'Showcase',
			'add_new'            => 'Add New',
			'add_new_item'       => 'Add New Showcase',
			'edit_item'          => 'Edit Showcase',
			'new_item'           => 'New Showcase',
			'all_items'          => 'All Showcases',
			'view_item'          => 'View Showcase',
			'search_items'       => 'Search Showcase',
			'not_found'          => 'No Showcase found',
			'not_found_in_trash' => 'No Showcase found in Trash',
			'parent_item_colon'  => '',
			'menu_name'          => 'Showcase'
		);
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'menu_icon'			 => 'dashicons-smartphone',
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => false,
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'thumbnail', 'comments')
		);
		register_post_type( 'iapp_showcase', $args );
	}
	/*
	 * Post meta
	 */
	function post_meta(){
		//option tree
		$meta_box = array(
			'id'        => 'ias_meta_box', //change this
			'title'     => 'Showcase options',
			'desc'      => '',
			'pages'     => array( 'iapp_showcase' ),
			'context'   => 'normal',
			'priority'	=> 'high',
			'fields'    => array(
				array(
					'id'          => 'ias_style',
					'label'       => __( 'Style', 'applay' ),
					'desc'        => __( '', 'applay' ),
					'std'         => '',
					'type'        => 'radio-image',
					'section'     => '',
					'rows'        => '',
					'post_type'   => '',
					'taxonomy'    => '',
					'min_max_step'=> '',
					'class'       => '',
					'condition'   => '',
					'choices'     => array(
					  array(
						'value'       => 'listing',
						'label'       => __( 'Listing', 'applay' ),
						'src'         => IAS_PATH.'images/option-listing.png'
					  ),
					  array(
						'value'       => 'hero',
						'label'       => __( 'Hero', 'applay' ),
						'src'         => IAS_PATH.'images/option-hero.png'
					  ),
					  array(
						'value'       => 'features',
						'label'       => __( 'Features Carousel', 'applay' ),
						'src'         => IAS_PATH.'images/option-features.png'
					  ),
					  array(
						'value'       => 'layer',
						'label'       => __( 'Screen Layers', 'applay' ),
						'src'         => IAS_PATH.'images/option-layer.png'
					  )
					)
				),//end ias_style
				//hero
			    array(
					'label'       => 'Devices',
					'id'          => 'hero_devide',
					'type'        => 'list-item',
					'class'       => '',
					'desc'        => __( 'Add device for Hero or Listing section', 'applay' ),
					'condition'	  => 'ias_style:is(hero),ias_style:is(listing)',
					'operator'	  => 'or',
					'choices'     => array(),
					'settings'    => array(
						array(
							'label'       => __( 'Device', 'applay' ),
							'id'          => 'devide',
							'type'        => 'select',
							'desc'        => '',
							'std'         => '',
							'rows'        => '',
							'post_type'   => '',
							'taxonomy'    => '',
							'choices'     => array(
								array(
									'value'       => 'iphonex',
									'label'       => __( 'iPhone X', 'applay' ),
									'src'         => ''
								),
								array(
									'value'       => 'galaxynote8',
									'label'       => __( 'Galaxy Note 8', 'applay' ),
									'src'         => ''
								),
								array(
									'value'       => 'iphone6',
									'label'       => __( 'iPhone 6', 'applay' ),
									'src'         => ''
								),
								array(
									'value'       => 'iphone6plus',
									'label'       => __( 'iPhone 6 Plus', 'applay' ),
									'src'         => ''
								),
								array(
									'value'       => 'iphone5s',
									'label'       => __( 'iPhone 5S', 'applay' ),
									'src'         => ''
								),
								array(
									'value'       => 'iphone5c',
									'label'       => __( 'iPhone 5C', 'applay' ),
									'src'         => ''
								),
								array(
									'value'       => 'iphone4s',
									'label'       => __( 'iPhone 4S', 'applay' ),
									'src'         => ''
								),
								array(
									'value'       => 'nexus5',
									'label'       => __( 'Nexus 5', 'applay' ),
									'src'         => ''
								),
								array(
									'value'       => 'lumia920',
									'label'       => __( 'Lumia 920', 'applay' ),
									'src'         => ''
								),
								array(
									'value'       => 'galaxys5',
									'label'       => __( 'Galaxy S5', 'applay' ),
									'src'         => ''
								),
								array(
									'value'       => 'htcone',
									'label'       => __( 'HTC One', 'applay' ),
									'src'         => ''
								),
								array(
									'value'       => 'ipadmini',
									'label'       => __( 'iPad Mini', 'applay' ),
									'src'         => ''
								),
								array(
									'value'       => 'macbookair',
									'label'       => __( 'Macbook Air', 'applay' ),
									'src'         => ''
								),
								array(
									'value'       => 'macbookpro',
									'label'       => __( 'Macbook Pro', 'applay' ),
									'src'         => ''
								),
								array(
									'value'       => 'applewatch',
									'label'       => __( 'Apple Watch', 'applay' ),
									'src'         => ''
								),
							),
						),//end devide
						//color
						array(
							'id'          => 'devide_color_iphone6',
							'label'       => __( 'Device color', 'applay' ),
							'desc'        => __( 'Choose device\'s color style', 'applay' ),
							'std'         => 'silver',
							'type'        => 'radio-image',
							'condition'   => 'devide:is(iphone6)',
							'choices'     => array(
							  array(
								'value'       => 'silver',
								'label'       => __( 'Silver', 'applay' ),
								'src'         => IAS_PATH.'/images/white.png'
							  ),
							  array(
								'value'       => 'black',
								'label'       => __( 'Black', 'applay' ),
								'src'         => IAS_PATH.'/images/black.png'
							  ),
							  array(
								'value'       => 'gold',
								'label'       => __( 'Gold', 'applay' ),
								'src'         => IAS_PATH.'/images/gold.png'
							  )
							)
						),//end features 6 color
						//color
						array(
							'id'          => 'devide_color_iphone6plus',
							'label'       => __( 'Device color', 'applay' ),
							'desc'        => __( 'Choose device\'s color style', 'applay' ),
							'std'         => 'silver',
							'type'        => 'radio-image',
							'condition'   => 'devide:is(iphone6plus)',
							'choices'     => array(
							  array(
								'value'       => 'silver',
								'label'       => __( 'Silver', 'applay' ),
								'src'         => IAS_PATH.'/images/white.png'
							  ),
							  array(
								'value'       => 'black',
								'label'       => __( 'Black', 'applay' ),
								'src'         => IAS_PATH.'/images/black.png'
							  ),
							  array(
								'value'       => 'gold',
								'label'       => __( 'Gold', 'applay' ),
								'src'         => IAS_PATH.'/images/gold.png'
							  )
							)
						),//end features 6 color
						array(
							'id'          => 'devide_color_iphone5s',
							'label'       => __( 'Device color', 'applay' ),
							'desc'        => __( 'Choose device\'s color style', 'applay' ),
							'std'         => 'silver',
							'type'        => 'radio-image',
							'condition'   => 'devide:is(iphone5s)',
							'choices'     => array(
							  array(
								'value'       => 'silver',
								'label'       => __( 'Silver', 'applay' ),
								'src'         => IAS_PATH.'/images/white.png'
							  ),
							  array(
								'value'       => 'black',
								'label'       => __( 'Black', 'applay' ),
								'src'         => IAS_PATH.'/images/black.png'
							  ),
							  array(
								'value'       => 'gold',
								'label'       => __( 'Gold', 'applay' ),
								'src'         => IAS_PATH.'/images/gold.png'
							  )
							)
						),//end features 5s color
						array(
							'id'          => 'devide_color_iphone5c',
							'label'       => __( 'Device color', 'applay' ),
							'desc'        => __( 'Choose device\'s color style', 'applay' ),
							'std'         => 'green',
							'type'        => 'radio-image',
							'condition'   => 'devide:is(iphone5c)',
							'choices'     => array(
							  array(
								'value'       => 'green',
								'label'       => __( 'Green', 'applay' ),
								'src'         => IAS_PATH.'/images/green.png'
							  ),
							  array(
								'value'       => 'white',
								'label'       => __( 'White', 'applay' ),
								'src'         => IAS_PATH.'/images/white.png'
							  ),
							  array(
								'value'       => 'red',
								'label'       => __( 'Red', 'applay' ),
								'src'         => IAS_PATH.'/images/red.png'
							  ),
							  array(
								'value'       => 'yellow',
								'label'       => __( 'Yellow', 'applay' ),
								'src'         => IAS_PATH.'/images/yellow.png'
							  ),
							  array(
								'value'       => 'blue',
								'label'       => __( 'Blue', 'applay' ),
								'src'         => IAS_PATH.'/images/blue.png'
							  )
							)
						),//end features 5c color
						array(
							'id'          => 'devide_color_lumia920',
							'label'       => __( 'Device color', 'applay' ),
							'desc'        => __( 'Choose device\'s color style', 'applay' ),
							'std'         => 'yellow',
							'type'        => 'radio-image',
							'condition'   => 'devide:is(lumia920)',
							'choices'     => array(
							  array(
								'value'       => 'black',
								'label'       => __( 'Black', 'applay' ),
								'src'         => IAS_PATH.'/images/black.png'
							  ),
							  array(
								'value'       => 'white',
								'label'       => __( 'White', 'applay' ),
								'src'         => IAS_PATH.'/images/white.png'
							  ),
							  array(
								'value'       => 'yellow',
								'label'       => __( 'Yellow', 'applay' ),
								'src'         => IAS_PATH.'/images/yellow.png'
							  ),
							  array(
								'value'       => 'red',
								'label'       => __( 'Red', 'applay' ),
								'src'         => IAS_PATH.'/images/red.png'
							  ),
							  array(
								'value'       => 'blue',
								'label'       => __( 'Blue', 'applay' ),
								'src'         => IAS_PATH.'/images/blue.png'
							  )
							)
						),//end features lumia color
						array(
							'id'          => 'devide_color_ipadmini',
							'label'       => __( 'Device color', 'applay' ),
							'desc'        => __( 'Choose device\'s color style', 'applay' ),
							'std'         => 'silver',
							'type'        => 'radio-image',
							'condition'   => 'devide:is(ipadmini)',
							'choices'     => array(
							  array(
								'value'       => 'silver',
								'label'       => __( 'Silver', 'applay' ),
								'src'         => IAS_PATH.'/images/white.png'
							  ),
							  array(
								'value'       => 'black',
								'label'       => __( 'Black', 'applay' ),
								'src'         => IAS_PATH.'/images/black.png'
							  )
							)
						),//end features ipadmini color
						array(
							'id'          => 'devide_color_iphone4s',
							'label'       => __( 'Device color', 'applay' ),
							'desc'        => __( 'Choose device\'s color style', 'applay' ),
							'std'         => 'silver',
							'type'        => 'radio-image',
							'condition'   => 'devide:is(iphone4s)',
							'choices'     => array(
							  array(
								'value'       => 'silver',
								'label'       => __( 'Silver', 'applay' ),
								'src'         => IAS_PATH.'/images/white.png'
							  ),
							  array(
								'value'       => 'black',
								'label'       => __( 'Black', 'applay' ),
								'src'         => IAS_PATH.'/images/black.png'
							  )
							)
						),//end features 4s color
						array(
							'id'          => 'devide_color_galaxys5',
							'label'       => __( 'Device color', 'applay' ),
							'desc'        => __( 'Choose device\'s color style', 'applay' ),
							'std'         => 'white',
							'type'        => 'radio-image',
							'condition'   => 'devide:is(galaxys5)',
							'choices'     => array(
							  array(
								'value'       => 'white',
								'label'       => __( 'White', 'applay' ),
								'src'         => IAS_PATH.'/images/white.png'
							  ),
							  array(
								'value'       => 'black',
								'label'       => __( 'Black', 'applay' ),
								'src'         => IAS_PATH.'/images/black.png'
							  )
							)
						),//end features s5 color
						array(
							'id'          => 'orientation',
							'label'       => __( 'Device Screen Orientation', 'applay' ),
							'desc'        => __( 'Not affect on some devices', 'applay' ),
							'std'         => '',
							'type'        => 'radio-image',
							//'condition'	  => 'ias_style:is(hero),ias_style:is(listing)',
							'operator'	  => 'or',
							'choices'     => array(
							  array(
								'value'       => 0,
								'label'       => __( 'Portrait', 'applay' ),
								'src'         => IAS_PATH.'/images/orientation-1.png'
							  ),
							  array(
								'value'       => 1,
								'label'       => __( 'Landscape', 'applay' ),
								'src'         => IAS_PATH.'/images/orientation-2.png'
							  )
							)
						),//end hero orientation
						array(
							'label'       => __( 'Screen Content', 'applay' ),
							'id'          => 'content',
							'type'        => 'select',
							'desc'        => __( 'Choose Screen Content', 'applay' ),
							'std'         => '',
							'rows'        => '',
							'choices'     => array(
								array(
									'value'       => 'image',
									'label'       => __( 'Single Image', 'applay' ),
									'src'         => ''
								),
								array(
									'value'       => 'carousel',
									'label'       => __( 'Images Carousel', 'applay' ),
									'src'         => ''
								),
								array(
									'value'       => 'iframe',
									'label'       => __( 'Iframe', 'applay' ),
									'src'         => ''
								),
								array(
									'value'       => 'text',
									'label'       => __( 'Custom Content text', 'applay' ),
									'src'         => ''
								),
							)
						),//end content
						array(
							'label'       => __( 'Image', 'applay' ),
							'id'          => 'content_image',
							'type'        => 'upload',
							'desc'        => '',
							'std'         => '',
							'rows'        => '',
							'condition'	  => 'content:is(image)',
							'choices'     => array()
						),//end image
						array(
							'label'       => __( 'Carousel', 'applay' ),
							'id'          => 'content_carousel',
							'type'        => 'gallery',
							'desc'        => __( 'Create gallery images for carousel', 'applay' ),
							'std'         => '',
							'rows'        => '',
							'condition'	  => 'content:is(carousel)',
							'choices'     => array()
						),//end gallery
						array(
							'label'       => __( 'Carousel Autoplay Timeout', 'applay' ),
							'id'          => 'content_carousel_autoplay',
							'type'        => 'text',
							'desc'        => __( 'Enter miliseconds timeout for autoplay. (Default is 6000, enter 0 for no auto)', 'applay' ),
							'std'         => '',
							'rows'        => '',
							'condition'	  => 'content:is(carousel)',
							'choices'     => array()
						),//end autoplay
						array(
							'label'       => __( 'Iframe URL', 'applay' ),
							'id'          => 'content_iframe',
							'type'        => 'text',
							'desc'        => __( 'Enter iframe URL', 'applay' ),
							'std'         => '',
							'rows'        => '',
							'condition'	  => 'content:is(iframe)',
							'choices'     => array()
						),//end iframe
						array(
							'label'       => __( 'Custom Content Text', 'applay' ),
							'id'          => 'content_text',
							'type'        => 'textarea',
							'desc'        => __( '', 'applay' ),
							'std'         => '',
							'rows'        => '8',
							'condition'	  => 'content:is(text)',
							'choices'     => array()
						),//end text
						array(
							'label'       => __( 'URL', 'applay' ),
							'id'          => 'devide_url',
							'type'        => 'text',
							'desc'        => __( 'Destination URL when click on device content', 'applay' ),
							'std'         => '',
							'rows'        => '',
							'condition'	  => '',
							'choices'     => array()
						),//end url
					),
				),//end hero_devide
				//features carousel
				array(
					'label'       => __( 'Device', 'applay' ),
					'id'          => 'features_devide',
					'type'        => 'select',
					'desc'        => __( 'Choose device to display features carousel', 'applay' ),
					'std'         => '',
					'rows'        => '',
					'post_type'   => '',
					'taxonomy'    => '',
					'condition'	  => 'ias_style:is(features)',
					'choices'     => array(
						array(
							'value'       => 'iphonex',
							'label'       => __( 'iPhone X', 'applay' ),
							'src'         => ''
						),
						array(
							'value'       => 'galaxynote8',
							'label'       => __( 'Galaxy Note 8', 'applay' ),
							'src'         => ''
						),
						array(
							'value'       => 'iphone6',
							'label'       => __( 'iPhone 6', 'applay' ),
							'src'         => ''
						),
						array(
							'value'       => 'iphone6plus',
							'label'       => __( 'iPhone 6 Plus', 'applay' ),
							'src'         => ''
						),
						array(
							'value'       => 'iphone5s',
							'label'       => __( 'iPhone 5S', 'applay' ),
							'src'         => ''
						),
						array(
							'value'       => 'iphone5c',
							'label'       => __( 'iPhone 5C', 'applay' ),
							'src'         => ''
						),
						array(
							'value'       => 'iphone4s',
							'label'       => __( 'iPhone 4S', 'applay' ),
							'src'         => ''
						),
						array(
							'value'       => 'nexus5',
							'label'       => __( 'Nexus 5', 'applay' ),
							'src'         => ''
						),
						array(
							'value'       => 'lumia920',
							'label'       => __( 'Lumia 920', 'applay' ),
							'src'         => ''
						),
						array(
							'value'       => 'galaxys5',
							'label'       => __( 'Galaxy S5', 'applay' ),
							'src'         => ''
						),
						array(
							'value'       => 'htcone',
							'label'       => __( 'HTC One', 'applay' ),
							'src'         => ''
						),
						array(
							'value'       => 'ipadmini',
							'label'       => __( 'iPad Mini', 'applay' ),
							'src'         => ''
						),
						array(
							'value'       => 'macbookair',
							'label'       => __( 'Macbook Air', 'applay' ),
							'src'         => ''
						),
						array(
							'value'       => 'macbookpro',
							'label'       => __( 'Macbook Pro', 'applay' ),
							'src'         => ''
						),
						array(
							'value'       => 'applewatch',
							'label'       => __( 'Apple Watch', 'applay' ),
							'src'         => ''
						),
					),
				),//end features devide
				array(
					'id'          => 'features_devide_color_iphone6',
					'label'       => __( 'Device color', 'applay' ),
					'desc'        => __( 'Choose device\'s color style', 'applay' ),
					'std'         => 'silver',
					'type'        => 'radio-image',
					'section'     => '',
					'class'       => '',
					'condition'   => 'features_devide:is(iphone6),ias_style:is(features)',
					'choices'     => array(
					  array(
						'value'       => 'silver',
						'label'       => __( 'Silver', 'applay' ),
						'src'         => IAS_PATH.'/images/white.png'
					  ),
					  array(
						'value'       => 'black',
						'label'       => __( 'Black', 'applay' ),
						'src'         => IAS_PATH.'/images/black.png'
					  ),
					  array(
						'value'       => 'gold',
						'label'       => __( 'Gold', 'applay' ),
						'src'         => IAS_PATH.'/images/gold.png'
					  )
					)
				),//end features 6 color
				array(
					'id'          => 'features_devide_color_iphone6plus',
					'label'       => __( 'Device color', 'applay' ),
					'desc'        => __( 'Choose device\'s color style', 'applay' ),
					'std'         => 'silver',
					'type'        => 'radio-image',
					'section'     => '',
					'class'       => '',
					'condition'   => 'features_devide:is(iphone6plus),ias_style:is(features)',
					'choices'     => array(
					  array(
						'value'       => 'silver',
						'label'       => __( 'Silver', 'applay' ),
						'src'         => IAS_PATH.'/images/white.png'
					  ),
					  array(
						'value'       => 'black',
						'label'       => __( 'Black', 'applay' ),
						'src'         => IAS_PATH.'/images/black.png'
					  ),
					  array(
						'value'       => 'gold',
						'label'       => __( 'Gold', 'applay' ),
						'src'         => IAS_PATH.'/images/gold.png'
					  )
					)
				),//end features 6 color
				array(
					'id'          => 'features_devide_color_iphone5s',
					'label'       => __( 'Device color', 'applay' ),
					'desc'        => __( 'Choose device\'s color style', 'applay' ),
					'std'         => 'silver',
					'type'        => 'radio-image',
					'section'     => '',
					'class'       => '',
					'condition'   => 'features_devide:is(iphone5s),ias_style:is(features)',
					'choices'     => array(
					  array(
						'value'       => 'silver',
						'label'       => __( 'Silver', 'applay' ),
						'src'         => IAS_PATH.'/images/white.png'
					  ),
					  array(
						'value'       => 'black',
						'label'       => __( 'Black', 'applay' ),
						'src'         => IAS_PATH.'/images/black.png'
					  ),
					  array(
						'value'       => 'gold',
						'label'       => __( 'Gold', 'applay' ),
						'src'         => IAS_PATH.'/images/gold.png'
					  )
					)
				),//end features 5s color
				array(
					'id'          => 'features_devide_color_iphone5c',
					'label'       => __( 'Device color', 'applay' ),
					'desc'        => __( 'Choose device\'s color style', 'applay' ),
					'std'         => 'green',
					'type'        => 'radio-image',
					'condition'   => 'features_devide:is(iphone5c),ias_style:is(features)',
					'choices'     => array(
					  array(
						'value'       => 'green',
						'label'       => __( 'Green', 'applay' ),
						'src'         => IAS_PATH.'/images/green.png'
					  ),
					  array(
						'value'       => 'white',
						'label'       => __( 'White', 'applay' ),
						'src'         => IAS_PATH.'/images/white.png'
					  ),
					  array(
						'value'       => 'red',
						'label'       => __( 'Red', 'applay' ),
						'src'         => IAS_PATH.'/images/red.png'
					  ),
					  array(
						'value'       => 'yellow',
						'label'       => __( 'Yellow', 'applay' ),
						'src'         => IAS_PATH.'/images/yellow.png'
					  ),
					  array(
						'value'       => 'blue',
						'label'       => __( 'Blue', 'applay' ),
						'src'         => IAS_PATH.'/images/blue.png'
					  )
					)
				),//end features 5c color
				array(
					'id'          => 'features_devide_color_lumia920',
					'label'       => __( 'Device color', 'applay' ),
					'desc'        => __( 'Choose device\'s color style', 'applay' ),
					'std'         => 'yellow',
					'type'        => 'radio-image',
					'condition'   => 'features_devide:is(lumia920),ias_style:is(features)',
					'choices'     => array(
					  array(
						'value'       => 'black',
						'label'       => __( 'Black', 'applay' ),
						'src'         => IAS_PATH.'/images/black.png'
					  ),
					  array(
						'value'       => 'white',
						'label'       => __( 'White', 'applay' ),
						'src'         => IAS_PATH.'/images/white.png'
					  ),
					  array(
						'value'       => 'yellow',
						'label'       => __( 'Yellow', 'applay' ),
						'src'         => IAS_PATH.'/images/yellow.png'
					  ),
					  array(
						'value'       => 'red',
						'label'       => __( 'Red', 'applay' ),
						'src'         => IAS_PATH.'/images/red.png'
					  ),
					  array(
						'value'       => 'blue',
						'label'       => __( 'Blue', 'applay' ),
						'src'         => IAS_PATH.'/images/blue.png'
					  )
					)
				),//end features lumia color
				array(
					'id'          => 'features_devide_color_ipadmini',
					'label'       => __( 'Device color', 'applay' ),
					'desc'        => __( 'Choose device\'s color style', 'applay' ),
					'std'         => 'silver',
					'type'        => 'radio-image',
					'condition'   => 'features_devide:is(ipadmini),ias_style:is(features)',
					'choices'     => array(
					  array(
						'value'       => 'silver',
						'label'       => __( 'Silver', 'applay' ),
						'src'         => IAS_PATH.'/images/white.png'
					  ),
					  array(
						'value'       => 'black',
						'label'       => __( 'Black', 'applay' ),
						'src'         => IAS_PATH.'/images/black.png'
					  )
					)
				),//end features ipadmini color
				array(
					'id'          => 'features_devide_color_iphone4s',
					'label'       => __( 'Device color', 'applay' ),
					'desc'        => __( 'Choose device\'s color style', 'applay' ),
					'std'         => 'silver',
					'type'        => 'radio-image',
					'condition'   => 'features_devide:is(iphone4s),ias_style:is(features)',
					'choices'     => array(
					  array(
						'value'       => 'silver',
						'label'       => __( 'Silver', 'applay' ),
						'src'         => IAS_PATH.'/images/white.png'
					  ),
					  array(
						'value'       => 'black',
						'label'       => __( 'Black', 'applay' ),
						'src'         => IAS_PATH.'/images/black.png'
					  )
					)
				),//end features 4s color
				array(
					'id'          => 'features_devide_color_galaxys5',
					'label'       => __( 'Device color', 'applay' ),
					'desc'        => __( 'Choose device\'s color style', 'applay' ),
					'std'         => 'white',
					'type'        => 'radio-image',
					'condition'   => 'features_devide:is(galaxys5),ias_style:is(features)',
					'choices'     => array(
					  array(
						'value'       => 'white',
						'label'       => __( 'White', 'applay' ),
						'src'         => IAS_PATH.'/images/white.png'
					  ),
					  array(
						'value'       => 'black',
						'label'       => __( 'Black', 'applay' ),
						'src'         => IAS_PATH.'/images/black.png'
					  )
					)
				),//end features s5 color
				array(
					'id'          => 'features_orientation',
					'label'       => __( 'Device Screen Orientation', 'applay' ),
					'desc'        => __( 'Not affect on some devices', 'applay' ),
					'std'         => '',
					'type'        => 'radio-image',
					'condition'   => 'ias_style:is(features), features_devide:not(macbookair), features_devide:not(macbookpro)',
					'operator'    => 'and',
					'choices'     => array(
					  array(
						'value'       => 0,
						'label'       => __( 'Portrait', 'applay' ),
						'src'         => IAS_PATH.'/images/orientation-1.png'
					  ),
					  array(
						'value'       => 1,
						'label'       => __( 'Landscape', 'applay' ),
						'src'         => IAS_PATH.'/images/orientation-2.png'
					  )
					)
				),//end orientation
				array(
					'label'       => __( 'Autoplay Timeout', 'applay' ),
					'id'          => 'features_autoplay',
					'type'        => 'text',
					'desc'        => __( 'Enter miliseconds timeout for autoplay. (Default is 3500, enter 0 for no auto)', 'applay' ),
					'std'         => '',
					'rows'        => '',
					'condition'	  => 'ias_style:is(features)',
					'choices'     => array()
				),//end autoplay
				array(
					'label'       => 'Screen Items',
					'id'          => 'screen_item',
					'type'        => 'list-item',
					'class'       => '',
					'desc'        => __( 'Add Screen Item for Features Carousel or Screen Layers section', 'applay' ),
					'condition'	  => 'ias_style:is(features),ias_style:is(layer)',
					'operator'	  => 'or',
					'choices'     => array(),
					'settings'    => array(
						array(
							'label'       => __( 'Feature Icon', 'applay' ),
							'id'          => 'feature_icon',
							'type'        => 'text',
							'desc'        => __( 'Enter Font Awesome icon class (Ex: fa-star) (Only used for Features Carousel)', 'applay' ),
							'std'         => '',
							'rows'        => '',
							//'condition'	  => 'ias_style:is(features)',
							'choices'     => array()
						),//end feature_icon
						array(
							'label'       => __( 'Feature Description', 'applay' ),
							'id'          => 'feature_description',
							'type'        => 'textarea',
							'desc'        => __( 'Enter Feature\'s Description (Only used for Features Carousel)', 'applay' ),
							'std'         => '',
							'rows'        => '',
							//'condition'	  => 'ias_style:is(features)',
							'choices'     => array()
						),//end feature_text
						array(
							'label'       => __( 'Screen Image', 'applay' ),
							'id'          => 'screen_image',
							'type'        => 'upload',
							'desc'        => '',
							'std'         => '',
							'rows'        => '',
							'post_type'   => '',
							'taxonomy'    => '',
							'choices'     => array(),
						),//end screen image
						array(
							'label'       => __( 'URL', 'applay' ),
							'id'          => 'screen_url',
							'type'        => 'text',
							'desc'        => __( 'Destination URL when click on screen (Optional)', 'applay' ),
							'std'         => '',
							'rows'        => '',
							'condition'	  => '',
							'choices'     => array()
						),//end url
					),
				),//end features item
		  	)
		);
		if (function_exists('ot_register_meta_box')) {
			ot_register_meta_box( $meta_box );
		}
	}
	/*
	 *
	 */
	function filter_showcase_content($content) {
		if( is_singular('iapp_showcase') ) {
			ob_start();
				require('views/single.php');
            //return
            $output_string = ob_get_contents();
			$content = $output_string.$content;	
			ob_end_clean();
		}
		return $content;
	}
	/*
	 * Get all plugin options
	 */
	function get_all_option(){
		$options = get_option('ias_options_group');
		$options['no_fontawesome'] = isset($options['load_fontawesome'])?$options['no_fontawesome']:0;
		return $options;
	}
	/*devide*/
	static function ias_devide($devide_item){
		global $global_devide_item;
		$global_devide_item = $devide_item;
		$devide = $devide_item['devide']?$devide_item['devide']:'iphone5s';
		if($devide == 'def_themeoption'){
			if(function_exists('ot_get_option')){
				$devide = ot_get_option('devide','iphone5s');
			}else{
				$devide = 'iphone5s';
			}
			
		}
		global $global_devide_item_count;
		$global_devide_item_count = $global_devide_item_count?$global_devide_item_count:0;
		$global_devide_item_count++;
		$new_devide = 0;
		if(in_array($devide,array('iphone6','iphone6plus','macbookair','macbookpro','applewatch'))){
			$new_devide = 1;
		}
		ob_start(); ?>
        	<div class="ias-devide-wrap ias-devide-<?php echo $global_devide_item_count; echo $new_devide?' ias-new-devide':'' ?>">
        		<?php require('views/devide_'.$devide.'.php'); ?>
            </div>
		<?php
		$output_string = ob_get_contents();
		ob_end_clean();
		return $output_string;
	}
	static function ias_devide_content($devide_item){
		global $global_devide_item;
		$global_devide_item = $devide_item;
		$devide_content = $devide_item['content']?$devide_item['content']:'image';
		ob_start();
			require('views/devide_content_'.$devide_content.'.php');
		$output_string = ob_get_contents();
		ob_end_clean();
		return $output_string;
	}
}
$iAppShowcase = new iAppShowcase();