<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package SCM
 */

global $post;

$site_align = scm_field( 'select_alignment_site', 'center', 'option' );
$foot_layout = ( scm_field( 'select_layout_page', 'full', 'option' ) === 'responsive' ? 'full' : scm_field( 'select_layout_foot', 'full', 'option' ) );

$foot_id = scm_field( 'id_footer', 'site-footer', 'option' );
$foot_class = 'row site-footer ' . $foot_layout . ' float-' . $site_align;

// If comments are open or we have at least one comment, load up the comment template
//if ( comments_open() || get_comments_number() )
    //comments_template();

            indent( 4, '</main><!-- main -->' );
        indent( 3, '</div><!-- primary -->', 2 );
           
    indent( 2, '</div><!-- content -->', 2 );

    indent( 2, '<footer id="' . $foot_id . '" class="' . $foot_class . '" role="contentinfo">', 2 );

            Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-scm-sections.php', array(
                'option' => 'footer',
                'indent' => 2
            ));

            scm_top_of_page();

        echo lbreak(2);

    indent( 2, '</footer><!-- footer -->', 2 );
indent( 1, '</div><!-- page -->', 2 );

wp_footer();
wp_reset_postdata();

echo '</body>' . lbreak();
echo '</html>';