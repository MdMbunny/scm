<?php

// +++ todo: attualmente non in uso. Una volta creato il type Contatti, che includere un CF7 + aggiunte ( e magari filtri per creare dinamicamente un CF7 )

	global $SCM_indent;

	$indent = 0;
	$contact = 'num';
	$ico = 0;
	$txt = 0;
	$sep = ' - ';

	if( isset($this) ) {
		$indent = $SCM_indent + 1;
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
			$nome = ( $txt ? $value['select_contact_' . $contact] . ' ' : '' );
			$testo = $value['contatti_' . $contact];
			if($contact == 'email') $testo = '<a href="mailto:' . $testo . '">' . $testo . '</a>';
			$separator = ( $i < sizeof( $list ) - 1 ? $sep : '' );
			$icon = ( $ico ? '<i class="fa ' . $icona . '"></i> ' : '' );
			
			indent( $indent, '<span>' . $icon . $nome . $testo . '</span>', 1 );
			if($separator)
				indent( $indent, '<span class="separator">' . $separator . '</span>', 1 );
		}
	}

?>