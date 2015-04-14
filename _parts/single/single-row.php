<?php

global $post, $SCM_indent;

$id = $post->ID;

$row_id = ( ( isset($this) && isset($this->row_id) && $this->row_id ) ?  ' id="' . $this->row_id . '"' : '' );

$row_layout = ( ( isset($this) && isset($this->row_layout) ) ?  ' ' . $this->row_layout : ' responsive' );
$row_attributes = ( ( isset($this) && isset($this->row_attributes) && $this->row_attributes ) ?  ' ' . $this->row_attributes : '' );

$row_class = 'row scm-row object scm-object ' . scm_options_get( 'align', 'option', 0 ) . $row_layout . ' ' . $post->post_name;
$row_class .= ( ( isset($this) && isset($this->row_class) ) ? $this->row_class : '' );

$row_style = scm_options_get_style( $id, 1 );


$indent = $SCM_indent;

indent( $indent + 1, '<div' . $row_id . ' class="' . $row_class . '"' . $row_style . $row_attributes . '>', 2 );

	$columns = scm_field( 'columns', array(), $id, 1 );

	if( sizeof( $columns ) ){

		$col_current = 0;
		$col_counter = 0;

		$col_odd = '';
		$col_class = '';
		
		$total = sizeof( $columns );

		foreach ($columns as $column) {

	    	$col_layout = ( isset( $column['column-width'] ) ? $column['column-width'] : '1/1' );
	    	$col_layout = ( $col_layout ? str_replace( '/', '', $col_layout ) : '11' );

	    	$col_size = (int)$col_layout[0] / (int)$col_layout[1];
	    	$col_counter += $col_size;
	    	$col_current++;
	    	$col_odd = ( $col_odd ? '' : ' odd' );

	    	$col_class = 'column scm-column column-layout object scm-object floatleft';

	    	$data = scm_column_data( $col_counter, $col_size );
	    	$col_counter = $data['count'];

	    	$col_attributes = ' data-column-width="' . $col_layout . '" data-column="' . $data['data'] . '"';

            $col_class .= $col_odd;
			$col_class .= scm_count_class( $col_current, $total );
			$col_class .= ( $column['class'] ? ' ' . $column['class'] : '' );

			$col_id = ( $column['id'] ? ' id="' . $column['id'] . '"' : '' ) ;
			
			$modules = $column['modules'];

			// +++ todo: column in nuovo file single-column.php

			indent( $indent + 2 , '<div' . $col_id . ' class="' . $col_class . '"' . $col_attributes . '>', 2 );
						
				if( isset( $modules ) && !empty( $modules ) ){

					$mod_current_column = 0;
					$mod_counter = 0;

					$mod_odd = '';
					$mod_class = '';
					
					$mod_total = sizeof( $modules );

					foreach ($modules as $module) {

						$mod_layout = ( isset( $module['column-width'] ) ? $module['column-width'] : '1/1' );
				    	$mod_layout = ( $mod_layout ? str_replace( '/', '', $mod_layout ) : '11' );

				    	$mod_size = (int)$mod_layout[0] / (int)$mod_layout[1];
				    	$mod_counter += $mod_size;
				    	$mod_current_column++;
				    	$mod_odd = ( $mod_odd ? '' : ' odd' );

				    	$mod_class = 'module scm-module' . ( $module['acf_fc_layout'] ? ' module-' . str_replace( 'layout-', '', $module['acf_fc_layout'] ) : '' ) . ' column-layout object scm-object floatleft';

				    	$mod_data = scm_column_data( $mod_counter, $mod_size );
				    	$mod_counter = $mod_data['count'];

				    	$mod_align = ( isset( $module['alignment'] ) && $module['alignment'] && $module['alignment'] != 'default' ? $module['alignment'] : '' );


				    	$mod_attributes = ( isset( $module['attributes'] ) ? $module['attributes'] : '' );
				    	$mod_attributes .= ' data-column-width="' . $mod_layout . '" data-column="' . $mod_data['data'] . '"';

						$mod_class .= ( $mod_align ? ' ' . $mod_align : '' );
			            $mod_class .= $mod_odd;
						$mod_class .= scm_count_class( $mod_current_column, $mod_total );
						$mod_class .= ( $module['class'] ? ' ' . $module['class'] : '' );

						$mod_id = ( $module['id'] ? ' id="' . $module['id'] . '"' : '' );

						// +++ todo: module in nuovo file single-module.php
				
						indent( $indent + 3 , '<div' . $mod_id . ' class="' . $mod_class . '"' . $mod_attributes . '>', 2 );
							
							$SCM_indent += 4;
							scm_flexible_content( [ $module ] );
							$SCM_indent -= 4;
						
						indent( $indent + 3, '</div><!-- module -->', 2 );

					}

				}
					
			indent( $indent + 2, '</div><!-- column -->', 2 );

	    }

	}else{
	    // no layouts found
	}

indent( $indent + 1, '</div><!-- row -->', 1 );


?>