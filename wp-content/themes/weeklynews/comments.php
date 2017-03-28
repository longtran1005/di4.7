<?php
/**
 * The template for displaying Comments
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

?>

<!-- start:article-comments -->
<section id="comments">

    <?php if ( have_comments() ) : ?>
	
	<header>
	    <h2><?php printf( _n( '1 Comment', '%1$s Comments', get_comments_number(), THEMENAME ), number_format_i18n( get_comments_number() ) ); ?></h2>
	    <span class="borderline"></span>
	</header>
    
	<ol id="comments-list">
	<?php
	    wp_list_comments( array(
		'style' => 'ol',
		'short_ping' => true,
		'avatar_size' => 75,
		'callback' => 'miptheme_comments_callback',
		'walker' => new MipTheme_Walker_Comment
	    ) );
	?>
	</ol><!-- .comment-list -->
	
	<div class="comment-pagination">
		<?php paginate_comments_links(); ?>
	</div>

    <?php endif; // have_comments() ?>

</section>
<!-- end:article-comments -->

<!-- start:article-comments-form -->
<section id="article-comments-form">

	<?php
	
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
            
        $fields =  array(
			'author' =>
				'<div class="row bottom-margin">
					<div class="col-sm-4">
						<span class="comment-req-wrap needsclick"><input class="form-control" id="author" name="author" placeholder="' . __('Name:', THEMENAME) . '" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />' . ( $req ? '</span>' : '' ) .
				'	</div>',
	
			'email'  =>
				'	<div class="col-sm-4">
						<span class="comment-req-wrap needsclick"><input class="form-control" id="email" name="email" placeholder="' . __('Email:', THEMENAME) . '" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' />' . ( $req ? '</span>' : '' ) .
				'	</div>',
	
			'url' =>
				'	<div class="col-sm-4">
						<input class="form-control" id="url" name="url" placeholder="' . __('Website:', THEMENAME) . '" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" />' .
				'	</div>
				</div>',
		);

	$defaults = array(
		'fields' => apply_filters('comment_form_default_fields', $fields ),
	);

	$defaults['comment_field'] = '<div class="row bottom-margin">
		<div class="col-md-12">
			<textarea class="form-control needsclick" placeholder="' . __('Comment:', THEMENAME) . '" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
		</div>
	</div>';

	$defaults['comment_notes_before'] = '';
	$defaults['comment_notes_after'] = '';
	$defaults['title_reply'] = __('Leave a Reply', THEMENAME);
	$defaults['label_submit'] = __('Post Comment', THEMENAME);
	$defaults['cancel_reply_link'] = __('Cancel reply', THEMENAME);

	comment_form($defaults);
	?>
	
</section>
<!-- end:article-comments-form -->       




<?php
/**
* Custom callback for outputting comments
*/

function miptheme_comments_callback( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	if ( $comment->comment_approved == '1' ) {
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div class="comment" id="comment-<?php comment_ID(); ?>">
			<?php echo get_avatar( $comment->comment_author_email, 75 ); ?>
			<div class="comment-text">
				<header>
					<h5 class="pull-left"><?php comment_author_link() ?></h5>
					<span class="time-stamp"><?php comment_date() ?> <?php _e('at', THEMENAME) ?> <?php comment_time() ?></span>
					<?php
						comment_reply_link(array_merge( $args, array(
							'depth' => $depth,
							'max_depth' => $args['max_depth'],
							'reply_text' => __('Reply <span>&darr;</span>', THEMENAME),
							'login_text' =>  __('Log in to leave a comment <span>&darr;</span>', THEMENAME),
							'before' => '<span class="reply pull-right">',
							'after' => '</span>'
						)))
					?>
				</header>
				<?php comment_text(); ?>
			</div>
		</div>
	</li>
<?php
	}
}
?>
