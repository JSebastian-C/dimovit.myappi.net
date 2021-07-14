<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to twentytwelve_comment() which is
 * located in the functions.php file.
 */

if ( post_password_required() )
	return;
if (!comments_open())
	return;
?>

<div id="comments" class="comments-area">
    <h4 class="count-title"><?php echo comments_number('');?></h4>
	<div class="comment-form-tm">
	<?php $ycom= esc_html__('Your comment ...','applay'); ?>
	<?php comment_form_leaf_custom(array('logged_in_as'=>'','comment_notes_before'=>'','comment_field'=>'
	
	<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" onblur="if(this.value == \'\') this.value = \''.esc_html__('Your comment ...','applay').'\';" onfocus="if(this.value == \''.esc_html__('Your comment ...','applay').'\') this.value = \'\';">'.esc_html__('Your comment ...','applay').'</textarea></p>',
	'title_reply'=>'',
	'id_submit'=>'comment-submit')); 
	?>
    </div>
	<?php if ( have_comments() ) : ?>
		<ul class="commentlist">
			<?php wp_list_comments( array( 'callback' => 'leafcolor_comment', 'style' => 'ul' ) ); ?>
		</ul><!-- .commentlist -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="navigation" role="navigation">
			<h1 class="assistive-text section-heading"><?php esc_html_e( 'Comment navigation', 'applay' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'applay' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'applay' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>
	<?php endif; // have_comments() ?>
	<div class="hidden hide"><?php comment_form();?></div>

</div><!-- #comments .comments-area -->