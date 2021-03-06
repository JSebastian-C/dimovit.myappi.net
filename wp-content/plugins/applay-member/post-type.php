<?php
// Register custom post type
add_action('init', 'app_member'); 
function app_member()  {
  $member_slug = function_exists('ot_get_option')?ot_get_option('member_slug','member'):'member';
  $labels = array(  
    'name' => __('Member', 'applay'),  
    'singular_name' => __('Member', 'applay'),  
    'add_new' => __('Add New Member', 'applay'),  
    'add_new_item' => __('Add New Member', 'applay'),  
    'edit_item' => __('Edit Member', 'applay'),  
    'new_item' => __('New Member', 'applay'),  
    'view_item' => __('View Member', 'applay'),  
    'search_items' => __('Search Member', 'applay'),  
    'not_found' =>  __('No Member found', 'applay'),  
    'not_found_in_trash' => __('No Member found in Trash', 'applay'),  
    'parent_item_colon' => '' 
  );  
  
  $args = array(  
    'labels' => $labels,  
    'menu_position' => 8, 
    'supports' => array('title','editor','thumbnail',),
	'public' => false,
	'show_ui' => true,
	'menu_icon' =>  'dashicons-businessman',
	'publicly_queryable' => true,
	'has_archive' => true,
	'hierarchical' => false,
	'rewrite' => array('slug' => $member_slug),
  );  
  register_post_type('member',$args);  
} 

// Add meta data
add_action( 'admin_init', 'leaf_member_meta_boxes' );


function leaf_member_meta_boxes() {
	/**
	 * Supported TYPE:
	 * background
	 * ...
	 * ...
	 * ...
	 */
  $my_meta_box = array(
    'id'        => 'leaf_mb_info',
    'title'     => 'Info',
    'desc'      => '',
    'pages'     => array( 'member' ),
    'context'   => 'normal',
    'priority'  => 'high',
    'fields'    => array(
      array(
        'id'          => 'position',
        'label'       => 'Position',
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'class'       => '',
        'choices'     => array()
      ),
      array(
        'id'          => 'mb-hover',
        'label'       => 'Set Image when hover',
        'desc'        => 'Upload image',
        'std'         => '',
        'type'        => 'upload',
        'class'       => '',
		'choices'     => array()
      ),	  
    )
  );  

	if (function_exists('ot_register_meta_box')) {
	  ot_register_meta_box( $my_meta_box );
	}
}
//Add ID columns
add_filter('manage_posts_columns', 'leafmb_posts_columns_id', 1);
add_action('manage_posts_custom_column', 'app_posts_custom_id_columns', 1, 2);
function leafmb_posts_columns_id($defaults){
    $defaults['wps_post_id'] = __('ID');
    return $defaults;
}
function app_posts_custom_id_columns($column_name, $id){
        if($column_name === 'wps_post_id'){
                echo $id;
    }
}
add_action( 'admin_init', 'leafmb_meta_social' );
function leafmb_meta_social() {
  $my_meta_box2 = array(
    'id'        => 'leaf_mb_social',
    'title'     => 'Social',
    'desc'      => '',
    'pages'     => array( 'member' ),
    'context'   => 'normal',
    'priority'  => 'high',
    'fields'    => array(
      array(
        'id'          => 'dribbble',
        'label'       => 'Dribble',
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'class'       => '',
        'choices'     => array()
      ),

      array(
        'id'          => 'envelope-o',
        'label'       => 'Email',
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'class'       => '',
        'choices'     => array()
      ),
      array(
        'id'          => 'facebook',
        'label'       => 'Facebook',
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'class'       => '',
        'choices'     => array()
      ),
      array(
        'id'          => 'flickr',
        'label'       => 'Flickr',
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'class'       => '',
        'choices'     => array()
      ),
      array(
        'id'          => 'google+',
        'label'       => 'Google+',
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'class'       => '',
        'choices'     => array()
      ),
      array(
        'id'          => 'instagram',
        'label'       => 'Instagram',
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'class'       => '',
        'choices'     => array()
      ),
      array(
        'id'          => 'linkedIn',
        'label'       => 'LinkedIn',
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'class'       => '',
        'choices'     => array()
      ),
      array(
        'id'          => 'pinterest',
        'label'       => 'Pinterest',
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'class'       => '',
        'choices'     => array()
      ),
      array(
        'id'          => 'rss',
        'label'       => 'RSS',
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'class'       => '',
        'choices'     => array()
      ),
      array(
        'id'          => 'stumbleupon',
        'label'       => 'StumbleUpon',
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'class'       => '',
        'choices'     => array()
      ),
      array(
        'id'          => 'twitter',
        'label'       => 'Twitter',
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'class'       => '',
        'choices'     => array()
      ),
      array(
        'id'          => 'vimeo',
        'label'       => 'Vimeo',
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'class'       => '',
        'choices'     => array()
      ),
      array(
        'id'          => 'youtube',
        'label'       => 'YouTube',
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'class'       => '',
        'choices'     => array()
      ),
    )
	
  );  

	if (function_exists('ot_register_meta_box')) {
  		ot_register_meta_box( $my_meta_box2 );
	}
}


