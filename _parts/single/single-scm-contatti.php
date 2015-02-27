<?php

	$indent = 0;
	$contact = 'num';
	$ico = 0;
	$txt = 0;
	$sep = ' - ';

	if( isset($this) ) {
		$indent = ( ( isset($this->indent) && $this->indent ) ?  $this->indent : $indent );
		$contact = ( ( isset($this->contact) && $this->contact ) ? $this->contact : $contact );
		$ico = ( ( isset($this->ico) && $this->ico ) ? $this->ico : $ico );
		$txt = ( ( isset($this->txt) && $this->txt ) ? $this->txt : $txt );
		$sep = ( ( isset($this->sep) && $this->sep ) ? $this->sep : $sep );
	}
	
	$list = get_field('contatti_' . $contact . '_rep');
			
	if( $list && sizeof($list) > 0 ){
								
		for( $i = 0; $i < sizeof( $list ); $i++ ) {
			$value = $list[$i];
			
			$icona = $value['contatti_icona_' . $contact];
			$nome = ( $txt ? $value['contatti_nome_' . $contact] . ' ' : '' );
			$testo = $value['contatti_' . $contact];
			if($contact == 'email') $testo = '<a href="mailto:' . $testo . '">' . $testo . '</a>';
			$separator = ( $i < sizeof( $list ) - 1 ? $sep : '' );
			$icon = ( $ico ? '<i class="fa ' . $icona . '"></i> ' : '' );
			
			echo '<span>' . $icon . $nome . $testo . '</span>';
			if($separator)
				echo '<span class="separator">' . $separator . '</span>';
		}
	}

?>