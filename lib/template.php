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
	return display_sidebar() ? 'col-sm-9' : 'col-sm-12';
}

function sidebar_class ( $sidebar='sidebar-primary' ) {
	return 'col-sm-3';
}

