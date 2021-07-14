<?php
function print_ia_blog($atts, $content=''){
	$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
	$post_type = isset($atts['post_type']) ? $atts['post_type'] : 'post';
	$cat = isset($atts['cat']) ? $atts['cat'] : '';
	$tag = isset($atts['tag']) ? $atts['tag'] : '';
	$ids = isset($atts['ids']) ? $atts['ids'] : '';
	$count = isset($atts['count']) ? $atts['count'] : 4;
	$order = isset($atts['order']) ? $atts['order'] : 'DESC';
	$orderby = isset($atts['orderby']) ? $atts['orderby'] : 'date';
	$meta_key = isset($atts['meta_key']) ? $atts['meta_key'] : '';
	
	$show_info = isset($atts['show_info']) ? $atts['show_info'] : 1;
	if(isset($atts['css_animation'])){
		$animation_class = $atts['css_animation']?'wpb_'.$atts['css_animation'].' wpb_animate_when_almost_visible':'';
	}
	$animation_delay = isset($atts['animation_delay']) ? $atts['animation_delay'] : 0;

	ob_start();
	?>
    	<section class="app-b-post-listing shortcode-blog-<?php echo $ID;  echo ' '.@$animation_class;?>" data-delay=<?php echo $animation_delay; ?>>
                <div class="section-body">
                	<div class="row">
                	<?php $the_query = ia_shortcode_query($post_type,$cat,$tag,$ids,$count,$order,$orderby,$meta_key);
					if ( $the_query->have_posts() ) {
						$query_count = 0;
						while ( $the_query->have_posts() ) {
							$the_query->the_post();
							$query_count++;
							?>
							<div class="col-md-12 shortcode-blog-item">
                                <div class="content-pad">
                                    <div class="post-item row">
                                        <div class="col-md-5 col-sm-6">
                                            <div class="content-pad">
                                                <div class="item-thumbnail">
                                                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
														<?php if(has_post_thumbnail()){
                                                            $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'applay_thumb_409x258', true);
                                                        }else{
                                                            $thumbnail = leafcolor_print_default_thumbnail();
                                                        }?>
                                                        <img src="<?php echo $thumbnail[0] ?>" width="<?php echo $thumbnail[1] ?>" height="<?php echo $thumbnail[2] ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>">
                                                        <div class='thumbnail-hoverlay main-color-1-bg'></div>
                                                        <div class='thumbnail-hoverlay-icon'><i class="fa fa-search"></i></div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7 col-sm-6">
                                            <div class="content-pad">
                                                <div class="item-content">
                                                <?php if($show_info==1){?>
                                                <div class="meta">
                                                     <span class="date"><i class="fa fa-calendar"></i> <?php the_time( get_option( 'date_format' ) ); ?></span> 
                                                     <?php if(comments_open()){ ?>
                                                     <i class="fa fa-comments"></i> <a href="<?php the_permalink(); ?>#comment" class="main-color-1-hover" title="<?php _e('View comments','applay'); ?>"><?php comments_number(__('0 COMMENTS','applay'),__('1 COMMENT','applay'),__('% COMMENTS','applay')); ?></a> 
                                                     <?php }?>
                                                </div>
                                                <?php }?>
                                                    <h3 class="item-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="main-color-1-hover"><?php the_title(); ?></a></h3>
                                                    <div class="shortcode-blog-excerpt"><?php the_excerpt(); ?></div>
                                                    <div class="item-meta">
                                                        <a class="btn btn-default btn-lighter" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php _e('Read more','applay') ?> <i class="fa fa-angle-right"></i></a>
														
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--/post-item-->
                                </div>
                            </div><!--/shortcode-blog-item-->
							<?php
							if($query_count%2==0 && $query_count != $the_query->post_count){ ?>
                            	</div><!--/row-->
                                <div class="row">
							<?php
							}
						}//while have_posts
					}//if have_posts
					wp_reset_postdata();
					?>
                    </div><!--/row-->
                </div><!--/section-body-->
        </section><!--/blog-listing-->
	<?php
	//return
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode( 'ia_blog', 'print_ia_blog' );

add_action( 'after_setup_theme', 'reg_ia_blog' );
function reg_ia_blog(){
	if(function_exists('vc_map')){
	vc_map( array(
	   "name" => __("Blog"),
	   "base" => "ia_blog",
	   "class" => "",
	   "icon" => "icon-blog",
	   "controls" => "full",
	   "category" => __('Content'),
	   "params" => array(
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Post Type", "applay"),
			 "param_name" => "post_type",
			 "value" => array(
			 	__('Post', 'applay') => 'post',
				__('Product', 'applay') => 'product',
				__('Portfolio', 'applay') => 'app_portfolio',
			 ),
			 "description" => __('Choose post type','applay')
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
			"value" => "4",
			"description" => __("Number of posts to show. Default is 4", 'applay'),
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
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Show info", 'applay'),
			 "param_name" => "show_info",
			 "value" => array(
			 	__('Show', 'applay') => 1,
				__('Hide', 'applay') => 0,
			 ),
			 "description" => 'Show date and comments'
		  ),
	   )
	));
  }
}