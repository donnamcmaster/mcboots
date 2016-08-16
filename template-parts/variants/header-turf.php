<?php
/**
 * Theme Header
 *
 * This is the template that displays the top <header> section that contains:
 * - logo and other branding
 * - main navigation
 *
 * Example: http://tgwca.org/
 * - very simple
 * - utility/site menu upper right
 * - logo left and tagline to the right of it
 * - full-width nav bar separates header from body
 *
 * @package McBoots
 */
?>

<header class="banner navbar navbar-default navbar-static-top" role="banner">
	<div class="container branding">

		<div class="utility-menu no-phone">
			<?php wp_nav_menu( ['theme_location' => 'utility_menu', 'menu_class' => 'nav utility-nav'] ); ?>
		</div><!-- utility-menu -->

		<div class="navbar-header">
			<div class="site-logo">
				<a class="navbar-brand" href="/" rel="home">
					<?php bloginfo( 'name' ); ?>
					<img class="logo" src="<?php echo MCW_IMG_DIR.'logo.png';?>">
					<span class="logo-text">Tagline</span>
				</a>
			</div>
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse" aria-controls="primary-menu" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div><!-- .navbar-header -->
	</div><!-- .branding -->

	<div class="container primary-nav">
		<nav class="collapse navbar-collapse" role="navigation">
			<?php wp_nav_menu( ['theme_location' => 'primary_navigation', 'menu_class' => 'nav navbar-nav'] ); ?>
		</nav>
	</div><!-- primary-nav -->
</header>
