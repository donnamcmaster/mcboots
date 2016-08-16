<?php
/**
 * Theme Footer
 *
 * @package McBoots
 */
?>

<footer class="content-info container" role="contentinfo">
	<div class="site-info">
		<?php wp_nav_menu( array( 'theme_location' => 'Footer Menu', 'menu' => 'Footer Menu', 'menu_class' => 'nav-footer' ) ); ?>
		<p class="pull-right">&copy; <?= bloginfo( 'name' ); ?> <?php echo date('Y'); ?></p>
		<p class="pull-left"> <a class="grey" href="#">Privacy Policy</a> | <a class="grey" href="#">Sitemap</a></p>
	</div><!-- .site-info -->
</footer><!-- .content-info -->
