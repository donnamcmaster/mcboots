<?php
namespace McBoots\Navigation;

/**
 * Bootstrap menu class injection
 */
function bootstrap_menu_objects($sorted_menu_items, $args)
{
    if($args->theme_location == 'primary')
    {//
        $current = array('current-menu-ancestor', 'current-menu-item');
        $registry = array();
        foreach($sorted_menu_items as $i => $item) {
            $is_current = array_intersect( (array) $item->classes, $current );
            if ( !empty($is_current) ) $item->classes[] = 'active';
            $registry[$item->ID] = $i;
            if($item->menu_item_parent) {
                $parent_index = $registry[$item->menu_item_parent];
                if( !in_array('dropdown', $sorted_menu_items[$parent_index]->classes) ) {
                    $sorted_menu_items[$parent_index]->classes[] = 'dropdown';
                }
            }
        }
        //print_r($sorted_menu_items);print_r($args);exit;
    }
    return $sorted_menu_items;
}
add_filter( 'wp_nav_menu_objects', 'bootstrap_menu_objects', 10, 2 );




// below this line is the _strap nav walker code

/**
 * Custom Bootstrap Walker
 */
class Bootstrap_Nav_Menu extends Walker_Nav_Menu {
    /**
     * @see Walker::start_lvl()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of page. Used for padding.
     */
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
    }

    /**
     * @see Walker::start_el()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item Menu item data object.
     * @param int $depth Depth of menu item. Used for padding.
     * @param int $current_page Menu item ID.
     * @param object $args
     */
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        if(is_array($args)) $args = json_decode(json_encode($args)); // convert to object
        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $dropdown = in_array('dropdown', $classes);
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        if($depth > 0) $class_names = str_replace('dropdown', 'dropdown-submenu', $class_names);

        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $value . $class_names .'>';

        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
        $attributes .= $dropdown                    ? ' class="dropdown-toggle" data-toggle="dropdown" data-target="#"' : '';

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        if($dropdown && $depth == 0) $item_output .= ' <b class="caret"></b>';
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}

// Custom Page Menu
class Bootstrap_Page_Menu extends Walker_Page {

	/**
	 * @see Walker::start_lvl()
	 * @since 2.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 * @param array $args
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"dropdown-menu\">\n";
	}

	/**
	 * @see Walker::start_el()
	 * @since 2.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $page Page data object.
	 * @param int $depth Depth of page. Used for padding.
	 * @param int $current_page Page ID.
	 * @param array $args
	 */
	public function start_el( &$output, $page, $depth = 0, $args = array(), $current_page = 0 ) {
		if ( $depth ) {
			$indent = str_repeat( "\t", $depth );
		} else {
			$indent = '';
		}

		$css_class = array( 'page_item', 'page-item-' . $page->ID );

		$has_childen = (bool) isset( $args['pages_with_children'][ $page->ID ] );
		if ( $has_childen ) {
			$css_class[] = 'page_item_has_children';
		}

		if ( ! empty( $current_page ) ) {
			$_current_page = get_post( $current_page );
			if ( $_current_page && in_array( $page->ID, $_current_page->ancestors ) ) {
				$css_class[] = 'active current_page_ancestor';
			}
			if ( $page->ID == $current_page ) {
				$css_class[] = 'active current_page_item';
			} elseif ( $_current_page && $page->ID == $_current_page->post_parent ) {
				$css_class[] = 'active current_page_parent';
			}
		} elseif ( $page->ID == get_option('page_for_posts') ) {
			$css_class[] = 'active current_page_parent';
		}
		if($has_childen && $depth > 0) $css_class[] = 'dropdown-submenu';

		$css_classes = implode( ' ', apply_filters( 'page_css_class', $css_class, $page, $depth, $args, $current_page ) );

		if ( '' === $page->post_title ) {
			$page->post_title = sprintf( __( '#%d (no title)' ), $page->ID );
		}

		$args['link_before'] = empty( $args['link_before'] ) ? '' : $args['link_before'];
		$args['link_after'] = empty( $args['link_after'] ) ? '' : $args['link_after'];
		if($has_childen && $depth == 0) $args['link_after'].= ' <b class="caret"></b>';

		$output .= $indent . sprintf(
				'<li class="%s"><a href="%s"%s>%s%s%s</a>',
				$css_classes,
				get_permalink( $page->ID ),
				$has_childen ? ' class="dropdown-toggle" data-toggle="dropdown" data-target="#"' : '',
				$args['link_before'],
				get_the_title($page->ID), // apply_filters( 'the_title', get_field('menu', $page->ID), $page->ID ),
				$args['link_after']
			);

		if ( ! empty( $args['show_date'] ) ) {
			if ( 'modified' == $args['show_date'] ) {
				$time = $page->post_modified;
			} else {
				$time = $page->post_date;
			}

			$date_format = empty( $args['date_format'] ) ? '' : $args['date_format'];
			$output .= " " . mysql2date( $date_format, $time );
		}
	}
}

