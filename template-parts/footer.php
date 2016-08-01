<?php
/**
 * The template for displaying the footer.
 *
 * @package McBoots
 */
?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'mcboots' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'mcboots' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'mcboots' ), 'mcboots', '<a href="https://www.donnamcmaster.com/" rel="designer">Donna McMaster</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
