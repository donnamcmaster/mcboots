<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package McBoots
 */

use McBoots\Template;

if ( !is_active_sidebar( 'sidebar-primary' ) ) {
	mcw_log( "expected active 'sidebar-primary' in template-parts/sidebar.php" );
	return;
}
?>
<aside class="widget-area sidebar-primary <?= Template\sidebar_class(); ?>" role="complementary">
	<?php dynamic_sidebar( 'sidebar-primary' ); ?>
</aside><!-- sidebar-primary -->
