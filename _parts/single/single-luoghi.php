<?php
/**
 * @package SCM
 */

global $post, $SCM_indent;

$type = get_post_type();
$id = $post->ID;

$province_prefix = '(';
$province_suffix = ')';

$rows = array(
	array(
		'tipo'							=>	'name',
	),
	array(
		'tipo'							=>	'address',
		'mostra_icona'					=>	'1',
		'separatore'					=>	'-',
	),
	array(
		'tipo'							=>	'num',
		'mostra_icona'					=>	'1',
		'mostra_nome'					=>	'1',
		'separatore'					=>	'-',
	),
	array(
		'tipo'							=>	'email',
		'mostra_icona'					=>	'1',
		'mostra_nome'					=>	'1',
		'separatore'					=>	'-',
	),
	array(
		'tipo'							=>	'link',
		'mostra_icona'					=>	'1',
		'mostra_nome'					=>	'1',
		'separatore'					=>	'-',
	),
);

$width = 100;
$legend = 0;

if( isset($this) ){
	$rows = ( isset($this->luogo_rows) ? $this->luogo_rows : $rows );
	$width = ( isset($this->luogo_width) ? $this->luogo_width : 100 );
	$legend = ( isset($this->luogo_legend) ? $this->luogo_legend : 0 );
}


$classes = 'luogo scm-luogo object scm-object ' . $post->post_name . ' clear';

$indent = $SCM_indent + 1;
$SCM_indent += 4;

indent( $indent, '<div class="' . $classes . '">' );

	$marker = ( get_field('luoghi_marker') ?: 0 );

	if ($legend && $marker)
		indent( $indent+1, '<div class="legend"><img src="' . $marker . '" alt="" /></div>' );

	indent( $indent+1, '<div class="datas">' );

	foreach ($rows as $row) {
		$elem = ( $row['tipo'] ?: $row['tipo'] );
		$ico = ( isset( $row['mostra_icona'] ) ? (int)$row['mostra_icona'] : 0 );
		$txt = ( isset( $row['mostra_nome'] ) ? (int)$row['mostra_nome'] : 0 );
		$sep = ( isset( $row['separatore'] ) ? ' ' . $row['separatore'] . ' ' : ' - ' );
		

		$class = 'scm-' . $elem . ' ' . $elem . ' full';

		indent( $indent+2, '<div class="' . $class . '">' );

			switch ($elem) {
				case 'name':
					indent( $indent+3, '<strong>' . get_field( 'luoghi_nome' ) . '</strong>' );
				break;
								
				case 'address':

					$icona = get_field('luoghi_icon');
						
					$country = get_field('luoghi_paese');
					$region = get_field('luoghi_regione');
					$province = scm_field( 'luoghi_provincia', '', $id, 1, $province_prefix, $province_suffix );
					$code = get_field('luoghi_cap');
					$city = get_field('luoghi_citta');
					$town = get_field('luoghi_frazione');
					$address = get_field('luoghi_indirizzo');

					$icon = ( $ico ? '<i class="fa ' . $icona . '"></i> ' : '' );

					$town = ( ( $town && ( $city || $code || $province ) ) ? $town . ' ' : $town );
					$code = ( ( $code && ( $city || $province ) ) ? $code . ' ' : $code );
					$city = ( ( $city && $province ) ? $city . ' ' : $city );
					$region = ( ( $region && $country ) ? $region . ', ' : $region );
					$country = ( $country ? $country : '' );

					$inline_address = '<span class="street">' . $address . '</span>';
					if( $town || $city || $code || $province ){
						$inline_address .= '<span class="separator">' . $sep . '</span>';
						$inline_address .= '<span class="town">' . $town . $code . $city . $province . '</span>';
					}

					if( $region || $country ){
						$inline_address .= '<span class="separator">' . $sep . '</span>';
						$inline_address .= '<span class="country">' . $region . $country . '</span>';
					}			
					
					indent( $indent+3, $icon . $inline_address );
					
				break;

				default:

					Get_Template_Part::get_part( SCM_DIR_PARTS_SINGLE . '-contatti.php', array(
                        'contact' => $elem,
                        'ico' => $ico,
                        'txt' => $txt,
                        'sep' => $sep,
                    ));
			}

		indent( $indent+2, '</div><!-- ' . $elem . ' -->' );
	}

	indent( $indent+1, '</div>' );

indent( $indent, '</div><!-- ' . $type . ' -->' );

$SCM_indent -= 4;

?>