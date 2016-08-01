<?php
/**
 * entry-meta-foot.php
 * 
 * used in the post footer to display meta information about cats, tags, comments, dates, etc
 * this version is adapted from DMc's 2014 Roots child theme
 *
 * @package McBoots
 */

	$byline = get_post_meta( $post->ID, 'byline', true );

	if ( $byline ) {
?>
<p class="byline author vcard">
	<?php echo $byline; ?>
</p>
<?php
	}
?>
<p class="entry-meta">
Posted <time class="published" datetime="<?php echo get_the_time('c'); ?>"><?php echo get_the_date(); ?></time>
<?php
	$categories_list = get_the_category_list( ', ' );
	if ( $categories_list ) {
		echo ' in ', $categories_list;
	}
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		echo "<br>Tagged $tag_list";
	}
?>
</p>


<?php
/**
 * ALTERNATE VERSION from _s
 *
 * Prints HTML with meta information for the categories, tags and comments.

	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		// translators: used between list items, there is a space after the comma
		$categories_list = get_the_category_list( esc_html__( ', ', 'mcboots' ) );
		if ( $categories_list && mcboots_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'mcboots' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		// translators: used between list items, there is a space after the comma
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'mcboots' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'mcboots' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		// translators: %s: post title
		comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'mcboots' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			// translators: %s: Name of current post
			esc_html__( 'Edit %s', 'mcboots' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
 */