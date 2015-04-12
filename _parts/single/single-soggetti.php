<?php
/**
 * @package SCM
 */

global $SCM_indent;

$title = get_the_title();
$id = get_the_ID();
$type = get_post_type();
$date = get_the_date();
$taxes = get_the_taxonomies();

//$wrap = ( isset( $this->wrap ) ? $this->wrap : '<div>%a</div>' );
$href = ( isset( $this->href ) ? $this->href : '' );
$target = ( isset( $this->target ) ? $this->target : '' );
$build = ( isset( $this->build ) ? $this->build : [] );

foreach ( $build as $value ) {

// switch 'acf_fc_layout'


}


printPre('SOGGETTO ' . $post->ID);

/*
$type = get_post_type();
$title = get_the_title();

$link = 'default';
$neg = 'off';

$rows = array(
	array(
		'acf_fc_layout'										=>	'logo',
		'logo_larghezza' 									=>	'',
	),
	// +++ todo: Template
);

if( isset($this) ){
	$rows = ( isset($this->soggetto_rows) ? $this->soggetto_rows : $rows);
	$link = ( isset($this->soggetto_link) ? $this->soggetto_link : $link);
	$neg = ( isset($this->soggetto_neg) ? $this->soggetto_neg : $neg);
}

$classes = 'soggetto scm-soggetto object scm-object ' . $post->post_name . ' full';

$link = ( $link == 'default' ? get_field( 'soggetti_link' ) : $link );
$data = ( ( $link && $link !== 'no' ) ? ' data-href="' . $link . '" data-target="_blank"' : '' );
$neg = ( $neg === 'on' );

$indent = $SCM_indent + 1;

indent( $indent, '<div class="' . $classes . '"' . $data . '>', 2 );

	if( $rows && sizeof( $rows ) ){

		foreach ($rows as $row) {

			$elem = ( $row['acf_fc_layout'] ?: 'logo' );

			$class =  $elem . ' scm-' . $elem . ( $neg ? ' negative' : '' ) . ' soggetto-row';
			
			indent( $indent+1, '<div class="' . $class . '">' );

				switch ($elem) {
					case 'logo':

						$width = ( $row['dimensione_logo'] ?: 100 );
						$units = ( $row['select_units_logo'] ?: '%' );

						$logo_pos = get_field('soggetti_logo');
						$logo_neg = get_field('soggetti_logo_negativo');

						$logo = ( $neg ? ( $logo_neg ?: $logo_pos ) : ( $logo_pos ?: $logo_neg ) );

						$fall = '';
						if( $neg && !$logo_neg )
							$fall = 'padding:1em;background-color:#FFF;'; // +++ todo: fallback bg color (and stuff)

						if( $logo )
							indent( $indent+2, '<img src="' . $logo . '" alt="" title="' . $title . '" style="max-width:' . $width . $units . ';' . $fall . '" />' );

					break;

					case 'icona':

						$size = ( $row['dimensione_icona'] ?: 150 );
						$units = ( $row['select_units_icona'] ?: 'px' );
						
						$logo = ( !$neg ? get_field('soggetti_icona') : get_field('soggetti_icona_negativo') );

						if( $logo )
							indent( $indent+2, '<img src="' . $logo . '" alt="" title="' . $title . '" style="max-width:' . $size . $units . '; max-height:' . $size . $units . ';" />' );

					break;

					case 'intestazione':
					case 'piva':
					case 'cf':

						$tag = ( isset( $row[ 'select_headings_complete_' . $elem ] ) ? $row[ 'select_headings_complete_' . $elem  ] : 'span' );

						$txt = get_field( 'soggetti_' . $elem );

						if( $txt )
							indent( $indent+2, '<' . $tag . '>' . $txt . '</' . $tag . '>' );

					break;

				}

			indent( $indent+1, '</div><!-- ' . $elem . ' -->', 2);
		}
	}

indent( $indent, '</div><!-- soggetto -->', 2 );
*/
?>