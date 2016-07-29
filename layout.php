<?php
	use McBoots\Template;

	return function( $main_content ) {
	ob_start();

?><!doctype html>
<html <?php language_attributes(); ?>>
<?php get_template_part( 'template-parts/head' ); ?>

<body <?php body_class(); ?>>
<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'mcboots' ); ?></a>
<div id="page" class="site">

<?php
	// add the <header> element
	do_action( 'get_header' );
	get_template_part( 'template-parts/header' );
?>

<div class="content container" id="content"role="document">
	<div class="row">
		<main class="site-main <?= Template\main_class(); ?>" role="main">
<?php
	echo $main_content;
	edit_post_link();
?>
		</main>

<?php
	// allow for an optional single sidebar
	if ( Template\display_sidebar() ) {
		get_template_part( 'template-parts/sidebar', 'primary' );
	}
?>
	</div><!-- row -->
</div><!-- content container -->

<?php
	// allow for a full-width aside between content and footer
	if ( Template\display_sidebar( 'footbar' ) ) {
		get_template_part( 'template-parts/aside', 'footbar' );
	}

	// add the <footer> element
	do_action( 'get_footer' );
	get_template_part( 'template-parts/footer' );
?>
</div><!-- #page -->

<?php
	wp_footer();
?>
</body>
</html>

<?php
	return ob_get_clean();
};
