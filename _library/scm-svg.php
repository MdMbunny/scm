<?php

	if ( ! function_exists( 'scm_svg_line' ) ) {
		function scm_svg_line( $attr = array(), $type = 'solid' ) {

			global $SCM_indent;

			$default = array(
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
			);

			$attr = array_merge( $default, $attr );
			$type = str_replace( 'line', 'solid', $type );

			$attr['height'] = ( $attr['height'] ?: $attr['stroke'] );
			$attr['y1'] = ( $attr['y1'] ?: (int)$attr['stroke'] * .5 );
			$attr['y2'] = ( $attr['y2'] ?: (int)$attr['stroke'] * .5 );
			$attr['x1'] = ( $attr['x1'] ?: ( $attr['cap'] == 'butt' ? '0' : (int)$attr['stroke'] * .5 ) );
			$attr['dash'] = ( $type == 'dotted' ? $attr['stroke'] : $attr['dash'] );

			indent( $SCM_indent + 1, '<svg width="' . $attr['width'] . '" height="' . $attr['height'] . '">', 1 );
			if( $type == 'solid' )
				indent( $SCM_indent + 2, '<line x1="' . $attr['x1'] . '" x2="' . $attr['x2'] . '" y1="' . $attr['y1'] . '" y2="' . $attr['y2'] . '" stroke="' . $attr['color'] . '" stroke-width="' . $attr['stroke'] . '" stroke-linecap="' . $attr['cap'] . '"></line>', 1 );
			else
				indent( $SCM_indent + 2, '<line x1="' . $attr['x1'] . '" x2="' . $attr['x2'] . '" y1="' . $attr['y1'] . '" y2="' . $attr['y2'] . '" stroke="' . $attr['color'] . '" stroke-width="' . $attr['stroke'] . '" stroke-linecap="' . $attr['cap'] . '" stroke-dasharray="' . $attr['dash'] . ', ' . $attr['space'] . '"></line>', 1 );
			indent( $SCM_indent + 1, '</svg>', 2 );

        }
    }

?>