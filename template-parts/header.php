<?php
/**
 * Theme Header
 *
 * This is the template that displays the top <header> section that contains:
 * - logo and other branding
 * - main navigation
 *
 * @package McBoots
 */
?>

<header class="banner navbar navbar-default navbar-static-top" role="banner">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse" aria-controls="primary-menu" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo home_url(); ?>/" rel="home"><?= bloginfo( 'name' ); ?></a>
		</div>

		<?php if ( has_nav_menu( 'primary' ) ) : ?>
			<nav class="collapse navbar-collapse" role="navigation">
				<?php wp_nav_menu( ['theme_location' => 'primary_navigation', 'menu_class' => 'nav navbar-nav'] ); ?>
			</nav>
		<?php endif; ?>

		<?php if ( has_nav_menu( 'utility_menu' ) ) : ?>
			<div class="utility-menu no-phone">
				<?php wp_nav_menu( ['theme_location' => 'utility_menu', 'menu_class' => 'nav utility-nav'] ); ?>
			</div><!-- utility-menu -->
		<?php endif; ?>
	</div>
</header>
