<?php
/**
 * Layout
 * - defines the skeleton of the rendered page
 * - called from lib/layout-wrapper.php 
 *
 * @package McBoots
 */

use McBoots\Template;

return function( $template ) {
	ob_start();

?><!doctype html>
<html <?php language_attributes(); ?>>
<?php get_template_part( 'template-parts/head' ); ?>

<body <?php body_class(); ?>>
<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'mcboots' ); ?></a>

<div class="wrapper container">

	<?php get_header(); ?>

	<div class="content" id="content" role="document">
		<div class="row">
			<main class="site-main <?= Template\main_class(); ?>" role="main">
				<?php include( $template ); ?>
			</main>

<?php
	// allow for an optional single sidebar
	if ( Template\display_sidebar() ) {
		get_template_part( 'template-parts/sidebar', 'primary' );
	}
?>
		</div><!-- row -->
	</div><!-- content -->

<?php
	// allow for a full-width aside between content and footer
	if ( Template\display_sidebar( 'footbar' ) ) {
		get_template_part( 'template-parts/aside', 'footbar' );
	}

	// add the <footer> element
	get_footer();
?>
</div><!-- wrapper container -->

<?php wp_footer(); ?>

</body>
</html>

<?php
	return ob_get_clean();
};
