<?php
function ia_woo_products( $atts ) {
	if (class_exists('Woocommerce')) {
		global $woocommerce_loop;
		$columns = isset($atts['column']) ? $atts['column'] : '';
		$listing_style = isset($atts['listing_style']) ? $atts['listing_style'] : '1';
		$cat = isset($atts['cat']) ? $atts['cat'] : '';
		$tag = isset($atts['tag']) ? $atts['tag'] : '';
		$ids = isset($atts['ids']) ? $atts['ids'] : '';
		$count = isset($atts['count']) ? $atts['count'] : 4;
		$order = isset($atts['order']) ? $atts['order'] : 'DESC';
		$orderby = isset($atts['orderby']) ? $atts['orderby'] : 'date';
		$meta_key = isset($atts['meta_key']) ? $atts['meta_key'] : '';
		extract( shortcode_atts( array(
			'per_page' 	=> $count,
			'columns' 	=> $columns,
			'orderby' 	=> $orderby,
			'order' 	=> $order
		), $atts ) );
		$meta_query = WC()->query->get_meta_query();
		$category='new';
		if($ids!=''){
			$ids = explode(",", $ids);	
			$args = array(
				'post_type'				=> 'product',
				'post_status'			=> 'publish',
				'ignore_sticky_posts'	=> 1,
				'category' => 'new',
				'posts_per_page' 		=> $per_page,
				'orderby' 				=> $orderby,
				'order' 				=> $order,
				'post__in' => $ids,
				'meta_key' => $meta_key,
			);
		}else{
			$args = array(
				'post_type'				=> 'product',
				'post_status'			=> 'publish',
				'ignore_sticky_posts'	=> 1,
				'category' => 'new',
				'posts_per_page' 		=> $per_page,
				'orderby' 				=> $orderby,
				'order' 				=> $order,
				'meta_key' => $meta_key,
			);
		}
//tag
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
//cat
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
		if(isset($texo)){
			$args += array('tax_query' => $texo);
		}


		ob_start();
		
		$products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $args, $atts ) );

		$woocommerce_loop['columns'] = $columns;
		$woocommerce_loop['listing_style'] = $listing_style;

		if ( $products->have_posts() ) : ?>

			<?php woocommerce_product_loop_start(); ?>

				<?php while ( $products->have_posts() ) : $products->the_post(); ?>

					<?php wc_get_template_part( 'content', 'shortcode' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

		<?php endif;

		wp_reset_postdata();

		return '<div class="ia-woo ia-product-listing"><div class="woocommerce columns-' . $columns . '">' . ob_get_clean() . '</div></div>';
	}
}
add_shortcode( 'ia_woo', 'ia_woo_products' );

add_action( 'after_setup_theme', 'reg_ia_woo' );
function reg_ia_woo(){
	if(function_exists('vc_map') && (class_exists('Woocommerce'))){
	vc_map( array(
	   "name" => __("Applay Product Listing"),
	   "base" => "ia_woo",
	   "class" => "",
	   "icon" => "icon-app-woo",
	   "controls" => "full",
	   "category" => __('Content'),
	   "params" => array(
		  array(
			"type" => "textfield",
			"heading" => __("Columns Number", "applay"),
			"param_name" => "column",
			"value" => "",
			"description" => __("From 1-6 (Default is 4)", "applay"),
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Listing Style", 'applay'),
			 "param_name" => "listing_style",
			 "value" => array(
			 	__('Modern (Thumbnail with App Icon)', 'applay') => '1',
				__('Classic (Only Icon or Thumbnail)', 'applay') => '0',
			 ),
			 "description" => ''
		  ),

		  array(
			"type" => "textfield",
			"heading" => __("Category", "applay"),
			"param_name" => "cat",
			"value" => "",
			"description" => __("List of cat ID (or slug), separated by a comma", "applay"),
		  ),
		  array(
			"type" => "textfield",
			"heading" => __("Tags", "applay"),
			"param_name" => "tag",
			"value" => "",
			"description" => __("list of tags, separated by a comma", "applay"),
		  ),
		  array(
			"type" => "textfield",
			"heading" => __("IDs", "applay"),
			"param_name" => "ids",
			"value" => "",
			"description" => __("Specify post IDs to retrieve", "applay"),
		  ),
		  array(
			"type" => "textfield",
			"heading" => __("Count", "applay"),
			"param_name" => "count",
			"value" => "8",
			"description" => __("Number of posts to show. Default is 8", 'applay'),
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Order", 'applay'),
			 "param_name" => "order",
			 "value" => array(
			 	__('DESC', 'applay') => 'DESC',
				__('ASC', 'applay') => 'ASC',
			 ),
			 "description" => ''
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Order by", 'applay'),
			 "param_name" => "orderby",
			 "value" => array(
			 	__('Date', 'applay') => 'date',
				__('ID', 'applay') => 'ID',
				__('Author', 'applay') => 'author',
			 	__('Title', 'applay') => 'title',
				__('Name', 'applay') => 'name',
				__('Modified', 'applay') => 'modified',
			 	__('Parent', 'applay') => 'parent',
				__('Random', 'applay') => 'rand',
				__('Comment count', 'applay') => 'comment_count',
				__('Menu order', 'applay') => 'menu_order',
				__('Meta value', 'applay') => 'meta_value',
				__('Meta value num', 'applay') => 'meta_value_num',
				__('Post__in', 'applay') => 'post__in',
				__('None', 'applay') => 'none',
			 ),
			 "description" => ''
		  ),
		  array(
			"type" => "textfield",
			"heading" => __("Meta key", "applay"),
			"param_name" => "meta_key",
			"value" => "",
			"description" => __("Name of meta key for ordering", "applay"),
		  ),
	   )
	));
	}
}