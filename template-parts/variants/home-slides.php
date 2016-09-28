<?php
/**
 * Sample Home Page Carousel
 *
 * - uses Bootstrap carousel
 * - uses Piklist for meta configuration
 *
 * @package McBoots
 */

	$sliders = get_post_meta( $post->ID, 'home_slides', true );

	// fall back to featured image if no slides configured
	if ( !$sliders ) {
		mcw_log( "front page: no sliders" );
		get_template_part( 'templates/featured-image' );
		return;
	}

?>
<div id="home-sliders" class="container carousel slide" data-ride="carousel">
	<!-- Wrapper for slides -->
	<div class="carousel-inner" role="listbox">

<?php
	// first item must be active
	$class = 'item active';
	$count = 0;

	foreach ( $sliders as $slide ) {
		extract( $slide );

		$title = wptexturize( $headline );
		$image = wp_get_attachment_image( $image[0], 'home-feature' );
		$content = wptexturize( wpautop( $text ) );
		$link = mcw_get_anchor( $link_url, wptexturize( $link_text ), 'btn btn-default' );
?>
		<div class="<?php echo $class;?>">
			<?php echo $image; ?>
			<div class="carousel-overlay">
				<div class="carousel-caption">
					<h3><?php echo $title; ?></h3>
					<?php echo $content; ?>
				</div>
				<div class="carousel-button">
					<?php echo $link; ?>
				</div>
			</div><!-- carousel overlay -->
		</div><!-- item -->

<?php
		// remaining items should not be active
		$class = 'item';
		$count++;
	}

?>
	</div><!-- carousel-inner -->

	<!-- Indicators -->
	<ol class="carousel-indicators">
<?php
	// first item must be active
	$class = 'class="active"';
	for ( $i=0; $i < $count; $i++ ) {
?>
		<li data-target="#home-sliders" data-slide-to="<?php echo $i;?>" <?php echo $class;?>></li>
<?php
		$class = '';
	}
?>
	</ol>

	<!-- Controls 
	<a class="left carousel-control" href="#home-sliders" role="button" data-slide="prev">
		<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		<span class="sr-only">Previous</span>
	</a>
	<a class="right carousel-control" href="#home-sliders" role="button" data-slide="next">
		<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		<span class="sr-only">Next</span>
	</a>
	-->
</div><!-- #home-sliders -->
<script type="text/javascript">
	$(document).ready(function() {
		$('.carousel').carousel({
			interval: 8000
		})
		$('#home-sliders').swipe({
			swipeLeft: function() {
				 $(this).carousel('next');
			},
			swipeRight: function() {
				$(this).carousel('prev');
			},
			allowPageScroll: 'vertical',
			threshold: 50
		 });
	});
</script>
