<?php
global $page_title;
$ct_hd = get_post_meta(get_the_ID(),'header_content',true);
if(function_exists('is_shop') && is_shop()){
	$ct_hd ='';
	$id_ot = get_option('woocommerce_shop_page_id');
	if($id_ot!=''){
		$ct_hd = get_post_meta($id_ot,'header_content',true);
	}
}
if( is_home()){
	$ct_hd ='';
	$id_ot = get_option('page_for_posts');
	if($id_ot!=''){
		$ct_hd = get_post_meta($id_ot,'header_content',true);
	}
}
if(!is_page_template('page-templates/front-page.php') && $ct_hd==''){
$heading_bg = leaf_get_option('heading_bg');

if(is_singular('app_portfolio') || is_singular('product')){ ?>
    <div class="page-heading main-color-1-bg dark-div">
        <div class="container">
            <div class="row">
                <?php if($icon = get_post_meta(get_the_ID(),'app-icon',true)){ ?>
                <div class="col-md-2 col-sm-3 col-xs-12">
                    <img src="<?php echo esc_url($icon); ?>" alt="<?php the_title_attribute(); ?>" title="<?php the_title_attribute(); ?>" class="icon-appport"/>
                </div>
                <?php }?>
                <div class="col-md-10 col-sm-9 col-xs-12">
                    <h1><?php echo esc_attr($page_title) ?></h1>
                    <div class="app-store-link">
                        <?php if($apple = get_post_meta(get_the_ID(),'store-link-apple',true)){ ?>
                        <a class="btn btn-default btn-store btn-store-apple" href="<?php echo esc_url($apple) ?>" target="_blank">
                            <i class="fa fa-apple"></i>
                            <div class="btn-store-text">
                                <span><?php esc_html_e("Download from","applay") ?></span><br />
                                <?php esc_html_e("APP STORE","applay") ?>
                            </div>
                        </a>
                        <?php }//if apple ?>
                        <?php if($google = get_post_meta(get_the_ID(),'store-link-google',true)){ ?>
                        <a class="btn btn-default btn-store btn-store-google" href="<?php echo esc_url($google) ?>" target="_blank">
                            <i class="fa fa-google"></i>
                            <div class="btn-store-text">
                                <span><?php esc_html_e("Download from","applay") ?></span><br />
                                <?php esc_html_e("PLAY STORE","applay") ?>
                            </div>
                        </a>
                        <?php }//if google ?>
                        <?php if($windows = get_post_meta(get_the_ID(),'store-link-windows',true)){ ?>
                        <a class="btn btn-default btn-store btn-store-windows" href="<?php echo esc_url($windows) ?>" target="_blank">
                            <i class="fa fa-windows"></i>
                            <div class="btn-store-text">
                                <span><?php esc_html_e("Download from","applay") ?></span><br />
                                <?php esc_html_e("WINDOWS STORE","applay") ?>
                            </div>
                        </a>
                        <?php }//if windows ?>
                        <?php if(get_post_meta(get_the_ID(),'app-port-file',true) && is_singular('app_portfolio')){ ?>
                        <a class="btn btn-default btn-store btn-store-file" href="<?php echo esc_url(get_post_meta(get_the_ID(),'app-port-file',true)) ?>" target="_blank">
                            <i class="fa fa-download"></i>
                            <div class="btn-store-text">
                                <span><?php esc_html_e("Download","applay") ?></span><br />
                                <?php esc_html_e("INSTALLATION FILE","applay") ?>
                            </div>
                        </a>
                        <?php }//if file ?>
                        
                        <?php if($links = get_post_meta(get_the_ID(),'app-custom-link',true)){
							foreach($links as $link){ ?>
                        <a class="btn btn-default btn-store btn-store-link" href="<?php echo esc_url($link['url']) ?>" target="_blank">
                            <i class="fa <?php echo esc_attr($link['icon']) ?>"></i>
                            <div class="btn-store-text">
                                <span><?php echo esc_attr($link['download_text']) ?></span><br />
                                <?php echo esc_attr($link['title']) ?>
                            </div>
                        </a>
                        <?php }/*foreach*/ }//if links ?>
                        
                    </div>
                </div>
            </div><!--/row-->
        </div><!--/container-->
    </div><!--/page-heading-->
    <?php
    
}else{ ?>
<div class="page-heading main-color-1-bg dark-div">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-8">
                <h1><?php echo esc_attr($page_title) ?></h1>
            </div>
            <?php if(is_active_sidebar('pathway_sidebar')){
                    echo '<div class="pathway pathway-sidebar col-md-4 col-sm-4 hidden-xs text-right">';
                        dynamic_sidebar('pathway_sidebar');
                    echo '</div>';
                }else{?>
            <div class="pathway col-md-4 col-sm-4 hidden-xs text-right">
                <?php if(function_exists('leafcolor_breadcrumbs')){ leafcolor_breadcrumbs(); } ?>
            </div>
            <?php } ?>
        </div><!--/row-->
    </div><!--/container-->
</div><!--/page-heading-->
<?php 
}//else product
}//if not front page ?>

<div class="top-sidebar">
    <div class="container">
        <div class="row">
            <?php
                if ( is_active_sidebar( 'top_sidebar' ) ) :
                    dynamic_sidebar( 'top_sidebar' );
                endif;
             ?>
        </div><!--/row-->
    </div><!--/container-->
</div><!--/Top sidebar-->