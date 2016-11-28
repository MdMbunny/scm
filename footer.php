<?php

/**
 * footer.php
 *
 * The template for displaying the footer.
 * Contains the closing of the #content div and all content after.
 *
 * @link http://www.studiocreativo-m.it
 *
 * @package SCM
 * @subpackage Root
 * @since 1.0.0
 */

global $SCM_indent, $SCM_forms;

wp_reset_postdata();

    $foot_layout = scm_field( 'layout-foot', 'full', 'option' );
    $foot_layout = ( scm_field( 'layout-page', 'full', 'option' ) === 'responsive' ? 'full ' : ( $foot_layout === 'full' ? 'full ' : 'responsive float-' ) );

    $foot_id = 'site-footer';
    $foot_class = 'footer site-footer ' . $foot_layout . SCM_SITE_ALIGN;

    $foot_page = scm_field( 'page-footer', array(), SCM_PAGE_ID );

    $foot_login = scm_field( 'opt-credits-login', 0, 'option' );

    $foot_credits_sel = scm_field( 'opt-credits-selectors', array(), 'option' );
    $foot_credits_id = scm_field( 'opt-credits-id', 'site-credits', 'option' );
    $foot_credits_class = scm_field( 'opt-credits-class', '', 'option' );

    $foot_credits = scm_field( 'opt-credits-credits', '', 'option' );
    $foot_separator = scm_field( 'opt-credits-separator', '', 'option' );
    $foot_piva = scm_field( 'opt-credits-piva', '', 'option' );
    $foot_policy = scm_field( 'opt-credits-policy', 0, 'option' );
    $foot_policy_link = scm_field( 'opt-credits-policy-link', '', 'option' );
    $foot_cookies_link = scm_field( 'opt-credits-cookies-link', '', 'option' );
    
    $foot_designed = scm_field( 'opt-credits-designed', '', 'option' );
    $foot_designed_link = scm_field( 'opt-credits-designed-link', '', 'option' );   

    $indent = $SCM_indent + 1;

                        $SCM_indent -= 1;
                        echo lbreak(2);
                    
                        indent( $SCM_indent, '</article><!-- article -->', 2 );
                    
                    $SCM_indent -= 1;

                $SCM_indent -= 3;

                indent( $SCM_indent+3, '</main><!-- main -->' );
            indent( $SCM_indent+2, '</div><!-- primary -->', 2 );
               
        indent( $SCM_indent+1, '</div><!-- content -->', 2 );

        indent( $SCM_indent+1, '<footer id="' . $foot_id . '" class="' . $foot_class . '">', 2 );

                $SCM_indent += 2;
        
                    $repeater = scm_field( 'footer-sections', array(), 'option', 1 );

                    foreach ($foot_page as $row) {

                        array_unshift( $repeater, array( 'rows' => array( array( 'acf_fc_layout' => 'layout-row', 'row' => $row , 'layout' => 'default') ) ) );
                    }

                    scm_content( array( 'sections' => $repeater ) );
                        
                    indent( $SCM_indent+1, '<div id="' . $foot_credits_id . '" class="site-credits ' . $foot_credits_class . ' ' . implode( ' ', $foot_credits_sel ) . '">', 1 );
                        
                        $fields = array();
                        
                            if( $foot_credits )
                                $fields[] = array( 'acf_fc_layout'=>'layout-titolo', 'title'=>$foot_credits, 'tag'=>'span', 'inherit'=>1 );

                            if( $foot_piva ){
                                if( $foot_separator && $foot_credits )
                                    $fields[] = array( 'acf_fc_layout'=>'layout-titolo', 'title'=>$foot_separator, 'tag'=>'span', 'inherit'=>1, 'class'=>'separator' );
                                
                                $fields[] = array( 'acf_fc_layout'=>'layout-titolo', 'title'=>$foot_piva, 'tag'=>'span', 'inherit'=>1 );
                            }

                            if( $foot_policy ){
                                $link = '';
                                if( $foot_policy_link ){
                                    $link = $foot_policy_link;
                                }else{
                                    $policy = scm_utils_preset_policies();
                                    if ( $foot_policy )
                                        $link = 'http://www.iubenda.com/privacy-policy/' . $policy['id'];
                                }

                                if ( $link ) {
                                    if( $foot_separator && ( $foot_credits || $foot_piva ) )
                                        $fields[] = array( 'acf_fc_layout'=>'layout-titolo', 'title'=>$foot_separator, 'tag'=>'span', 'inherit'=>1, 'class'=>'separator' );
                                    
                                    $fields[] = array( 'acf_fc_layout'=>'layout-titolo', 'title'=>__( 'Privacy Policy', SCM_THEME ), 'attributes'=>' data-href="' . $link . '" data-target="_self"', 'tag'=>'span', 'inherit'=>1 );
                                }else{
                                    $foot_policy = 0;
                                }
                            }

                            if( $foot_cookies_link ){
                                if( $foot_separator && ( $foot_policy || ( $foot_credits || $foot_piva ) ) )
                                    $fields[] = array( 'acf_fc_layout'=>'layout-titolo', 'title'=>$foot_separator, 'tag'=>'span', 'inherit'=>1, 'class'=>'separator' );
                                
                                $fields[] = array( 'acf_fc_layout'=>'layout-titolo', 'title'=>__( 'Cookies Policy', SCM_THEME ), 'attributes'=>' data-href="' . $foot_cookies_link . '" data-target="_self"', 'tag'=>'span', 'inherit'=>1 );
                            }

                            if( $foot_designed ){
                                if( $foot_separator && ( $foot_credits || $foot_piva || $foot_policy ) )
                                    $fields[] = array( 'acf_fc_layout'=>'layout-titolo', 'title'=>$foot_separator, 'tag'=>'span', 'inherit'=>1, 'class'=>'separator' );
                                
                                $fields[] = array( 'acf_fc_layout'=>'layout-titolo', 'title'=>'Designed by ' . $foot_designed, 'attributes'=>( $foot_designed_link ? ' data-href="' . getURL( $foot_designed_link ) . '" ' : '' ), 'tag'=>'span', 'inherit'=>1 );
                            }

                            if( $foot_separator && ( $foot_credits || $foot_piva || $foot_designed ) )
                                $fields[] = array( 'acf_fc_layout'=>'layout-titolo', 'title'=>$foot_separator, 'tag'=>'span', 'inherit'=>1, 'class'=>'separator' );
                            
                            $fields[] = array( 'acf_fc_layout'=>'layout-titolo', 'title'=>'Powered by SCM', 'attributes'=>' data-href="' . getURL( 'info@mdmbunny.com' ) . '" ', 'tag'=>'span', 'inherit'=>1 );

                            if( $foot_login )
                                $fields[] = array( 'acf_fc_layout'=>'layout-login', 'login_type'=>'page', 'login-buttons'=>array( array( 'type'=>'edit' ), array( 'type'=>'logout' ) ), 'id'=>'scm-login-edit' );

                        scm_content( array( 'modules' => $fields ) );

                    indent( $SCM_indent+1, '</div>', 2 );

                $SCM_indent -= 2;

                scm_top_of_page();

        indent( $SCM_indent+1, '</footer><!-- footer -->', 2 );
    indent( $SCM_indent, '</div><!-- page -->', 2 );
    
    wp_footer();
    wp_reset_postdata();

    // ACF Forms
    $SCM_forms = apply_filters( 'scm_filter_page_form', $SCM_forms, SCM_PAGE_ID );
    if( SCM_PAGE_EDIT && !empty( $SCM_forms ) ){

        indent( $SCM_indent + 1, '<div id="scm-forms">', 2 );
            indent( $SCM_indent + 1, '<div id="scm-close-forms">', 2 );
                indent( $SCM_indent + 1, '<span class="acf-button">' . __( 'Chiudi senza salvare' ) . '</span>', 2 );
            indent( $SCM_indent + 1, '</div>', 2 );
            foreach ( $SCM_forms as $form) 
                acf_form( $form );
        indent( $SCM_indent + 1, '</div><!-- scm-forms -->', 2 );
    }
    // ---


    echo '</body>' . lbreak();

echo '</html>';

?>