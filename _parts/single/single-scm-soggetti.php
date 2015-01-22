<?php
/**
 * @package SCM
 */

global $post;

$type = get_post_type();


$province_prefix = '(';
$province_suffix = ')';

$single = 0;
$max = -1;
$pag = 'no';

$rows = array(
	array(
		'acf_fc_layout'					=>	'logo',
		'negativo'						=>	'0',
		'larghezza' 					=>	100,
	),
	array(
		'acf_fc_layout'					=>	'data',
		'tipo'							=>	'address',
		'mostra_icona'					=>	'1',
		'mostra_nome'					=>	'1',
		'separatore'					=>	'-',
		'larghezza' 					=>	100,
	),
	array(
		'acf_fc_layout'					=>	'data',
		'tipo'							=>	'num',
		'mostra_icona'					=>	'1',
		'mostra_nome'					=>	'1',
		'separatore'					=>	'-',
		'larghezza' 					=>	100,
	),
	array(
		'acf_fc_layout'					=>	'data',
		'tipo'							=>	'email',
		'mostra_icona'					=>	'1',
		'mostra_nome'					=>	'1',
		'separatore'					=>	'-',
		'larghezza' 					=>	100,
	),
	array(
		'acf_fc_layout'					=>	'data',
		'tipo'							=>	'link',
		'mostra_icona'					=>	'1',
		'mostra_nome'					=>	'1',
		'separatore'					=>	'-',
		'larghezza' 					=>	100,
	),
	array(
		'acf_fc_layout'					=>	'map',
		'larghezza' 					=>	100,
	),
);

if( isset($this) ){
	$rows = ( isset($this->soggetto_rows) ? $this->soggetto_rows : $rows);
}


$id = uniqid( $type . '-' );
$classes = SCM_PREFIX . 'object ' . implode( " ", get_post_class() ) . $post->post_name . ' clear';

//echo '<div id="' . $id . '" class="' . $classes . '">';

	foreach ($rows as $row) {
		$elem = ( $row['acf_fc_layout'] != 'data' ? $row['acf_fc_layout'] : $row['tipo'] );
		$ico = ( isset( $row['mostra_icona'] ) ? (int)$row['mostra_icona'] : 0 );
		$txt = ( isset( $row['mostra_nome'] ) ? (int)$row['mostra_nome'] : 0 );
		$sep = ( isset( $row['separatore'] ) ? ' ' . $row['separatore'] . ' ' : ' - ' );
		// +++ todo: integrare ICONA POS o NEG
		$neg = ( isset( $row['negativo'] ) ? (int)$row['negativo'] : 0 );
		$wid = ( isset( $row['larghezza'] ) ? $row['larghezza'] : 100 );

		$class = SCM_PREFIX . $elem . ' ' . $elem . ' full' . ( $neg ? ' negative' : '' );

		echo '<div class="' . $class . '">';

			switch ($elem) {
				case 'logo':
					
					$logo = ( !$neg ? get_field('soggetti_logo') : get_field('soggetti_logo_negativo') );
					$width = ( $wid ? 'width=' . $wid . '%' : '' );

					echo '<img src="' . $logo . '"' . $width . '>';

				break;
				
				case 'num':
				case 'email':
				case 'link':
					
					$list = get_field('soggetti_' . $elem);
					
					if( $list && sizeof($list) > 0 ){
												
						for( $i = 0; $i < sizeof( $list ); $i++ ) {
							$value = $list[$i];
							
							$icona = $value['soggetto_icona_' . $elem];
							$nome = ( $txt ? $value['soggetto_nome_' . $elem] . ' ' : '' );
							$testo = $value['soggetto_' . $elem];
							if($elem == 'email') $testo = '<a href="mailto:' . $testo . '">' . $testo . '</a>';
							$separator = ( $i < sizeof( $list ) - 1 ? $sep : '' );
							$icon = ( $ico ? '<i class="fa ' . $icona . '"></i> ' : '' );
							
							echo '<span>' . $icon . $nome . $testo . $separator . '</span>';
						}
					}

				break;
				
				case 'address':
				case 'map':

					$luogo = get_field('soggetti_luogo');
					$icona = get_field('soggetti_icona_luogo');

					if($luogo){
						
						$id = $luogo->ID;
						$country = get_field('luoghi_paese', $id);
						$region = get_field('luoghi_regione', $id);
						$province = ( get_field('luoghi_provincia', $id) ? $province_prefix . get_field('luoghi_provincia', $id) . $province_suffix : '' );
						$code = get_field('luoghi_cap', $id);
						$city = get_field('luoghi_citta', $id);
						$town = get_field('luoghi_frazione', $id);
						$address = get_field('luoghi_indirizzo', $id);
						$lat = get_field('luoghi_lat', $id);
						$lng = get_field('luoghi_lng', $id);

						if( $elem == 'map' ){

							if( $lat && $lng ){
								echo '<div class="' . SCM_PREFIX . 'marker marker" data-lat="' . $lat . '" data-lng="' . $lng . '"></div>';
							}

						}else{

							$icon = ( $ico ? '<i class="fa ' . $icona . '"></i> ' : '' );

							$town = ( ( $town && ( $city || $code || $province ) ) ? $town . ' ' : $town );
							$code = ( ( $code && ( $city || $province ) ) ? $code . ' ' : $code );
							$city = ( ( $city && $province ) ? $city . ' ' : $city );
							$region = ( ( $region && $country ) ? $region . ', ' : $region );
							$country = ( $country ? $country : '' );

							$inline_address = '<span class="street">' . $address . '</span>';
							if( $town || $city || $code || $province ){
								$inline_address .= $sep;
								$inline_address .= '<span class="town">' . $town . $code . $city . $province . '</span>';
							}

							if( $region || $country ){
								$inline_address .= $sep;
								$inline_address .= '<span class="country">' . $region . $country . '</span>';
							}			
							
							echo $icon . $inline_address;
						}
					}
					
				break;
			}

		echo '</div><!-- ' . SCM_PREFIX . $elem . ' -->';
	}

//echo '</div><!-- ' . $type . ' -->';

?>