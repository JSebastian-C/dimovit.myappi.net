<div class="single-post-content-text content-pad">
	<?php 
	if(get_post_format()=='video' || get_post_format()=='audio'){
		$content =  preg_replace ('#<embed(.*?)>(.*)#is', ' ', get_the_content());
		$content =  preg_replace ('@<iframe[^>]*?>.*?</iframe>@siu', ' ', $content);
		preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $content, $match);
		foreach ($match[0] as $amatch) {
			if(strpos($amatch,'youtube.com') !== false || strpos($amatch,'vimeo.com') !== false || strpos($amatch,'soundcloud.com') !== false){
				$content = str_replace($amatch, '', $content);
			}
		}
		echo wp_kses_post($content = preg_replace('%<object.+?</object>%is', '', $content));
	}else{ the_content(); }?>
</div>
<?php
$pagiarg = array(
	'before'           => '<div class="single-post-pagi">'.esc_html__( 'Pages:','applay'),
	'after'            => '</div>',
	'link_before'      => '<span type="button" class="btn btn-default btn-sm">',
	'link_after'       => '</span>',
	'next_or_number'   => 'number',
	'separator'        => ' ',
	'nextpagelink'     => esc_html__( 'Next page','applay'),
	'previouspagelink' => esc_html__( 'Previous page','applay'),
	'pagelink'         => '%',
	'echo'             => 1
);
wp_link_pages($pagiarg); ?>
<div class="clearfix"></div>
<div class="item-meta single-post-meta content-pad">
	<?php if(leaf_get_option('enable_author_info')!='off'){ ?>
    <div class="media">
        <div class="pull-left"><i class="fa fa-user"></i></div>
        <div class="media-body">
            <?php esc_html_e('Author','applay') ?>
            <div class="media-heading"><span class="vcard author"><span class="fn"><?php the_author_posts_link(); ?></span></span></div>
        </div>
    </div>
    <?php }?>
    <?php if(leaf_get_option('single_published_date')!='off'){ ?>
    <div class="media">
        <div class="pull-left"><i class="fa fa-calendar"></i></div>
        <div class="media-body">
            <?php esc_html_e('Published','applay') ?>
            <div class="media-heading" rel="bookmark"><time datetime="<?php echo get_the_date('c', get_the_ID());?>" class="entry-date updated"><?php the_time(get_option('date_format')); ?></time></div>
        </div>
    </div>
    <?php }?>
    <?php if(leaf_get_option('single_categories')!='off'){ ?>
    <div class="media">
        <div class="pull-left"><i class="fa fa-bookmark"></i></div>
        <div class="media-body">
            <?php esc_html_e('Categories','applay') ?>
            <div class="media-heading"><?php the_category(' <span class="dot">.</span> '); ?></div>
        </div>
    </div>
    <?php }?>
    <?php if(leaf_get_option('single_tags')!='off' && has_tag()){ ?>
    <div class="media">
        <div class="pull-left"><i class="fa fa-tags"></i></div>
        <div class="media-body">
            <?php esc_html_e('Tags','applay') ?>
            <div class="media-heading"><?php the_tags('', ', ', ''); ?></div>
        </div>
    </div>
    <?php }?>
    <?php if(leaf_get_option('single_cm_count')!='off'){ ?>
    <?php if(comments_open()){ ?>
    <div class="media">
        <div class="pull-left"><i class="fa fa-comment"></i></div>
        <div class="media-body">
            <?php esc_html_e('Comment','applay') ?>
            <div class="media-heading"><a href="#comment"><?php comments_number(esc_html__('0 Comments','applay'),esc_html__('1 Comment','applay')); ?></a></div>
        </div>
    </div>
	<?php } //check comment open?>
    <?php }?>
</div>
<ul class="list-inline social-light single-post-share">
	<?php if(function_exists('leafcolor_social_share')){ leafcolor_social_share(); } ?>
</ul>