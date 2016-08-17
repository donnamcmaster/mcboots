<?php
/**
 *	Configure the gallery thumbnail and enlarged (popup) image sizes.
 *
 * @package McBoots
 */

// avoids having the gallery popup image be unnecessarily huge
// the default size is 'full'
// 'max-gallery' is defined in lib/setup/images.php
add_filter( 'mcb_gallery_enlarged_size', function() {
	return 'max-gallery';
});

/*
usually no need to filter 'mcb_gallery_thumb_size' as 'thumbnail' is default
add_filter( 'mcb_gallery_thumb_size', function() {
	return 'thumbnail';
});
*/