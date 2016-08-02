<?php

/**
 * Class Base_Views
 *
 * Default functions for template pieces. 
 * Called from index.php, page.php, and other template files. 
 * 
 * Subclasses are defined for each post_type, e.g., Post_Views. 
 * Each post_type class can override any of the Base_Views functions. 
 *
 * @package McBoots
 */

class Base_Views {

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
	public static function render_list_item () {
		$post_type = get_post_type();
		$post_type_class = $post_type.'_Views';

		ob_start();
?>

<li>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<header class="entry-header">
<?php
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			echo $post_type_class::entry_meta_head( false );
?>
		</header><!-- .entry-header -->

		<div class="entry-content entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- entry-content entry-summary -->

		<footer>
<?php
			echo $post_type_class::entry_meta_foot( false );
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
	public static function render_singular () {
		$post_type = get_post_type();
		$post_type_class = $post_type.'_Views';

		ob_start();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">

<?php
		// for singles the title is in the page-header

		// type 'post' and possibly others have entry meta, e.g., author & date
		echo $post_type_class::entry_meta_head( true );
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
		echo $post_type_class::entry_meta_foot( true );
		edit_post_link();
?>
	</footer><!-- .entry-footer -->

</article><!-- #post-## -->

<?php
		echo $post_type_class::post_navigation( true );
		echo $post_type_class::comments_template( true );

		return ob_get_clean();
	}


/**
 * Smaller Parts
 *
 * Default functions for optional template pieces. 
 * Can be overridden by a subclass of Base_Views. 
 * Most of these apply only to type 'post' (blog posts). 
 */
	public static function entry_meta_head ( $is_singular, $is_search=false ) {
		return '';
	}

	public static function entry_meta_foot ( $is_singular, $is_search=false ) {
		return '';
	}

	public static function post_navigation ( $is_singular, $is_search=false ) {
		return '';
	}

	public static function comments_template ( $is_singular, $is_search=false ) {
		return '';
	}


} // class