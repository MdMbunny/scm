<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package SCM
 */


global $post;

                   
                    $foot_id = ( get_field( 'id_footer', 'option' ) ? get_field( 'id_footer', 'option' ) : 'site-footer' );
                    $foot_row_id = $foot_id . '-row';
                    
                    $foot_layout = ( get_field('select_layout_page', 'option') != 'responsive' ? ( get_field('select_layout_foot', 'option') ? get_field('select_layout_foot', 'option') : 'full' ) : 'full' );
                    $foot_align = ( get_field( 'select_alignment_site', 'option' ) ? get_field( 'select_alignment_site', 'option' ) : 'center' );

                    $foot_class = $foot_align . ' site-footer full';
                    $foot_row_class = $foot_layout . ' row scm-row';

                     // If comments are open or we have at least one comment, load up the comment template
                        /*if ( comments_open() || get_comments_number() ) :
                            comments_template();
                        endif;*/
                    ?>

                    </main><!-- #main -->
                </div><!-- #primary -->
           
        </div><!-- #site-content -->

        <footer id="<?php echo $foot_id; ?>" class="<?php echo $foot_class; ?>" role="contentinfo">
            <row id="<?php echo $foot_row_id; ?>" class="<?php echo $foot_row_class; ?>">
                <?php

                $credits = get_field( 'footer_credits_active', 'option' );
                $sections = ( get_field( 'footer_sections', 'option' ) ? get_field( 'footer_sections', 'option' ) : array() );

                scm_flexible_content( $sections );

                if( $credits )
                    scm_credits();

                scm_top_of_page();

                ?>
            </row><!-- #site-footer-row -->
        </footer><!-- #site-footer -->
    </div><!-- #page -->

<?php wp_footer(); ?><!-- WP Footer Hook -->

<?php wp_reset_postdata(); ?>

</body>
</html>