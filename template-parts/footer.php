<?php
/**
 * The template for displaying the footer.
 *
 * @package McBoots
 */
?>

<footer class="content-info" role="contentinfo">
	<div class="site-info">
		<?php if ( has_nav_menu( 'footer_menu' ) ) : ?>
			<?php wp_nav_menu( array( 'theme_location' => 'footer_menu', 'menu' => 'Footer Menu', 'menu_class' => 'nav-footer' ) ); ?>
		<?php endif; ?>
		<p class="pull-right">&copy; <?= bloginfo( 'name' ); ?> <?php echo date('Y'); ?></p>
		<p class="pull-left"> <a class="grey" href="#">Privacy Policy</a> | <a class="grey" href="#">Sitemap</a></p>
	</div><!-- .site-info -->
</footer><!-- .content-info -->
