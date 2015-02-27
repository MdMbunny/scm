<?php
/**
 * @package SCM
 */

global $post;

$type = get_post_type();
$title = get_the_title();

$link = 'no';

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
	$link = ( isset($this->soggetto_link) ? $this->soggetto_link : $link);
}

$classes = 'soggetto scm-soggetti scm-object ' . $post->post_name . ' full';

echo '<div class="' . $classes . '">';

	if( $rows && sizeof( $rows ) > 0 ){

		foreach ($rows as $row) {
			// +++ todo: integrare ICONA POS o NEG, NAME e PIVA
			$elem = ( $row['acf_fc_layout'] ?: $row['acf_fc_layout'] );
			$neg = ( isset( $row['negativo'] ) ? (int)$row['negativo'] : 0 );
			$mea = ( isset( $row['larghezza'] ) ? $row['larghezza'] : '' );
			if( $mea ){
				if( strpos( $mea, 'px' ) === false && strpos( $mea, 'em' ) === false )
					$mea = (string)(int)$mea . '%';
			}else{
				$mea = '100%';
			}

			$tag = ( isset( $row['select_complete_headings'] ) ? $row['select_complete_headings'] : 'span' );

			$link = ( $link == 'default' ? get_field( 'soggetti_link' ) : $link );
			$data = ( ( $link && $link != 'no' ) ? ' data-href="' . $link . '" data-target="_blank"' : '' );

			$class =  $elem . ' scm-' . $elem . ( $neg ? ' negative' : '' ) . ' soggetto-row';
			
			echo '<div class="' . $class . '"' . $data . '>';

				switch ($elem) {
					case 'logo':

						$logo_pos = get_field('soggetti_logo');
						$logo_neg = get_field('soggetti_logo_negativo');

						$logo = ( $neg ? ( $logo_neg ?: $logo_pos ) : $logo_pos );

						$fall = '';
						if( $neg && !$logo_neg )
							$fall = 'padding:1em;background-color:#FFF;'; // +++ todo: fallback bg color (and stuff)

						if( $logo )
							echo '<img src="' . $logo . '" alt="" title="' . $title . '" style="max-width:' . $mea . ';' . $fall . '">';

					break;

					case 'icona':
						
						$logo = ( !$neg ? get_field('soggetti_icona') : get_field('soggetti_icona_negativo') );

						if( $logo )
							echo '<img src="' . $logo . '" alt="" title="' . $title . '" style="max-width:' . $mea . '; max-height:' . $mea . ';">';

					break;

					case 'intestazione':
					case 'piva':
					case 'cf':

						$txt = get_field( 'soggetti_' . $elem );

						if( $txt )
							echo '<' . $tag . '>' . $txt . '</' . $tag . '>';

					break;

				}

			echo '</div><!-- ' . $elem . ' -->';
		}

	}

echo '</div><!-- soggetto -->';

?>