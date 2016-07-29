<?php


// Bootstrap styling for captions, comment forms, search forms
// from _strap


/**
 * Bootstrap styled Caption shortcode.
 * Hat tip: http://justintadlock.com/archives/2011/07/01/captions-in-wordpress
 */
add_filter( 'img_caption_shortcode', 'bootstrap_img_caption_shortcode', 10, 3 );

function bootstrap_img_caption_shortcode( $output, $attr, $content )  {

    /* We're not worried abut captions in feeds, so just return the output here. */
    if ( is_feed() )  return '';

    extract(shortcode_atts(array(
                'id'	=> '',
                'align'	=> 'alignnone',
                'width'	=> '',
                'caption' => ''
            ), $attr));

    if ( 1 > (int) $width || empty($caption) )
        return $content;

    if ( $id ) $id = 'id="' . esc_attr($id) . '" ';

    return '<div ' . $id . 'class="thumbnail ' . esc_attr($align) . '">'
        . do_shortcode( $content ) . '<div class="caption">' . $caption . '</div></div>';
}

/**
 * Bootstrap styled Comment form.
 */
add_filter( 'comment_form_defaults', 'bootstrap_comment_form_defaults', 10, 1 );
function bootstrap_comment_form_defaults( $defaults ) {
    $commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $defaults['fields'] =  array(
        'author' => '<div class="form-group comment-form-author">' .
                '<label for="author" class="col-sm-3 control-label">' . __( 'Name', 'mcboots' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
                '<div class="col-sm-9">' .
                    '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '"  class="form-control"' . $aria_req . ' />' .
                '</div>' .
            '</div>',
        'email'  => '<div class="form-group comment-form-email">' .
                '<label for="email" class="col-sm-3 control-label">' . __( 'Email', 'mcboots' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
                '<div class="col-sm-9">' .
                    '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '"  class="form-control"' . $aria_req . ' />' .
                '</div>' .
            '</div>',
        'url'    => '<div class="form-group comment-form-url">' .
            '<label for="url" class="col-sm-3 control-label"">' . __( 'Website', 'mcboots' ) . '</label>' .
                '<div class="col-sm-9">' .
                    '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '"  class="form-control" />' .
                '</div>' .
            '</div>',
    );
    $defaults['comment_field'] = '<div class="form-group comment-form-comment">' .
        '<label for="comment" class="col-sm-3 control-label">' . _x( 'Comment', 'noun', 'mcboots' ) . '</label>' .
            '<div class="col-sm-9">' .
                '<textarea id="comment" name="comment" aria-required="true" class="form-control" rows="8"></textarea>' .
                '<span class="help-block form-allowed-tags">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' ), ' <code>' . allowed_tags() . '</code>' ) . '</span>' .
           '</div>' .
        '</div>';

    $defaults['comment_notes_after'] = '<div class="form-group comment-form-submit">';

    return $defaults;
}


add_action( 'comment_form', 'bootstrap_comment_form', 10, 1 );
function bootstrap_comment_form( $post_id )
{
    // closing tag for 'comment_notes_after'
    echo '</div><!-- .form-group .comment-form-submit -->';
}


function bootstrap_searchform_class( $bt = array() )
{
    $caller = basename($bt[1]['file'], '.php');
    switch($caller) {
        case 'header':
            return 'navbar-form navbar-right';
        default:
            return 'form-inline';
    }
}
