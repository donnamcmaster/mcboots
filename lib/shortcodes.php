<?php
/**
 *	Some handy shortcodes
 *
 * @package McBoots
 */

add_shortcode( 'author', function( $atts, $content=null ) {
    ob_start();
?>
    <div class="author">
        <span class='leader'>–</span> <span class='name'><?= empty( $atts['name'] ) ? "" : esc_html( $atts['name'] ); ?></span>
    </div>

<?php
    return ob_get_clean();
});

add_shortcode( 'highlight', function( $atts, $content=null ) {
    ob_start();
?>
    <div class="highlight">
        <?= $content; ?>
    </div>

<?php
    return ob_get_clean();
});

add_shortcode( 'mcw-button', function( $atts, $content=null ) {
	extract( shortcode_atts(
		array(
			'title' => '',
			'link'	=> '',
			'class' => 'btn btn-primary',
		), 
		$atts 
	));
	if ( !$title || !$url ) {
		mcw_log( "mcw_button: title is $title; link is $link" );
	}

    ob_start();
?>
    <a class="<?= $class; ?>" url="<?= $link; ?>"><?= $title; ?></a>

<?php
    return ob_get_clean();
});
