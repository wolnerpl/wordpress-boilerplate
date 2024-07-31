<?php
function change_logo_class( $html ) {
    $html = str_replace('custom-logo-link', 'header__logo-link', $html);
    $html = str_replace('custom-logo', 'header__logo-image', $html);
    return $html;
}
add_filter( 'get_custom_logo', 'change_logo_class' );