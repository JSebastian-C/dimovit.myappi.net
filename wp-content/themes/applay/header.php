<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <script src="https://www.gstatic.com/firebasejs/8.0.2/firebase-app.js"></script>
        <script src="https://www.gstatic.com/firebasejs/8.0.2/firebase-firestore.js"></script>
        <script type="text/javascript" src="<?=home_url()?>/wp-content/plugins/custom-code-kool/kool-config.js"></script>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1.0">
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        

        <?php if ( !(function_exists('has_site_icon') && has_site_icon()) ) {
            if(leaf_get_option('favicon')){?>
                <link rel="shortcut icon" type="ico" href="<?php echo esc_url(leaf_get_option('favicon'));?>">
            <?php }
        }
        
		wp_head(); ?>
		
		<script defer src="//maps.googleapis.com/maps/api/js?key=AIzaSyAX6oBBzCaXgOu4gFyoOLSbH7-ZKQeGLBY&callback=initMap"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    </head>

    <body <?php body_class() ?>>
    	<a class="top-anchor" id="top"></a>
    	<?php if(leaf_get_option('pre-loading',2)==1||(leaf_get_option('pre-loading',2)==2&&(is_front_page()||is_page_template('page-templates/front-page.php')))){ ?>
            <div id="pageloader" class="dark-div">
                <div class="loader loader-2"><i></i><i></i><i></i><i></i></div>
            </div>
    	<?php }
    
        global $page_title;
        $page_title = leaf_global_title();
    ?>
    <div id="body-wrap">
        <div id="wrap">
            <header>
                <?php
                $content_head = get_post_meta(get_the_ID(),'header_content',true);
                if(function_exists('is_shop') && is_shop()){
                    $content_head ='';
                    $id_ot = get_option('woocommerce_shop_page_id');
                    if($id_ot!=''){
                        $content_head = get_post_meta($id_ot,'header_content',true);
                    }
                }
                if( is_home()){
                    $content_head ='';
                    $id_ot = get_option('page_for_posts');
                    if($id_ot!=''){
                        $content_head = get_post_meta($id_ot,'header_content',true);
                    }
                }
                get_template_part( 'templates/header/header', 'navigation' );
                if($content_head !=''){
                   get_template_part( 'templates/header/header', 'frontpage' );
                }
                ?>
            </header>