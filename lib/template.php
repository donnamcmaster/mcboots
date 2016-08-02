<?php

namespace McBoots\Template;

// does this page have a sidebar?
function display_sidebar ( $sidebar='sidebar-primary' ) {
	if ( $sidebar != 'sidebar-primary' ) {
		return false;
	}
	if ( is_front_page() ) {
		return false;
	} else {
		return true;
	}
}

function main_class () {
	if ( display_sidebar() ) {
		$class = 'col-sm-9';
	} else {
		$class = 'col-sm-12';
	}
	return $class;
}

function sidebar_class ( $sidebar='sidebar-primary' ) {
	return 'col-sm-3';
}

