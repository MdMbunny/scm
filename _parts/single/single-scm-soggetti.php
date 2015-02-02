<?php
/**
 * @package SCM
 */

global $post;

$type = get_post_type();

$rows = array(
	array(
		'acf_fc_layout'					=>	'logo',
		'negativo'						=>	'0',
		'larghezza' 					=>	100,
	),
	// +++ todo: case 'icon', case 'name', case 'piva'
);

if( isset($this) ){
	$rows = ( isset($this->soggetto_rows) ? $this->soggetto_rows : $rows);
}


$id = uniqid( $type . '-' );
$classes = SCM_PREFIX . 'object ' . implode( " ", get_post_class() ) . $post->post_name . ' clear';

echo '<div id="' . $id . '" class="' . $classes . '">';

	foreach ($rows as $row) {
		// +++ todo: integrare ICONA POS o NEG, NAME e PIVA
		$elem = ( $row['acf_fc_layout'] ?: $row['acf_fc_layout'] );
		$neg = ( isset( $row['negativo'] ) ? (int)$row['negativo'] : 0 );
		$wid = ( isset( $row['larghezza'] ) ? $row['larghezza'] : 100 );

		$class = SCM_PREFIX . $elem . ' ' . $elem . ' full' . ( $neg ? ' negative' : '' );

		echo '<div class="' . $class . '">';

			switch ($elem) {
				// +++ todo: case 'icon', case 'name', case 'piva'
				case 'logo':
					
					$logo = ( !$neg ? get_field('soggetti_logo') : get_field('soggetti_logo_negativo') );
					$width = ( $wid ? 'width=' . $wid . '%' : '' );

					echo '<img src="' . $logo . '"' . $width . '>';

				break;

			}

		echo '</div><!-- ' . SCM_PREFIX . $elem . ' -->';
	}

echo '</div><!-- ' . $type . ' -->';

?>