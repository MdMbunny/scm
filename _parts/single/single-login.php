<?php

// Global Variables
global $post, $SCM_indent;
$post_id = $post->ID;

$args = array(
    'acf_fc_layout' => 'layout-login',
    'id' => '',
    'class' => '',
    'attributes' => '',
    'style' => '',
);

if( isset( $this ) )
    $args = ( isset( $this->cont ) ? array_merge( $args, toArray( $this->cont ) ) : array() );

/***************/

//consoleLog( $args );

$redirect = ( $args['login-type'] ?: 'admin' );
$link = $args['login-redirect'];
$link = ( $redirect == 'admin' || !$link ? site_url('/wp-admin/users.php') : $link );

if( $redirect == 'page' )
    $link = getURL( 'page:' . $link );

if ( is_user_logged_in() ) { // todo: non so, son buttati lì, vedi tu, magari con personalizzazione da Options e cose così

    echo '<a class="scm-button shape" href="' . $link . '">' . __( 'Enter', SCM_THEME ) . '</a>';
    echo '<a class="scm-button shape" href="' . getURL( 'logout:' . SCM_DOMAIN ) . '">' . __( 'Log Out', SCM_THEME ) . '</a>';
    
}else{

    $remember = 0; //$args['login-rememberme'];
    $label_user = ( $args['login-user'] ?: __( 'Username', SCM_THEME ) );
    $label_password = ( $args['login-password'] ?: __( 'Password', SCM_THEME ) );
    $label_remember = ( $args['login-remember'] ?: __( 'Remember Me', SCM_THEME ) );
    $label_login = ( $args['login-send'] ?: __( 'Log In', SCM_THEME ) );
    $cont_user = ( $args['login-uservalue'] ?: '' );


    $attr = array(
            'echo'           => true,
            'redirect' 		 => $link,
            'form_id'        => 'loginform',
            'label_username' => $label_user,
            'label_password' => $label_password,
            'label_remember' => $label_remember,
            'label_log_in'   => $label_login,
            'id_username'    => 'user_login',
            'id_password'    => 'user_pass',
            'id_remember'    => 'rememberme',
            'id_submit'      => 'wp-submit',
            'remember'       => $remember,
            'value_username' => $cont_user,
            'value_remember' => false
    );

    wp_login_form( $attr );
}



/***************/




?>