<?php

/**
 * single-login.php
 *
 * Part Single Login content.
 *
 * @link http://www.studiocreativo-m.it
 *
 * @package SCM
 * @subpackage Parts/Single/Login
 * @since 1.0.0
 */

// Global Variables
global $post, $SCM_indent;
$post_id = $post->ID;

$args = array(
    'acf_fc_layout' => 'layout-login',
    'id' => '',
    'class' => '', // not used
    'attributes' => '', // not used
    'style' => '', // not used
    
    'login-type' => 'page',
    'login-button' => 0,
    'login-icon' => 'page',
    'login-redirect' => '',

    'login-buttons' => array(),
    
    'login-label-user' => __( 'Username', SCM_THEME ),
    'login-label-password' => __( 'Password', SCM_THEME ),
    'login-label-remember' => __( 'Remember Me', SCM_THEME ),
    'login-send' => __( 'Log In', SCM_THEME ),

    'login-remember' => false,
    
    'login-value-remember' => false,
    'login-value-user' => '',

);

if( isset( $this ) )
    $args = ( isset( $this->cont ) ? array_merge( $args, toArray( $this->cont ) ) : array() );

// -----------------------------------------------------------------------------------------------------

// REDIRECT

$redirect = $args['login-type'];
$link = $args['login-redirect'];

$link = loginRedirect( $redirect, $link );

if( is_user_logged_in() ){

    // LOGGED IN BUTTONS

    $buttons = ex_attr( $args, 'login-buttons', 0 ) ?: array();

    foreach ( $buttons as $button ) {
        $b_type = ( isset( $button['type'] ) ? $button['type'] : 'logout' );
        $b_icon = ( isset( $button['icon'] ) ? $button['icon'] : '' );
        $b_label = ( isset( $button['label'] ) ? $button['label'] : '' );
        $b_login = ( isset( $button['login'] ) ? $button['login'] : 'page' );
        $b_link = loginRedirect( $b_login, ( isset( $button['redirect'] ) ? $button['redirect'] : '' ) );
        if( $b_type == 'edit' ){
            // ???
            //$b_link = ( SCM_PAGE_EDIT ? $b_link . '?action=view' : $b_link . '?action=edit' );
            //$b_label = ( SCM_PAGE_EDIT ? __( 'View', SCM_THEME ) : ( $b_label ?: __( 'Edit', SCM_THEME ) ) );
        }elseif( $b_type == 'enter' ){
            $b_label = ( $b_label ?: ( $b_icon ? '' : __( 'Enter', SCM_THEME ) ) );
        }elseif( $b_type == 'logout' ){
            $b_link = getURL( 'logout:' . $b_link );
            $b_label = ( $b_label ?: ( $b_icon ? '' : __( 'Sign Out', SCM_THEME ) ) );
        }
        echo '<a class="scm-button shape column-layout" href="' . $b_link . '">' . ( $b_icon ? '<i class="fa ' . $b_icon . '"></i>' : '' ) . $b_label . '</a>';
    }

}else{

    if( $args['login-button'] ){

        // SIGN IN BUTTON

        echo '<a class="scm-button shape column-layout" href="' . $link . '">' . ( $args['login-icon'] ? '<i class="fa ' . $args['login-icon'] . '"></i>' : '' ) . $args['login-send'] . '</a>';

    }else{

        // LOG IN FORM

        $login_id = $args['id'];

        $login_remember = $args['login-remember'];
        
        $value_remember = $args['login-value-remember'];
        $value_user = $args['login-value-user'];
        
        $label_user = $args['login-label-user'];
        $label_password = $args['login-label-password'];
        $label_remember = $args['login-label-remember'];
        $label_login = $args['login-send'] ?: '_empty_label';
        $label_icon = ( $args['login-icon'] ? '<i class="fa ' . $args['login-icon'] . '"></i>' : '' );
        
        $attr = array(
                'echo'           => true,
                'redirect' 		 => $link,
                'form_id'        => ( $login_id ?: 'loginform' ),
                'label_username' => $label_user,
                'label_password' => $label_password,
                'label_remember' => $label_remember,
                'label_log_in'   => $label_login,
                'id_username'    => 'user_login',
                'id_password'    => 'user_pass',
                'id_remember'    => 'rememberme',
                'id_submit'      => 'wp-submit',
                'remember'       => $login_remember,
                'value_username' => $value_user,
                'value_remember' => $value_remember,
        );

        wp_login_form( $attr );
    }
}

?>