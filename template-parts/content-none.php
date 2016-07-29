<?php
/**
 * Template part for displaying a message that posts cannot be found.
 * Used for 404, search failure, and empty archive pages.
 *
 * @package McBoots
 */

	if ( is_search() ) {
		$message = esc_html( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'mcboots' );
	} else {
		$message = esc_html( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'mcboots' );
	}

?>
	<div class="entry-content">
		<p><?=$message; ?></p>
		<?php get_search_form(); ?>
	</div><!-- .entry-content -->
