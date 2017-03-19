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
			<a class="navbar-brand" href="<?= home_url(); ?>/" rel="home"><?= bloginfo( 'name' ); ?></a>
		</div>

		<?php if ( has_nav_menu( 'primary_navigation' ) ) : ?>
			<nav class="collapse navbar-collapse" role="navigation">
				<?php wp_nav_menu( ['theme_location' => 'primary_navigation', 'menu_class' => 'nav navbar-nav'] ); ?>
			</nav>
		<?php endif; ?>
	</div>
</header>
