<?php
/**
 *	Register Sidebars / Widget Areas
 *
 *	@package McBoots
 */

add_action( 'after_setup_theme', function() {

	if ( current_theme_supports ( 'mcboots-sidebars' ) ) {

		add_action( 'widgets_init', function() {
			register_sidebar( array(
				'name'          => esc_html__( 'Primary Sidebar', 'mcboots' ),
				'id'            => 'sidebar-primary',
				'description'   => esc_html__( 'Appears on most pages.', 'mcboots' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			) );

			// for blog pages only
			if ( current_theme_supports ( 'mcboots-blog' ) ) {
				register_sidebar( array(
					'name'          => esc_html__( 'Blog Sidebar', 'mcboots' ),
					'id'            => 'sidebar-blog',
					'description'   => esc_html__( 'Appears only on blog pages.', 'mcboots' ),
					'before_widget' => '<section id="%1$s" class="widget %2$s">',
					'after_widget'  => '</section>',
					'before_title'  => '<h2 class="widget-title">',
					'after_title'   => '</h2>',
				) );
			}
		}); // end "widgets_init" action

	}
	
}, 99 ); // end "after_setup_theme" action
