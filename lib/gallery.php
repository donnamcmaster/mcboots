<?php
/**
 * Bootstrap Gallery Code
 * - generates Bootstrap v3 row/col markup based on the # of columns 
 * - assumes a 12-column grid; defaults to 3 cols if value isn't a factor of 12
 *   (the default is based on WordPress gallery cols default of 3)
 * - phone-size gets fewer columns with max of 3
 * - add filters to change thumbnail or full sizes
 * - 'img-responsive' is defined in Bootstrap
 * - see assets/less/app.less for basic gallery styling 
 *
 * props to http://stackoverflow.com/users/1948627/bitworking for the starting point in
 * http://stackoverflow.com/questions/35772718/output-gallery-shortcode-as-bootstrap-columns-in-wordpress
 * and to https://github.com/cullylarson for review & critique
 *
 * @package McBoots
 */

add_filter( 'post_gallery', 'bootstrap_gallery', 10, 3 );
function bootstrap_gallery ( $output = '', $atts, $instance ) {
	$default_number_columns = 3;
	$defaults = [
		'columns' => $default_number_columns,
		'thumb_size' => apply_filters( 'mcb_gallery_thumb_size', 'thumbnail' ),
		'enlarged_size' => apply_filters( 'mcb_gallery_enlarged_size', 'full' ),
	];
	$atts = array_merge( $defaults, $atts );

	// if no images, return
	if ( !isset( $atts['ids'] ) || !$atts['ids'] ) {
		return;
	}

	$columns = $atts['columns'];
	$images = explode( ',', $atts['ids'] );

	// map number of columns to the Bootstrap CSS markup
	// if unworkable # of columns, set it to 3
	if ( !isset( $col_map[$columns] ) ) {
		$columns = $default_number_columns;
	}
	$col_map = [
		// if fewer than 4 columns, go to 1 column in phone-size
		1 => 'col-sm-12',
		2 => 'col-sm-6',
		3 => 'col-sm-4',

		// if 4 or 6 columns, then phone-size gets half that many
		4 => 'col-sm-3 col-xs-6',
		6 => 'col-sm-2 col-xs-4',
		12 => 'col-sm-1',
	];
	$col_class = $col_map[$columns];

	// start collecting the output
	ob_start();

?>
<div class="gallery">
	<div class="row">

<?php
	$cols_printed = 0;
	foreach ( $images as $img_id ) {
		$img_atts = wp_get_attachment_image_src( $img_id, $atts['enlarged_size'] );
		if ( !$img_atts ) {
			continue;
		}
		$img_src = $img_atts[0];

		$img_caption = '';
		$img_caption = apply_filters( 'mcb_get_gallery_caption', $img_caption, $img_id );

		$thumb_tag = wp_get_attachment_image( $img_id, $atts['thumb_size'], false, ['class'=>'img-responsive'] );

		// time to start a new row?
		if ( $cols_printed >= $columns ) {
			$cols_printed = 0;
?>
	</div><!-- row -->
	<div class="row">

<?php
		} // if new row

?>
		<div class="gallery_item <?= $col_class;?>">
			<a data-gallery="gallery" href="<?= $img_src;?>" title="<?= $img_caption;?>">
				<?= $thumb_tag;?>
			</a>
		</div>

<?php
		$cols_printed++;
	} // foreach

?>
	</div><!-- row -->
</div><!-- gallery -->

<?php
	return ob_get_clean();
}
