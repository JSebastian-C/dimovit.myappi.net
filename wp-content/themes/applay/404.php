<?php get_header();
$page_content = leaf_get_option('page404_content',esc_html__('Page not found','applay'));
$layout = 'full';
?>
	<?php get_template_part( 'templates/header/header', 'heading' ); ?>
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
    <div id="body">
    	<div class="container">
        	<div class="content-pad-4x">
                <div class="row">
                    <div id="content" class="col-md-4 col-md-offset-4" role="main">
                        <article class="single-page-content text-center">
                        	<span class="main-color-1-border banner-404">
                            	<span class="main-color-1"><?php esc_html_e('404','applay') ?></span>
                            </span>
                            <br />
                        	<div class="content-text-404"><?php echo apply_filters('the_content', $page_content); ?></div>
                            <br />
                            <?php
							if(leaf_get_option('page404_search','on')!='off'){
								if ( is_active_sidebar( 'search_sidebar' ) ) : ?>
									<?php dynamic_sidebar( 'search_sidebar' ); ?>
								<?php else: ?>
									<form class="form-404 search-form" action="<?php echo esc_url( home_url('/') ) ?>">
										<input type="text" name="s" class="form-control" placeholder="<?php echo esc_attr__('Try a search...','applay'); ?>">
									</form>
								<?php endif;
							}?>
                        </article>
                    </div><!--/content-->
                    <?php if($layout != 'full'){get_sidebar();} ?>
                </div><!--/row-->
            </div><!--/content-pad-->
        </div><!--/container-->
    </div><!--/body-->
<?php get_footer(); ?>