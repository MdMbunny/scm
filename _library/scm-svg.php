<?php

	if ( ! function_exists( 'scm_svg_line' ) ) {
		function scm_svg_line( $attr = [], $type = 'solid' ) {

			$default = [
				'width' => '100%',
				'height' => '',
				'x1' => '',
				'x2' => '100%',
				'y1' => '',
				'y2' => '',
				'color' => '#ddd',
				'stroke' => '1',
				'cap' => 'butt',
				'space' => '19',
				'dash' => '0.1',
			];

			$attr = array_merge( $default, $attr );

			$attr['height'] = ( $attr['height'] ?: $attr['stroke'] . 'px' );
			$attr['y1'] = ( $attr['y1'] ?: (int)$attr['stroke'] * .5 );
			$attr['y2'] = ( $attr['y2'] ?: (int)$attr['stroke'] * .5 );
			$attr['x1'] = ( $attr['x1'] ?: ( $attr['cap'] == 'butt' ? '0' : (int)$attr['stroke'] * .5 ) );
			$attr['dash'] = ( $type == 'dotted' ? '0.1' : $attr['dash'] );

			echo '<svg width="' . $attr['width'] . '" height="' . $attr['height'] . '">';
			if( type == 'solid' )
				echo '<line x1="' . $attr['x1'] . '" x2="' . $attr['x2'] . '" y1="' . $attr['y1'] . '" y2="' . $attr['y2'] . '" stroke="' . $attr['color'] . '" stroke-width="' . $attr['stroke'] . '" stroke-linecap="' . $attr['cap'] . '"></line>';
			else
				echo '<line x1="' . $attr['x1'] . '" x2="' . $attr['x2'] . '" y1="' . $attr['y1'] . '" y2="' . $attr['y2'] . '" stroke="' . $attr['color'] . '" stroke-width="' . $attr['stroke'] . '" stroke-linecap="' . $attr['cap'] . '" stroke-dasharray="' . $attr['dash'] . ', ' . $attr['space'] . '"></line>';
			echo '</svg>';

        }
    }

?>