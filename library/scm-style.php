<?php

//if( !is_admin() ) :

// *****************************************************
// *      ACTIONS AND FILTERS
// *****************************************************
	
	add_action( 'wp_enqueue_scripts', 'scm_site_assets_styles_inline' );

// *****************************************************
// *      ASSETS
// *****************************************************

	if ( ! function_exists( 'scm_site_assets_styles_inline' ) ) {
        function scm_site_assets_styles_inline() {

            global $SCM_styles;

            $alpha = ( get_field('text_alpha', 'option') != null ? get_field('text_alpha', 'option') : 1 );
            $color = 'rgba(' . hex2rgba( ( get_field('text_color', 'option') ? get_field('text_color', 'option') : '#000000' ), $alpha ) . ')';
            $opacity = ( get_field('text_opacity', 'option') != null ? get_field('text_opacity', 'option') : 1);
            $shadow = ( get_field('text_shadow', 'option') ? get_field('text_shadow_x', 'option') . 'px ' . get_field('text_shadow_y', 'option') . 'px ' . get_field('text_shadow_size', 'option') . 'px rgba(' . hex2rgba( ( get_field('text_shadow_color', 'option') ? get_field('text_shadow_color', 'option') : '#000000'), ( get_field('text_shadow_alpha', 'option') != null ? get_field('text_shadow_alpha', 'option') : 1 ), true ) . ')' : 'none' );
            
            $heading_color = ( get_field('styling_heading_color', 'option') ? get_field('styling_heading_color', 'option') : '#000000');
            $heading_font = ( get_field( 'select_webfonts_families_heading', 'option' ) != 'no' ? get_field( 'select_webfonts_families_heading', 'option' ) . ',' . str_replace( '_', ', ', get_field( 'select_webfonts_default_families_heading', 'option' ) ) : str_replace( '_', ', ', get_field( 'select_webfonts_default_families_heading', 'option' ) ) );
            $heading_weight = ( get_field('select_font_weight', 'option') ? get_field('select_font_weight', 'option') : '700');

            $font = font2string( get_field( 'select_webfonts_families', 'option' ), get_field( 'select_webfonts_default_families', 'option' ) );
            $menu_font = font2string( get_field( 'select_webfonts_families_menu', 'option' ), get_field( 'select_webfonts_default_families_menu', 'option' ) );
            $sticky_font = font2string( get_field( 'select_webfonts_families_sticky_menu', 'option' ), get_field( 'select_webfonts_default_families_sticky_menu', 'option' ) );

            $bg_image = ( get_field('background_image', 'option') ? 'url(' . get_field('background_image', 'option') . ')' : 'none' );
            $bg_repeat = ( get_field('select_bg_repeat', 'option') != 'default' ? get_field('select_bg_repeat', 'option') : 'no-repeat' );
            $bg_position = ( get_field('select_bg_position', 'option') != null ? get_field('select_bg_position', 'option') : 'center center' );
            $bg_size = ( get_field('background_size', 'option') != null ? get_field('background_size', 'option') : 'auto' );
            $bg_alpha = ( get_field('background_alpha', 'option') != null ? get_field('background_alpha', 'option') : 1 );
            $bg_color = 'rgba(' . hex2rgba( ( get_field('background_color', 'option') != null ? get_field('background_color', 'option') : '#FFFFFF' ), $bg_alpha ) . ')';
            $margin = ( get_field('margin', 'option') != null ? get_field('margin', 'option') : '0');
            $padding = ( get_field('padding', 'option') != null ? get_field('padding', 'option') : '0');

            //$fader = ( get_field('fader_active', 'option') ? get_field('fader_active', 'option') : 0 );
            //$body_opacity = ( $fader ? 0 : 1 );
            //$body_pointer = ( $fader ? 'none' : 'all' );
            //$body_trans = ( $fader ? 'opacity ' . get_field('fader_duration', 'option') . 's' : 'none' );

            array_merge( $SCM_styles, array(
                'alpha' => $alpha,
                'color' => $color,
                'opacity' => $opacity,
                'shadow' => $shadow,
                'font' => $font,
                'heading_color' => $heading_color,
                'heading_font' => $heading_font,
                'heading_weight' => $heading_weight,
                'menu_font' => $menu_font,
                'background-image' => $bg_image,
                'background-repeat' => $bg_repeat,
                'background-position' => $bg_position,
                'background-size' => $bg_size,
                'background-color' => $bg_color,
                'margin' => $margin,
                'padding' => $padding,
            ));

            $css = '
                *, input, textarea{
                    font-family: ' . $font . ';
                    color: ' . $color . ';
                }

                body {
                    background-color: ' . $bg_color . ';
                    background-image: ' . $bg_image . ';
                    background-repeat: ' . $bg_repeat . ';
                    background-position: ' . $bg_position . ';
                    background-size: ' . $bg_size . ';
                    text-shadow: ' . $shadow . ';
                    margin: ' . $margin . ';
                    padding: ' . $padding . ';
                    
                }

                #page {
                    opacity: ' . $opacity . ';
                }

                h1, h2, h3, h4, h5, h6, .h7, .h8, .h9, .h0 {
                    font-family: ' . $heading_font . ';
                    color: ' . $heading_color . ';
                    font-weight: ' . $heading_weight . ';
                }

                header i {
                    color: ' . $heading_color . ';
                }

                #site-navigation {
                    font-family: ' . $menu_font . ';
                }

                #site-navigation-sticky row {
                    font-family: ' . $sticky_font . ';
                }';
            
            if( !empty( $css ) )
                wp_add_inline_style( 'global', $css );

            //echo '<!-- styles -->\r\n$out\r\n';
        }
    }

//endif;

?>