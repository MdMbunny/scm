<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package SCM
 */

global $post, $SCM_indent;

$site_align = scm_field( 'layout-alignment', 'center', 'option' );
$foot_layout = ( scm_field( 'layout-page', 'full', 'option' ) === 'responsive' ? 'full' : scm_field( 'layout-foot', 'full', 'option' ) );

$foot_id = scm_field( 'opt-ids-footer', 'site-footer', 'option' );
$foot_class = 'row site-footer ' . $foot_layout . ' float-' . $site_align;

// If comments are open or we have at least one comment, load up the comment template
//if ( comments_open() || get_comments_number() )
    //comments_template();

$indent = $SCM_indent + 1;

$SCM_indent -= 3;

            indent( $SCM_indent+3, '</main><!-- main -->' );
        indent( $SCM_indent+2, '</div><!-- primary -->', 2 );
           
    indent( $SCM_indent+1, '</div><!-- content -->', 2 );

    indent( $SCM_indent+1, '<footer id="' . $foot_id . '" class="' . $foot_class . '" role="contentinfo">', 2 );

            Get_Template_Part::get_part( SCM_DIR_PARTS . '-sections.php', array(
                'option' => 'footer',
            ));

            scm_top_of_page();

    indent( $SCM_indent+1, '</footer><!-- footer -->', 2 );
indent( $SCM_indent, '</div><!-- page -->', 2 );

wp_footer();
wp_reset_postdata();

echo '</body>' . lbreak();
echo '</html>';