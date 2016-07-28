<?php get_template_part( 'template-parts/head' ); ?>
<body <?php body_class(); ?>>

<!--[if lt IE 8]>
	<div class="alert alert-warning">
		<?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'roots'); ?>
	</div>
<![endif]-->

<?php
	do_action( 'get_header' );
	get_template_part( 'template-parts/header-top-navbar' );
	if ( is_front_page() ) {
		get_template_part( 'template-parts/home-slides' );
	} else {
		get_template_part( 'template-parts/featured-image' );
	}

	// now the content
?>
<div class="content" role="document">
	<div class="content-header container">
		<?php get_template_part('template-parts/breadcrumbs'); ?>
		<?php get_template_part('template-parts/page', 'header'); ?>
	</div>

<?php
	if ( roots_display_sidebar() ) {
		// main and sidebar are INSIDE a container
?>

	<div class="content-body container">
		<div class="row">
			<main class="main <?php echo roots_main_class(); ?>" role="main">
				<?php include roots_template_path(); ?>
				<?php edit_post_link(); ?>
			</main><!-- main -->
			<aside class="sidebar <?php echo roots_sidebar_class(); ?>" role="complementary">
				<?php get_template_part( 'template-parts/sidebar', 'blog' ); ?>
			</aside><!-- sidebar -->
		</div><!-- row -->
	</div><!-- content-body container -->

<?php
	} else {
		// main may CONTAIN multiple containers
?>
	<main class="main" role="main">
		<div class="content-panel container">
			<?php include roots_template_path(); ?>
			<?php edit_post_link(); ?>
		</div><!-- content-panel container -->
	</main><!-- main -->

<?php
	}
?>


</div><!-- content -->

<?php
	if ( is_front_page() ) {
		get_template_part( 'template-parts/aside', 'footbar' );
	}
?>

<?php
	get_template_part('template-parts/footer');
?>

</body>
</html>