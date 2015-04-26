<?php
/**
 * @package SCM
 */

// *****************************************************
// *    SCM CONTENT
// *****************************************************

/*
*****************************************************
*
*   0.0 Actions and Filters
*   1.0 Print Contents
**      1.1 Content (filter single module to 1.2 or 1.3)
**      1.2 Containers (section, row, column, module, post, content)
**      1.3 Contents (section, indirizzo, map, social_follow, ...)
*   2.0 Post Content
**      2.1 Post (soggetti, luoghi, ...)
**      2.2 Post Link (self, template, link)
*
*****************************************************
*/

// *****************************************************
// *      0.0 ACTIONS AND FILTERS
// *****************************************************


// *****************************************************
// *      1.0 PRINT CONTENTS
// *****************************************************

    // *****************************************************
    // *      1.1 CONTENT
    // *****************************************************

    if ( ! function_exists( 'scm_content' ) ) {
        function scm_content( $content = [] ) {

            global $post, $SCM_indent;

            $type = $post->name;

            $container = '';

            if( isset( $content['sections'] ) ){
                $container = 'section';
                $content = $content['sections'];
            }else if( isset( $content['rows'] ) ){
                $container = 'row';
                $content = $content['rows'];
            }else if( isset( $content['columns'] ) ){
                $container = 'column';
                $content = $content['columns'];
            }else if( isset( $content['modules'] ) ){
                $container = 'module';
                $content = $content['modules'];
            }else if( isset( $content['acf_fc_layout'] ) ){
                if( isset( $content['row'] ) && !$content['row'] )
                    return;
                $container = 'content';
            }
            
            switch ( $container ) {
                
                case 'section':
                case 'row':
                case 'post':
                case 'column':
                case 'module':

                    scm_containers( $content, $container );

                    
                    /*if( !empty( $content['sections'] ){
                        $build = $content['sections'];
                        $type = 'row';
                    }else*/
                    
                    /*$section = is( $content['columns'], 'NONE' );
                    
                    $section = is( $content['modules'], 'NONE' );*/

                    //scm_containers( ( isset( $content['columns'] ) && is( $content['columns'] ) ? $content['columns'] : ( isset( $content['modules'] ) && is( $content['modules'] ) ? $content['modules'] : [] ) ), ( $container == 'section' ? 'row' : ( $container == 'row' ? 'column' : ( $container == 'column' ? 'module' : 'content' ) ) ) );
                
                break;

                
                /*case 'content':

                    $SCM_indent++;
                    scm_contents( $content );
                    $SCM_indent--;

                break;*/

                case 'content':

                    $SCM_indent++;

        // SCM FILTER - $content before it is elaborated - scm_filter_echo_content/{content}
                    $content = apply_filters( 'scm_filter_echo_content' . is( $content['acf_fc_layout'], '', '/' ), $content );

                    // TRY default contents - scm_contents
                    scm_contents( $content );

                    // TRY scm_single_content_{type}
                    if( function_exists( 'scm_single_content_' . $type ) )
                        call_user_func( 'scm_single_content_' . $type, $content, $SCM_indent );

                    // +++ todo: GALLERY: aggiungi opzioni [mostra thumb/title/description] a Gallery Temp > Thumbs
                    // quando printi le gallery, per ogni Thumb assegni un data-init diverso

        // SCM ACTION - with $content - scm_action_echo_content/{type}
                    do_action( 'scm_action_echo_content' . is( $type, '', '/' ), $content, $SCM_indent );

                    $SCM_indent--;

                break;
                
                default:
                    if( function_exists( (string)$container ) )
                        call_user_func( (string)$container, $content );
                break;
            }
        }
    }

    // *****************************************************
    // *      1.2 CONTAINERS
    // *****************************************************

    if ( ! function_exists( 'scm_containers' ) ) {
        function scm_containers( $build = [], $container = 'module', $action = '' ) {

            if( is( $container == 'post' ) ){
                $builder = $build;
                $build = ( isset( $build['posts'] ) ? $build['posts'] : [] );
            }

            if( !is( $build ) )
                return;

            global $post, $SCM_indent;

            $current = 0;
            $counter = 0;
            $odd = '';
            $total = sizeof( $build );

            $SCM_indent++;
            $count = 0;

            foreach ( $build as $content ) {

                $count++;

                $args = [

                    'column-width' => '',
                    'layout' => 'full',
                    
                    'acf_fc_layout' => '',
                    'inherit' => false,

                    'id' => '',
                    'class' => '',
                    'attributes' => '',
                    'style' => '',

                    'alignment' => 'default',
                    'float' => '',
                    'overlay' => '',
                    
                    'link' => 'no',
                    'template' => 0,
                    'url' => '#',
                    
                ];

                if( $container == 'post' ){
                    $post = ( is_numeric( $content ) ? get_post( $content ) : $content );
                    setup_postdata( $post );
                    $content = $builder;
                }

                $content = ( is_array( $content ) ? array_merge( $args, $content ) : [] );

                if( isset( $content['row'] ) && !empty( $content['row'] ) ){



                    $mod_post = $content['row'];
                    $mod_post = ( is_numeric( $mod_post ) ? $mod_post : $mod_post->ID );
                    $module = get_fields( $mod_post );

                    if( is( $module ) ){

                        $mod_layout = ( isset( $content['layout'] ) ? $content['layout'] : '' );
                        $mod_id = ( isset( $content['id'] ) ? $content['id'] : '' );
                        $mod_class = ( isset( $content['class'] ) ? $content['class'] : '' );
                        $mod_attr = ( isset( $content['attributes'] ) ? $content['attributes'] : '' );

                        $content = array_merge( $content, $module );

                        //printPre( $orig );
                        $content['layout'] = ( $mod_layout && $mod_layout != 'default' ? $mod_layout : $content['layout'] );
                        $content['layout'] = ( $content['layout'] != 'default' ? $content['layout'] : 'responsive' );
                        $content['id'] = is( $mod_id, $content['id'] );
                        $content['class'] = $mod_class . ' ' . $content['class'];
                        $content['attributes'] = $mod_attr . ' ' . $content['attributes'];
                    }
                }

                // -- Layout

                $content['id'] = is( $content['id'], ( $container == 'section' ? $post->post_name . '-' . $count : '' ) );

                $name = $content['acf_fc_layout'];
                $slug = str_replace( 'layout-', '', $name );

                // -- Width

                $current++;
                $odd = ( $odd ? '' : 'odd' );
                
                $layout = $content['column-width'];
                $content['inherit'] = ( $layout === 'auto' );
                
                // -- Link

                $link = ( $content['link'] ?: 'no' );

                if( !$container == 'post' ){
                    $link_object = scm_post_link( 0, $content );
                }else{
                    $link_object = scm_post_link();
                    $link_template = ( $content['template'] ? ' data-href="' . get_permalink() . '?template=' . $content['template'] . '"' : '' );
                    $link_url = ( $content['url'] ? ' data-href="' . $content['url'] . '"' : '' );
                }

                $href = ( $link == 'self' ? $link_object : ( $link == 'template' ? $link_template : ( $link == 'link' ? $link_url : '' ) ) );
                $target = ( $link == 'template' ? ' data-target="_self"' : ' data-target="_blank"' );
                $content['attributes'] .= ( $link && $link != 'no' ? $href . $target : '' );

                // -- Class
                $content['class'] .= ' ' . $odd;
                $content['class'] .= ' ' . scm_count_class( $current, $total );
                $content['class'] .= ' ' . ( $content['alignment'] != 'default' ? $content['alignment'] : '' );
                $content['class'] .= ' ' . ( $content['inherit'] ? is( $content['float'], '' ) : is( $content['overlay'] ) );
                $content['class'] .= ' ' . ifnotequal( is( $content['alignment'], 'default' ), 'default' );                

                if( !$content['inherit'] ){

                // -- Column Width
                
                    if( strpos( $layout, '/' ) !== false ){

                        $layout = str_replace( '/', '', $layout );
                        $size = (int)$layout[0] / (int)$layout[1];
                        $counter += $size;
                        $data = scm_column_data( $counter, $size );
                        $counter = $data['count'];

                        $content['attributes'] = ' data-column-width="' . $layout . '" data-column="' . $data['data'] . '"' . $content['attributes'];
                        $content['class'] .= ' ' . 'column-layout';

                    }else{

                        $content['class'] .= ' ' . $content['layout'];

                    }

                    $content['class'] = $container . ' scm-' . $container . ' ' . $name . ' ' . $slug . ' object scm-object ' . $content['class'];
                    // container
                    indent( $SCM_indent, openTag( 'div', $content['id'], $content['class'], $content['style'], $content['attributes'] ), 1 );

                    $content['id'] = $content['class'] = $content['style'] = $content['attributes'] = '';

                }

                // content
                scm_content( $content );

                if( function_exists( (string)$action ) )
                    call_user_func( (string)$action, $content );

                if( !$content['inherit'] )
                    indent( $SCM_indent, '</div><!-- ' . $container . ' -->', 2 );
            }

            $SCM_indent--;
        }
    }

    // *****************************************************
    // *      1.3 CONTENTS
    // *****************************************************

    //Prints Element Flexible Contents
    if ( ! function_exists( 'scm_contents' ) ) {
        function scm_contents( $content ) {

            if( !$content )
                return;

            $content = ( !isset( $content[0] ) ? array( $content ) : $content );

            global $post, $SCM_indent;

            foreach ( $content as $args ) {

                $default = [
                    'acf_fc_layout' => '',
                    'id' => '',
                    'class' => '',
                    'attributes' => '',
                    'style' => '',
                ];

                $args = array_merge( $default, $args );

                $element = $args[ 'acf_fc_layout' ];
                $class = $args['class'];
                $id = $args['id'];
                $attributes = $args['attributes'];
                $style = $args['style'];

                switch ($element) {

// *** Dynamic Objects

                    case 'layout-banner':
                    case 'layout-module':
                    case 'layout-section':

                        scm_containers( [ $args ], 'row' );

                    break;

                    case 'layout-indirizzo':

                        Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-address.php', array(
                            'cont' => $args,
                        ));

                    break;

                    case 'layout-map':

                        Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-map.php', array(
                            'cont' => $args,
                        ));

                    break;
                    
                    case 'layout-contatti':
                    case 'layout-social_follow':
                    case 'layout-elenco_puntato':
                    case 'layout-pulsanti':
                    case 'layout-link':
                    case 'layout-pagine':
                    case 'layout-media':

                        Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-list.php', array(
                            'cont' => $args
                        ));

                    break;

                    case 'layout-slider':
                        
                        Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-slider.php', array(
                            'cont' => $args
                        ));

                    break;

                    // +++ todo: non in uso - attualmente inclusa in single-slider
                    // quando diventerà un template a sé, immaginalo come elemento utilizzabile da solo, tipo animazioni
                    // e leva Nivo Slider, se ogni singola slide ha animazioni d'entrata e uscita, ti serve solo una classe per il timer, al massimo uno slide orizzontale o verticale
                    case 'layout-slide':

                        $slide = $args[ 'slide' ];
                        if(!$slide) continue;
                        $post = ( is_numeric( $slide ) ? get_post( $slide ) : $slide );
                        setup_postdata( $slide );
                        
                        Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-slide.php', array(
                            'cont' => $args
                        ));

                    break;

                    case 'layout-form':

                        $single = $args[ 'form' ];
                        if(!$single) continue;
                        $post = ( is_numeric( $single ) ? get_post( $single ) : $single );
                        setup_postdata( $post );

                        indent( $SCM_indent + 1, do_shortcode('[contact-form-7 id="' . get_the_ID() . '" title="' . get_the_title() . '"]'), 2 );

                        //get_template_part( SCM_DIR_PARTS_SINGLE, 'wpcf7_contact_form' );
                    break;

// *** Static Objects

                    case 'layout-separatore':

                        $height = scm_content_preset_size( $args[ 'height-number' ], $args[ 'height-units' ], 1 );
                        $style = 'height:' . $height . ';';

                        $line = ( $args['line'] ?: 'no' );

                        if( $line != 'no' ){

                            $svg_args = [];
                            $svg_args['height'] = $height;
                            $svg_args['y1'] = $svg_args['y2'] = scm_content_preset_size( $args[ 'position-number' ], $args[ 'position-units' ], 50, '%' );
                            $svg_args['color'] = scm_content_preset_rgba( $args['color-color'], $args['color-alpha'], '#ddd' );
                            $svg_args['stroke'] = scm_content_preset_size( $args[ 'size-number' ], $args[ 'size-units' ], 5 );
                            $svg_args['cap'] = ( $args['cap'] ?: 'round' );
                            $svg_args['space'] = scm_content_preset_size( $args[ 'space-number' ], $args[ 'space-units' ], 26 );
                            $svg_args['dash'] = scm_content_preset_size( $args[ 'dash-number' ], $args[ 'dash-units' ], 8 );

                            indent( $SCM_indent, scm_svg_line( $svg_args, $line ), 2 );
                        
                        }else{

                            indent( $SCM_indent, openTag( 'hr', $id, $class, $style, $attributes ) . '<!-- divider -->', 2 );
                            
                        }

                    break;

                    case 'layout-icona':

                        Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-icon.php', array(
                            'cont' => $args
                        ));

                    break;

                    case 'layout-logo-icona':
                    case 'layout-logo':
                    case 'layout-immagine':

                        Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-image.php', array(
                            'cont' => $args
                        ));

                    break;

                    case 'layout-quote':
                    case 'layout-copy':
                    case 'layout-cf':
                    case 'layout-piva':
                    case 'layout-intestazione':
                    case 'layout-titolo':

                        Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-title.php', array(
                            'cont' => $args
                        ));

                    break;

                    case 'layout-data':

                        // +++ todo: rimane comunque da splittare in più span, perlomeno
                        
                        $unformat = ( isset( $args[ 'date' ] ) ? $args[ 'date' ] : ( get_the_date() ?: '' ) );
                        $date_format = implode( $args[ 'separator' ], str_split( $args[ 'format' ] ) );
                        $date = date_format( date_create( $unformat ), $date_format );
                        $tag = ( $args[ 'tag' ] ?: 'h1' );
                        $date_class = 'scm-date date' . is( $class );


                        if( strpos( $tag, '.' ) !== false ){
                            $date_class .= ' ' . substr( $tag, strpos($tag, '.') + 1 );
                            $tag = 'div';
                        }

                        indent( $SCM_indent, openTag( $tag, $id, $class, $style, $attributes ) . (string)$date . '</' . $tag . '><!-- date -->', 2 );

                    break;

                    case 'layout-testo':

                    

                        $text = ( isset( $args['editor'] ) ? $args['editor'] : ( isset( $args['editor-visual'] ) ? $args['editor-visual'] : '' ) );
                        if(!$text) continue;
                        
                        indent( $SCM_indent, $text, 1 ); // +++ todo: se non è un <p> aggiungilo, e comunque aggiungi class id style e attr

                    break;
                    

                    default:

                        if( strpos( $element, 'layout-SCMTAX-' ) === 0 ){

                            $tax = str_replace( 'layout-SCMTAX-', '', $element );
                            $terms = ( isset( $args[ 'categorie' ] ) ? $args[ 'categorie' ] : ( wp_get_object_terms( get_the_ID(),  $tax ) ?: [] ) );
                            //printPre( $args );
                            $tag = $args['tag'];
                            $pre = $args['prepend'];
                            $app = $args['append'];
                            $sep = $args['separator'];

                            if ( ! empty( $terms ) ) {
                                if ( ! is_wp_error( $terms ) ) {

                                    indent( $SCM_indent, openTag( $tag, $id, $class, $style, $attributes ), 2 );
                                    
                                        indent( $SCM_indent + 1, '<span class="prepend">' . $pre . '</span>', 1 );

                                        for ($i=0; $i < sizeof( $terms ) ; $i++){

                                            $term = $terms[ $i ];
                                            $href = ( $args['link'] == 'self' ? ' href="' . get_term_link( $term->slug, $tax ) . '"' : '' );
                                            
                                            indent( $SCM_indent + 1, '<a class="term"' . $href . '>' . esc_html( $term->name ) . '</a>' . ( $i < sizeof( $terms ) - 1 ? ( $sep ? $sep . ' ' : '' ) : $app ) , 2 );

                                        }
                                    
                                    indent( $SCM_indent, '</' . $tag . '>', 2 );

                                }
                            }

                        }else{

                            scm_post( $args );

                        }

                    break;

                                        
                }
            }

            //$SCM_indent--;
        }
    }



// *****************************************************
// *      2.0 POST CONTENT
// *****************************************************

    // *****************************************************
    // *      2.1 POST
    // *****************************************************

    if ( ! function_exists( 'scm_post' ) ) {
        function scm_post( $cont = [] ) {

            global $SCM_types, $SCM_indent;

            $element = ( isset( $cont[ 'acf_fc_layout' ] ) ? $cont[ 'acf_fc_layout' ] : '' );

            $type = str_replace( '_', '-', str_replace( 'layout-', '', $element) );

            if ( getByKey( $SCM_types['public'], $type ) === false )
                return;

            $archive = ( isset( $cont['type'] ) ? $cont['type'] === 'archive' : 0 );
            $width = ( isset( $cont['width'] ) ? $cont['width'] : 'auto' );
            $query = [];

            $template_id = ( isset( $cont['template'] ) && $cont['template'] ? $cont['template'] : get_query_var( 'template', 0 ) );
            // +++ todo: se non c'è template, tira fuori tutti i campi, uno via l'altro, o solo titolo con link oggetto se c'è
            if( !$template_id )
                return;

            $template = get_fields( $template_id );
            $template_post = get_post( $template_id );
            $template_name = $template_post->post_name;
            $template['column-width'] = $width;

            if ( empty( $template ) )
                return;


            if( $archive ){

                $tax = [];

                foreach ($cont as $key => $terms) {

                    if( startsWith( $key, 'archive-' ) && endsWith( $key, '-terms' ) ){

                        $taxonomy = str_replace( 'archive-', '', str_replace( '-terms', '', $key) );

                        if( isset( $terms ) && !empty( $terms ) ){
                            $tax[ 'relation' ] = 'OR';
                            foreach ( $terms as $term) {
                                $tax[] = array( 
                                    'taxonomy' => $taxonomy,
                                    'field' => 'term_id',
                                    'terms' => array( $term ),
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

            $template['posts'] = $loop->posts;
            $template['class'] = $type . ' template-' . $template_id . ' ' . $template_name;
            scm_containers( $template, 'post' );

            wp_reset_postdata();

        }
    }

    // *****************************************************
    // *      2.1 POST LINK
    // *****************************************************

    if ( ! function_exists( 'scm_post_link' ) ) {
        function scm_post_link( $id = 0, $content = [] ) {
            
            global $post;

            if( $id ){
                $post = ( is_numeric( $id ) ? get_post( $id ) : $id );
                setup_postdata( $post );
            }

            $type = $post->post_type;
            $id = $post->ID;
            $link = '';

            $attr = '';

            switch ( $type ) {
                case 'soggetti':
                    $link = scm_field( 'soggetto-link', '#', $id );
                break;
                
                case 'luoghi':
                    $lat = scm_field( 'luogo-lat', 0, $id );
                    $lng = scm_field( 'luogo-lng', 0, $id );
                    $link = 'http://maps.google.com/maps?q=' . $lat . ',' . $lng;
                break;

                case 'documenti':
                    $link = scm_field( 'documento-file', '#', $id );
                break;

                case 'rassegne-stampa':
                    $typ = scm_field( 'rassegna-type', 'file', $id );
                    $link = ( $typ == 'file' ? scm_field( 'rassegna-file', '#', $id ) : scm_field( 'rassegna-link', '#', $id ) );
                break;

                case 'gallerie':
                    global $SCM_galleries;
                    $link = '';
                    $images = scm_field( 'galleria-images', [], $id );
                    $custom_id = uniqid( 'gallery-' );
                    $SCM_galleries[ $custom_id ] = $images;
                    $init = ( !empty( $content ) && isset( $content['btn-img'] ) ? $content['btn-img'] : 0 );
                    $attr = ' data-gallery="' . $custom_id . '"';
                    $attr .= ' data-gallery-init="' . $init . '"';
                    $attr .= ' data-gallery-title="' . get_the_title( $id ) . '"';
                break;

                case 'video':
                    global $SCM_galleries;
                    $link = '';
                    $video = scm_field( 'video-url', [], $id );
                    $video = ( strpos( $video, '/embed/' ) === false ? 'https://www.youtube.com/embed/' . substr( $video, strpos( $video, '=' ) + 1 ) : $video );
                    $images = [ '<iframe width="800" height="600" src="' . $video . '" frameborder="0" allowfullscreen></iframe>', '<iframe width="800" height="600" src="' . $video . '" frameborder="0" allowfullscreen></iframe>' ];
                    $custom_id = uniqid( 'video-' );
                    $SCM_galleries[ $custom_id ] = $images;
                    $attr = ' data-gallery="' . $custom_id . '"';
                    $attr .= ' data-gallery-init="0"';
                    $attr .= ' data-gallery-title="' . get_the_title( $id ) . '"';
                    $attr .= ' data-gallery-type="html"';
                break;

                default:
                    $link = apply_filters( 'scm_filter_object_link/' . $type, $link, $id );
                break;
            }

            return $attr . ( $link ? ' data-href="' . getURL( $link ) . '"' : '' );

        }
    }


?>