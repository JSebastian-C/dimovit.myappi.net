<?php
function print_ia_heading($atts, $content){
	$ID = isset($atts['ID']) ? $atts['ID'] : 'heading_'.rand(10,9999);
	$url = isset($atts['url']) ? $atts['url'] : '';
	$size = isset($atts['size']) ? $atts['size'] : '1';
	$align = isset($atts['align']) ? $atts['align'] : 'left';
	if(isset($atts['css_animation'])){
		$animation_class = $atts['css_animation']?'wpb_'.$atts['css_animation'].' wpb_animate_when_almost_visible':'';
	}
	$animation_delay = isset($atts['animation_delay']) ? $atts['animation_delay'] : 0;
	//display
	ob_start(); ?>
    <div class="ia-heading <?php echo 'ia-heading-'.$ID; echo ' heading-align-'.$align; echo ' '.@$animation_class; ?>" data-delay=<?php echo $animation_delay; ?>>
    	<h2 <?php if($size){ ?>class="h1"<?php } ?>>
        <?php if($url){ ?><a href="<?php echo $url; ?>" title="<?php echo esc_attr($content) ?>"><?php } ?>
        	<?php echo do_shortcode($content);?>
        <?php if($url){ ?></a><?php } ?>
        </h2>
        <div class="clearfix"></div>
    </div>
    <?php
	//return
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode( 'ia_heading', 'print_ia_heading' );
add_action( 'after_setup_theme', 'reg_ia_heading' );
function reg_ia_heading(){
	if(function_exists('vc_map')){
		/* Register shortcode with Visual Composer */
		vc_map( array(
		   "name" => __("Heading",'applay'),
		   "base" => "ia_heading",
		   "class" => "",
		   "controls" => "full",
		   "category" => 'Content',
		   "icon" => "icon-heading",
		   "params" => array(
			  array(
				 "type" => "textfield",
				 "holder" => "div",
				 "class" => "",
				 "heading" => __("Heading text", 'applay'),
				 "param_name" => "content",
				 "value" => __("Heading text", 'applay'),
				 "description" => '',
			  ),
			  array(
				"type" => "textfield",
				"heading" => __("Heading URL", "applay"),
				"param_name" => "url",
				"value" => "",
				"description" => __("Optional", "applay"),
			  ),
			  array(
				 "type" => "dropdown",
				 "holder" => "div",
				 "class" => "",
				 "heading" => __("Size", 'applay'),
				 "param_name" => "size",
				 "value" => array(
					__('Big', 'applay') => '1',
					__('Small', 'applay') => '0',
				 ),
				 "description" => ''
			  ),
			  array(
				 "type" => "dropdown",
				 "holder" => "div",
				 "class" => "",
				 "heading" => __("Align", 'applay'),
				 "param_name" => "align",
				 "value" => array(
					__('Left', 'applay') => 'left',
					__('Right', 'applay') => 'right',
					__('Center', 'applay') => 'center',
				 ),
				 "description" => ''
			  ),
		   )
		) );
	}
}