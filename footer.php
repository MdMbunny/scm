<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package SCM
 */


global $post;

$site_align = ( get_field( 'select_alignment_site', 'option' ) ?: 'center' );

$foot_id = ( get_field( 'id_footer', 'option' ) ? get_field( 'id_footer', 'option' ) : 'site-footer' );
$foot_row_id = $foot_id . '-row';

$foot_layout = ( get_field( 'select_layout_page', 'option' ) != 'responsive' ? ( get_field( 'select_layout_foot', 'option' ) ?: 'full' ) : 'full' );

$foot_class = 'row site-footer full';// . $foot_layout;
$foot_row_class = $foot_layout . ' float-' . $site_align . ' row scm-row';

$credits = get_field( 'footer_credits_active', 'option' );
$sections = ( get_field( 'footer_sections', 'option' ) ? get_field( 'footer_sections', 'option' ) : array() );

// If comments are open or we have at least one comment, load up the comment template
//if ( comments_open() || get_comments_number() )
    //comments_template();

            echo lbreak(2);
            indent( 4, '</main><!-- #main -->' );
        indent( 3, '</div><!-- #primary -->', 2 );
           
    indent( 2, '</div><!-- #site-content -->', 2 );

    indent( 2, '<footer id="' . $foot_id . '" class="' . $foot_class . '" role="contentinfo">' );
        indent( 3, '<div id="' . $foot_row_id . '" class="' . $foot_row_class . '">', 2 );

            foreach ($sections as $section) {
                $single = $section[ 'select_section' ];
                if(!$single) continue;
                $post = $single;
                setup_postdata( $post );
                get_template_part( SCM_DIR_PARTS_SINGLE, 'scm-sections' );
            }

            if( $credits )
                scm_credits();

            scm_top_of_page();

        echo lbreak(2);
        indent( 3, '</div><!-- #site-footer-row -->' );
    indent( 2, '</footer><!-- #site-footer -->', 2 );
indent( 1, '</div><!-- #page -->', 2 );

wp_footer();
echo '<!-- WP Footer Hook -->' . lbreak();

wp_reset_postdata();

echo '</body>' . lbreak();
echo '</html>';