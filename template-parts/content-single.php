<?php
/**
 * template-parts/content-single.php
 *
 * Template part for displaying a single post where post_type = "post"
 * - to display custom post types differently, use content-single-<post_type>.php
 * - to display post formats differently, use content-single-<post_format>.php
 * Note: don't name your post type the same as a post format that you're using!
 *
 * @package McBoots
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">

<?php
//	the_title( '<h1 class="entry-title">', '</h1>' );	// for singles this is in page-header
	get_template_part( 'templates/entry-meta', 'head' );

?>
	</header><!-- .entry-header -->

	<div class="entry-content">

<?php
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'mcboots' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'mcboots' ),
				'after'  => '</div>',
			) );
?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php get_template_part( 'templates/entry-meta', 'foot' ); ?>
	</footer><!-- .entry-footer -->

</article><!-- #post-## -->

<?php
	the_post_navigation();

	// if comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) :
		comments_template();
	endif;