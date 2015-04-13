<?php

    //Prints Element Flexible Contents
    if ( ! function_exists( 'scm_flexible_content' ) ) {
        function scm_flexible_content( $content ) {

            if( !$content )
                return;

            //$content = ( !is_array( $content ) ? array( [ 'acf_fc_layout' => $content ] ) : $content );

            global $post, $SCM_indent, $SCM_types;

            $SCM_indent += 1;

            foreach ( $content as $cont ) {

                $element = ( isset( $cont[ 'acf_fc_layout' ] ) ? $cont[ 'acf_fc_layout' ] : '' );

                switch ($element) {

                    

                    /*case 'layout_archive':

                        $args = array(
                            'post_type' => $cont[ 'select_types_public_archive' ],
                            'orderby' => $cont[ 'orderby_archive' ],
                            'order' => $cont[ 'order_archive' ],
                            'posts_per_page' => ( (int)$cont[ 'all_archive' ] ? -1 : $cont[ 'max_archive' ] ),
                        );

                        if( $cont[ 'categories_archive' ] ){
                            $args[ 'tax_query' ] = array(
                                array(
                                    'taxonomy' => 'categories-' . $cont[ 'select_types_public_archive' ],
                                    'field'    => 'slug',
                                    'terms'    => explode( ' ', $cont[ 'categories_archive' ] ),
                                ),
                            );
                        }

                        Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-archive.php', array(
                            'pargs' => $args,
                            'pagination' => ( (int)$cont['all_archive'] ? 'no' : $cont[ 'pagination_archive' ] ),
                            'layout' => $cont[ 'layout_archive' ],
                        ));

                    break;

                    case 'layout_galleria':

                        $single = $cont[ 'select_galleria' ];
                        if(!$single) continue;
                        $post = ( is_numeric( $single ) ? get_post( $single ) : $single );
                        setup_postdata( $post );
                        $single_type = $post->post_type;
                        Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-' . $single_type . '.php', array(
                            'b_init'    => $cont[ 'module_galleria_init' ],
                            'b_type'    => $cont[ 'select_gallerie_button' ],
                            'b_img'     => $cont[ 'module_galleria_img_num' ],
                            'b_size'    => $cont[ 'dimensione_galleria' ],
                            'b_units'    => $cont[ 'select_units_galleria' ],
                            'b_txt'     => $cont[ 'module_galleria_txt' ],
                            'b_bg'      => $cont[ 'module_galleria_txt_bg' ],
                            'b_section' => $cont[ 'module_galleria_section' ],
                        ));

                    break;

                    case 'layout_soggetto':

                        $single = $cont[ 'select_soggetto' ];
                        if(!$single) continue;
                        $post = ( is_numeric( $single ) ? get_post( $single ) : $single );
                        setup_postdata( $post );
                        $single_type = $post->post_type;
                        $build = $cont[ 'flexible_soggetto' ];
                        $link = $cont[ 'select_soggetto_link' ];
                        $neg = $cont[ 'select_positive_negative_soggetto' ];
                        Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-' . $single_type . '.php', array(
                            'soggetto_rows' => $build,
                            'soggetto_link' => $link,
                            'soggetto_neg' => $neg,
                        ));

                    break;

                    case 'layout_map':

                        $luoghi = $cont[ 'select_luogo' ];
                        if(!$luoghi) continue;
                        $width = $cont[ 'dimensione_map' ];
                        $units = $cont[ 'select_units_map' ];
                        $zoom = $cont[ 'zoom_map' ];

                        Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-map.php', array(
                            'map_luoghi' => $luoghi,
                            'map_width' => $width,
                            'map_units' => $units,
                            'map_zoom' => $zoom
                        ));

                    break;

                    case 'layout_luogo':

                        $luoghi = $cont[ 'select_luogo' ];
                        if(!$luoghi) continue;
                        $build = $cont[ 'build_cont_luogo' ];
                        $width = ( $cont[ 'larghezza_luogo' ] >= 0 ? $cont[ 'larghezza_luogo' ] : 100);
                        $legend = ( $cont[ 'legend_luogo' ] ?: 0);

                        foreach ($luoghi as $luogo) {
                            $single_type = $luogo->post_type;
                            $post = $luogo;
                            setup_postdata( $post );
                            Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-' . $single_type . '.php', array(
                                'luogo_rows' => $build,
                                'luogo_width' => $width,
                                'luogo_legend' => $legend
                            ));
                        }

                    break;

                    case 'layout_contact_form':

                        $single = $cont[ 'select_contact_form' ];
                        if(!$single) continue;
                        $post = ( is_numeric( $single ) ? get_post( $single ) : $single );
                        setup_postdata( $post );
                        $single_type = $post->post_type;
                        get_template_part( SCM_DIR_PARTS_SINGLE, $single_type );

                    break;

                    case 'layout_login_form':

                        get_template_part( SCM_DIR_PARTS_SINGLE, 'login-form' );

                    break;*/

                    case 'layout-section':

                        $single = $cont[ 'sections' ];
                        if(!$single) continue;
                        $post = ( is_numeric( $single ) ? get_post( $single ) : $single );
                        setup_postdata( $post );

                        get_template_part( SCM_DIR_PARTS_SINGLE, 'row' );

                        //Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-row.php', array(
                        //));

                    break;

                    case 'layout-separatore':

                        $height = ( $cont['divider-height-number'] ?: 1 );
                        $height = $height . ( $cont['divider-height-units'] ?: 'px' );

                        $line = ( $cont['divider-line'] ?: 'no' );

                        if( $line != 'no' ){

                            $args['color'] = ( $cont['divider-color-color'] ?: '#ddd' );
                            $args['color'] = hex2rgba( $args['color'], ( $cont['divider-color-alpha'] ?: 1 ) );

                            $args['stroke'] = ( $cont['divider-size-number'] ?: 1 );
                            $args['stroke'] = $args['stroke'] . ( $cont['divider-size-units'] ?: 'px' );

                            $args['cap'] = ( $cont['divider-cap'] ?: 'round' );

                            $args['space'] = ( $cont['divider-space-dash-number'] ?: 26 );
                            $args['space'] = $args['space'] . ( $cont['divider-space-dash-units'] ?: 'px' );

                            $args['dash'] = ( $cont['divider-dash-number'] ?: 8 );
                            $args['dash'] = $args['dash'] . ( $cont['divider-dash-units'] ?: 'px' );

                            indent( $SCM_indent, scm_svg_line( $args, $line ), 2 );
                        
                        }else{
                            indent( $SCM_indent, '<hr style="height:' . $height . ';" />', 2 );
                        }

                    break;

                    case 'layout-icona':

                        $icon = $cont[ 'icon' ];
                        $icon_float = ( ( $cont[ 'icon-float' ] && $cont[ 'icon-float' ] != 'no' ) ? $cont[ 'icon-float' ] : 'no-float' );
                        $icon_float = ( $icon_float == 'float-center' ? 'float-center text-center' : $icon_float );
                        $icon_size = $cont[ 'icon-size-number' ];
                        $icon_units = ( $cont[ 'icon-size-units' ] ?: 'px' );
                        $icon_class = 'scm-img img ' . $icon_float;
                        $icon_style = 'line-height:0;font-size:' . ( is_numeric( $icon_size ) ? $icon_size . $icon_units : ( $icon_size ?: 'inherit' ) );

                        indent( $SCM_indent, '<div class="' . $icon_class . '" style="' . $icon_style . '">', 1 );

                            indent( $SCM_indent+1, '<i class="fa ' . $icon . '"></i>', 1 );

                        indent( $SCM_indent, '</div><!-- icon -->', 2 );

                    break;

                    case 'layout-immagine':

                        $image = ( $cont[ 'image' ] ?: '' );
                        $image_fissa = ( $cont[ 'image' ] ?: 'norm' );
                        
                        $image_float = ( ( $cont[ 'image-float' ] && $cont[ 'image-float' ] != 'no' ) ? $cont[ 'image-float' ] : 'no-float' );
                        $image_float = ( $image_float == 'float-center' ? 'float-center text-center' : $image_float );

                        $image_class = 'scm-img img ' . $image_float;
                        
                        switch ($image_fissa) {
                            case 'full':
                                $image_float = '';
                                $image_units = ( $cont[ 'image-full-units' ] ?: 'px' );
                                $image_height = ( isset( $cont[ 'image-full-number' ] ) ? $cont[ 'image-full-number' ] : 'initial' );
                                $image_height = ( is_numeric( $image_height ) ? $image_height . $image_units : ( $image_height ?: 'initial' ) );
                                $image_style = 'max-height:' . $image_height . ';';
                                $image_class = 'scm-full-image full-image mask full';
                            break;

                            case 'quad':
                                $image_units = ( $cont[ 'image-size-units' ] ?: 'px' );
                                $image_size = ( isset( $cont[ 'image-size-number' ] ) ? $cont[ 'image-size-number' ] : 'auto' );
                                $image_size = ( is_numeric( $image_size ) ? $image_size . $image_units : ( $image_size ?: 'auto' ) );
                                $image_style = 'width:' . $image_size . '; height:' . $image_size . ';';
                            break;
                            
                            default:
                                $image_units_w = ( $cont[ 'image-width-units' ] ?: '%' );
                                $image_units_h = ( $cont[ 'image-height-units' ] ?: '%' );
                                $image_width = ( isset( $cont[ 'image-width-number' ] ) ? $cont[ 'image-width-number' ] : 'auto' );
                                $image_height = ( isset( $cont[ 'image-height-units' ] ) ? $cont[ 'image-height-units' ] : $image_width );
                                $image_width = ( is_numeric( $image_width ) ? $image_width . $image_units_w : 'auto' );
                                $image_height = ( is_numeric( $image_height ) ? $image_height . $image_units_h : ( $image_height ?: $image_width ) );
                                $image_style = 'width:' . $image_width . '; height:' . $image_height . ';';
                            break;
                        }

                        if( !$image )
                            continue;

                        indent( $SCM_indent, '<div class="' . $image_class . '" style="' . $image_style . '">', 1 );

                            indent( $SCM_indent+1, '<img src="' . $image . '" alt="">', 1 );

                        indent( $SCM_indent, '</div><!-- image -->', 2 );

                    break;

                    case 'layout-titolo':

                        $text = $cont[ 'title' ];
                        $text_tag = ( $cont[ 'title-tag' ] ?: 'h1' );
                        //$text_default = ( $cont[ 'title-tag' ] ?: '' );
                        //$text_tag = ( strpos( $text_default, 'select_' ) === false ? $cont[ 'title-tag' ] : scm_field( $text_default , 'h1', 'option') );
                        $text_align = ( $cont[ 'alignment' ] != 'default' ? ( $cont[ 'alignment' ] ? $cont[ 'alignment' ] . ' ' : '' ) : '' );
                        //$text_class = scm_acf_field_choices_preset( 'select_headings_default',  $text_default ) . ' ';
                        $text_class = $text_align . 'scm-title title clear';


                        if( strpos( $text_tag, '.' ) !== false ){
                            $text_class .= ' ' . substr( $text_tag, strpos($text_tag, '.') + 1 );
                            $text_tag = 'h1';
                        }

                        indent( $SCM_indent, '<' . $text_tag . ' class="' . $text_class . '">' . (string)$text . '</' . $text_tag . '><!-- title -->', 2 );

                    break;

                    case 'layout-testo':

                        $content = $cont['editor'];
                        if(!$content) continue;
                        indent( $SCM_indent, $content, 2 );

                    break;

                    case 'layout-map':
                    break;

                    case 'layout-social_follow':
                    break;

                    case 'layout-slider':
                    break;

                    case 'layout-form':
                        $single = $cont[ 'form' ];
                        if(!$single) continue;
                        $post = ( is_numeric( $single ) ? get_post( $single ) : $single );
                        setup_postdata( $post );

                        get_template_part( SCM_DIR_PARTS_SINGLE, 'wpcf7_contact_form' );
                    break;

                    case 'layout-elenco_puntato':
                    break;

                    case 'layout-elenco_link':
                    break;

                    case 'layout-elenco_file':
                    break;

                    default:

                        $type = str_replace( '_', '-', str_replace( 'layout-', '', $element) );

                        if ( getByKey( $SCM_types['public'], $type ) === false )
                            continue;

                        $template_id = ( isset( $cont['template'] ) && $cont['template'] ? $cont['template'] : get_query_var( 'template', 0 ) );
                        $archive = ( isset( $cont['type'] ) ? $cont['type'] === 'archive' : 0 );
                        $width = ( isset( $cont['width'] ) ? $cont['width'] : 'auto' );
                        $query = [];

                        // +++ todo: se non c'è template, tira fuori tutti i campi, uno via l'altro
                        if( !$template_id )
                            continue;

                        $template = get_fields( $template_id );

                        if ( empty( $template ) )
                        	continue;

                        $link = ( $template['link'] ?: 'no' );
                        $single = strpos( $link, 'single') !== false;
                        $block = ( $link != 'no' && !$single );
						$url = ( strpos( $link, 'template' ) !== false ? $template['template'] : ( strpos( $link, 'link' ) !== false ? ( $template['url'] ? '' : '#' ) : '' ) );
						$target = ( strpos( $link, 'link' ) !== false ? '_blank' : '_self' );
						$link = $template['link'] = str_replace( '-single', '', $link);

                        if( $archive ){

                        	$tax = [];

                        	foreach ($cont as $key => $terms) {

                        		if( startsWith( $key, 'archive-' ) && endsWith( $key, '-terms' ) ){

                        			$taxonomy = str_replace( 'archive-', '', str_replace( '-terms', '', $key) );

	                        		//$terms = ( $cont['archive-soggetti-tipologie-terms'] ?: [] );
		                            if( sizeof( $terms ) ){
		                                $tax[ 'relation' ] = 'OR';
		                                foreach ( $terms as $term) {
		                                    $tax[] = array( 
		                                        'taxonomy' => $taxonomy, //(string)$term->taxonomy,
		                                        'field' => 'term_id',
		                                        'terms' => array( $term /*$term->term_id*/),
		                                        'operator' => 'IN',
		                                    );
		                                }
		                            }
	                        	}
                        	}

                            $complete = $cont['archive-complete'] === 'complete';
                            $perpage = ( $cont['archive-perpage'] ?: get_option( 'posts_per_page' ) );
                            $pagination = $cont['archive-pagination'] === 'yes';
                            $more = $cont['archive-pagination'] === 'more';
                            $all = $cont['archive-pagination'] === 'all';
                            $orderby = ( $cont['archive-orderby'] ?: 'date' );
                            $ordertype = ( $cont['archive-ordertype'] ?: 'ASC' );
                            $query = [
                                'post_type' => $type,
                                'tax_query' => $tax,
                                'posts_per_page' => $perpage,
                                'order' => $ordertype,
                                'orderby' => $orderby
                            ];

                        }else{

                            if( !empty( $cont['single'] ) ){

                                $query = [
                                    'post_type' => $type,
                                    'post__in' => ( $cont['single'] ?: [] ),
                                    'posts_per_page' => -1,
                                ];

                            }

                        }			
						

                        $loop = new WP_Query( $query );

                        $size = 0;
                        $current_column = 0;
						$counter = 0;

						$odd = '';
						$class = '';

						$total = 2;

						$data = [ 'data' => 'auto' ];

						printPre( $template );

                        $total = sizeof( $loop->posts );

                        if ( $loop->have_posts() ) {
                            
                            while ( $loop->have_posts() ) {
                                $loop->the_post();

                                // Open LI o DIV con data-href in base a $template['link']['template/url']
                                // Vedi di pescare la field principale Link in caso di $template['link'] = 'object'

								$class = 'post scm-post object scm-object inlineblock floatleft';
								$attributes = '';

						    	$odd = ( $odd ? '' : ' odd' );
					            $class .= $odd;

					            $current_column++;
								$class .= scm_count_class( $current_column, $total );

// if self crea funzione scm_object_link() dove controlli type e restituisci un link (soggetti, files, ecc) oppure niente

						    	$href = ( $link == 'template' && $block ? get_permalink() . ( $url ? '?template=' . $url : '' ) : $url );
// e lo aggiungi agli attributes
								$attributes .= ( $block ? ' data-href="' . $href . '" data-target="' . $target . '"' : '' );

								$layout = ( $width ? str_replace( '/', '', $width ) : '11' );

								if( $layout != 'auto' ){
						    		$size = (int)$layout[0] / (int)$layout[1];
						    		$counter += $size;
						    		$data = scm_column_data( $counter, $size );
						    		$counter = $data['count'];
                                    $attributes .= ' data-column-width="' . $layout . '" data-column="' . $data['data'] . '"';
						    	}

								indent( $SCM_indent, '<div class="' . $class . '"' . $attributes . '>', 2 );

	                                Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-' . $type . '.php', array(
                                        //'wrap' => '<div class="' . $class . '"' . $attributes . '>%a</div><!-- ' . $type . '-' . $post->ID . ' -->',
                                        'href' => ( $single ? $href : '' ),
                                        'target' => ( $single ? $target : '' ),
                                        'build' => ( $template['build'] ?: [] ),
	                                ));

                                indent( $SCM_indent, '</div><!-- ' . $type . '-' . $post->ID . ' -->', 2 );
                                
                            }

                            

                        } else {
                            // no posts found
                        }

                        wp_reset_postdata();

                    break;

                                        
                }
            }

            $SCM_indent -= 1;
        }
    }

    //Prints Post Contents
    /*if ( ! function_exists( 'scm_content' ) ) {
        function scm_content( $template ) {

            $href = ( $template['href'] ?: '' );
            $target = ( $template['target'] ?: '' );
            $build = ( $template['build'] ?: '' );



        }
    }*/

?>