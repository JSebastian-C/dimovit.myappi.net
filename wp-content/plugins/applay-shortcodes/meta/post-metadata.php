<?php
/**
 * Initialize the meta boxes. 
 */
add_action( 'admin_init', 'ia_post_meta_boxes' );
if ( ! function_exists( 'ia_post_meta_boxes' ) ){
	function ia_post_meta_boxes() {
	  $theme_uri = get_template_directory_uri();
	  //layout
	  $meta_box = array(
		'id'        => 'page_layout',
		'title'     => 'Layout settings',
		'desc'      => '',
		'pages'     => array( 'post' ),
		'context'   => 'normal',
		'priority'  => 'high',
		'fields'    => array(
			array(
			  'id'          => 'sidebar_layout',
			  'label'       => esc_html__('Sidebar','applay'),
			  'desc'        => esc_html__('Select "Default" to use settings in Theme Options','applay'),
			  'std'         => '',
			  'type'        => 'radio-image',
			  'class'       => '',
			  'choices'     => array(
				  array(
					'value'       => '',
					'label'       => 'Default',
					'src'         => $theme_uri.'/images/options/layout-default.png'
				  ),
				  array(
					'value'       => 'right',
					'label'       => 'Sidebar Right',
					'src'         => $theme_uri.'/images/options/layout-right.png'
				  ),
				  array(
					'value'       => 'left',
					'label'       => 'Sidebar Left',
					'src'         => $theme_uri.'/images/options/layout-left.png'
				  ),
				  array(
					'value'       => 'full',
					'label'       => 'Hidden',
					'src'         => $theme_uri.'/images/options/layout-full.png'
				  ),
			   )
			),
			array(
			  'id'          => 'content_padding',
			  'label'       => esc_html__('Content Padding','applay'),
			  'desc'        => esc_html__('Enable default top and bottom padding for content (30px)','applay'),
			  'std'         => 'on',
			  'type'        => 'on-off',
			  'class'       => '',
			  'choices'     => array()
			),
		 )
		);
	  
	  if (function_exists('ot_register_meta_box')) {
		  ot_register_meta_box( $meta_box );
	  }
	}
}
add_action( 'admin_init', 'ia_product_meta_boxes' );
if ( ! function_exists( 'ia_product_meta_boxes' ) ){
	function ia_product_meta_boxes() {
		$theme_uri = get_template_directory_uri();
		//app
		$meta_box_app = array(
		'id'        => 'product_app',
		'title'     => 'App settings',
		'desc'      => '',
		'pages'     => array( 'product','app_portfolio' ),
		'context'   => 'normal',
		'priority'  => 'high',
		'fields'    => array(
			array(
			  'id'          => 'app-icon',
			  'label'       => esc_html__('Icon','applay'),
			  'desc'        => esc_html__('Upload App Icon','applay'),
			  'std'         => '',
			  'type'        => 'upload',
			  'class'       => '',
			  'choices'     => array()
			),
			array(
			  'id'          => 'app-banner',
			  'label'       => esc_html__('Header Banner','applay'),
			  'desc'        => esc_html__('Upload App Banner Image','applay'),
			  'std'         => '',
			  'type'        => 'upload',
			  'class'       => '',
			  'choices'     => array()
			),
			array(
			  'id'          => 'banner-darkness',
			  'label'       => esc_html__('Header Banner Darkness (Optional)','applay'),
			  'desc'        => esc_html__('Adjust Banner Darkness level % (To make title readable)','applay'),
			  'std'         => '0',
			  'type'        => 'numeric-slider',
			  'class'       => '',
			  'min_max_step'=> '0,100,5',
			  'choices'     => array()
			),
			//devide
			array(
				'label'       => esc_html__( 'Device for displaying Screenshots', 'applay' ),
				'id'          => 'devide',
				'type'        => 'select',
				'desc'        => '',
				'std'         => '',
				'choices'     => array(
					array(
						'value'       => 'def_themeoption',
						'label'       => esc_html__( 'Default theme options', 'applay' ),
						'src'         => ''
					),
					array(
						'value'       => 'def',
						'label'       => esc_html__( 'Default Gallery', 'applay' ),
						'src'         => ''
					),
					array(
						'value'       => 'iphone6',
						'label'       => esc_html__( 'iPhone 6', 'applay' ),
						'src'         => ''
					),
					array(
						'value'       => 'iphone6plus',
						'label'       => esc_html__( 'iPhone 6 Plus', 'applay' ),
						'src'         => ''
					),
					array(
						'value'       => 'iphone5s',
						'label'       => esc_html__( 'iPhone 5S', 'applay' ),
						'src'         => ''
					),
					array(
						'value'       => 'iphone5c',
						'label'       => esc_html__( 'iPhone 5C', 'applay' ),
						'src'         => ''
					),
					array(
						'value'       => 'iphone4s',
						'label'       => esc_html__( 'iPhone 4S', 'applay' ),
						'src'         => ''
					),
					array(
						'value'       => 'nexus5',
						'label'       => esc_html__( 'Nexus 5', 'applay' ),
						'src'         => ''
					),
					array(
						'value'       => 'lumia920',
						'label'       => esc_html__( 'Lumia 920', 'applay' ),
						'src'         => ''
					),
					array(
						'value'       => 'galaxys5',
						'label'       => esc_html__( 'Galaxy S5', 'applay' ),
						'src'         => ''
					),
					array(
						'value'       => 'htcone',
						'label'       => esc_html__( 'HTC One', 'applay' ),
						'src'         => ''
					),
					array(
						'value'       => 'ipadmini',
						'label'       => esc_html__( 'iPad Mini', 'applay' ),
						'src'         => ''
					),
					array(
						'value'       => 'macbookair',
						'label'       => esc_html__( 'Macbook Air', 'applay' ),
						'src'         => ''
					),
					array(
						'value'       => 'macbookpro',
						'label'       => esc_html__( 'Macbook Pro', 'applay' ),
						'src'         => ''
					),
					array(
						'value'       => 'applewatch',
						'label'       => esc_html__( 'Apple Watch', 'applay' ),
						'src'         => ''
					),
				),
			),//end devide
			//color
			array(
				'id'          => 'devide_color_iphone6',
				'label'       => esc_html__( 'Device color', 'applay' ),
				'desc'        => esc_html__( 'Choose device\'s color style', 'applay' ),
				'std'         => 'silver',
				'type'        => 'radio-image',
				'condition'   => 'devide:is(iphone6)',
				'choices'     => array(
				  array(
					'value'       => 'silver',
					'label'       => esc_html__( 'Silver', 'applay' ),
					'src'         => $theme_uri.'/images/options/white.png'
				  ),
				  array(
					'value'       => 'black',
					'label'       => esc_html__( 'Black', 'applay' ),
					'src'         => $theme_uri.'/images/options/black.png'
				  ),
				  array(
					'value'       => 'gold',
					'label'       => esc_html__( 'Gold', 'applay' ),
					'src'         => $theme_uri.'/images/options/gold.png'
				  )
				)
			),//end features 6 color
			//color
			array(
				'id'          => 'devide_color_iphone6plus',
				'label'       => esc_html__( 'Device color', 'applay' ),
				'desc'        => esc_html__( 'Choose device\'s color style', 'applay' ),
				'std'         => 'silver',
				'type'        => 'radio-image',
				'condition'   => 'devide:is(iphone6plus)',
				'choices'     => array(
				  array(
					'value'       => 'silver',
					'label'       => esc_html__( 'Silver', 'applay' ),
					'src'         => $theme_uri.'/images/options/white.png'
				  ),
				  array(
					'value'       => 'black',
					'label'       => esc_html__( 'Black', 'applay' ),
					'src'         => $theme_uri.'/images/options/black.png'
				  ),
				  array(
					'value'       => 'gold',
					'label'       => esc_html__( 'Gold', 'applay' ),
					'src'         => $theme_uri.'/images/options/gold.png'
				  )
				)
			),//end features 6 color
			array(
				'id'          => 'devide_color_iphone5s',
				'label'       => esc_html__( 'Device color', 'applay' ),
				'desc'        => esc_html__( 'Choose device\'s color style', 'applay' ),
				'std'         => 'silver',
				'type'        => 'radio-image',
				'condition'   => 'devide:is(iphone5s)',
				'choices'     => array(
				  array(
					'value'       => 'silver',
					'label'       => esc_html__( 'Silver', 'applay' ),
					'src'         => $theme_uri.'/images/options/white.png'
				  ),
				  array(
					'value'       => 'black',
					'label'       => esc_html__( 'Black', 'applay' ),
					'src'         => $theme_uri.'/images/options/black.png'
				  ),
				  array(
					'value'       => 'gold',
					'label'       => esc_html__( 'Gold', 'applay' ),
					'src'         => $theme_uri.'/images/options/gold.png'
				  )
				)
			),//end features 5s color
			array(
				'id'          => 'devide_color_iphone5c',
				'label'       => esc_html__( 'Device color', 'applay' ),
				'desc'        => esc_html__( 'Choose device\'s color style', 'applay' ),
				'std'         => 'green',
				'type'        => 'radio-image',
				'condition'   => 'devide:is(iphone5c)',
				'choices'     => array(
				  array(
					'value'       => 'green',
					'label'       => esc_html__( 'Green', 'applay' ),
					'src'         => $theme_uri.'/images/options/green.png'
				  ),
				  array(
					'value'       => 'white',
					'label'       => esc_html__( 'White', 'applay' ),
					'src'         => $theme_uri.'/images/options/white.png'
				  ),
				  array(
					'value'       => 'red',
					'label'       => esc_html__( 'Red', 'applay' ),
					'src'         => $theme_uri.'/images/options/red.png'
				  ),
				  array(
					'value'       => 'yellow',
					'label'       => esc_html__( 'Yellow', 'applay' ),
					'src'         => $theme_uri.'/images/options/yellow.png'
				  ),
				  array(
					'value'       => 'blue',
					'label'       => esc_html__( 'Blue', 'applay' ),
					'src'         => $theme_uri.'/images/options/blue.png'
				  )
				)
			),//end features 5c color
			array(
				'id'          => 'devide_color_lumia920',
				'label'       => esc_html__( 'Device color', 'applay' ),
				'desc'        => esc_html__( 'Choose device\'s color style', 'applay' ),
				'std'         => 'yellow',
				'type'        => 'radio-image',
				'condition'   => 'devide:is(lumia920)',
				'choices'     => array(
				  array(
					'value'       => 'black',
					'label'       => esc_html__( 'Black', 'applay' ),
					'src'         => $theme_uri.'/images/options/black.png'
				  ),
				  array(
					'value'       => 'white',
					'label'       => esc_html__( 'White', 'applay' ),
					'src'         => $theme_uri.'/images/options/white.png'
				  ),
				  array(
					'value'       => 'yellow',
					'label'       => esc_html__( 'Yellow', 'applay' ),
					'src'         => $theme_uri.'/images/options/yellow.png'
				  ),
				  array(
					'value'       => 'red',
					'label'       => esc_html__( 'Red', 'applay' ),
					'src'         => $theme_uri.'/images/options/red.png'
				  ),
				  array(
					'value'       => 'blue',
					'label'       => esc_html__( 'Blue', 'applay' ),
					'src'         => $theme_uri.'/images/options/blue.png'
				  )
				)
			),//end features lumia color
			array(
				'id'          => 'devide_color_ipadmini',
				'label'       => esc_html__( 'Device color', 'applay' ),
				'desc'        => esc_html__( 'Choose device\'s color style', 'applay' ),
				'std'         => 'silver',
				'type'        => 'radio-image',
				'condition'   => 'devide:is(ipadmini)',
				'choices'     => array(
				  array(
					'value'       => 'silver',
					'label'       => esc_html__( 'Silver', 'applay' ),
					'src'         => $theme_uri.'/images/options/white.png'
				  ),
				  array(
					'value'       => 'black',
					'label'       => esc_html__( 'Black', 'applay' ),
					'src'         => $theme_uri.'/images/options/black.png'
				  )
				)
			),//end features ipadmini color
			array(
				'id'          => 'devide_color_iphone4s',
				'label'       => esc_html__( 'Device color', 'applay' ),
				'desc'        => esc_html__( 'Choose device\'s color style', 'applay' ),
				'std'         => 'silver',
				'type'        => 'radio-image',
				'condition'   => 'devide:is(iphone4s)',
				'choices'     => array(
				  array(
					'value'       => 'silver',
					'label'       => esc_html__( 'Silver', 'applay' ),
					'src'         => $theme_uri.'/images/options/white.png'
				  ),
				  array(
					'value'       => 'black',
					'label'       => esc_html__( 'Black', 'applay' ),
					'src'         => $theme_uri.'/images/options/black.png'
				  )
				)
			),//end features 4s color
			array(
				'id'          => 'devide_color_galaxys5',
				'label'       => esc_html__( 'Device color', 'applay' ),
				'desc'        => esc_html__( 'Choose device\'s color style', 'applay' ),
				'std'         => 'white',
				'type'        => 'radio-image',
				'condition'   => 'devide:is(galaxys5)',
				'choices'     => array(
				  array(
					'value'       => 'white',
					'label'       => esc_html__( 'White', 'applay' ),
					'src'         => $theme_uri.'/images/options/white.png'
				  ),
				  array(
					'value'       => 'black',
					'label'       => esc_html__( 'Black', 'applay' ),
					'src'         => $theme_uri.'/images/options/black.png'
				  )
				)
			),//end features s5 color
			array(
				'id'          => 'orientation',
				'label'       => esc_html__( 'Device Screen Orientation', 'applay' ),
				'desc'        => esc_html__( 'Not affect on some devices', 'applay' ),
				'std'         => '',
				'type'        => 'radio-image',
				'condition'   => 'devide:not(def_themeoption),devide:not(def)',
				'operator'    => 'and',
				'choices'     => array(
				  array(
					'value'       => 0,
					'label'       => esc_html__( 'Portrait', 'applay' ),
					'src'         => $theme_uri.'/images/options/orientation-1.png'
				  ),
				  array(
					'value'       => 1,
					'label'       => esc_html__( 'Landscape', 'applay' ),
					'src'         => $theme_uri.'/images/options/orientation-2.png'
				  )
				)
			),//end orientation
			//appstore
			array(
			  'id'          => 'store-link-apple',
			  'label'       => __('<i class="fa fa-apple"></i> iOS Appstore URL','applay'),
			  'desc'        => esc_html__('Enter Appstore URL if available','applay'),
			  'std'         => '',
			  'type'        => 'text',
			  'class'       => '',
			  'choices'     => array()
			),
			array(
			  'id'          => 'store-link-google',
			  'label'       => __('<i class="fa fa-google"></i> Android Google Play Store URL','applay'),
			  'desc'        => esc_html__('Enter Play Store URL if available','applay'),
			  'std'         => '',
			  'type'        => 'text',
			  'class'       => '',
			  'choices'     => array()
			),
			array(
			  'id'          => 'store-link-windows',
			  'label'       => __('<i class="fa fa-windows"></i> Windows Phone Store URL','applay'),
			  'desc'        => esc_html__('Enter Windows Phone Store URL if available','applay'),
			  'std'         => '',
			  'type'        => 'text',
			  'class'       => '',
			  'choices'     => array()
			),
			array(
			  'id'          => 'app-port-file',
			  'label'       => esc_html__('Installation File','applay'),
			  'desc'        => esc_html__('Upload or enter your app download link','applay'),
			  'std'         => '',
			  'type'        => 'upload',
			  'class'       => '',
			  'choices'     => array()
			),
			array(
				'label'       => 'Custom Store Links',
				'id'          => 'app-custom-link',
				'type'        => 'list-item',
				'desc'        => esc_html__( 'Add Custom Store Links', 'applay' ),
				'settings'    => array(
					array(
						'label'       => esc_html__( 'Icon', 'applay' ),
						'id'          => 'icon',
						'type'        => 'text',
						'desc'        => esc_html__( 'Enter Font Awesome icon class (Ex: fa-apple)', 'applay' ),
						'std'         => '',
					),
					array(
						'label'       => esc_html__( 'Download text', 'applay' ),
						'id'          => 'download_text',
						'type'        => 'text',
						'desc'        => esc_html__( 'Ex: Download from', 'applay' ),
						'std'         => 'Download from',
					),
					array(
						'label'       => esc_html__( 'URL', 'applay' ),
						'id'          => 'url',
						'type'        => 'text',
						'desc'        => '',
					),
				),
			),//end custom link
			array(
			  'id'          => 'port-author-name',
			  'label'       => esc_html__('Author','applay'),
			  'desc'        => esc_html__('App\'s Author name','applay'),
			  'std'         => '',
			  'type'        => 'text',
			  'class'       => '',
			  'choices'     => array()
			),
			array(
			  'id'          => 'port-release',
			  'label'       => esc_html__('Release','applay'),
			  'desc'        => esc_html__('Release Date','applay'),
			  'std'         => '',
			  'type'        => 'date-picker',
			  'class'       => '',
			  'choices'     => array()
			),
			array(
			  'id'          => 'port-version',
			  'label'       => esc_html__('Version','applay'),
			  'desc'        => esc_html__('Current App\'s Version','applay'),
			  'std'         => '',
			  'type'        => 'text',
			  'class'       => '',
			  'choices'     => array()
			),
			array(
			  'id'          => 'port-requirement',
			  'label'       => esc_html__('Requirement','applay'),
			  'desc'        => esc_html__('App\'s Requirement','applay'),
			  'std'         => '',
			  'type'        => 'text',
			  'class'       => '',
			  'choices'     => array()
			),
			array(
				'label'       => 'Custom Meta',
				'id'          => 'app-custom-meta',
				'type'        => 'list-item',
				'desc'        => esc_html__( 'Add Custom Meta', 'applay' ),
				'settings'    => array(
					array(
						'label'       => esc_html__( 'Icon', 'applay' ),
						'id'          => 'icon',
						'type'        => 'text',
						'desc'        => esc_html__( 'Enter Font Awesome icon class (Ex: fa-check-square-o)', 'applay' ),
						'std'         => '',
					),
					array(
						'label'       => esc_html__( 'Value', 'applay' ),
						'id'          => 'value',
						'type'        => 'text',
						'desc'        => esc_html__( 'Enter value of meta', 'applay' ),
						'std'         => '',
					),
				),
			),//end custom link
			array(
			  'id'          => 'custom-screenshot',
			  'label'       => esc_html__('Custom Screenshot Images','applay'),
			  'desc'        => esc_html__('Enter custom app screenshots url, each image url per line','applay'),
			  'std'         => '',
			  'type'        => 'textarea',
			  'class'       => '',
			  'choices'     => array()
			),			
		 )
		);
	  //layout
	  $theme_uri = get_template_directory_uri();
	  $meta_box2 = array(
		'id'        => 'product_layout',
		'title'     => 'Layout settings',
		'desc'      => '',
		'pages'     => array( 'product'),
		'context'   => 'normal',
		'priority'  => 'high',
		'fields'    => array(
			array(
			  'id'          => 'product-sidebar',
			  'label'       => esc_html__('Sidebar','applay'),
			  'desc'        => esc_html__('Select "Default" to use settings in Theme Options','applay'),
			  'std'         => '',
			  'type'        => 'radio-image',
			  'class'       => '',
			  'choices'     => array(
				 array(
					'value'       => '',
					'label'       => 'Default',
					'src'         => $theme_uri.'/images/options/layout-default.png'
				  ),
				  array(
					'value'       => 'right',
					'label'       => 'Sidebar Right',
					'src'         => $theme_uri.'/images/options/layout-right.png'
				  ),
				  array(
					'value'       => 'left',
					'label'       => 'Sidebar Left',
					'src'         => $theme_uri.'/images/options/layout-left.png'
				  ),
				  array(
					'value'       => 'full',
					'label'       => 'Hidden',
					'src'         => $theme_uri.'/images/options/layout-full.png'
				  ),
			   )
			),
			array(
			  'id'          => 'product-contpadding',
			  'label'       => esc_html__('Content Padding','applay'),
			  'desc'        => esc_html__('Enable default top and bottom padding for content (30px)','applay'),
			  'std'         => 'on',
			  'type'        => 'on-off',
			  'class'       => '',
			  'choices'     => array()
			),
			array(
			  'id'          => 'disable-woo',
			  'label'       => esc_html__('Disable Woocommerce Layout','applay'),
			  'desc'        => esc_html__('Enable only if you want to build your own product content','applay'),
			  'std'         => 'off',
			  'type'        => 'on-off',
			  'class'       => '',
			  'choices'     => array()
			),
			array(
			  'id'          => 'product-mode',
			  'label'       => esc_html__('Product style','applay'),
			  'desc'        => esc_html__('Select "Default" to use settings in Theme Options','applay'),
			  'std'         => '',
			  'type'        => 'select',
			  'class'       => '',
			  'choices'     => array(
				 array(
					'value'       => '',
					'label'       => 'Default',
					'src'         => ''
				  ),
				  array(
					'value'       => '1',
					'label'       => 'Woocommerce Product',
					'src'         => ''
				  ),
				  array(
					'value'       => 'on',
					'label'       => 'Listing App',
					'src'         => ''
				  ),
			   )
			),
		 )
		);
	  $meta_box4 = array(
		'id'        => 'port_app_screenshots',
		'title'     => 'App screenshots',
		'desc'      => '',
		'pages'     => array('app_portfolio'  ),
		'context'   => 'normal',
		'priority'  => 'high',
		'fields'    => array(
				  array(
					  'label'       => esc_html__( 'Screen Image', 'applay' ),
					  'id'          => 'app_screen_image',
					  'type'        => 'gallery',
					  'desc'        => '',
					  'std'         => '',
					  'rows'        => '',
					  'post_type'   => '',
					  'taxonomy'    => '',
					  'choices'     => array(),
				  ),//end screen image
					
		 )
		);

	  $meta_box3 = array(
		'id'        => 'port_layout',
		'title'     => 'Layout settings',
		'desc'      => '',
		'pages'     => array('app_portfolio'  ),
		'context'   => 'normal',
		'priority'  => 'high',
		'fields'    => array(
			array(
			  'id'          => 'port_sidebar',
			  'label'       => esc_html__('Sidebar','applay'),
			  'desc'        => esc_html__('Select "Default" to use settings in Theme Options','applay'),
			  'std'         => '',
			  'type'        => 'radio-image',
			  'class'       => '',
			  'choices'     => array(
				 array(
					'value'       => '',
					'label'       => 'Default',
					'src'         => $theme_uri.'/images/options/layout-default.png'
				  ),
				  array(
					'value'       => 'right',
					'label'       => 'Sidebar Right',
					'src'         => $theme_uri.'/images/options/layout-right.png'
				  ),
				  array(
					'value'       => 'left',
					'label'       => 'Sidebar Left',
					'src'         => $theme_uri.'/images/options/layout-left.png'
				  ),
				  array(
					'value'       => 'full',
					'label'       => 'Hidden',
					'src'         => $theme_uri.'/images/options/layout-full.png'
				  ),
			   )
			),
			array(
			  'id'          => 'port-ctpadding',
			  'label'       => esc_html__('Content Padding','applay'),
			  'desc'        => esc_html__('Enable default top and bottom padding for content (30px)','applay'),
			  'std'         => 'on',
			  'type'        => 'on-off',
			  'class'       => '',
			  'choices'     => array()
			),
		 )
		);
		$meta_auto_fetch = array(
			'id'        => 'standard',
			'title'     => 'Auto Fetch Data from store',
			'desc'      => '',
			'pages'     => array('product'  ),
			'context'   => 'side',
			'priority'  => 'high',
			'fields'    => array(
				array(
				  'id'          => 'fetch_data_itunes',
				  'label'       => __('<strong>Enable Auto Fetch</strong>','applay'),
				  'desc' => esc_html__('Turn-off here if you do not want to auto-fetch data after save/edit','applay'),
				  'std'         => 'on',
				  'type'        => 'on-off',
				  'class'       => '',
				  'choices'     => array()
				),
			)
		);
	  
	  if (function_exists('ot_register_meta_box')) {
		  ot_register_meta_box( $meta_box_app );
		  ot_register_meta_box( $meta_box2 );
		  ot_register_meta_box( $meta_box4 );
		  ot_register_meta_box( $meta_box3 );
		  ot_register_meta_box( $meta_auto_fetch );
	  }
	}
}
?>