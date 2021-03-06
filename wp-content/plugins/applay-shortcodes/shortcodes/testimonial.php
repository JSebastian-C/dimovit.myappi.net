<?php
function print_ia_testimonial($atts, $content=''){
	//get parameter
	$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
	$scroll = isset($atts['scroll']) ? $atts['scroll'] : 0;
	if(isset($atts['css_animation'])){
		$animation_class = $atts['css_animation']?'wpb_'.$atts['css_animation'].' wpb_animate_when_almost_visible':'';
	}
	$animation_delay = isset($atts['animation_delay']) ? $atts['animation_delay'] : 0;
	//display
	ob_start(); ?>
		<section class="testimonials testimonials-<?php echo $ID;  echo ' '.@$animation_class; ?>" data-delay=<?php echo $animation_delay; ?>>
        	<div class="section-inner">
                <div class="testimonial-carousel owl-carousel init-carousel single-carousel" <?php if($scroll){ ?>data-autoplay=5000<?php } ?> >
                    <?php echo do_shortcode($content); ?>
                </div>
            </div>
        </section><!--/testimonial-->
	<?php
	//return
	$output_string=ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode( 'ia_testimonial', 'print_ia_testimonial' );

function print_ia_testimonial_item($atts, $content=''){
	$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
	$name = isset($atts['name']) ? $atts['name'] : '';
	$title = isset($atts['title']) ? $atts['title'] : '';
	$avatar = isset($atts['avatar']) ? $atts['avatar'] : '';
	ob_start(); ?>
		<div class="carousel-item testimonial-item-<?php echo $ID; ?>">
            <div class="testimonial-item text-center">
            	<i class="fa fa-quote-right main-color-1"></i>
                <p class="font-2"><?php echo do_shortcode($content); ?></p>
                <div class="media testi_user">
                	<?php if($avatar){ ?>
                    <div class="pull-left">
                    	<?php $thumbnail = wp_get_attachment_image_src($avatar,'thumbnail', true); ?>
                        <img src="<?php echo $thumbnail[0] ?>" width="50" height="50" alt="<?php echo esc_attr($name) ?>">
                    </div>
                    <?php }?>
                    <div class="media-body">
                        <h6 class="h5 media-heading main-color-1"><?php echo $name ?></h6>
                        <span><?php echo $title ?></span>
                    </div>
                </div>
            </div>
        </div><!--/carousel-item-->
	<?php
	//return
	$output_string=ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode( 'ia_testimonial_item', 'print_ia_testimonial_item' );

//Visual Composer
add_action( 'after_setup_theme', 'reg_ia_testimonial' );
function reg_ia_testimonial(){
	if(function_exists('vc_map')){
		//parent
		vc_map( array(
			"name" => __("Testimonials", "applay"),
			"base" => "ia_testimonial",
			"as_parent" => array('only' => 'ia_testimonial_item'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
			"content_element" => true,
			"show_settings_on_create" => false,
			"icon" => "icon-testimonial",
			"params" => array(
				// add params same as with any other content element
				array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __("Auto Scroll", "applay"),
					"param_name" => "scroll",
					"value" => array(
						__('No', 'applay') => '0',
						__('Yes', 'applay') => '1',
					),
					"description" => __('Auto scroll Testimonials','applay')
				),
			),
			"js_view" => 'VcColumnView'
		) );
		
		//child
		vc_map( array(
			"name" => __("Testimonial Item", "applay"),
			"base" => "ia_testimonial_item",
			"content_element" => true,
			"as_child" => array('only' => 'ia_testimonial_item'), // Use only|except attributes to limit parent (separate multiple values with comma)
			"icon" => "icon-testimonial-item",
			"params" => array(
				array(
					"type" => "attach_image",
					"heading" => __("Avatar", "applay"),
					"param_name" => "avatar",
					"value" => "",
					"description" => __("Avatar of client", "applay"),
				),
				array(
					"type" => "textfield",
					"heading" => __("Name", "applay"),
					"param_name" => "name",
					"value" => "",
					"description" => ""
				),
				array(
					"type" => "textfield",
					"heading" => __("Title", "applay"),
					"param_name" => "title",
					"value" => "",
					"description" => __("Title of client (Ex: CEO)", "applay"),
				),
				array(
					"type" => "textarea",
					"heading" => __("Testimonial content", "applay"),
					"param_name" => "content",
					"value" => "",
					"description" => "",
				),
			)
		) );
		
	}
	if(class_exists('WPBakeryShortCode') && class_exists('WPBakeryShortCodesContainer')){
	class WPBakeryShortCode_ia_testimonial extends WPBakeryShortCodesContainer{}
	class WPBakeryShortCode_ia_testimonial_item extends WPBakeryShortCode{}
	}
}