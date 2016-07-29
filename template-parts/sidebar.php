<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package McBoots
 */

if ( !is_active_sidebar( 'sidebar-primary' ) ) {
	return;
}
?>

<aside class="widget-area sidebar-primary <?= sidebar_class(); ?>" role="complementary">
	<?php dynamic_sidebar( 'sidebar-primary' ); ?>
</aside><!-- sidebar-primary -->
