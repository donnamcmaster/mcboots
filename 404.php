<?php
/**
 * The template for displaying 404 pages (not found).
 * 
 * @package McBoots
 */
?>

		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'mcboots' ); ?></h1>
		</header><!-- .page-header -->

		<div class="page-content">
			<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'mcboots' ); ?></p>

			<?php
				get_search_form();
			?>

		</div><!-- .page-content -->
