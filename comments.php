<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package Vendd
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<span class="comments-title"><i class="fa fa-comments"></i>
			<?php
				printf( _nx( 'One response... ', '%1$s responses... ', get_comments_number(), 'comments title', 'vendd' ),
					number_format_i18n( get_comments_number() )
				);
			?>
			<?php if ( comments_open() ) : ?>
				<a href="#commentform" class="add-comment"><?php _e( 'add one', 'vendd' ); ?></a>
			<?php endif; ?>
		</span>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-above" class="comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'vendd' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( '<i class="fa fa-chevron-left"></i> ' . __( 'Older Comments', 'vendd' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments', 'vendd' ) . ' <i class="fa fa-chevron-right"></i>' ); ?></div>
		</nav><!-- #comment-nav-above -->
		<?php endif; // check for comment navigation ?>

		<div class="comment-list">
			<?php
				wp_list_comments( array(
					'style'      => 'div',
					'callback'	=> 'vendd_comment_template'
				) );
			?>
		</div><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'vendd' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( '<i class="fa fa-chevron-left"></i> ' . __( 'Older Comments', 'vendd' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments', 'vendd' ) . ' <i class="fa fa-chevron-right"></i>' ); ?></div>
		</nav><!-- #comment-nav-below -->
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'vendd' ); ?></p>
	<?php endif; ?>
	<?php 
		$commenter = wp_get_current_commenter();
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );
		comment_form( 
			array(
				'id_form'				=> 'commentform',
				'id_submit'				=> 'submit',
				'title_reply'			=> __( 'Leave a Reply', 'vendd' ),
				'title_reply_to'		=> __( 'Leave a Reply to %s', 'vendd' ),
				'cancel_reply_link'		=> __( 'Cancel Reply', 'vendd' ),
				'label_submit'			=> __( 'Post Comment', 'vendd' ),	
				'comment_field'			=>  '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true">' . '</textarea></p>',	
				'must_log_in'			=> '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'vendd' ), wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) ) . '</p>',	
				'logged_in_as'			=> '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'vendd' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',	
				'comment_notes_before'	=> '',	
				'comment_notes_after'	=> '',	
				'fields'				=> apply_filters( 'comment_form_default_fields', array(
					'author'				=> '<p class="comment-form-author comment-form-field"><input id="author" name="author" type="text" placeholder="' . __( 'Name (required)', 'vendd' ) . '"' . $aria_req . ' /></p>',

					'email'					=> '<p class="comment-form-email comment-form-field"><input id="email" name="email" type="email" placeholder="' . __( 'Email (required)', 'vendd' ) . '"' . $aria_req . ' /></p>',

					'url'					=> '<p class="comment-form-url comment-form-field"><input id="url" name="url" type="url" placeholder="' . __( 'Website URL', 'vendd' ) . '" /></p>'
					)
				),
			) 
		);
	?>

</div><!-- #comments -->
