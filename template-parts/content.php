<?php
/**
 * template-parts/content.php
 *
 * Template part for displaying posts in a list (e.g., index, archive).
 * Customized for post_type = "post"
 * - to display custom post types differently, use content-<post_type>.php
 * - to display post formats differently, use content-<post_format>.php
 * Note: don't name your post type the same as a post format that you're using!
 *
 * @package McBoots
 */
?>

<li>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
<?php
		the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		if ( 'post' === get_post_type() ) {
			get_template_part( 'templates/entry-meta', 'head' );
		}
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

		<footer>
<?php
		if ( 'post' === get_post_type() ) {
			get_template_part( 'templates/entry-meta', 'foot' );
		}
?>
		</footer>
	</article><!-- #post-## -->
</li>