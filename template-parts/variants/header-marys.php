<?php
/**
 * Theme Header
 *
 * This is the template that displays the top <header> section that contains:
 * - logo and other branding
 * - main navigation
 *
 * Example: http://mrwc.org/
 * - very simple
 * - utility/site menu upper right
 * - logo left, tagline far right
 * - full-width nav bar separates header from body
 * - phone size has donate button at bottom of header
 *
 * @package McBoots
 */
?>

<header class="banner navbar navbar-default navbar-static-top" role="banner">
	<div class="container branding">
		<div class="navbar-header">
			<div class="site-logo">
				<a class="navbar-brand" href="/">
					<img class="logo" width="94px" src="<?php echo MCW_IMG_DIR.'c-logo.jpg';?>">
					<img class="logo-text" src="<?php echo MCW_IMG_DIR.'logo-text.png';?>">
				</a>
			</div>
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>

			<div class="site-logo-text">
				<a class="navbar-brand" href="/"></a>
			</div>

			<div class="utility-menu no-phone">
				<?php wp_nav_menu( ['theme_location' => 'utility_menu', 'menu_class' => 'nav utility-nav'] ); ?>
			</div><!-- utility-menu -->

			<div class="header-text">
				Tagline
			</div>
		</div><!-- .navbar-header -->
	</div><!-- .container -->

	<div class="container primary-nav">
		<nav class="collapse navbar-collapse" role="navigation">
			<?php wp_nav_menu( ['theme_location' => 'primary_navigation', 'menu_class' => 'nav navbar-nav'] ); ?>
		</nav>
	</div><!-- primary-nav -->
	<div class="phone-only donate-button">
		<a class="btn btn-primary" href="/donate/">Donate!</a>
	</div><!-- donate-button -->
</header>