<?php
/*load admin js & css*/
function leafcolor_admin_styles() {	
	wp_enqueue_style( 'applay-admin-style', get_template_directory_uri().'/admin/style.css');	
}
if(is_admin()){
	add_action('admin_print_styles', 'leafcolor_admin_styles');
	add_filter('manage_edit-post_columns', 'leafcolor_add_posts_columns');
	add_filter('manage_edit-page_columns', 'leafcolor_add_pages_columns');
	add_filter('manage_edit-category_columns', 'leafcolor_add_pages_columns' );

	function leafcolor_add_posts_columns($columns) {
		$cols = array_merge(array('id' => esc_html__('ID','applay')),$columns);
		$cols = array_merge($cols,array('thumbnail'=>__('Thumbnail','applay')));
		return $cols;
	}
	
	function leafcolor_add_pages_columns($columns) {
		$cols = array_merge(array('id' => esc_html__('ID','applay')),$columns);
		
		return $cols;
	}
	add_action( 'manage_pages_custom_column' , 'leafcolor_set_posts_columns_value', 10, 2 );
	add_action( 'manage_posts_custom_column' , 'leafcolor_set_posts_columns_value', 10, 2 );
	add_filter( 'manage_category_custom_column', 'leafcolor_set_cats_columns_value', 10, 3 );
	function leafcolor_set_posts_columns_value( $column, $post_id ) {
		if ($column == 'id'){
			echo esc_attr($post_id);
		} else if($column == 'thumbnail'){
			echo esc_url(get_the_post_thumbnail($post_id,'thumbnail'));
		} else if($column == 'startdate'){
			// for event
			$date_str = get_post_meta($post_id,'start_day',true);
			if($date_str != ''){
				$date = date_create_from_format('m/d/Y H:i', $date_str);
				echo esc_attr($date->format(get_option('date_format')));
			}
		}
	}
	
	function leafcolor_set_cats_columns_value( $value, $name, $cat_id ){
		if( 'id' == $name ) 
			echo esc_attr($cat_id);
	}

	function leafcolor_image_custom_sizes( $sizes ) {
		global $_wp_additional_image_sizes;

		// make the names human friendly by removing dashes and capitalising
		foreach( $_wp_additional_image_sizes as $key => $value ) {
			$custom[ $key ] = ucwords( str_replace( '-', ' ', $key ) );
		}

		return array_merge( $sizes, $custom );
	}
	add_filter( 'image_size_names_choose', 'leafcolor_image_custom_sizes' );/* Add Image Sizes to Media Chooser */
	
	/* Allow to upload custom fonts */
	function leafcolor_addUploadMimes($mimes) {
		$mimes = array_merge($mimes, array(
		'eot' => 'application/octet-stream',
		'svg' => 'image/svg+xml',
		'ttf' => 'application/octet-stream',
		'otf' => 'application/octet-stream',
		'woff' => 'application/octet-stream',
		));
		return $mimes;
    }
    add_filter('upload_mimes', 'leafcolor_addUploadMimes');
	add_action('admin_head', 'custom_admin_styling');
	function custom_admin_styling() {
		echo '<s'.'tyle type="text/css">th#id{width:40px;}</st'.'yle>';
	}
}
