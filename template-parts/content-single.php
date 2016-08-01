<?php
/**
 * template-parts/content-single.php
 *
 * Template part for displaying a single post
 * Generic plus entry meta for post_type = "post"
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
	// for singles this is in page-header
	// the_title( '<h1 class="entry-title">', '</h1>' );
	if ( 'post' === get_post_type() ) {
		get_template_part( 'template-parts/entry-meta', 'head' );
	}
?>
	</header><!-- .entry-header -->

	<div class="entry-content">
<?php
	the_content();
	wp_link_pages( array(
		'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'mcboots' ),
		'after'  => '</div>',
	) );
?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
<?php
	if ( 'post' === get_post_type() ) {
		get_template_part( 'template-parts/entry-meta', 'foot' );
	}
	edit_post_link();
?>
	</footer><!-- .entry-footer -->

</article><!-- #post-## -->

<?php
	the_post_navigation();

	// if comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) :
		comments_template();
	endif;