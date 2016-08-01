<?php
/**
 * template-parts/content-page.php
 *
 * Template part for displaying page content in page.php.
 *
 * @package McBoots
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
<?php
	// for singles this is in page-header
	// the_title( '<h1 class="entry-title">', '</h1>' );
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
		<?php edit_post_link(); ?>
	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
