<?php get_template_part( 'template-parts/head' ); ?>
<body <?php body_class(); ?>>
<div class="wrapper">

<!--[if lt IE 8]>
	<div class="alert alert-warning">
		<?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'roots'); ?>
	</div>
<![endif]-->

<?php
	do_action( 'get_header' );
	// Use Bootstrap's navbar if enabled in config.php
	if ( current_theme_supports( 'bootstrap-top-navbar' ) ) {
		get_template_part( 'template-parts/header-top-navbar' );
	} else {
		get_template_part( 'template-parts/header' );
	}

	if ( is_front_page() ) {
		get_template_part( 'template-parts/front-feature-img' );
	}

	// now the main content body
?>
<div class="wrap container" role="document">
	<?php get_template_part( 'template-parts/breadcrumbs' ); ?>
	<?php get_template_part( 'template-parts/page-feature-img' ); ?>
	<div class="content row">
		<main class="main <?php echo roots_main_class(); ?>" role="main">
			<?php include roots_template_path(); ?>
			<?php edit_post_link(); ?>
		</main><!-- /.main -->

<?php
	if ( roots_display_sidebar() ) {
?>
		<aside class="sidebar <?php echo roots_sidebar_class(); ?>" role="complementary">
			<?php include roots_sidebar_path(); ?>
		</aside><!-- /.sidebar -->

<?php
	}
?>
	</div><!-- /.content -->
</div><!-- /.wrap -->

<?php
	get_template_part('template-parts/footer');
?>

</div><!-- /.wrapper -->
</body>
</html>