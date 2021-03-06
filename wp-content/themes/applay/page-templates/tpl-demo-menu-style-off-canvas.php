<?php 
/*
 * Template Name: Demo menu style off canvas
 */
 ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1.0">
<?php if(leaf_get_option('favicon')):?>
<link rel="shortcut icon" type="ico" href="<?php echo esc_url(leaf_get_option('favicon'));?>">
<?php endif;?>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php if(leaf_get_option('favicon')):?>
<link rel="shortcut icon" type="ico" href="<?php echo esc_url(leaf_get_option('favicon'));?>">
<?php endif;?>
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>

<!--[if lte IE 9]>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ie.css" />
<![endif]-->

<?php wp_head(); ?>
</head>

<body <?php body_class() ?>>
<a class="top-anchor" id="top"></a>
<?php if(leaf_get_option('pre-loading',2)==1||(leaf_get_option('pre-loading',2)==2&&(is_front_page()||is_page_template('page-templates/front-page.php')))){ ?>
<div id="pageloader" class="dark-div">   
    <div class="loader loader-2"><i></i><i></i><i></i><i></i></div>
</div>
<?php }?>

<?php
	//prepare page title
	global $page_title;
	$page_title = esc_html__('Demo Menu style off canvas','applay');
?>
<div id="body-wrap">
    <div id="wrap">
        <header>
            <?php
			$nav_style = true;
			$nav_des = 'off';
			?>
			<div id="main-nav" class="<?php if(leaf_get_option('nav_schema',false)){echo esc_attr('light-nav');}else{ echo esc_attr('dark-div');} ?> <?php if($nav_des=='off'){?> disable-description <?php }?>" <?php if(leaf_get_option('nav_sticky','on')=='on'){?>data-spy="affix" data-offset-top="280"<?php } ?>>
                <nav class="navbar navbar-inverse <?php if($nav_style){?> style-off-canvas <?php }?>" role="navigation">
                    <div class="container">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <?php if(leaf_get_option('logo_image') == ''):?>
                            <a class="logo" href="<?php echo esc_url( home_url('/') ); ?>"><img src="<?php echo esc_url(get_template_directory_uri()) ?>/images/web-logo.png" alt="<?php esc_attr_e('Logo','applay'); ?>"></a>
                            <?php else:?>
                            <a class="logo" href="<?php echo esc_url( home_url('/') ); ?>" title="<?php wp_title( '|', true, 'right' ); ?>"><img src="<?php echo esc_url(leaf_get_option('logo_image')); ?>" alt="<?php wp_title( '|', true, 'right' ); ?>"/></a>
                            <?php endif;?>
                        </div>
                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="main-menu hidden-xs <?php if($nav_style){?> hidden <?php }?>">
                        	<?php if(leaf_get_option('enable_search')!='off'){ ?>
                        	<ul class="nav navbar-nav navbar-right">
                            	<li><a href="#" class="search-toggle"><i class="fa fa-search"></i></a></li>
                            </ul>
                            <?php } ?>
                            <ul class="nav navbar-nav navbar-right">
                            	<?php
									if(has_nav_menu( 'primary-menus' )){
										wp_nav_menu(array(
											'theme_location'  => 'primary-menus',
											'container' => false,
											'items_wrap' => '%3$s',
											'walker'=> new leafcolor_walker_nav_menu()
										));	
									}else{?>
										<li><a href="<?php echo esc_url( home_url('/') ); ?>"><?php esc_html_e('Home','applay') ?> <span class="menu-description"><?php esc_html_e('Home page','applay') ?></span></a></li>
										<?php wp_list_pages('depth=1&number=4&title_li=' ); ?>
								<?php } ?>
                            </ul>
                        </div><!-- /.navbar-collapse -->
                        <button type="button" class="mobile-menu-toggle <?php if($nav_style){ ?> <?php }else{?> visible-xs <?php }?>">
                            <span class="sr-only"><?php esc_html_e('Menu','applay') ?></span>
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>
                </nav>
            </div><!-- #main-nav -->
            <?php get_template_part( 'templates/header/header', 'frontpage' ); ?>
        </header> 
        <?php
global $global_page_layout;
$global_page_layout = 'true-full';
$single_page_layout = get_post_meta(get_the_ID(),'sidebar_layout',true);
$content_padding = get_post_meta(get_the_ID(),'content_padding',true);
$layout = $single_page_layout ? $single_page_layout : ($global_page_layout ? $global_page_layout : leaf_get_option('page_layout','right'));
$global_page_layout = $layout;
?>
 
    <div id="body">
    	<?php if($layout!='true-full'){ ?>
    	<div class="container">
        <?php }?>
        	<?php if($content_padding!='off'){ ?>
        	<div class="content-pad-4x">
            <?php }?>
                <div class="row">
                    <div id="content" class="<?php if($layout != 'full' && $layout != 'true-full'){?> col-md-9  <?php }else{?>col-md-12 <?php } if($layout == 'left'){?> revert-layout <?php }?>" role="main">
                        <article class="single-page-content">
                        	<?php
							// The Loop
							while ( have_posts() ) : the_post();
								the_content();
							endwhile;
							?>
                        </article>
                    </div><!--/content-->
                    <?php if($layout != 'full' && $layout != 'true-full'){get_sidebar();} ?>
                </div><!--/row-->
            <?php if($content_padding!='off'){ ?>
            </div><!--/content-pad-4x-->
            <?php }?>
        <?php if($layout!='true-full'){ ?>
        </div><!--/container-->
        <?php }?>
    </div><!--/body-->





<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 */
?>
		<div id="bottom-sidebar">
            <div class="container">
                <div class="row normal-sidebar">
                    <?php
                    if ( is_active_sidebar( 'bottom_sidebar' ) ) :
                        dynamic_sidebar( 'bottom_sidebar' );
                    endif;
                    ?>
                </div>
            </div>
        </div>
        <footer class="dark-div main-color-2-bg <?php echo leaf_get_option('fixed_footer')!='off'?'fixed-effect':'' ?>">
        	<div class="footer-inner fixed-effect-inner">
        	<section id="bottom">
            	<div class="section-inner">
                	<div class="container">
                    	<div class="row normal-sidebar">
							<?php
                            if ( is_active_sidebar( 'footer_sidebar' ) ) :
                                dynamic_sidebar( 'footer_sidebar' );
                            endif;
                            ?>
                		</div>
                    </div>
                </div>
            </section>
            <div id="bottom-nav">
                <div class="container">
                	<?php if(leaf_get_option('off_gototop')!='off'){?>
                    <div class="text-center back-to-top-wrap">
                        <a class="back-to-top main-color-2-bg" href="#top" title="<?php esc_html_e('Go to top','applay'); ?>"><i class="fa fa-angle-double-up"></i></a>
                    </div>
                    <?php }?>
                    <div class="row footer-content">
                        <div class="copyright col-md-6">
                       		<?php if(leaf_get_option('copyright')){  echo leaf_get_option('copyright');  } else {echo esc_html__('Applay WordPress Theme by Leafcolor &copy;','applay'); }?>
                        </div>
                        <nav class="col-md-6 footer-social">
                        	<?php 
							$social_account = array(
								'facebook',
								'twitter',
								'linkedin',
								'tumblr',
								'google-plus',
								'pinterest',
								'youtube',
								'flickr',
							);
							?>
                            <ul class="list-inline pull-right social-list">
                            	<?php 
								$social_link_open = leaf_get_option('social_link_open');
								foreach($social_account as $social){
									if($link = leaf_get_option('acc_'.$social,false)){ ?>
                                            <li><a href="<?php echo esc_url($link) ?>" <?php if($social_link_open=='on'){?>target="_blank" <?php }?> class="btn btn-default social-icon"><i class="fa fa-<?php echo esc_attr($social) ?>"></i></a></li>
								<?php }
								}//foreach
								if($custom_acc = leaf_get_option('custom_acc')){
									foreach($custom_acc as $a_social){ ?>
										<li><a href="<?php echo esc_url($a_social['link']) ?>" <?php if($social_link_open=='on'){?>target="_blank" <?php }?> class="btn btn-default social-icon"><i class="fa <?php echo esc_attr($a_social['icon']) ?>"></i></a></li>
									<?php }
								}
								?>
                            </ul>
                        </nav>
                    </div><!--/row-->
                </div><!--/container-->
            </div>
            </div>
        </footer><!--/footer-inner-->
        </div><!--wrap-->
    </div><!--/body-wrap-->
    <div class="mobile-menu-wrap dark-div ">
        <a href="#" class="mobile-menu-toggle"><i class="fa fa-times"></i></a>
        <ul class="mobile-menu">
            <?php
                if(has_nav_menu( 'off-canvas-menus' )){
					  wp_nav_menu(array(
						  'theme_location'  => 'off-canvas-menus',
						  'container' => false,
						  'items_wrap' => '%3$s',
					  ));
				}elseif(has_nav_menu( 'primary-menus' )){
                    wp_nav_menu(array(
                        'theme_location'  => 'primary-menus',
                        'container' => false,
                        'items_wrap' => '%3$s',
                    ));	
                }else{?>
                    <li><a href="<?php echo esc_url( home_url('/') ); ?>"><?php esc_html_e('Home','applay') ?></a></li>
                    <?php wp_list_pages('depth=1&number=4&title_li=' ); ?>
            <?php } ?>
            <?php if(leaf_get_option('enable_search')!='off'){ ?>
            <li><a href="#" class="search-toggle"><i class="fa fa-search"></i></a></li>
            <?php } ?>
        </ul>
    </div>
	<?php if(leaf_get_option('enable_search')!='off'){ ?>
    <div id="off-canvas-search" class="dark-div">
    	<div class="search-inner">
        <div class="container">
            <form action="<?php echo esc_url( home_url('/') ); ?>">
                <input type="text" name="s" id="s" class="form-control search-field font-2" placeholder="<?php esc_attr_e('TYPE AND HIT ENTER...','applay') ?>" autocomplete="off">
                <a href="#" class="search-toggle"><i class="fa fa-times"></i></a>
            </form>
        </div>
        </div>
    </div>
	<?php } //if search ?>
    
<?php echo leaf_get_option('google_analytics_code', ''); ?>    
<?php wp_footer(); ?>
</body>
</html>
