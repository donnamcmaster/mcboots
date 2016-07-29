<?php

namespace McBoots\Template;

// does this page have a sidebar?
function display_sidebar ( $sidebar='primary' ) {
	if ( $sidebar != 'primary' ) {
		return false;
	}

	if ( is_home() || ( get_post_type() == 'post' ) ) {
		return true;
	} else {
		return false;
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

function sidebar_class ( $sidebar='primary' ) {
	return 'col-sm-3';
}

