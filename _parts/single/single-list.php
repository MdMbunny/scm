<?php
/**
 * @package SCM
 */

global $post, $SCM_indent, $SCM_fa;
$post_id = $post->ID;

$args = array(
	'acf_fc_layout' => 'layout-list',
	'list' => array(),
	'intro' => '',
	'display' => 'block',
	'alignment' => 'left',
	'size' => '',
	'rgba-color' => '',
	'rgba-alpha' => '',
	'shape' => 'no',
	'shape-size' => 'normal',
	'shape-angle' => 'all',
	'box-color' => '',
	'box-alpha' => '',
	'icon-even' => 'no',
	'icon-odd' => 'no',
	'position' => 'inside',
	'type' => '',
    'element' => 0,
	'color-filter' => '',
    'id' => '',
    'class' => '',
    'attributes' => '',
    'style' => '',
);

if( isset( $this ) )
	$args = ( isset( $this->cont ) ? array_merge( $args, toArray( $this->cont ) ) : array() );

//***************


$class = 'scm-list list scm-object object ' . $args['class'];

$attributes = $args['attributes'];
$style = $args['style'];
$id = $args['id'];


//***************

$element = $args[ 'element' ];
$layout = $args['acf_fc_layout'];
$slug = str_replace( '_', '-', str_replace( 'layout-', '', $layout ) );
$pos = is( $args['position'], 'inside' );

switch ( $layout ) {
    case 'layout-social_follow':
        if( !$element ){
            if( $post->post_type === 'soggetti' )
                $element = $post_id;
            else
                return;
        }
        $layout = 'layout-link';
        $args['list'] = get_field( 'soggetto-buttons', ( is_numeric( $element ) ? $element  : $element->ID ) );
        $args['color-filter'] = 'social';
        //$args['display'] = 'inlineblock';
    break;

    case 'layout-contatti':
        if( !$element ){
            if( $post->post_type === 'luoghi' )
                $element = $post_id;
            else
                return;
        }
        $layout = 'layout-link';
        $args['list'] = get_field( 'luogo-contatti', ( is_numeric( $element ) ? $element  : $element->ID ) );
        //$args['color-filter'] = 'social';
        //$args['display'] = 'inlineblock';
    break;
    
    case 'layout-elenco_puntato':
        $type = is( $args['type'] );
        if( $type ){
            $style .= ' list-style:' . $type . ';' ;
            $style .= ' list-style-position:' . $pos . ';';
            $class .= ( $type == 'none' ? ' nobullet' : '' );
            $args['display'] = 'block';
        }
    break;
}

$list = $args['list'];
$intro = $args['intro'];
$intro = str_replace( '<p>', '<p class="intro">', $intro);
$display = $args['display'];
$direction = ( $args['display'] === 'block' ? 'vertical' : 'horizontal' );
$align = ifnotequal( $args['alignment'], 'default', scm_field( 'style-txt-set-alignment', 'left', 'option' ) );
$size = ifnotequal( $args['size'], 'default', 'normal' );
$color = scm_content_preset_rgba( $args['rgba-color'], $args['rgba-alpha'] );
$shape = ( $args['shape'] ? ifnotequal( $args['shape'], 'no', 'no-shape' ) : 'no-shape' );
$shape_size = ( $shape ? ifnotequal( $shape, 'square', '', '', '-' . $args['shape-size'] ) : '' );
$shape_angle = ifnotequal( $args['shape-angle'], array( 'all', 'square' ) );
$bg = scm_content_preset_rgba( $args['box-color'], $args['box-alpha'] );

$icon_even = $args['icon-even'];
$icon_odd = ifnotequal( $args['icon-odd'], 'no', $icon_even );
$icon = 'no';

$class .= ' ' . $pos . ' ' . $align . ' ' . $size . ' ' . $slug . ' ' . $direction;

if( $intro )
    indent( $SCM_indent, (string)$intro, 1 ); // +++ todo: se non è un <p> aggiungilo, e comunque aggiungi class id style e attr

indent( $SCM_indent, openTag( 'ul', $id, $class, $style, $attributes ), 1 );

if( is( $list ) ){

    $odd = '';
    foreach ($list as $button) {
        
        $odd = ( $odd ? '' : 'odd' );
        $name = (string)$button['name'];
        $pos = ( !$name ? 'inside' : $pos );
        
        if( isset( $button['icon'] ) )
            $icon = ( $button['icon'] !== 'no' ? $button['icon'] : ( $odd ? $icon_odd : $icon_even ) );

        $li_attributes = '';

        $txt_col = $color;
        $bg_col = $bg;

        if( is( $args['color-filter'] ) ){
            if( !$color || !$bg ){
                foreach ($SCM_fa[ $args['color-filter'] ] as $value) {
                    $index = getByValue( $value['choices'], $button['icon'] );
                    if( $index !== false ){
                    	if( !$color )
                        	$txt_col = ( $value['color'] ?: '' );
                        else
                        	$bg_col = ( $value['color'] ?: '' );
                        continue;
                    }
                }
            }
        }

        $button_layout = ( isset( $button['acf_fc_layout'] ) ? is( $button['acf_fc_layout'], $layout ) : $layout );

        $li_style = is( $txt_col, '', ' color:', ';' ) . is( $bg_col, '', ' background-color:', ';' );

        $li_class = 'scm-button button ' . $display . ' ' . $direction . ' ' . $button_layout . ' ' . str_replace( 'layout-', '', $button_layout );
        $li_class .= ( $name ? '' : ' icon' ) . ' ' . ( $shape == 'no-shape' ? ' ' . $shape : ' shape' . $shape ) . ' ' . $shape_size . ' ' . $shape_angle;
        $li_class .= ' ' . $align . ' ' . $odd;

        if( isset( $button['link'] ) && is( $button['link'] ) ){
            switch ( $button_layout ) {
                case 'layout-media':
                    $li_attributes .= scm_post_link( array(), $button['link'] );
                break;

                case 'layout-paypal':
                break;

                case 'layout-phone':
                    $li_attributes .= ' data-href="tel:' . ( startsWith( (string)$button['link'], '+' ) ? (string)$button['link'] : '+' . (string)$button['link'] ) . '"';
                break;

                case 'layout-fax':
                    $li_attributes .= ' data-href="fax:' . ( startsWith( (string)$button['link'], '+' ) ? (string)$button['link'] : '+' . (string)$button['link'] ) . '"';
                break;

                case 'layout-email':
                    $li_attributes .= ' data-href="mailto:' . (string)$button['link'] . '"';
                break;

                case 'layout-skype':
                    $li_attributes .= ' data-href="skype:' . (string)$button['link'] . '?chat"';
                break;

                case 'layout-skype-call':
                    $li_attributes .= ' data-href="skype:' . (string)$button['link'] . '?call"';
                break;

                case 'layout-skype-phone':
                    $li_attributes .= ' data-href="callto://+' . (string)$button['link'] . '"';
                break;
                
                default:
                    $li_attributes .= ' data-href="' . getURL( (string)$button['link'] ) . '"';//' data-target="_blank"';
                break;
            }
        }

        if( $button_layout === 'layout-paypal' ){

            indent( $SCM_indent, '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank"><input name="cmd" type="hidden" value="_s-xclick" />', 1 );
                indent( $SCM_indent, '<input name="hosted_button_id" type="hidden" value="' . $button['link'] . '" />', 1 );
                indent( $SCM_indent, '<input class="' . ( $pos == 'inside' || $slug == 'elenco-puntato' ? $li_class : '' ) . '" style="' . ( $pos == 'inside' || $slug == 'elenco-puntato' ? $li_style : '' ) . '" alt="PayPal - Il metodo rapido, affidabile e innovativo per pagare e farsi pagare." name="submit" type="submit" value="' . $name . '" />', 1 );
                indent( $SCM_indent, '<img src="https://www.paypalobjects.com/it_IT/i/scr/pixel.gif" alt="" width="1" height="1" border="0" />', 1 );
            indent( $SCM_indent, '</form>', 2 );        
        
        }else{

            indent( $SCM_indent, openTag( 'li', '', ( $pos == 'inside' || $slug == 'elenco-puntato' ? $li_class : '' ), ( $pos == 'inside' || $slug == 'elenco-puntato' ? $li_style : '' ), $li_attributes ), 1 );
            if( $icon && $icon !== 'no' )
                indent( $SCM_indent + 1, '<i class="bullet fa ' . $icon . ' ' . $align . ( $pos == 'inside' || $slug == 'elenco-puntato' ? ( $name ? ' float-' . $align : '' ) : '' ) . '"></i> ', 1 );
            if( $name && $slug != 'elenco-puntato' )
                indent( $SCM_indent + 1, openTag( 'span', '', ( $pos == 'outside' && $slug != 'elenco-puntato' ? $li_class : '' ) . ' ' . $align, ( $pos == 'outside' && !$slug == 'elenco-puntato' ? $li_style : '' ), '' ) . $name . '</span>', 1 );
            else if( $name )
                indent( $SCM_indent + 1, $name, 1 );

            indent( $SCM_indent, '</li>', 2 );
        }

    }

}

indent( $SCM_indent, '</ul><!-- list -->', 2 );

?>