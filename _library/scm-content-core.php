<?php

/**
* SCM echo containers and contents.
*
* @link http://www.studiocreativo-m.it
*
* @package SCM
* @subpackage 5-Content/Core
* @since 1.0.0
*/

/**
* @global int $SCM_indent Used for formatting HTML
*/
$SCM_indent         = 1;

/**
* @global int $SCM_page_id Current page id
*/
//$SCM_page_id        = 0;

// ------------------------------------------------------
//
// 1.0 Echo Content
//      1.1 Content (filter single module to 1.2 or 1.3)
//      1.2 Containers (section, row, column, module, post, content)
//      1.3 Contents (section, indirizzo, map, social_follow, ...)
//      1.4 Post Content
//
// ------------------------------------------------------

// ------------------------------------------------------
// 1.0 PRINT CONTENTS
// ------------------------------------------------------
// ------------------------------------------------------
// 1.1 CONTENT
// ------------------------------------------------------

/**
* [SET] Main content function
*
* Check and set container and content of the element.
*
* If container [section|sub-section|row|column|module|post]:<br>
* - apply 'scm_filter_echo_containers' filter<br>
* - call {@see scm_containers()}<br>
*
* Else if content [any acf_fc_layout]:<br>
* - call {@see scm_contents()}<br>
*
* Else if a second {string} argument is passed:<br>
* - call {argument2} function
*
* @param {array=} content Content array (default is empty array).
* @param {string=} container Container name (default is '').
*/
function scm_content( $content = array(), $container = '' ) {

    if( isset( $content['sections'] ) ){
        if( isset( $content['page-menu'] ) )
            $container = 'section';
        else
            $container = 'sub-section';
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
        case 'sub-section':
        case 'row':
        case 'post':
        case 'column':
        case 'module':

            scm_containers( $content, $container );

        break;

        case 'content':

            scm_contents( $content );

        break;

        default:
            if( function_exists( (string)$container ) )
                call_user_func( (string)$container, $content );
        break;
    }
}

// ------------------------------------------------------
// 1.2 CONTAINERS
// ------------------------------------------------------

/**
* [ECHO] Container
*
* Setup container.
*
* Hooks:
```php
// Filter container and content before echo
$build = apply_filters( 'scm_filter_echo_containers', $build, $container, $action );
```
*
* @todo 1 - Attivare inherit per tutti i contenuti vuoti e/o aggiungi opzione SKIP IF EMPTY a tutti gli elementi con contenuti (immagini, video, link, ...)
*
* @param {array=} build Content array (default is empty array).
* @param {string=} container Container name (default is 'module').
* @param {string=} action Optional function name run at the end of the process (default is '').
*/
function scm_containers( $build = array(), $container = 'module', $action = '' ) {

    $build = apply_filters( 'scm_filter_echo_containers', $build, $container, $action );

    $builder = array();

    if( is( $container == 'post' ) ){
        $builder = $build;
        $build = ( isset( $build['posts'] ) ? $build['posts'] : array() );
    }

    if( !isset( $build ) )
        return;

    global $post, $SCM_indent;

    $current = 0;
    $counter = 0;
    $odd = '';
    $total = ( !$build ? 0 : sizeof( $build ) );

    $SCM_indent++;
    $count = 0;

    if( $total === 0 ){ 

        if( sizeof($builder) > 0 ){

            indent( $SCM_indent, openTag( 'div', '', ' fallback', '', '' ), 1 );

                indent( $SCM_indent+1, $builder['fallback'], 1 );

            indent( $SCM_indent, '</div><!-- fallback -->', 2 );

        }

    }elseif( $total > 0 ){

        foreach ( $build as $content ) {

            $count++;

            $args = array(

                'column-width' => '',
                'layout' => '',

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

            );

            if( $container == 'post' ){
                $post = ( is_numeric( $content ) ? get_post( $content ) : $content );
                setup_postdata( $post );
                $content = $builder;

                $taxes = get_object_taxonomies( $post );

                if( !is_wp_error( $taxes ) && is_array( $taxes ) ){

                    foreach ( $taxes as $key => $tax ) {

                        $content['class'] .= ' ' . $tax;

                        if( $tax === 'docs-tags' ){

                            $terms = get_the_terms( $post->ID, 'docs-tags' );

                            if( !is_wp_error( $terms ) && is_array( $terms ) ){

                                foreach ( $terms as $key => $term ) {

                                    $content['class'] .= ' term-' . $term->slug;

                                }
                            }
                        }
                    }
                }

                $content['attributes'] = ( isset( $content['attributes'] ) ? $content['attributes'] : '' );
                $content['attributes'] .= ' data-id="' . $post->ID . '" ' . ( $content['attributes'] ?: $args['attributes'] );
            }

            $content = ( is_array( $content ) ? array_merge( $args, $content ) : array() );

            // -- Layout
            if($container == 'sub-section')
                $container = 'section';
            else
                $content['id'] = is( $content['id'], ( $container == 'section' ? $post->post_name . '-' . $count : '' ) );

            $name = $content['acf_fc_layout'];
            $slug = str_replace( 'layout-', '', $name );

            // -- Post
            if( isset( $content['type'] ) ){

                if( $content['type'] == 'archive' ){
                    if( $content['archive-complete'] != 'complete' ){
                        if( $content['archive-pagination'] == 'yes' || $content['archive-pagination'] == 'more' ){
                            $content['id'] = ( $content['id'] ?: 'archive-' . $slug );
                            $content['archive-paginated'] = $content['id'];
                            $content['class'] .= ' paginated';
                        }
                    }

                    $content['class'] = 'scm-archive archive archive-' . $slug . ' ' . $content['class'];

                }else if( $content['type'] == 'single' ){

                    $content['class'] = 'scm-single single ' . $content['class'];

                }

            }

            // -- Single Post
            if( isset( $content['template'] ) && $content['acf_fc_layout'] === 'layout-template' ){

                if( isset( $content['archive'] ) && ifexists( $content['archive'], '' ) ){

                    $content['type'] = 'archive';

                    $temp = explode( ':', $content['archive'] );
                    $archive = $temp[0];
                    $field = '';
                    $value = '';
                    if( isset( $temp[1] ) ){
                        $filter = explode( '=', $temp[1] );
                        $field = $filter[0];
                        if( isset( $filter[1] ) )
                            $value = $filter[1];
                    }

                    $content['acf_fc_layout'] = 'layout-' . $archive;
                    $content['archive-field'] = $field;
                    $content['archive-value'] = $value;

                }elseif( isset( $content['post'] ) && ifexists( $content['post'], '' ) ){

                    $content['type'] = 'single';

                    if( (int)$content['post'] > 1 ){
                        $content['single'] = array_walk( explode( ',', str_replace( ' ', '', $content['post'] ) ), 'intval' );
                    }else{
                        $content['single'] = array( scm_field( (string)$content['post'], null, 'option' ) );
                    }

                    if( !empty( $content['single'] ) ){
                        $temp = get_post( $content['single'][0] );
                        $content['acf_fc_layout'] = 'layout-' . $temp->post_type;
                    }
                }else{

                    $content['type'] = 'single';

                    $content['acf_fc_layout'] = 'layout-' . $post->post_type;
                    $content['single'] = array( $post->ID );

                    $content['layout'] = ( isset( $content['layout'] ) && $content['layout'] != 'default' ? $content['layout'] : 'responsive' );
                    $content['alignment'] = ( isset( $content['alignment'] ) && $content['alignment'] != 'default' ? $content['alignment'] : '' );
                }
            }

            // -- Row
            if( isset( $content['row'] ) && !empty( $content['row'] ) ){

                $mod_post = $content['row'];
                $mod_post = ( is_numeric( $mod_post ) ? $mod_post : ( isset( $mod_post->ID ) ? $mod_post->ID : $mod_post ) );
                $module = ( is_numeric( $mod_post ) ? get_fields( $mod_post ) : $mod_post );

                if( is( $module ) ){

                    $mod_layout = ( isset( $content['layout'] ) ? $content['layout'] : '' );
                    $mod_id = ( isset( $content['id'] ) ? $content['id'] : '' );
                    $mod_class = ( isset( $content['class'] ) ? $content['class'] : '' );
                    $mod_attr = ( isset( $content['attributes'] ) ? $content['attributes'] : '' );

                    $content = array_merge( $content, $module );

                    $content['layout'] = ( $mod_layout && $mod_layout != 'default' ? $mod_layout : $content['layout'] );
                    $content['layout'] = ( $content['layout'] != 'default' ? $content['layout'] : 'responsive' );
                    $content['id'] = is( $mod_id, $content['id'] );
                    $content['class'] = $mod_class . ' ' . $content['class'];

                }

            }

            // -- Link
            $link = ( $content['link'] ?: 'no' );

            if( isset( $link ) && $link && $link != 'no' ){

                $href = '';
                $target = ' data-target="_blank"';

                if( $container != 'post' ){
                    $href = scm_utils_link_post( $content );
                }else{
                    switch ( $link ) {
                        case 'self':
                            // if thumbs $content['link'] = $href e $href = '' else...
                            $href = scm_utils_link_post( $content );
                        break;

                        case 'template':
                            $target = ' data-target="_self"';
                            $href = ' data-href="' . get_permalink() . ( $content['template'] ? '?template=' . $content['template'] : '' ) . '"';
                        break;

                        case 'link':
                            $href = ( $content['url'] ? ' data-href="' . $content['url'] . '"' : '' );
                        break;

                        default: break;
                    }
                }

                $content['attributes'] .= ( $href ? $href . $target : '' );
            }

            // -- Column Width
            $layout = $content['column-width'];

            // ++todo 1
            $content['inherit'] = ( $layout === 'auto' && $container !== 'post' ) || ( $slug === 'immagine' && ( isset( $content['image'] ) && !$content['image'] ) );
            //$content['inherit'] = ( $layout === 'auto' && $container !== 'post' ) || ( isset( $content['image'] ) && !$content['image'] );

            if( !$content['inherit'] ){

                if( strpos( $layout, '/' ) !== false ){

                    $layout = str_replace( '/', '', $layout );
                    $size = (int)$layout[0] / (int)$layout[1];
                    $counter += $size;
                    $data = scm_utils_data_column( $counter, $size );
                    $counter = $data['count'];

                    $content['attributes'] = ' data-column-width="' . $layout . '" data-column="' . $data['data'] . '"' . $content['attributes'];
                    $content['class'] .= ' ' . 'column-layout';

                }else{

                    $content['class'] .= ' ' . $content['layout'];

                }
            }

            // -- Column Count
            $current++;
            $odd = ( $odd ? '' : 'odd' );

            // -- Class
            $content['class'] .= ' ' . $odd;
            $content['class'] .= ' ' . scm_utils_class_count( $current, $total );
            $content['class'] .= ' ' . ( $content['alignment'] != 'default' ? $content['alignment'] : '' );
            $content['class'] .= ' ' . ( $content['inherit'] ? is( $content['float'], '' ) : is( $content['overlay'] ) );
            $content['class'] .= ' ' . ifnotequal( is( $content['alignment'], 'default' ), 'default' );

            // FILTER contents before echo            
            $content = apply_filters( 'scm_filter_echo_container', $content );
            
            // -- Open Container
            if( !$content['inherit'] ){

                $content['class'] = $container . ' scm-' . $container . ' ' . $name . ' ' . $slug . ' object scm-object ' . $content['class'];

                    indent( $SCM_indent, openTag( 'div', $content['id'], $content['class'], $content['style'], $content['attributes'] ), 1 );

                $content['id'] = $content['class'] = $content['style'] = $content['attributes'] = '';
            }

            // -- Content
            scm_content( $content );

            if( function_exists( (string)$action ) )
                call_user_func( (string)$action, $content );

            // -- Close Container
            if( !$content['inherit'] )
                indent( $SCM_indent, '</div><!-- ' . $container . ' -->', 2 );
        }
    }

    $SCM_indent--;
}

// ------------------------------------------------------
// 1.3 CONTENTS
// ------------------------------------------------------

/**
* [ECHO] Content
*
* It uses @see scm_contents_single() to filter the Contents array.
*
* Hooks:
```php
// Filter any $content before echoed
$content = apply_filters( 'scm_filter_echo_content', $content );

// Filter specific $content before echoed
$content = apply_filters( 'scm_filter_echo_content_{acf_fc_layout}, $content );

// Action after any $content is echoed
do_action( 'scm_action_echo_content', $content, $SCM_indent );

// Action after specific $content is echoed
do_action( 'scm_action_echo_content_' . $type, $content, $SCM_indent );
```
*
* @todo 1 - Sostituisci Nivo Slider e Slide diventa elemento singolo<br>
*           Ogni slide ha animazioni d'entrata e uscita, aggiungi una classe per il timer
*
* @todo 2 - Dividi date/time in span
*
* @todo 3 - Verifica/aggiungi tag paragrafo in textarea e aggiungi class id style e attr
*
* @param {array} content Content array.
*/
function scm_contents( $content = NULL ) {

    if( is_null( $content ) ) return;

    global $SCM_forms;

    $content = apply_filters( 'scm_filter_echo_content', $content );

    if( is_null( $content ) || !$content ) return;

    if( $content['acf_fc_layout'] ) $content = apply_filters( 'scm_filter_echo_content_' . $content['acf_fc_layout'], $content );                

    $content = toArray( $content, true, true );
    if( ! $content ) return;

    global $post, $SCM_indent;

    $id = $post->ID;
    $type = $post->post_type;
    $SCM_indent++;

    foreach ( $content as $args ) {

        $args = scm_contents_single( $args );

        do_action( 'scm_action_echo_content', $args, $SCM_indent );
        do_action( 'scm_action_echo_content_' . $type, $args, $SCM_indent );

        $SCM_forms = apply_filters( 'scm_filter_content_form', $SCM_forms, $args, $type, $id, $SCM_indent );
        $SCM_forms = apply_filters( 'scm_filter_content_form_' . $type, $SCM_forms, $args, $id, $SCM_indent );

        $SCM_indent--;
    }
}

/**
* [GET] Content Helper
*
* @param {array} content Single content (default is empty array).
* @return {array} Modified Single content.
*/
function scm_contents_single( $args = array() ) {
    global $post, $SCM_indent;
    
    $default = array(
            'acf_fc_layout' => '',
            'id' => '',
            'class' => '',
            'attributes' => '',
            'style' => '',
        );

    $args = array_merge( $default, $args );

    $element = $args['acf_fc_layout'];
    $class = $args['class'];
    $id = $args['id'];
    $attributes = $args['attributes'];
    $style = $args['style'];

    switch ($element) {

// Dynamic Objects

        case 'layout-modules':
            $args['modules'] = scm_field( 'modules', '', $post->ID );
            scm_content( $args );
        break;

        case 'layout-banner':
        case 'layout-module':
        case 'layout-section':

            scm_containers( array( $args ), 'row' );

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

        // ++todo 1
        case 'layout-slider':

            Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-slider.php', array(
                'cont' => $args
            ));

        break;

        case 'layout-form':

            if( !shortcode_exists('contact-form-7') )
                continue;

            $prev = $post->ID;
            $single = $args['form'];
            if(!$single) continue;
            $post = ( is_numeric( $single ) ? get_post( $single ) : $single );
            setup_postdata( $post );

            indent( $SCM_indent + 1, do_shortcode('[contact-form-7 id="' . get_the_ID() . '" title="' . get_the_title() . '"]'), 2 );
            wp_reset_query();
        break;

// Static Objects

        case 'layout-login':

            Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-login.php', array(
                'cont' => $args,
            ));

        break;

        case 'layout-share':

            if( !shortcode_exists('ssba') )
                continue;

            indent( $SCM_indent + 1, do_shortcode('[ssba]'), 2 );

        break;

        case 'layout-separatore':

            $height = scm_utils_preset_size( $args[ 'height-number' ], $args[ 'height-units' ], 1 );
            $style = 'height:' . $height . ';';

            $line = ( $args['line'] ?: 'no' );

            if( $line != 'no' ){

                $svg_args = array();
                $svg_args['height'] = $height;
                $svg_args['y1'] = $svg_args['y2'] = scm_utils_preset_size( $args[ 'position-number' ], $args[ 'position-units' ], 50, '%' );
                $svg_args['color'] = scm_utils_preset_rgba( $args['color-rgba-color'], $args['color-rgba-alpha'], '#ddd' );
                $svg_args['stroke'] = scm_utils_preset_size( $args[ 'size-number' ], $args[ 'size-units' ], 5 );
                $svg_args['cap'] = ( $args['cap'] ?: 'round' );
                $svg_args['space'] = scm_utils_preset_size( $args[ 'space-number' ], $args[ 'space-units' ], 26 );
                $svg_args['dash'] = scm_utils_preset_size( $args[ 'dash-number' ], $args[ 'dash-units' ], 8 );

                indent( $SCM_indent, svgLine( $svg_args, $line, $SCM_indent ), 2 );

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
        case 'layout-image':
        case 'layout-thumbs':

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
        case 'layout-sottotitolo':
        case 'layout-titolo-empty':
        case 'layout-excerpt':

            Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-title.php', array(
                'cont' => $args
            ));

        break;
        
        // ++todo 2
        case 'layout-data':

            $date_format = implode( $args[ 'separator' ], str_split( $args[ 'format' ] ) );
            $args['title'] = ( isset( $args[ 'date' ] ) ? date_i18n( $date_format, strtotime( $args[ 'date' ] ) ) : ( get_the_date( $date_format ) ?: '' ) );

            $args['class'] = 'scm-date date' . is( $class );

            Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-title.php', array(
                'cont' => $args
            ));

        break;

        // ++todo 3
        case 'layout-testo':

            $text = ( isset( $args['editor'] ) ? $args['editor'] : ( isset( $args['editor-visual'] ) ? $args['editor-visual'] : scm_field( 'editor', '', get_the_ID() ) ) );
            if(!$text) continue;

            indent( $SCM_indent, $text, 1 );

        break;

        default:

            if( strpos( $element, 'layout-SCMTAX-' ) === 0 ){

                $tax = str_replace( 'layout-SCMTAX-', '', $element );
                $terms = ( isset( $args[ 'categorie' ] ) ? $args[ 'categorie' ] : ( wp_get_object_terms( get_the_ID(),  $tax ) ?: array() ) );

                $sep = $args['separator'];

                $args['title'] = '';

                if ( ! is_wp_error( $terms ) ) {

                    for ($i=0; $i < sizeof( $terms ) ; $i++){

                        $term = $terms[$i];
                        $href = ( $args['link'] == 'self' ? ' href="' . get_term_link( $term->slug, $tax ) . '"' : '' );

                        $args['title'] .= indent( $SCM_indent + 1 ) . '<' . ( $href ? 'a' : 'span' ) . ' class="term"' . $href . '>' . esc_html( $term->name ) . '</' . ( $href ? 'a' : 'span' ) . '>' . ( $i < sizeof( $terms ) - 1 ? ( $sep ? $sep . ' ' : '' ) : '' ) . lbreak();

                    }

                    $args['title'] = ( $args['title'] ?: '—' );

                    Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-title.php', array(
                        'cont' => $args
                    ));
                }

            }else{

                scm_post( $args );

            }

        break;
    }

    return $args;
}

// ------------------------------------------------------
// 1.4 POST CONTENT
// ------------------------------------------------------

/**
* [ECHO] Post
*
* Hooks:
```php
// Filter before $content is echoed [note: {post_type} with _ instead of -]
$before = apply_filters( 'scm_filter_archive_before_{post_type}}', $content, $posts );
```
*
* @todo 1 - Se non esiste il template dovresti aver pronte delle parts per i type di default, o meglio dei template fissi (single e archive)<br>
*       mentre per i custom type tirar fuori almeno titolo, content e featured image (torna a quelli WP) ed eventuale link oggetto se archive
*
* @param {array} content Content array.
*/
function scm_post( $content = array() ) {

    global $post, $SCM_types, $SCM_indent;

    $element = ( isset( $content[ 'acf_fc_layout' ] ) ? $content[ 'acf_fc_layout' ] : '' );

    $type = str_replace( '_', '-', str_replace( 'layout-', '', $element) );

    if ( is_null( getByKey( $SCM_types['public'], $type ) ) )
        return;

    $archive = ( isset( $content['type'] ) ? $content['type'] === 'archive' : 0 );
    $width = ( isset( $content['width'] ) ? $content['width'] : 'auto' );
    $query = array();
    $loop = array( $post->ID );

    $template_id = ( isset( $content['template'] ) && $content['template'] ? $content['template'] : 0 );

    // ++todo 1
    if( !$template_id )
        return;

    $template = get_fields( $template_id );
    $template_post = get_post( $template_id );
    $template_name = $template_post->post_name;
    $template['column-width'] = $width;
    $template['fallback'] = ( isset( $content['archive-fallback'] ) ? $content['archive-fallback'] : '<p>' . __( 'Nessun elemento', SCM_THEME ) . '</p>' );

    if ( empty( $template ) )
        return;

    $pagination = false;
    if( $archive ){

        $tax = array();

        foreach ($content as $key => $terms) {

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

        $complete = ( isset( $content['archive-complete'] ) ? $content['archive-complete'] === 'complete' : true );
        $perpage = ( $complete ? -1 : ( isset( $content['archive-perpage'] ) ? $content['archive-perpage'] : get_option( 'posts_per_page' ) ) );
        $offset = ( isset( $content['archive-offset'] ) ? $content['archive-offset'] : '0' );
        $pagination = ( $complete ? false : ( isset( $content['archive-pagination'] ) ? $content['archive-pagination'] === 'yes' : false ) );
        $more = ( $complete ? false : ( isset( $content['archive-pagination'] ) ? $content['archive-pagination'] === 'more' : false ) ); // non in uso
        $all = ( $complete ? false : ( isset( $content['archive-pagination'] ) ? $content['archive-pagination'] === 'all' : false ) ); // non in uso
        $button = ( isset( $content['archive-pag-text'] ) && $content['archive-pag-text'] ? $content['archive-pag-text'] : '' );
        $paginated = ( isset( $content['archive-paginated'] ) ? $content['archive-paginated'] : '' );
        $page = 'page-' . $type;
        $paged = ( $pagination ? ( isset( $_GET[ $page ] ) ? (int) $_GET[ $page ] : 1 ) : 1 );
        $orderby = ( isset( $content['archive-orderby'] ) ? $content['archive-orderby'] : 'date' );
        $ordertype = ( isset( $content['archive-ordertype'] ) ? $content['archive-ordertype'] : 'DESC' );
        $field = ( isset( $content['archive-field'] ) && $content['archive-field'] ? $content['archive-field'] : ( ( $orderby == 'meta_value' && isset( $content['archive-order'] ) ) ? $content['archive-order'] : '' ) );
        $meta = ( isset( $content['meta_query'] ) ? $content['meta_query'] : '' );
        $value = ( isset( $content['archive-value'] ) && $content['archive-value'] ? $content['archive-value'] : ( isset( $content['archive-field'] ) && $content['archive-field'] ? $post->ID : '') );

        $query = array(
            'post_type' => $type,
            'tax_query' => $tax,
            'posts_per_page' => $perpage,
            'order' => $ordertype,
            'orderby' => $orderby,
            'paged' => $paged,
            'meta_key' => $field,
            'meta_query' => $meta,
            'meta_value' => $value,
        );

    }else{

        if( !empty( $content['single'] ) ){

            $query = array(
                'post_type' => $type,
                'post__in' => ( $content['single'] ?: array() ),
                'posts_per_page' => -1,
            );
        }
    }

    $id = $post->ID;

    if( !empty( $query ) )
        $loop = new WP_Query( $query );

    $template['posts'] = $loop->posts;
    $template['class'] = $type . ' template-' . $template_id . ' ' . $template_name;


    // Filter before
    $before = apply_filters( 'scm_filter_archive_before_' . str_replace('-', '_', $type), '', $content, $template['posts'] );
    if( $before )
        indent( $SCM_indent, $before, 1 );

    // Content
    scm_containers( $template, 'post' );

    // Pagination and button
    if( sizeof( $template['posts'] ) > 0 ){
        if( $pagination ){

            if( $button )
                indent( $SCM_indent, '<h5>' . $button . '</h5>', 1 );

            indent( $SCM_indent, '<div class="scm-pagination pagination" data-load-content="#' . $paginated . '" data-load-page="' . $page . '" data-load-paged="' . $paged . '" data-load-offset="' . $offset . '">', 1 );

                $SCM_indent++;
                    scm_pagination( $loop, $page, '#' . $paginated );
                $SCM_indent--;

            indent( $SCM_indent, '</div> <!-- pagination -->', 1 );

        }else if( isset( $all ) && $all ){

            $button = ( $button ?: __( 'Archive', SCM_THEME ) );

            indent( $SCM_indent, '<div class="button button-archive" data-href="' . get_post_type_archive_link( $type ) . '">' . $button . '</div>', 1 );

        }else if( isset( $more ) && $more ){

            $button = ( $button ?: __( 'More', SCM_THEME ) );

            indent( $SCM_indent, '<div class="button button-more" data-href="' . get_post_type_archive_link( $type ) . '">' . $button . '</div>', 1 ); // DA FARE

        }
    }

    $post = get_post( $id );
    setup_postdata( $post );
}

?>