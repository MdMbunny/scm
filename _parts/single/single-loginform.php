<?php

/**
 * single-loginform.php
 *
 * Part Single Login content.
 *
 * @link http://www.studiocreativo-m.it
 *
 * @package SCM
 * @subpackage Parts/Single/Login Form
 * @since 1.0.0
 */

$action = ( !empty( $_GET['action'] ) && $_GET['action'] == 'forgot' ? 'forgot' : 'login' );
$success = !empty( $_GET['success'] );
$failed = !empty( $_GET['failed'] ) ? $_GET['failed'] : false;

$forgot_success = __( 'Check your email for the instructions to get a new password.', SCM_THEME );
$forgot_failed = ( $failed == 'wrongkey' ? __( 'The reset key is wrong or expired. Please check that you used the right reset link or request a new one.', SCM_THEME ) : __( 'Sorry, we couldn\'t find any user with that username or email.', SCM_THEME ) );
$login_failed = __( 'Check your email for the instructions to get a new password.', SCM_THEME );


if( $action == 'forgot' && $success ){

    alert( $forgot_success );

}elseif( $action == 'forgot' && $failed ){

    alert( $forgot_failed );

}elseif( $action == 'login' && $failed ){

    alert( $login_failed );

}

// Global Variables
global $post, $SCM_indent;
$post_id = $post->ID;

$args = array(
    'acf_fc_layout' => 'layout-loginform',
    'id' => '',
    'class' => '', // not used
    'attributes' => '', // not used
    'style' => '', // not used
    
    'login-type' => 'page',
    'login-button' => 0,
    
    'login-redirect' => '',

    'login-buttons' => array(),

    'login-icon' => '',
    'login-send' => __( 'Log In', SCM_THEME ),

    'login-label-user' => __( 'Username', SCM_THEME ),
    'login-placeholder-user' => __( 'Username', SCM_THEME ),
    'login-value-user' => '',
    
    'login-label-password' => __( 'Password', SCM_THEME ),
    'login-placeholder-password' => __( 'Password', SCM_THEME ),
    
    'login-remember' => false,
    'login-label-remember' => __( 'Remember Me', SCM_THEME ),
    'login-value-remember' => false,

    'login-forgot' => false,
    'login-label-forgot' => __( 'Forgot Password?', SCM_THEME ),
    'login-label-back' => __( 'Log In', SCM_THEME ),
    'login-label-email' => __( 'Username or Email', SCM_THEME ),
    'login-placeholder-email' => __( 'Username or Email', SCM_THEME ),
    'login-forgot-send' => __( 'Send', SCM_THEME ),
    'login-forgot-icon' => '',

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

        $login_id = $args['id'] ?: 'loginform';

        $login_remember = $args['login-remember'];
        
        $value_remember = $args['login-value-remember'];
        $value_user = $args['login-value-user'];
        
        $placeholder_user = $args['login-placeholder-user'];
        $placeholder_password = $args['login-placeholder-password'];

        $label_user = $args['login-label-user'];
        $label_password = $args['login-label-password'];
        $label_remember = $args['login-label-remember'];
        $label_login = $args['login-send'] ?: '';
        $label_icon = ( $args['login-icon'] ? '<i class="fa ' . $args['login-icon'] . ( $label_login ? ' prepend' : '' ) . '"></i>' : '' );
        
        $attr = array(
                'echo'           => false,
                'redirect'       => $link,
                'form_id'        => $login_id,
                'label_username' => $label_user,
                'label_password' => $label_password,
                'label_remember' => $label_remember,
                'label_log_in'   => ( !$label_icon && !$label_login ? __( 'Submit', SCM_THEME ) : $label_login ),
                'id_username'    => 'user_login',
                'id_password'    => 'user_pass',
                'id_remember'    => 'rememberme',
                'id_submit'      => 'wp-submit',
                'remember'       => $login_remember,
                'value_username' => $value_user,
                'value_remember' => $value_remember,
        );

        $form = wp_login_form( $attr );

        if( $label_icon ){
            
            $input = string_extract( $form, '<input type="submit"', '/>' );
            $value = string_between( $input, ' value="', '"' );
            $ninput = str_replace( 'input', 'button', $input );
            $ninput = str_replace( ' value="' . $value . '"', '', $ninput );
            $ninput = str_replace( '/>', '>' . $label_icon . $value . '</button>', $ninput );
            $ninput = str_replace( 'class="button button-primary"', 'class="scm-ui-button scm-ui-label submit-input' . ( $label_icon ? ' icon' : '' ) . '"', $ninput );
            $form = str_replace( $input, $ninput, $form );

        }

        $user = string_extract( $form, '<p class="login-username">', '</p>' );
        $luser = string_extract( $user, '<label for="user_login">', '</label>' );
        if( !getTagContent( $luser, 'label' ) ) $luser = '';
        $nuser = str_replace( $luser, '', $user );
        $nuser = str_replace( '<p class="login-username">', '<div class="scm-ui-label scm-ui-button scm-ui-input scm-ui-comp user-input">', $nuser );
        $nuser = str_replace( '</p>', '</div>', $nuser );
        if( $placeholder_user ) $nuser = str_replace( '<input type="text" name="log"', '<input type="text" name="log" placeholder="' . $placeholder_user . '"', $nuser );

        $pass = string_extract( $form, '<p class="login-password">', '</p>' );
        $lpass = string_extract( $pass, '<label for="user_pass">', '</label>' );
        if( !getTagContent( $lpass, 'label' ) ) $lpass = '';
        $npass = str_replace( $lpass, '', $pass );
        $npass = str_replace( '<p class="login-password">', '<div class="scm-ui-label scm-ui-button scm-ui-input scm-ui-comp password-input">', $npass );
        $npass = str_replace( '</p>', '</div>', $npass );
        if( $placeholder_password ) $npass = str_replace( '<input type="password" name="pwd"', '<input type="password" name="pwd" placeholder="' . $placeholder_password . '"', $npass );
        
        $form = str_replace( $user, $luser . $nuser, $form );
        $form = str_replace( $pass, $lpass . $npass, $form );
        $form = str_replace( array( '<p class="login-submit">', '</p>', ' size="20"'), '', $form );

        $form = str_replace( '<form name="' . $login_id . '"', '<form name="' . $login_id . '" class="scm-ui-content -wrap"', $form ) . lbreak();

        // FORGOT

        $forgot = $args['login-forgot'];
        $label_forgot = $args['login-label-forgot'];
        $label_back = $args['login-label-back'];
        $label_email = $args['login-label-email'];
        $placeholder_email = $args['login-placeholder-email'];
        $forgot_send = $args['login-forgot-send'];
        $forgot_icon = ( $args['login-forgot-icon'] ? '<i class="fa ' . $args['login-forgot-icon'] . ( $label_login ? ' prepend' : '' ) . '"></i>' : '' );

        if( $forgot ){

            $tab = strpos( $form, '<form' );
            if( $tab !== false ) $tab = substr( $form, 0, $tab );
            else $tab = '';

            $form = $tab . '<input type="checkbox" name="forgot" id="login-show-forgot" checked>' . lbreak() . $form;

            $form = str_replace( '</form>', $tab . '<label class="scm-ui-label show-forgot" for="login-show-forgot">' . $label_forgot . '</label>' . lbreak() . '</form>', $form );

            $form .= $tab . '<form name="lostpasswordform" id="lostpasswordform" class="scm-ui-content -wrap" action="' . site_url('wp-login.php?action=lostpassword', 'login_post') . '" method="post">' . lbreak();
            if( $label_email ) $form .= $tab . indent() . '<label for="user_login">' . $label_email . '</label>' . lbreak();
            $form .= $tab . indent() . '<div class="scm-ui-label scm-ui-button scm-ui-input scm-ui-comp user-input">' . lbreak();
                $form .= $tab . indent(2) . '<input type="text" name="user_login" id="user_login" class="input" value="" placeholder="' . $placeholder_email . '">' . lbreak();
            $form .= $tab . indent() . '</div>' . lbreak();
            $form .= $tab . indent() . '<input type="hidden" name="redirect_to" value="' . SCM_SITE . '/login/?action=forgot&amp;success=1">' . lbreak();
            $form .= $tab . indent() . '<button type="submit" name="wp-submit" id="wp-submit" class="scm-ui-button scm-ui-label submit-input' . ( $forgot_icon ? ' icon' : '' ) . '">' . $forgot_icon . $forgot_send . '</button>' . lbreak();
            $form .= $tab . '<label class="scm-ui-label show-forgot" for="login-show-forgot">' . $label_back . '</label>' . lbreak();
            $form .= $tab . '</form>' . lbreak();

        }
        
        echo $form;
    }
}

?>