<?php
/**
 * Custom template tags for this theme.
 *
 * @package Vendd
 */

if ( ! function_exists( 'vendd_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 */
function vendd_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'vendd' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( '<i class="fa fa-caret-left"></i> ' . __( 'Older posts', 'vendd' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts', 'vendd' ) . ' <i class="fa fa-caret-right"></i>' ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;


if ( ! function_exists( 'vendd_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function vendd_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'vendd' ); ?></h1>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous"><span class="post-nav-title">' . __( 'Previous Post', 'vendd' ) . ':</span> %link</div>', _x( '%title', 'Previous post link', 'vendd' ) );
				next_post_link( '<div class="nav-next"><span class="post-nav-title">' . __( 'Next Post', 'vendd' ) . ':</span> %link</div>', _x( '%title', 'Next post link',     'vendd' ) );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;


if ( ! function_exists( 'vendd_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function vendd_posted_on() {
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);
	?>
	<span class="byline byline-item">
		<i class="fa fa-pencil"></i>
		<?php
			printf( '<span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_html( get_the_author() )
			);
		?>
	</span>
	<span class="posted-on byline-item">
		<i class="fa fa-calendar"></i>
		<?php
			printf( '<a href="%1$s" rel="bookmark">%2$s</a>',
				esc_url( get_permalink() ),
				$time_string
			);
		?>
	</span>
	<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<span class="comments-link byline-item"><i class="fa fa-comments"></i><?php comments_popup_link( __( 'Comments', 'vendd' ), __( '1 Comment', 'vendd' ), __( '% Comments', 'vendd' ) ); ?></span>
	<?php endif;
}
endif;


if ( ! function_exists( 'vendd_posted_in' ) ) :
/**
 * Prints HTML with category/tag information for the current post-date/time and author.
 */
function vendd_posted_in() { ?>

	<footer class="entry-footer">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'vendd' ) );
				if ( $categories_list && vendd_categorized_blog() ) :
			?>
			<span class="cat-links">
				<i class="fa fa-archive"></i>
				<?php echo $categories_list; ?><br>
			</span>
			<?php endif; // End if categories ?>

			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ', ', 'vendd' ) );
				if ( $tags_list ) :
			?>
			<span class="tags-links">
				<i class="fa fa-tags"></i>
				<?php echo $tags_list; ?>
			</span>
			<?php endif; // End if $tags_list ?>
		<?php endif; // End if 'post' == get_post_type() ?>
	</footer><!-- .entry-footer -->
	<?php
}
endif;


if ( ! function_exists( 'vendd_comment_template' ) ) :
/**
 * Used as a custom callback by wp_list_comments() for displaying
 * the comments and pings.
 */
function vendd_comment_template( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	$avatar_size = apply_filters( 'avatar_size', 48 );

	switch ( $comment->comment_type ) {

		// Pings format
		case 'pingback' :
		case 'trackback' : ?>
			<div class="pingback">
				<span>
					<?php
						echo __( 'Pingback: ', 'vendd'),
						comment_author_link(),
						edit_comment_link( __(' (Edit) ', 'vendd') ); 
					?>
				</span>
			<?php 
			break;

		// Comments format
		default : ?>
			<div <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
				<article id="comment-<?php comment_ID(); ?>" class="comment-full">
					<footer class="comment-footer">
						<div class="comment-author vcard">
							<div class="comment-avatar">
								<?php echo get_avatar( $comment, $avatar_size ); ?>
							</div>
						</div>
						<?php
							if ( '0' == $comment->comment_approved ) : ?>
								<em><?php _e( 'Your comment is awaiting moderation.', 'vendd' ); ?></em><br /> 
								<?php
							endif;
						?>
						<div class="comment-meta commentmetadata">
							<cite class="fn"><?php printf(__( 'by %s', 'vendd' ), get_comment_author_link() ); ?></cite>
							<?php
								// Is it the post author? If so, let us know.
								if ( 'post' == get_post_type() ) {
									$post = get_post( get_the_ID() );
									if ( $comment->user_id === $post->post_author ) {
										echo '<span class="by-post-author"><span class="post-author-icon"><i class="fa fa-pencil"></i></span><span class="post-author-label">' . __( 'post author', 'vendd' ) . '</span></span>';
									}
								}
							?>
							<span class="comment-date">
								<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
									<time pubdate datetime="<?php comment_time( 'c' ); ?>"><?php echo get_comment_date(); // translators: 1: date, 2: time ?></time>
								</a>
								<?php edit_comment_link( __( '(Edit)', 'vendd' ), ' ', ' ' ); ?>
							</span>
						</div>
					</footer>
					<div class="comment-content"> 
						<?php comment_text(); ?>
					</div>
					<div class="reply">
						<?php 
							comment_reply_link(
								array_merge( $args, array(
									'reply_text'	=> '<i class="fa fa-reply"></i> ' . __( 'Reply', 'vendd' ),
									'depth'			=> $depth, 
									'max_depth'		=> $args['max_depth'],
								) )
							);
						?>
					</div>
				</article>
			<?php
			break;
	}
}
endif;


/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function vendd_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'vendd_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'vendd_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so vendd_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so vendd_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in vendd_categorized_blog.
 */
function vendd_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'vendd_categories' );
}
add_action( 'edit_category', 'vendd_category_transient_flusher' );
add_action( 'save_post',     'vendd_category_transient_flusher' );
