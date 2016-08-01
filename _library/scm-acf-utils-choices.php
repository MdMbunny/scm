<?php

/**
* ACF select choiches utilities.
*
* @link http://www.studiocreativo-m.it
*
* @package SCM
* @subpackage 2-ACF/UTILS
* @since 1.0.0
*/

// ------------------------------------------------------
//
// 1.0 Filter
// 2.0 Choices
//
// ------------------------------------------------------

// ------------------------------------------------------
// 1.0 FILTER
// ------------------------------------------------------

/**
* [GET] Set default value and optionally add elements to choices
*
* Example usage:
```php
$choices = [ 'first', 'second' ];

// Set default value
$choices = scm_acf_field_choices( 'second', $choices );
print( $choices ); // [ 'choices'=>[ 'first', 'second' ], 'default'=>'second' ]

// Add choices and set first new element as default value
$choices = scm_acf_field_choices( [ 'third', 'fourth' ], $choices );
print( $choices ); // [ 'choices'=>[ 'first', 'second', 'third', 'fourth' ], 'default'=>'third' ]
```
*
* @param {misc|array} default Default value or additional choices.
* @param {array=} choices Original choices (default is empty array).
* @return {array} Array containing 'choices' and 'default' attributes.
*/
function scm_acf_field_choices( $default, $choices = array() ){
	
	$key = '';

	if( isset( $default ) ){

		if( is_array( $default ) && !empty( $default ) ){

			$choices = array_merge( $choices, $default );

		}else{
			$key = $default;
		}
	}

	if( $key === '' && sizeof( $choices ) ){
    	reset( $choices );
    	$key = key( $choices );
    }

	
	return array( 'choices' => $choices, 'default_value' => $key );
}

// ------------------------------------------------------
// 2.0 CHOICES
// ------------------------------------------------------

/**
* [GET] Choices preset by name or specific choiches preset value
*
* Example usage:
```php
// Get choices from 'position_menu' preset
scm_acf_field_choices_preset( 'position_menu' );

// Get 'top' value from 'position_menu' preset
scm_acf_field_choices_preset( 'position_menu', 'top' );
```
*
* Complete structure:
```php
// types_:
// 	_complete:
` 		$SCM_types['complete'];
// 	_private:
` 		$SCM_types['private'];
// 	_public:
` 		$SCM_types['public'];
// ...
` 		$SCM_types['all'];
` 
// wp_menu:
` 	$menus = get_registered_nav_menus();
` 	$lang = '';
` 	$def = '';
` 	foreach ( $menus as $location => $description )
` 		$choices[$location] = $description;
` 	$choices['no'] = __( 'Nessun Menu', SCM_THEME );
` 
// templates_:
` 	$pos = strpos( $list, 'templates_' ) + strlen( 'templates_' );
` 	$type = substr( $list, $pos ) . SCM_TEMPLATE_APP;
` 	$temps = get_posts( array( 'post_type' => $type, 'orderby' => 'menu_order date', 'posts_per_page' => -1 ) );
` 	foreach( $temps as $temp)
` 		$choices[$temp->post_name] = $temp->post_title;
` 
// side_position:
// 	side_position_no:
` 		$str = str_replace( '_', '', str_replace( 'side_position_no', '', substr( $list, strpos( $list, 'side_position_no'))));
` 		$str = ( $str ?: __( 'Elemento', SCM_THEME ) );
` 		$choices = array(
` 			'no' => __( 'Nascondi', SCM_THEME ) . ' ' . $str,
` 			'top' => $str . ' ' . __( 'Sopra', SCM_THEME ),
` 			'right' => $str . ' ' . __( 'Destra', SCM_THEME ),
` 			'bottom' => $str . ' ' . __( 'Sotto', SCM_THEME ),
` 			'left' => $str . ' ' . __( 'Sinistra', SCM_THEME ),
` 		);
// ...
` 		$str = str_replace( '_', '', str_replace( 'side_position', '', substr( $list, strpos( $list, 'side_position'))));
` 		$str = ( $str ?: __( 'Elemento', SCM_THEME ) );
` 		$choices = array(
` 			'top' => $str . ' ' . __( 'Sopra', SCM_THEME ),
` 			'right' => $str . ' ' . __( 'Destra', SCM_THEME ),
` 			'bottom' => $str . ' ' . __( 'Sotto', SCM_THEME ),
` 			'left' => $str . ' ' . __( 'Sinistra', SCM_THEME ),
` 		);

// position_menu:
` 	$choices = array(
` 		'top' => __( 'Menu sopra al logo', SCM_THEME ),
` 		'inline' => __( 'Menu affianco al logo', SCM_THEME ),
` 		'bottom' => __( 'Menu sotto al logo', SCM_THEME ),
` 	);
` 
// sticky_active:
` 	$choices = array(
` 		'self' => __( 'Sticky Self', SCM_THEME ),
` 		'plus' => __( 'Sticky Plus', SCM_THEME ),
` 		'head' => __( 'Sticky Head', SCM_THEME ),
` 	);
` 
// sticky_attach:
` 	$choices = array(
` 		'nav-top' => __( 'Attach to main navigation TOP', SCM_THEME ),
` 		'nav-bottom' => __( 'Attach to main navigation BOTTOM', SCM_THEME ),
` 	);
` 
// home_active:
` 	$choices = array(
` 		'both' => __( 'Menu + Sticky', SCM_THEME ),
` 		'sticky' => __( 'Solo Sticky', SCM_THEME ),
` 		'menu' => __( 'Solo Menu', SCM_THEME ),
` 		'no' => __( 'Solo Toggle', SCM_THEME ),
` 	);
` 
// branding_header:
` 	$choices = array(
` 		'text' => __( 'Usa il nome del sito', SCM_THEME ),
` 		'img' => __( 'Usa un\'immagine', SCM_THEME ),
` 	);
` 
// head_position:
` 	$choices = array(
` 		'menu_down'			=> __( 'Menu sotto a Logo', SCM_THEME ),
` 		'menu_right'		=> __( 'Menu alla destra del Logo', SCM_THEME ),
` 	);
` 
// head_social_position:
` 	$choices = array(
` 		'top' => __( 'Sopra al menu (se menu inline)', SCM_THEME ),
` 		'bottom' => __( 'Sotto al menu (se menu inline)', SCM_THEME ),
` 	);

// image_format:
` 	$choices = array(
` 		'norm' => __( 'Normale', SCM_THEME ),
` 		'quad' => __( 'Quadrata', SCM_THEME ),
` 		'full' => __( 'Full Width', SCM_THEME ),
` 	);
` 
// size_icon:
` 	$choices = array(
` 		'16x16' => '16x16',
` 		'32x32' => '32x32',
` 		'64x64' => '64x64',
` 		'128x128' => '128x128',
` 		'256x256' => '256x256',
` 	);
` 
// archive_mode:
` 	$choices = array(
` 		'single' => __( 'Singoli', SCM_THEME ),
` 		'archive' => __( 'Archivio', SCM_THEME ),
` 	);
` 
// archive_complete:
` 	$choices = array(
` 		'partial' => __( 'Archivio parziale', SCM_THEME ),
` 		'complete' => __( 'Archivio completo', SCM_THEME ),
` 	);
` 
// archive_pagination:
` 	$choices = array(
` 		'yes' => __( 'Paginazione', SCM_THEME ),
` 		'all' => __( 'Pulsante ALL', SCM_THEME ),
` 		'more' => __( 'Pulsante MORE', SCM_THEME ),
` 		'no' => __( 'No paginazione', SCM_THEME ),
` 	);
` 
// gallerie_button:
` 	$choices = array(
` 		'img' => __( 'Thumb', SCM_THEME ),
` 		'txt' => __( 'Testo', SCM_THEME ),
` 		'section' => __( 'Sezione', SCM_THEME ),
` 	);
` 
// template_link:
// 	_complete:
` 		$choices = array(
` 			'template' => __( 'Link Template (tutto)', SCM_THEME ),
` 			'template-single' => __( 'Link Template (singoli elementi)', SCM_THEME ),
` 			'link' => __( 'Inserisci Link (tutto)', SCM_THEME ),
` 			'link-single' => __( 'Inserisci Link (singoli elementi)', SCM_THEME ),
` 		);
// 	...
` 		$choices = array(
` 			'self' => __( 'Link Oggetto', SCM_THEME ),
` 			'template' => __( 'Link Template', SCM_THEME ),
` 			'link' => __( 'Link Inserito', SCM_THEME ),
` 		);
` 
// luogo_data:
` 	$choices = array(
` 		'name' => __( 'Nome', SCM_THEME ),
` 		'address' => __( 'Indirizzo', SCM_THEME ),
` 		'num' => __( 'Numeri', SCM_THEME ),
` 		'email' => __( 'Email', SCM_THEME ),
` 		'link' => __( 'Link', SCM_THEME ),
` 	);
` 
// contact_link:
` 	$choices = array(
` 		'web:' => __( 'web:', SCM_THEME ),
` 		'support:' => __( 'support:', SCM_THEME ),
` 	);
` 
// contact_email:
` 	$choices = array(
` 		'e-mail:' => __( 'e-mail:', SCM_THEME ),
` 	);
` 
// contact_num:
` 	$choices = array(
` 		'Tel.' => __( 'Tel.', SCM_THEME ),
` 		'Mobile' => __( 'Mobile', SCM_THEME ),
` 		'Fax' => __( 'Fax', SCM_THEME ),
` 	);
` 
// rassegne_type:
` 	$choices = array(
` 		'file' => __( 'File', SCM_THEME ),
` 		'link' => __( 'Link', SCM_THEME ),
` 	);
` 
// links_type:
` 	$choices = array(
` 		'page' 	=> __( 'Pagina', SCM_THEME ),
` 		'link' 	=> __( 'Link', SCM_THEME ),
` 	);
` 
// waitfor:
` 	$choices = array(
` 		//'window' => 'Window',
` 		'images' => 'Images - ALL',
` 		'nobg' => 'Images - NO Background Images',
` 		'sliders' => 'Sliders',
` 		'maps' => 'Maps',
` 	);
` 
// positive_negative:
` 	$choices = array(
` 		'off' => __( 'Versione positiva', SCM_THEME ),
` 		'on' => __( 'Versione negativa', SCM_THEME ),
` 	);
` 
// show:
// 	options_show:
` 		$choices = array(
` 			'hide' 		=> __( 'Nascondi Opzioni', SCM_THEME ),
` 			'options' 	=> __( 'Opzioni', SCM_THEME ),
` 			'advanced' 	=> __( 'Opzioni avanzate', SCM_THEME ),
` 		);
// 	...
`     	$choices = array(
` 			'on' => __( 'Mostra', SCM_THEME ),
` 			'off' => __( 'Nascondi', SCM_THEME ),
` 		);
`     endif;
` 
// hide:
` 	$choices = array(
` 		'off' => __( 'Nascondi', SCM_THEME ),
` 		'on' => __( 'Mostra', SCM_THEME ),
` 	);
` 
// enable:
` 	$choices = array(
` 		'on' => __( 'Abilita', SCM_THEME ),
` 		'off' => __( 'Disabilita', SCM_THEME ),
` 	);
` 
// disable:
` 	$choices = array(
` 		'off' => __( 'Disabilita', SCM_THEME ),
` 		'on' => __( 'Abilita', SCM_THEME ),
` 	);
` 
// ordertype:
` 	$choices = array(
` 		'DESC' => __( 'Discendente', SCM_THEME ),
` 		'ASC' => __( 'Ascendente', SCM_THEME ),
` 	);
` 
// orderby:
` 	$choices = array(
` 		'date' => __( 'Data', SCM_THEME ),
` 		'title' => __( 'Titolo', SCM_THEME ),
` 		'modified' => __( 'Data modifica', SCM_THEME ),
` 		'name' => __( 'Slug', SCM_THEME ),
` 		'type' => __( 'Tipo', SCM_THEME ),
` 		'rand' => __( 'Random', SCM_THEME ),
` 		'meta_value' => __( 'Custom Field', SCM_THEME ),
` 	);
` 
// line_style:
` 	$choices = array(
` 		'no' => __( 'Vuoto', SCM_THEME ),
` 		'line' => __( 'Linea', SCM_THEME ),
` 		'dashed' => __( 'Tratteggiato', SCM_THEME ),
` 		//'dotted' => __( 'Punteggiato', SCM_THEME ),
` 	);
` 
// line_cap:
` 	$choices = array(
` 		'round' => __( 'Tondeggiato', SCM_THEME ),
` 		'square' => __( 'Squadrato', SCM_THEME ),
` 		'butt' => __( 'Squadrato a filo', SCM_THEME ),
` 	);
` 
// list_type:
` 	$choices = array(
` 		'none' => __( 'Non puntato', SCM_THEME ),
` 		'disc' => __( 'Cerchio', SCM_THEME ),
` 		'circle' => __( 'Cerchio vuoto', SCM_THEME ),
` 		'square' => __( 'Quadrato', SCM_THEME ),
` 		'decimal' => __( 'Decimali', SCM_THEME ),
` 		'decimal-leading-zero' => __( 'Decimali con zero', SCM_THEME ),
` 		'lower-latin' => __( 'Lettere minuscole', SCM_THEME ),
` 		'upper-latin' => __( 'Lettere maiuscole', SCM_THEME ),
` 		'lower-roman' => __( 'Roman minuscolo', SCM_THEME ),
` 		'upper-roman' => __( 'Roman maiuscolo', SCM_THEME ),
` 	);
` 
// alignment:
// 	vertical_alignment:
`     	$choices = array(
` 			'top' => __( 'Alto', SCM_THEME ),
` 			'middle' => __( 'Centro', SCM_THEME ),
` 			'bottom' => __( 'Basso', SCM_THEME ),
` 		);
// 	txt_alignment':
`     	$choices = array(
` 			'left' => __( 'Sinistra', SCM_THEME ),
` 			'right' => __( 'Destra', SCM_THEME ),
` 			'center' => __( 'Centrato', SCM_THEME ),
` 			'justify' => __( 'Giustificato', SCM_THEME ),
` 		);
// 	...
`     	$choices = array(
` 			'left' => __( 'Sinistra', SCM_THEME ),
` 			'right' => __( 'Destra', SCM_THEME ),
` 			'center' => __( 'Centrato', SCM_THEME ),
` 		);
` 
`     };
` 
// float:
` 	$choices = array(
` 		'float-none' => __( 'No Float', SCM_THEME ),
` 		'float-left' => __( 'Float Sinistra', SCM_THEME ),
` 		'float-right' => __( 'Float Destra', SCM_THEME ),
` 		'float-center' => __( 'Float Centrato', SCM_THEME ),
` 	);
` 
// overlay:
` 	$choices = array(
` 		'no-overlay' => __( 'No Overlay', SCM_THEME ),
` 		'overlay' => __( 'Overlay', SCM_THEME ),
` 		'underlay' => __( 'Underlay', SCM_THEME ),
` 	);
` 
// units:
` 	$choices = array(
` 		'px' => 'px',
` 		'%' => '%',
` 		'em' => 'em',
` 	);
` 
// headings:
` 	$choices = array(
` 		'h1' => 'h1',
` 		'h2' => 'h2',
` 		'h3' => 'h3',
` 		'h4' => 'h4',
` 		'h5' => 'h5',
` 		'h6' => 'h6',
` 		'.h7' => '.h7',
` 		'.h8' => '.h8',
` 		'.h9' => '.h9',
` 		'.h0' => '.h0',
` 		'strong' => 'strong',
` 		'div' => 'div',
` 		'span' => 'span',
` 		'p' => 'p',
` 	);
// 	headings_low:
` 	$choices = array(
` 		'p' => 'p',
` 		'span' => 'span',
` 		'strong' => 'strong',
` 		'div' => 'div',
` 		'h6' => 'h6',
` 		'h5' => 'h5',
` 		'h4' => 'h4',
` 		'h3' => 'h3',
` 		'h2' => 'h2',
` 		'h1' => 'h1',
` 	);
// 	headings_min:
` 	$choices = array(
` 		'p' => 'p',
` 		'span' => 'span',
` 		'strong' => 'strong',
` 	);
// 	headings_max:
` 	$choices = array(
` 		'h2' => __( 'Primario', SCM_THEME ),
` 		'h3' => __( 'Secondario', SCM_THEME ),
` 		'h4' => __( 'Terziario', SCM_THEME ),
` 	);
` 
// columns_width:
` 	$choices = array(
` 		'1/1' => '1/1',
` 		'1/2' => '1/2',
` 		'1/3' => '1/3',
` 		'2/3' => '2/3',
` 		'1/4' => '1/4',
` 		'3/4' => '3/4',
` 		'1/5' => '1/5',
` 		'2/5' => '2/5',
` 		'3/5' => '3/5',
` 		'4/5' => '4/5',
` 		'1/6' => '1/6',
` 		'5/6' => '5/6',
` 	);
` 
// txt_size:
` 	$choices = array(
` 		'100%' => 'Normal',
` 		'60%' => 'XXX-Small',
` 		'70%' => 'XX-Small',
` 		'80%' => 'X-Small',
` 		'90%' => 'Smaller',
` 		'95%' => 'Small',
` 		'105%' => 'Medium',
` 		'110%' => 'Large',
` 		'120%' => 'X-Large',
` 		'130%' => 'XX-Large',
` 		'140%' => 'XXX-Large',
` 		'150%' => 'Big',
` 		'160%' => 'X-Big',
` 		'170%' => 'XX-Big',
` 		'180%' => 'XXX-Big',
` 		'200%' => 'Huge',
` 	);
` 
// txt_font_size:
` 	$choices = array(
` 		'16px' => 'Normal',
` 		'10px' => 'XXX-Small',
` 		'11px' => 'XX-Small',
` 		'12px' => 'X-Small',
` 		'13px' => 'Smaller',
` 		'15px' => 'Small',
` 		'17px' => 'Medium',
` 		'18px' => 'Large',
` 		'19px' => 'X-Large',
` 		'20px' => 'XX-Large',
` 		'21px' => 'XXX-Large',
` 		'22px' => 'Big',
` 		'23px' => 'X-Big',
` 		'24px' => 'XX-Big',
` 		'25px' => 'XXX-Big',
` 		'26px' => 'Huge',
` 	);
` 
// main_layout:
` 	$choices = array(
` 		'responsive'		=> 'Responsive',
` 		'full'				=> 'Full Width',
` 	);
` 
// responsive_events:
// 	_width:
` 		$choices = array(
` 			'500px'			=> 'Mobile Min',
` 			'600px'			=> 'Mobile Mid',
` 			'700px'			=> 'Mobile',
` 			'800px'			=> 'Tablet Portrait',
` 			'940px'			=> 'Notebook',
` 			'1030px'		=> 'Tablet Landscape',
` 			'1120px'		=> 'Desktop',
` 		);
// 	...
` 		$choices = array(
` 			'smartmin'		=> 'Mobile Min',
` 			'smartmid'		=> 'Mobile Mid',
` 			'smart'			=> 'Mobile',
` 			'portrait'		=> 'Tablet Portrait',
` 			'notebook'		=> 'Notebook',
` 			'tablet'		=> 'Tablet Landscape',
` 			'desktop'		=> 'Desktop',
` 		);
` 
` 
// responsive_up:
` 	$choices = array(
` 		'smartmin'																=> 'Mobile Min',
` 		'smartmin smartmid'														=> 'Mobile Mid',
` 		'smartmin smartmid smart'												=> 'Mobile',
` 		'smartmin smartmid smart portrait'										=> 'Tablet Portrait',
` 		'smartmin smartmid smart portrait notebook'								=> 'Notebook',
` 		'smartmin smartmid smart portrait notebook landscape'					=> 'Tablet Landscape',
` 		'smartmin smartmid smart portrait notebook landscape desktop'			=> 'Desktop',
` 		'smartmin smartmid smart portrait notebook landscape desktop wide'		=> 'Wide',
` 	);
` 
// responsive_down:
` 	$choices = array(
` 		'wide desktop landscape notebook portrait smart smartmid smartmin'		=> 'Mobile Min',
` 		'wide desktop landscape notebook portrait smart smartmid'				=> 'Mobile Mid',
` 		'wide desktop landscape notebook portrait smart'						=> 'Mobile',
` 		'wide desktop landscape notebook portrait'								=> 'Tablet Portrait',
` 		'wide desktop landscape notebook'										=> 'Notebook',
` 		'wide desktop landscape'												=> 'Tablet Landscape',
` 		'wide desktop'															=> 'Desktop',
` 		'wide'																	=> 'Wide',
` 	);
` 
// responsive_layouts:
` 	$choices = array(
` 		'1400px'			=> '1250px',
` 		'1120px'			=> '1120px',
` 		'1030px'			=> '1030px',
` 		'940px'				=> '940px',
` 		'800px'				=> '800px',
` 		'700px'				=> '700px',
` 		'600px'				=> '600px',
` 	);
` 
// bg_repeat:
` 	$choices = array(
` 		'no-repeat'			=> 'No repeat',
` 		'repeat'			=> 'Repeat',
` 		'repeat-x'			=> 'Repeat x',
` 		'repeat-y'			=> 'Repeat y',
` 	);
` 
// bg_position:
` 	$choices = array(
` 		'center center'			=> 'center center',
` 		'center top'			=> 'center top',
` 		'center bottom'			=> 'center bottom',
` 		'left center'			=> 'left center',
` 		'left top'				=> 'left top',
` 		'left bottom'			=> 'left bottom',
` 		'right center'			=> 'right center',
` 		'right top'				=> 'right top',
` 		'right bottom'			=> 'right bottom',
` 	);
` 
// webfonts_adobe:
// 	webfonts_adobe_styles:
` 		$choices = array(
` 			'n1' => 'Thin',
` 			'i1' => 'Thin Italic',
` 			'n3' => 'Light',
` 			'i3' => 'Light Italic',
` 			'n4' => 'Normal',
` 			'i4' => 'Normal Italic',
` 			'n6' => 'Semi Bold',
` 			'i6' => 'Semi Bold Italic',
` 			'n7' => 'Bold',
` 			'i7' => 'Bold Italic',
` 			'n8' => 'Extra Bold',
` 			'i8' => 'Extra Bold Italic',
` 			'n9' => 'Ultra Bold',
` 			'i9' => 'Ultra Bold Italic',
` 		);
// 	...
` 		global $SCM_typekit;
` 
` 		if( $SCM_typekit ){
` 			$choices = array('no' => 'No Adobe font');
` 			$kits = scm_field( 'styles-adobe', array(), 'option' );
` 			foreach ( $kits as $field){
` 				$kit = $SCM_typekit->get( $field['id'] );
` 				if( !$kit || !$kit['kit'] )
` 					continue;
` 				foreach ( $kit['kit']['families'] as $family)
` 					$choices[$family['slug']] = $family['name'];
` 			}
` 		}
` 
// webfonts_google:
// 	webfonts_google_styles:
` 		$choices = array(
` 			'100,' => 'Thin',
` 			'100italic,' => 'Thin Italic',
` 			'300,' => 'Light',
` 			'300italic,' => 'Light Italic',
` 			'400,' => 'Normal',
` 			'400italic,' => 'Normal Italic',
` 			'600,' => 'Semi Bold',
` 			'600italic,' => 'Semi Bold Italic',
` 			'700,' => 'Bold',
` 			'700italic,' => 'Bold Italic',
` 			'800,' => 'Extra Bold',
` 			'800italic,' => 'Extra Bold Italic',
` 			'900,' => 'Ultra Bold',
` 			'900italic,' => 'Ultra Bold Italic',
` 		);
// 	...
` 		$choices = array('no' => 'No Google font');
` 		$fonts = scm_field( 'styles-google', array(), 'option' );
` 		foreach ( $fonts as $font)
` 			$choices[$font['family']] = $font['family'];
` 
// webfonts_fallback:
` 	$choices = array(
` 		'Helvetica_Arial_sans-serif'						=> 'Helvetica, Arial, sans-serif',
` 		'Lucida Sans Unicode_Lucida Grande_sans-serif'		=> 'Lucida Sans Unicode, Lucida Grande, sans-serif',
` 		'Trebuchet MS_Helvetica_sans-serif'					=> 'Trebuchet MS, Helvetica, sans-serif',
` 		'Verdana_Geneva_sans-serif'							=> 'Verdana, Geneva, sans-serif',
` 		'Georgia_serif'										=> 'Georgia, serif',
` 		'Times New Roman_Times_serif'						=> 'Times New Roman, Times, serif',
` 		'Palatino Linotype_Book Antiqua_Palatino_serif'		=> 'Palatino Linotype, Book Antiqua, Palatino, serif',
` 		'cursive_serif'										=> 'cursive, serif',
` 		'Courier New_Courier_monospace'						=> 'Courier New, Courier, monospace',
` 		'Lucida Console_Monaco_monospace'					=> 'Lucida Console, Monaco, monospace',
` 	);
` 
// font_weight:
` 	$choices = array(
` 		'lighter' => 'Light',
` 		'normal' => 'Normal',
` 		//'semi' => 'Semi Bold',
` 		'bold' => 'Bold',
` 		//'900' => 'Extra Bold',
` 	);
` 
// line_height:
` 	$choices = array(
` 		'0-0' => __( 'Nessuno spazio', SCM_THEME ),
` 		'0-25' => __( '1 quarto di linea', SCM_THEME ),
` 		'0-5' => __( 'Mezza linea', SCM_THEME ),
` 		'1-0' => __( 'Una linea', SCM_THEME ),
` 		'1-25' => __( 'Una linea e 1 quarto', SCM_THEME ),
` 		'1-5' => __( 'Una linea e mezza', SCM_THEME ),
` 		'1-75' => __( 'Una linea e 3 quarti', SCM_THEME ),
` 		'2-0' => __( 'Doppia linea', SCM_THEME ),
` 		'2-5' => __( 'Doppia linea e mezza', SCM_THEME ),
` 		'3-0' => __( 'Tripla linea', SCM_THEME ),
` 		'4-0' => __( 'Quadrupla linea', SCM_THEME ),
` 	);
` 
// slider_model:
` 	$choices = array(
` 		'nivo' => 'Nivo Slider',
` 		'bx' => 'BX Slider',
` 	);
` 
// effect:
// 	_nivo:
` 		$choices = array(
` 			'sliceDown' => __( 'Slice Down', SCM_THEME ),
` 			'sliceDownLeft' => __( 'Slice Down Left', SCM_THEME ),
` 			'sliceUp' => __( 'Slice Up', SCM_THEME ),
` 			'sliceUpLeft' => __( 'Slice Up Left', SCM_THEME ),
` 			'sliceUpDown' => __( 'Slice Up Down', SCM_THEME ),
` 			'sliceUpDownLeft' => __( 'Slice Up Down Left', SCM_THEME ),
` 			'fold' => __( 'Fold', SCM_THEME ),
` 			'fade' => __( 'Fade', SCM_THEME ),
` 			'random' => __( 'Random', SCM_THEME ),
` 			'slideInRight' => __( 'Slide In Right', SCM_THEME ),
` 			'slideInLeft' => __( 'Slide In Left', SCM_THEME ),
` 			'boxRandom' => __( 'Box Random', SCM_THEME ),
` 			'boxRain' => __( 'Box Rain', SCM_THEME ),
` 			'boxRainReverse' => __( 'Box Rain Reverse', SCM_THEME ),
` 			'boxRainGrow' => __( 'Box Rain Grow', SCM_THEME ),
` 			'boxRainGrowReverse' => __( 'Box Rain Grow Reverse', SCM_THEME ),
` 		);
` 
// themes_nivo:
` 	$choices = array(
` 		'scm' 		=> 'SCM',
` 	);
` 
// box_shape:
` 	$choices = array(
` 		'square' 		=> __( 'Quadrato', SCM_THEME ),
` 		'circle' 		=> __( 'Cerchio', SCM_THEME ),
` 		'rounded' 		=> __( 'Arrotondato', SCM_THEME ),
` 	);
` 
// simple_size:
` 	$choices = array(
` 		'normal' 	=> __( 'Normale', SCM_THEME ),
` 		'min' 		=> __( 'Minimo', SCM_THEME ),
` 		'small' 	=> __( 'Piccolo', SCM_THEME ),
` 		'medium' 	=> __( 'Medio', SCM_THEME ),
` 		'big' 		=> __( 'Grande', SCM_THEME ),
` 		'max' 		=> __( 'Massimo', SCM_THEME ),
` 	);
` 
// date_format:
` 	$choices = array(
` 		'dmy' 		=> '31 12 15',
` 		'dmY' 		=> '31 12 2015',
` 		'd F Y' 	=> __( '31 Dicembre 2015', SCM_THEME ),
` 		'd M y' 	=> __( '31 Dic 15', SCM_THEME ),
` 		'ymd' 		=> '15 12 31',
` 		'Ymd' 		=> '2015 12 31',
` 	);
` 
// box_angle_type:
` 	$choices = array(
` 		'all' 					=> __( 'Tutti', SCM_THEME ),
` 		'round-top' 			=> __( 'Sopra', SCM_THEME ),
` 		'round-left' 			=> __( 'Sinistra', SCM_THEME ),
` 		'round-right' 			=> __( 'Destra', SCM_THEME ),
` 		'round-bottom' 			=> __( 'Sotto', SCM_THEME ),
` 		'round-leaf-left' 		=> __( 'Foglia A', SCM_THEME ),
` 		'round-leaf-right' 		=> __( 'Foglia B', SCM_THEME ),
` 		'round-petal-left' 		=> __( 'Petalo A', SCM_THEME ),
` 		'round-petal-right' 	=> __( 'Petalo B', SCM_THEME ),
` 		'round-drop-left' 		=> __( 'Petalo C', SCM_THEME ),
` 		'round-drop-right' 		=> __( 'Petalo D', SCM_THEME ),
` 		'round-head-left' 		=> __( 'Singolo A', SCM_THEME ),
` 		'round-head-right' 		=> __( 'Singolo B', SCM_THEME ),
` 		'round-foot-left' 		=> __( 'Singolo C', SCM_THEME ),
` 		'round-foot-right' 		=> __( 'Singolo D', SCM_THEME ),
` 	);
` 
// ease:
` 	$choices = array(
` 		'swing' 			=> 'Swing',
` 		'linear' 			=> 'Linear',
` 		'easeInQuad' 		=> 'Quad In',
` 		'easeOutQuad' 		=> 'Quad Out',
` 		'easeInOutQuad' 	=> 'Quad InOut',
` 		'easeInCubic' 		=> 'Cubic In',
` 		'easeOutCubic' 		=> 'Cubic Out',
` 		'easeInOutCubic' 	=> 'Cubic InOut',
` 		'easeInQuart' 		=> 'Quart In',
` 		'easeOutQuart' 		=> 'Quart Out',
` 		'easeInOutQuart' 	=> 'Quart InOut',
` 		'easeInQuint' 		=> 'Quint In',
` 		'easeOutQuint' 		=> 'Quint Out',
` 		'easeInOutQuint' 	=> 'Quint InOut',
` 		'easeInExpo' 		=> 'Expo In',
` 		'easeOutExpo' 		=> 'Expo Out',
` 		'easeInOutExpo' 	=> 'Expo InOut',
` 		'easeInSine' 		=> 'Sine In',
` 		'easeOutSine' 		=> 'Sine Out',
` 		'easeInOutSine' 	=> 'Sine InOut',
` 		'easeInCirc' 		=> 'Circ In',
` 		'easeOutCirc' 		=> 'Circ Out',
` 		'easeInOutCirc' 	=> 'Circ InOut',
` 		'easeInElastic' 	=> 'Elastic In',
` 		'easeOutElastic' 	=> 'Elastic Out',
` 		'easeInOutElastic' 	=> 'Elastic InOut',
` 		'easeInBack' 		=> 'Back In',
` 		'easeOutBack' 		=> 'Back Out',
` 		'easeInOutBack' 	=> 'Back InOut',
` 		'easeInBounce' 		=> 'Bounce In',
` 		'easeOutBounce' 	=> 'Bounce Out',
` 		'easeInOutBounce' 	=> 'Bounce InOut',
` 	);
```
*
* @param {string} list Choices preset name.
* @param {string=} get Optional. Returns specific choice value instead of choices list (default is '').
* @return {array} Associative array filled with choices.
*/
function scm_acf_field_choices_preset( $list, $get = '' ){

	global $post;

	$choices = array();
        				
	if( strpos( $list, 'types_' ) !== false ):
		global $SCM_types;
		if( strpos( $list, '_complete') !== false )
			$choices = $SCM_types['complete'];
		else if( strpos( $list, '_private') !== false )
			$choices = $SCM_types['private'];
		else if( strpos( $list, '_public') !== false )
			$choices = $SCM_types['public'];
		else
			$choices = $SCM_types['all'];

	elseif( strpos( $list, 'wp_menu' ) !== false ):
		$menus = get_registered_nav_menus();
		foreach ( $menus as $location => $description )
			$choices[$location] = $description;

		$choices['auto'] = __( 'Menu Auto', SCM_THEME );
		$choices['no'] = __( 'Nessun Menu', SCM_THEME );

	elseif( strpos( $list, 'templates_' ) !== false ):
		$pos = strpos( $list, 'templates_' ) + strlen( 'templates_' );
		$type = substr( $list, $pos ) . SCM_TEMPLATE_APP;
		$temps = get_posts( array( 'post_type' => $type, 'orderby' => 'menu_order date', 'posts_per_page' => -1 ) );
		foreach ( $temps as $temp)
			$choices[$temp->post_name] = $temp->post_title;

	elseif( strpos( $list, 'side_position' ) !== false ):
		if( strpos( $list, 'side_position_no' ) !== false ):
			$str = str_replace( '_', '', str_replace( 'side_position_no', '', substr( $list, strpos( $list, 'side_position_no'))));
			$str = ( $str ?: __( 'Elemento', SCM_THEME ) );
			$choices = array(
				'no' => __( 'Nascondi', SCM_THEME ) . ' ' . $str,
				'top' => $str . ' ' . __( 'Sopra', SCM_THEME ),
				'right' => $str . ' ' . __( 'Destra', SCM_THEME ),
				'bottom' => $str . ' ' . __( 'Sotto', SCM_THEME ),
				'left' => $str . ' ' . __( 'Sinistra', SCM_THEME ),
			);
		else:
			$str = str_replace( '_', '', str_replace( 'side_position', '', substr( $list, strpos( $list, 'side_position'))));
			$str = ( $str ?: __( 'Elemento', SCM_THEME ) );
			$choices = array(
				'top' => $str . ' ' . __( 'Sopra', SCM_THEME ),
				'right' => $str . ' ' . __( 'Destra', SCM_THEME ),
				'bottom' => $str . ' ' . __( 'Sotto', SCM_THEME ),
				'left' => $str . ' ' . __( 'Sinistra', SCM_THEME ),
			);
		endif;
			
	elseif( strpos( $list, 'position_menu' ) !== false ):
		$choices = array(
			'top' => __( 'Menu sopra al logo', SCM_THEME ),
			'inline' => __( 'Menu affianco al logo', SCM_THEME ),
			'bottom' => __( 'Menu sotto al logo', SCM_THEME ),
		);

	elseif( strpos( $list, 'sticky_active' ) !== false ):
		$choices = array(
			'self' => __( 'Sticky Self', SCM_THEME ),
			'plus' => __( 'Sticky Plus', SCM_THEME ),
			'head' => __( 'Sticky Head', SCM_THEME ),
		);

	elseif( strpos( $list, 'sticky_attach' ) !== false ):
		$choices = array(
			'nav-top' => __( 'Attach to main navigation TOP', SCM_THEME ),
			'nav-bottom' => __( 'Attach to main navigation BOTTOM', SCM_THEME ),
		);

	elseif( strpos( $list, 'home_active' ) !== false ):
		$choices = array(
			'both' => __( 'Menu + Sticky', SCM_THEME ),
			'sticky' => __( 'Solo Sticky', SCM_THEME ),
			'menu' => __( 'Solo Menu', SCM_THEME ),
			'no' => __( 'Solo Toggle', SCM_THEME ),
		);

	elseif( strpos( $list, 'branding_header' ) !== false ):
		$choices = array(
			'text' => __( 'Usa il nome del sito', SCM_THEME ),
			'img' => __( 'Usa un\'immagine', SCM_THEME ),
		);

	elseif( strpos( $list, 'head_position' ) !== false ):
		$choices = array(
			'menu_down'			=> __( 'Menu sotto a Logo', SCM_THEME ),
			'menu_right'		=> __( 'Menu alla destra del Logo', SCM_THEME ),
		);

	elseif( strpos( $list, 'head_social_position' ) !== false ):
		$choices = array(
			'top' => __( 'Sopra al menu (se menu inline)', SCM_THEME ),
			'bottom' => __( 'Sotto al menu (se menu inline)', SCM_THEME ),
		);
			
	elseif( strpos( $list, 'image_format' ) !== false ):
		$choices = array(
			'norm' => __( 'Normale', SCM_THEME ),
			'quad' => __( 'Quadrata', SCM_THEME ),
			'full' => __( 'Full Width', SCM_THEME ),
		);
	
	elseif( strpos( $list, 'size_icon' ) !== false ):
		$choices = array(
			'16x16' => '16x16',
			'32x32' => '32x32',
			'64x64' => '64x64',
			'128x128' => '128x128',
			'256x256' => '256x256',
		);

	elseif( strpos( $list, 'archive_mode' ) !== false ):
		$choices = array(
			'single' => __( 'Singoli', SCM_THEME ),
			'archive' => __( 'Archivio', SCM_THEME ),
		);
	
	elseif( strpos( $list, 'archive_complete' ) !== false ):
		$choices = array(
			'partial' => __( 'Archivio parziale', SCM_THEME ),
			'complete' => __( 'Archivio completo', SCM_THEME ),
		);
	
	elseif( strpos( $list, 'archive_pagination' ) !== false ):
		$choices = array(
			'yes' => __( 'Paginazione', SCM_THEME ),
			'all' => __( 'Pulsante ALL', SCM_THEME ),
			'more' => __( 'Pulsante MORE', SCM_THEME ),
			'no' => __( 'No paginazione', SCM_THEME ),
		);
	
	elseif( strpos( $list, 'gallerie_button' ) !== false ):
		$choices = array(
			'img' => __( 'Thumb', SCM_THEME ),
			'txt' => __( 'Testo', SCM_THEME ),
			'section' => __( 'Sezione', SCM_THEME ),
		);

	// +++ todo: non più 2, con _complete, ma spostati in alto, dove c'è template_ e lo fai simile
	// chiami tamplate_link{type}, recuperi type, in qualche modo risali alle fields di quel type, becchi la field link/url/file e aggiungi la choice Link Oggetto
	elseif( strpos( $list, 'template_link' ) !== false ):
		if( strpos( $list, '_complete' ) !== false ):
			$choices = array(
				'template' => __( 'Link Template (tutto)', SCM_THEME ),
				'template-single' => __( 'Link Template (singoli elementi)', SCM_THEME ),
				'link' => __( 'Inserisci Link (tutto)', SCM_THEME ),
				'link-single' => __( 'Inserisci Link (singoli elementi)', SCM_THEME ),
			);

		else:
			$choices = array(
				'self' => __( 'Link Oggetto', SCM_THEME ),
				'template' => __( 'Link Template', SCM_THEME ),
				'link' => __( 'Link Inserito', SCM_THEME ),
			);

		endif;
	
	elseif( strpos( $list, 'luogo_data' ) !== false ):
		$choices = array(
			'name' => __( 'Nome', SCM_THEME ),
			'address' => __( 'Indirizzo', SCM_THEME ),
			'num' => __( 'Numeri', SCM_THEME ),
			'email' => __( 'Email', SCM_THEME ),
			'link' => __( 'Link', SCM_THEME ),
		);
	
	elseif( strpos( $list, 'contact_link' ) !== false ):
		$choices = array(
			'web:' => __( 'web:', SCM_THEME ),
			'support:' => __( 'support:', SCM_THEME ),
		);

	elseif( strpos( $list, 'contact_email' ) !== false ):
		$choices = array(
			'e-mail:' => __( 'e-mail:', SCM_THEME ),
		);

	elseif( strpos( $list, 'contact_num' ) !== false ):
		$choices = array(
			'Tel.' => __( 'Tel.', SCM_THEME ),
			'Mobile' => __( 'Mobile', SCM_THEME ),
			'Fax' => __( 'Fax', SCM_THEME ),
		);

	elseif( strpos( $list, 'rassegne_type' ) !== false ):
		$choices = array(
			'file' => __( 'File', SCM_THEME ),
			'link' => __( 'Link', SCM_THEME ),
		);

	elseif( strpos( $list, 'links_type' ) !== false ):
		$choices = array(
			'page' 	=> __( 'Pagina', SCM_THEME ),
			'link' 	=> __( 'Link', SCM_THEME ),
		);

	elseif( strpos( $list, 'waitfor' ) !== false ):
		$choices = array(
			'images' => 'Images - ALL',
			'nobg' => 'Images - NO Background Images',
			'sliders' => 'Sliders',
			'maps' => 'Maps',
		);

	elseif( strpos( $list, 'positive_negative' ) !== false ):
    	$choices = array(
			'off' => __( 'Versione positiva', SCM_THEME ),
			'on' => __( 'Versione negativa', SCM_THEME ),
		);

    elseif( strpos( $list, 'show' ) !== false ):
    	if( strpos( $list, 'options_show' ) !== false ):
			$choices = array(
				'hide' 		=> __( 'Nascondi Opzioni', SCM_THEME ),
				'options' 	=> __( 'Opzioni', SCM_THEME ),
				'advanced' 	=> __( 'Opzioni avanzate', SCM_THEME ),
			);

		else:
        	$choices = array(
				'on' => __( 'Mostra', SCM_THEME ),
				'off' => __( 'Nascondi', SCM_THEME ),
			);

        endif;

    elseif( strpos( $list, 'hide' ) !== false ):
    	$choices = array(
    		'off' => __( 'Nascondi', SCM_THEME ),
			'on' => __( 'Mostra', SCM_THEME ),
		);

	elseif( strpos( $list, 'enable' ) !== false ):
    	$choices = array(
			'on' => __( 'Abilita', SCM_THEME ),
			'off' => __( 'Disabilita', SCM_THEME ),
		);

    elseif( strpos( $list, 'disable' ) !== false ):
    	$choices = array(
    		'off' => __( 'Disabilita', SCM_THEME ),
			'on' => __( 'Abilita', SCM_THEME ),
		);

	elseif( strpos( $list, 'ordertype' ) !== false ):
    	$choices = array(
    		'DESC' => __( 'Discendente', SCM_THEME ),
    		'ASC' => __( 'Ascendente', SCM_THEME ),
		);

    elseif( strpos( $list, 'orderby' ) !== false ):
    	$choices = array(
    		'date' => __( 'Data', SCM_THEME ),
			'title' => __( 'Titolo', SCM_THEME ),
			'modified' => __( 'Data modifica', SCM_THEME ),
			'name' => __( 'Slug', SCM_THEME ),
			'type' => __( 'Tipo', SCM_THEME ),
			'rand' => __( 'Random', SCM_THEME ),
			'meta_value' => __( 'Custom Field', SCM_THEME ),
		);

    elseif( strpos( $list, 'line_style' ) !== false ):
    	$choices = array(
    		'no' => __( 'Vuoto', SCM_THEME ),
    		'line' => __( 'Linea', SCM_THEME ),
    		'dashed' => __( 'Tratteggiato', SCM_THEME ),
		);

    elseif( strpos( $list, 'line_cap' ) !== false ):
    	$choices = array(
    		'round' => __( 'Tondeggiato', SCM_THEME ),
    		'square' => __( 'Squadrato', SCM_THEME ),
    		'butt' => __( 'Squadrato a filo', SCM_THEME ),
		);
	
	elseif( strpos( $list, 'list_type' ) !== false ):
    	$choices = array(
    		'none' => __( 'Non puntato', SCM_THEME ),
    		'disc' => __( 'Cerchio', SCM_THEME ),
    		'circle' => __( 'Cerchio vuoto', SCM_THEME ),
    		'square' => __( 'Quadrato', SCM_THEME ),
    		'decimal' => __( 'Decimali', SCM_THEME ),
    		'decimal-leading-zero' => __( 'Decimali con zero', SCM_THEME ),
    		'lower-latin' => __( 'Lettere minuscole', SCM_THEME ),
    		'upper-latin' => __( 'Lettere maiuscole', SCM_THEME ),
			'lower-roman' => __( 'Roman minuscolo', SCM_THEME ),
			'upper-roman' => __( 'Roman maiuscolo', SCM_THEME ),
		);

    elseif( strpos( $list, 'alignment' ) !== false ):

    	if( strpos( $list, 'vertical_alignment' ) !== false ):
        	$choices = array(
				'top' => __( 'Alto', SCM_THEME ),
				'middle' => __( 'Centro', SCM_THEME ),
				'bottom' => __( 'Basso', SCM_THEME ),
			);

		elseif( strpos( $list, 'txt_alignment' ) !== false ):
        	$choices = array(
				'left' => __( 'Sinistra', SCM_THEME ),
				'right' => __( 'Destra', SCM_THEME ),
				'center' => __( 'Centrato', SCM_THEME ),
				'justify' => __( 'Giustificato', SCM_THEME ),
			);

		else:
        	$choices = array(
				'left' => __( 'Sinistra', SCM_THEME ),
				'right' => __( 'Destra', SCM_THEME ),
				'center' => __( 'Centrato', SCM_THEME ),
			);

        endif;

	elseif( strpos( $list, 'float' ) !== false ):
    	$choices = array(
    		'float-none' => __( 'No Float', SCM_THEME ),
			'float-left' => __( 'Float Sinistra', SCM_THEME ),
			'float-right' => __( 'Float Destra', SCM_THEME ),
			'float-center' => __( 'Float Centrato', SCM_THEME ),
		);

    elseif( strpos( $list, 'overlay' ) !== false ):
    	$choices = array(
			'no-overlay' => __( 'No Overlay', SCM_THEME ),
			'overlay' => __( 'Overlay', SCM_THEME ),
			'underlay' => __( 'Underlay', SCM_THEME ),
		);

	elseif( strpos( $list, 'units' ) !== false ):
    	$choices = array(
    		'px' => 'px',
    		'%' => '%',
			'em' => 'em',
		);

    elseif( strpos( $list, 'headings' ) !== false ):

    	$max = array(
			'h2' => __( 'Primario', SCM_THEME ),
			'h3' => __( 'Secondario', SCM_THEME ),
			'h4' => __( 'Terziario', SCM_THEME ),
		);

    	$min = array(
			'p' => 'p',
			'span' => 'span',
			'strong' => 'strong',
		);

    	$low = array(
			'p' => 'p',
			'span' => 'span',
			'strong' => 'strong',
			'div' => 'div',
			'h6' => 'h6',
			'h5' => 'h5',
			'h4' => 'h4',
			'h3' => 'h3',
			'h2' => 'h2',
			'h1' => 'h1',
		);

    	$choices = array(
			'h1' => 'h1',
			'h2' => 'h2',
			'h3' => 'h3',
			'h4' => 'h4',
			'h5' => 'h5',
			'h6' => 'h6',
			'.h7' => '.h7',
			'.h8' => '.h8',
			'.h9' => '.h9',
			'.h0' => '.h0',
			'strong' => 'strong',
			'div' => 'div',
			'span' => 'span',
			'p' => 'p',
		);

		if( strpos( $list, 'headings_low' ) !== false ){
			$choices = $low;
		}else if( strpos( $list, 'headings_min' ) !== false ){
			$choices = $min;
		}else if( strpos( $list, 'headings_max' ) !== false ){
			$choices = $max;
		};

	elseif( strpos( $list, 'columns_width' ) !== false ):
		$choices = array(
			'1/1' => '1/1',
			'1/2' => '1/2',
			'1/3' => '1/3',
			'2/3' => '2/3',
			'1/4' => '1/4',
			'3/4' => '3/4',
			'1/5' => '1/5',
			'2/5' => '2/5',
			'3/5' => '3/5',
			'4/5' => '4/5',
			'1/6' => '1/6',
			'5/6' => '5/6',
		);

	elseif( strpos( $list, 'txt_size' ) !== false ):
		$choices = array(
			'100%' => 'Normal',
			'60%' => 'XXX-Small',
			'70%' => 'XX-Small',
			'80%' => 'X-Small',
			'90%' => 'Smaller',
			'95%' => 'Small',
			'105%' => 'Medium',
			'110%' => 'Large',
			'120%' => 'X-Large',
			'130%' => 'XX-Large',
			'140%' => 'XXX-Large',
			'150%' => 'Big',
			'160%' => 'X-Big',
			'170%' => 'XX-Big',
			'180%' => 'XXX-Big',
			'200%' => 'Huge',
		);

	elseif( strpos( $list, 'txt_font_size' ) !== false ):
		$choices = array(
			'16px' => 'Normal',
			'10px' => 'XXX-Small',
			'11px' => 'XX-Small',
			'12px' => 'X-Small',
			'13px' => 'Smaller',
			'15px' => 'Small',
			'17px' => 'Medium',
			'18px' => 'Large',
			'19px' => 'X-Large',
			'20px' => 'XX-Large',
			'21px' => 'XXX-Large',
			'22px' => 'Big',
			'23px' => 'X-Big',
			'24px' => 'XX-Big',
			'25px' => 'XXX-Big',
			'26px' => 'Huge',
		);
	
	elseif( strpos( $list, 'main_layout' ) !== false ):
		$choices = array(
			'responsive'		=> 'Responsive',
			'full'				=> 'Full Width',
		);
	
	elseif( strpos( $list, 'responsive_events' ) !== false ):

		if( strpos( $list, '_width' ) !== false ):
			$choices = array(
				'500px'			=> 'Mobile Min',
				'600px'			=> 'Mobile Mid',
				'700px'			=> 'Mobile',
				'800px'			=> 'Tablet Portrait',
				'940px'			=> 'Notebook',
				'1030px'		=> 'Tablet Landscape',
				'1120px'		=> 'Desktop',
			);
		
		else:
			$choices = array(
				'smartmin'		=> 'Mobile Min',
				'smartmid'		=> 'Mobile Mid',
				'smart'			=> 'Mobile',
				'portrait'		=> 'Tablet Portrait',
				'notebook'		=> 'Notebook',
				'tablet'		=> 'Tablet Landscape',
				'desktop'		=> 'Desktop',
			);

		endif;

	elseif( strpos( $list, 'responsive_up' ) !== false ):
		$choices = array(
			'smartmin'																=> 'Mobile Min',
			'smartmin smartmid'														=> 'Mobile Mid',
			'smartmin smartmid smart'												=> 'Mobile',
			'smartmin smartmid smart portrait'										=> 'Tablet Portrait',
			'smartmin smartmid smart portrait notebook'								=> 'Notebook',
			'smartmin smartmid smart portrait notebook landscape'					=> 'Tablet Landscape',
			'smartmin smartmid smart portrait notebook landscape desktop'			=> 'Desktop',
			'smartmin smartmid smart portrait notebook landscape desktop wide'		=> 'Wide',
		);

	elseif( strpos( $list, 'responsive_down' ) !== false ):
		$choices = array(
			'wide desktop landscape notebook portrait smart smartmid smartmin'		=> 'Mobile Min',
			'wide desktop landscape notebook portrait smart smartmid'				=> 'Mobile Mid',
			'wide desktop landscape notebook portrait smart'						=> 'Mobile',
			'wide desktop landscape notebook portrait'								=> 'Tablet Portrait',
			'wide desktop landscape notebook'										=> 'Notebook',
			'wide desktop landscape'												=> 'Tablet Landscape',
			'wide desktop'															=> 'Desktop',
			'wide'																	=> 'Wide',
		);

	elseif( strpos( $list, 'responsive_layouts' ) !== false ):
		$choices = array(
			'1400px'			=> '1250px',
			'1120px'			=> '1120px',
			'1030px'			=> '1030px',
			'940px'				=> '940px',
			'800px'				=> '800px',
			'700px'				=> '700px',
			'600px'				=> '600px',
		);
	
	elseif( strpos( $list, 'bg_repeat' ) !== false ):
		$choices = array(
			'no-repeat'			=> 'No repeat',
			'repeat'			=> 'Repeat',
			'repeat-x'			=> 'Repeat x',
			'repeat-y'			=> 'Repeat y',
		);
	
	elseif( strpos( $list, 'bg_position' ) !== false ):
		$choices = array(
			'center center'			=> 'center center',
			'center top'			=> 'center top',
			'center bottom'			=> 'center bottom',
			'left center'			=> 'left center',
			'left top'				=> 'left top',
			'left bottom'			=> 'left bottom',
			'right center'			=> 'right center',
			'right top'				=> 'right top',
			'right bottom'			=> 'right bottom',
		);

	elseif( strpos( $list, 'webfonts_adobe' ) !== false ):
		if( strpos( $list, 'webfonts_adobe_styles' ) !== false ):
			$choices = array(
				'n1' => 'Thin',
				'i1' => 'Thin Italic',
				'n3' => 'Light',
				'i3' => 'Light Italic',
				'n4' => 'Normal',
				'i4' => 'Normal Italic',
				'n6' => 'Semi Bold',
				'i6' => 'Semi Bold Italic',
				'n7' => 'Bold',
				'i7' => 'Bold Italic',
				'n8' => 'Extra Bold',
				'i8' => 'Extra Bold Italic',
				'n9' => 'Ultra Bold',
				'i9' => 'Ultra Bold Italic',
			);

		else:
			global $SCM_typekit;

			if( $SCM_typekit ):
				$choices = array('no' => 'No Adobe font');
				$kits = scm_field( 'styles-adobe', array(), 'option' );
				foreach ( $kits as $field):
					$kit = $SCM_typekit->get( $field['id'] );
					if( !$kit || !$kit['kit'] ) continue;
					foreach( $kit['kit']['families'] as $family)
						$choices[$family['slug']] = $family['name'];

				endforeach;

			endif;

		endif;

	elseif( strpos( $list, 'webfonts_google' ) !== false ):
		if( strpos( $list, 'webfonts_google_styles' ) !== false ):
			$choices = array(
				'100,' => 'Thin',
				'100italic,' => 'Thin Italic',
				'300,' => 'Light',
				'300italic,' => 'Light Italic',
				'400,' => 'Normal',
				'400italic,' => 'Normal Italic',
				'600,' => 'Semi Bold',
				'600italic,' => 'Semi Bold Italic',
				'700,' => 'Bold',
				'700italic,' => 'Bold Italic',
				'800,' => 'Extra Bold',
				'800italic,' => 'Extra Bold Italic',
				'900,' => 'Ultra Bold',
				'900italic,' => 'Ultra Bold Italic',
			);

		else:
			$choices = array('no' => 'No Google font');
			$fonts = scm_field( 'styles-google', array(), 'option' );
			foreach( $fonts as $font)
				$choices[$font['family']] = $font['family'];

		endif;

	elseif( strpos( $list, 'webfonts_fallback' ) !== false ):
		$choices = array(
			'Helvetica_Arial_sans-serif'						=> 'Helvetica, Arial, sans-serif',
			'Lucida Sans Unicode_Lucida Grande_sans-serif'		=> 'Lucida Sans Unicode, Lucida Grande, sans-serif',
			'Trebuchet MS_Helvetica_sans-serif'					=> 'Trebuchet MS, Helvetica, sans-serif',
			'Verdana_Geneva_sans-serif'							=> 'Verdana, Geneva, sans-serif',
			'Georgia_serif'										=> 'Georgia, serif',
			'Times New Roman_Times_serif'						=> 'Times New Roman, Times, serif',
			'Palatino Linotype_Book Antiqua_Palatino_serif'		=> 'Palatino Linotype, Book Antiqua, Palatino, serif',
			'cursive_serif'										=> 'cursive, serif',
			'Courier New_Courier_monospace'						=> 'Courier New, Courier, monospace',
			'Lucida Console_Monaco_monospace'					=> 'Lucida Console, Monaco, monospace',
		);

	elseif( strpos( $list, 'font_weight' ) !== false ):
		$choices = array(
			'lighter' => 'Light',
			'normal' => 'Normal',
			'bold' => 'Bold',
		);

	elseif( strpos( $list, 'line_height' ) !== false ):
		$choices = array(
			'0-0' => __( 'Nessuno spazio', SCM_THEME ),
			'0-25' => __( '1 quarto di linea', SCM_THEME ),
			'0-5' => __( 'Mezza linea', SCM_THEME ),
			'1-0' => __( 'Una linea', SCM_THEME ),
			'1-25' => __( 'Una linea e 1 quarto', SCM_THEME ),
			'1-5' => __( 'Una linea e mezza', SCM_THEME ),
			'1-75' => __( 'Una linea e 3 quarti', SCM_THEME ),
			'2-0' => __( 'Doppia linea', SCM_THEME ),
			'2-5' => __( 'Doppia linea e mezza', SCM_THEME ),
			'3-0' => __( 'Tripla linea', SCM_THEME ),
			'4-0' => __( 'Quadrupla linea', SCM_THEME ),
		);

	elseif( strpos( $list, 'slider_model' ) !== false ):
		$choices = array(
			'nivo' => 'Nivo Slider',
			'bx' => 'BX Slider',
		);

	elseif( strpos( $list, 'effect' ) !== false ):
		if( strpos( $list, '_nivo' ) !== false ):
			$choices = array(
				'sliceDown' => __( 'Slice Down', SCM_THEME ),
				'sliceDownLeft' => __( 'Slice Down Left', SCM_THEME ),
				'sliceUp' => __( 'Slice Up', SCM_THEME ),
				'sliceUpLeft' => __( 'Slice Up Left', SCM_THEME ),
				'sliceUpDown' => __( 'Slice Up Down', SCM_THEME ),
				'sliceUpDownLeft' => __( 'Slice Up Down Left', SCM_THEME ),
				'fold' => __( 'Fold', SCM_THEME ),
				'fade' => __( 'Fade', SCM_THEME ),
				'random' => __( 'Random', SCM_THEME ),
				'slideInRight' => __( 'Slide In Right', SCM_THEME ),
				'slideInLeft' => __( 'Slide In Left', SCM_THEME ),
				'boxRandom' => __( 'Box Random', SCM_THEME ),
				'boxRain' => __( 'Box Rain', SCM_THEME ),
				'boxRainReverse' => __( 'Box Rain Reverse', SCM_THEME ),
				'boxRainGrow' => __( 'Box Rain Grow', SCM_THEME ),
				'boxRainGrowReverse' => __( 'Box Rain Grow Reverse', SCM_THEME ),
			);
		
		endif;

	elseif( strpos( $list, 'themes_nivo' ) !== false ):
		$choices = array(
			'scm' 		=> 'SCM',
		);

	elseif( strpos( $list, 'box_shape' ) !== false ):
		$choices = array(
			'square' 		=> __( 'Quadrato', SCM_THEME ),
			'circle' 		=> __( 'Cerchio', SCM_THEME ),
			'rounded' 		=> __( 'Arrotondato', SCM_THEME ),
		);

	elseif( strpos( $list, 'simple_size' ) !== false ):
		$choices = array(
			'normal' 	=> __( 'Normale', SCM_THEME ),
			'min' 		=> __( 'Minimo', SCM_THEME ),
			'small' 	=> __( 'Piccolo', SCM_THEME ),
			'medium' 	=> __( 'Medio', SCM_THEME ),
			'big' 		=> __( 'Grande', SCM_THEME ),
			'max' 		=> __( 'Massimo', SCM_THEME ),
		);

	elseif( strpos( $list, 'date_format' ) !== false ):
		$choices = array(
			'dmy' 		=> '31 12 15',
			'dmY' 		=> '31 12 2015',
			'd F Y' 	=> __( '31 Dicembre 2015', SCM_THEME ),
			'd M y' 	=> __( '31 Dic 15', SCM_THEME ),
			'ymd' 		=> '15 12 31',
			'Ymd' 		=> '2015 12 31',
		);
	
	elseif( strpos( $list, 'box_angle_type' ) !== false ):
		$choices = array(
			'all' 					=> __( 'Tutti', SCM_THEME ),
			'round-top' 			=> __( 'Sopra', SCM_THEME ),
			'round-left' 			=> __( 'Sinistra', SCM_THEME ),
			'round-right' 			=> __( 'Destra', SCM_THEME ),
			'round-bottom' 			=> __( 'Sotto', SCM_THEME ),
			'round-leaf-left' 		=> __( 'Foglia A', SCM_THEME ),
			'round-leaf-right' 		=> __( 'Foglia B', SCM_THEME ),
			'round-petal-left' 		=> __( 'Petalo A', SCM_THEME ),
			'round-petal-right' 	=> __( 'Petalo B', SCM_THEME ),
			'round-drop-left' 		=> __( 'Petalo C', SCM_THEME ),
			'round-drop-right' 		=> __( 'Petalo D', SCM_THEME ),
			'round-head-left' 		=> __( 'Singolo A', SCM_THEME ),
			'round-head-right' 		=> __( 'Singolo B', SCM_THEME ),
			'round-foot-left' 		=> __( 'Singolo C', SCM_THEME ),
			'round-foot-right' 		=> __( 'Singolo D', SCM_THEME ),
		);

	elseif( strpos( $list, 'ease' ) !== false ):
		$choices = array(
			'swing' 			=> 'Swing',
			'linear' 			=> 'Linear',
			'easeInQuad' 		=> 'Quad In',
			'easeOutQuad' 		=> 'Quad Out',
			'easeInOutQuad' 	=> 'Quad InOut',
			'easeInCubic' 		=> 'Cubic In',
			'easeOutCubic' 		=> 'Cubic Out',
			'easeInOutCubic' 	=> 'Cubic InOut',
			'easeInQuart' 		=> 'Quart In',
			'easeOutQuart' 		=> 'Quart Out',
			'easeInOutQuart' 	=> 'Quart InOut',
			'easeInQuint' 		=> 'Quint In',
			'easeOutQuint' 		=> 'Quint Out',
			'easeInOutQuint' 	=> 'Quint InOut',
			'easeInExpo' 		=> 'Expo In',
			'easeOutExpo' 		=> 'Expo Out',
			'easeInOutExpo' 	=> 'Expo InOut',
			'easeInSine' 		=> 'Sine In',
			'easeOutSine' 		=> 'Sine Out',
			'easeInOutSine' 	=> 'Sine InOut',
			'easeInCirc' 		=> 'Circ In',
			'easeOutCirc' 		=> 'Circ Out',
			'easeInOutCirc' 	=> 'Circ InOut',
			'easeInElastic' 	=> 'Elastic In',
			'easeOutElastic' 	=> 'Elastic Out',
			'easeInOutElastic' 	=> 'Elastic InOut',
			'easeInBack' 		=> 'Back In',
			'easeOutBack' 		=> 'Back Out',
			'easeInOutBack' 	=> 'Back InOut',
			'easeInBounce' 		=> 'Bounce In',
			'easeOutBounce' 	=> 'Bounce Out',
			'easeInOutBounce' 	=> 'Bounce InOut',
		);

	elseif( strpos( $list, 'roles' ) !== false ):
		$choices = getRoles();
	
	endif;

	if( $get )
		return ( isset( $choices[$get] ) ? $choices[$get] : '' );

	return $choices;
}

?>