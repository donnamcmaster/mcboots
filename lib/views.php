<?php
/**
 * Views
 *
 * Default functions for the content parts of templates. 
 * Called from index.php, page.php, and other template files. 
 * 
 * Subclasses are defined for each post_type, e.g., Post_Views. 
 * Each post_type class can override any of the Base_Views functions. 
 *
 * @package McBoots
 */

namespace McBoots\Views;

/**
 * Method render_list_item
 *
 * Template part for displaying one post in a page that lists multiple posts.
 * Uses WordPress template functions and assumes that we are in the loop. 
 * Compare to _s file: template-parts/content.php.
 *
 * Includes generic options plus calls to optional entry meta, post nav, and comments. 
 * - to display custom post types differently, override in Class {$post_type}_Views. 
 * - to display post formats differently, use content-single-<post_format>.php
 */
function render_list_item ( $post_type ) {
	ob_start();
?>

<li>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<header class="entry-header">
<?php
	the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
	echo entry_meta_head( $post_type, false );
?>
		</header><!-- .entry-header -->

		<div class="entry-content entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- entry-content entry-summary -->

		<footer>
<?php
	echo entry_meta_foot( $post_type, false );
	edit_post_link();
?>
		</footer>

	</article><!-- #post-## -->

</li>
<?php
	return ob_get_clean();
}


/**
 * Method render_singular
 *
 * Template part for displaying a singular post (of any type).
 * Uses WordPress template functions and assumes that we are in the loop. 
 * Compare to _s files: template-parts/content-single.php or template-parts/content-page.php
 *
 * Includes generic options plus calls to optional entry meta, post nav, and comments. 
 * - to display custom post types differently, override in Class {$post_type}_Views. 
 * - to display post formats differently, use content-single-<post_format>.php
 */
function render_singular ( $post_type ) {

	ob_start();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">

<?php
	// for singles the title is in the page-header

	// type 'post' and possibly others have entry meta, e.g., author & date
	echo entry_meta_head( $post_type, true );
?>

	</header><!-- .entry-header -->

	<div class="entry-content">
<?php
	the_content();

	// for multi-page articles
	wp_link_pages( array(
		'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'mcboots' ),
		'after'  => '</div>',
	) );
?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
<?php
	echo entry_meta_foot( $post_type, true );
	edit_post_link();
?>
	</footer><!-- .entry-footer -->

</article><!-- #post-## -->

<?php
	echo post_navigation( $post_type, true );
	echo render_comments( $post_type, true );

	return ob_get_clean();
}


/**
 * Smaller Parts
 *
 * Default functions for optional template pieces. 
 * Can be overridden by a subclass of Base_Views. 
 * Most of these apply only to type 'post' (blog posts). 
 */
function entry_meta_head ( $post_type, $is_singular, $is_search=false ) {
	if ( $post_type == 'post' ) {
		get_template_part( 'template-parts/entry-meta', 'head' );
	} else {
		return '';
	}
}

function entry_meta_foot ( $post_type, $is_singular, $is_search=false ) {
	if ( $post_type == 'post' ) {
		get_template_part( 'template-parts/entry-meta', 'foot' );
	} else {
		return '';
	}
}

function post_navigation ( $post_type, $is_singular, $is_search=false ) {
	if ( $post_type == 'post' ) {
		the_post_navigation();
	}
}

function render_comments ( $post_type, $is_singular, $is_search=false ) {
	// if comments are open or we have at least one comment, load up the comment template.
	if ( ( $post_type == 'post' ) && ( comments_open() || get_comments_number() ) ) {
		comments_template();
	}
}
