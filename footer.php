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

    // ACF Forms
    if( SCM_LEVEL <= 30 && SCM_PAGE_FORM && !empty( $SCM_forms ) ){
        indent( $SCM_indent + 1, '<div id="scm-forms">', 2 );
            indent( $SCM_indent + 1, '<div id="scm-close-forms">', 2 );
                indent( $SCM_indent + 1, '<span class="acf-button">' . __( 'Chiudi senza salvare' ) . '</span>', 2 );
            indent( $SCM_indent + 1, '</div>', 2 );
            foreach ( $SCM_forms as $form) 
                acf_form( $form );
        indent( $SCM_indent + 1, '</div><!-- scm-forms -->', 2 );
    }

    $foot_layout = scm_field( 'layout-foot', 'full', 'option' );
    //$site_align = scm_field( 'layout-alignment', 'center', 'option' );
    $foot_layout = ( scm_field( 'layout-page', 'full', 'option' ) === 'responsive' ? 'full ' : ( $foot_layout === 'full' ? 'full ' : 'responsive float-' ) );

    $foot_id = 'site-footer';
    $foot_class = 'footer site-footer ' . $foot_layout . SCM_SITE_ALIGN;

    //$id = $SCM_page_id;

    $foot_page = scm_field( 'page-footer', array(), SCM_PAGE_ID );

    $indent = $SCM_indent + 1;

                        $SCM_indent -= 1;
                        echo lbreak(2);
                    
                        indent( $SCM_indent, '</article><!-- article -->', 2 );
                    
                    $SCM_indent -= 1;

                $SCM_indent -= 3;

                indent( $SCM_indent+3, '</main><!-- main -->' );
            indent( $SCM_indent+2, '</div><!-- primary -->', 2 );
               
        indent( $SCM_indent+1, '</div><!-- content -->', 2 );

        indent( $SCM_indent+1, '<footer id="' . $foot_id . '" class="' . $foot_class . '" role="contentinfo">', 2 );

                $SCM_indent += 2;
        
                    $repeater = scm_field( 'footer-sections', array(), 'option', 1 );

                    foreach ($foot_page as $row) {
                        array_unshift( $repeater, array( 'rows' => array( array( 'acf_fc_layout' => 'layout-row', 'row' => $row ) ) ) );
                    }

                    scm_content( array( 'sections' => $repeater ) );

                $SCM_indent -= 2;

                scm_top_of_page();

        indent( $SCM_indent+1, '</footer><!-- footer -->', 2 );
    indent( $SCM_indent, '</div><!-- page -->', 2 );

    wp_footer();

    wp_reset_postdata();



    echo '</body>' . lbreak();

echo '</html>';