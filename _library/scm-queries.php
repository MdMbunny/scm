<?php

// Needs:
//		scm.php
//		scm-functions.php



/*******************************************************************/

/**
* SHORTCODES
*/

function scm_list_shortcode( $atts, $content = null ) {

	global $paged;

    $a = shortcode_atts( array(
    	'layout' => 'default',
    	'type' => null,
    	'tax' => '',
    	'cat' => '',
    	'ids' => '',
    	'class' => '',
        'title' => null,
        'order' => 'new',
        'inline' => false,
        'align' => 'center',
        'icon' => 1,
        'atitle' => '',
        'more' => 0,
        'moreicon' => 'archive',
        'pagination' => false,
        'perpage' => -1,
        'filesize' => 1,
        'nopost' => true,
        'dateclass' => '',
    	'dateformat' => null,
    	'datein' => 0,
    	'big' => 0
    ), $atts );
	
	$type = $a['type'];
	if(!$type) return null;
	if(strpos($type, ' ')) $type = explode(' ', $type);


	$layout = $a['layout'];
	$tax = $a['tax'];
	$cat = $a['cat'];
	$ids = $a['ids'];
	$class = $a['class'];
	$align = $a['align'];
	$icon = $a['icon'];
	$title = $a['title'];
	$order = $a['order'];
	$atitle = $a['atitle'];
	$more = $a['more'];
	$moreicon = $a['moreicon'];
	$inline = $a['inline'];
	$pagination = $a['pagination'];
	$per_page = $a['perpage'];
	$filesize = $a['filesize'];
	$nopost = $a['nopost'];
	$dateclass = $a['dateclass'];
	$dateformat = $a['dateformat'];
	$datein = $a['datein'];
	$big = $a['big'];
	$h = 'h2';

	$paged = 1;
	
	if($pagination){
		$paged = ( get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1 );
	}

	if($big){
		$class .= ' big';
		$h = 'h1';
	}

	$ownClass = implode(' ', SCM('class'));
	$class .= ' ' . $ownClass;

	if($ids != ''){
		$ids = explode(" ", $ids);
	}

	if( $inline == false ) $class .= ' column-list';
	elseif( $inline == true ) $class .= ' inline-list';

	$orderMethod = array(
		'all'    => array( 'new', 'old', 'name', 'random' ),
		'new'    => array( 'date', 'DESC' ),
		'old'    => array( 'date', 'ASC' ),
		'name'   => array( 'title', 'ASC' ),
		'random' => array( 'rand', '' )
	);

	$order       = ( in_array( $order, $orderMethod['all'] ) ) ? ( $orderMethod[$order] ) : ( $orderMethod['new'] );

	wp_reset_query();

    $pargs = array(
	'post_type' => $type,
	'orderby' => $order[0],
	'order' => $order[1],
	'posts_per_page' => $per_page,
	'paged' => $paged,
	'ignore_sticky_posts' => 1,
	'post__in' => $ids,
	'post_status' => 'publish',
    );
    
    if($tax == 'categorie' || $tax == 'tags' || $tax == 'categories' || $tax == 'tag' || $tax == 'categoria' || $tax == 'category' || $tax == 'cat'){
    	$tax .= '-' . $type;
    	$pargs[$tax] = $cat;
    }

	$loop = new WP_Query( $pargs );
	$pagination = ( $pagination ) ? ( scm_pagination( $loop, array( 'print' => false ) ) ) : ( '' );
	$paginationClass = ( $pagination ) ? ( ' paginated' ) : ( '' );

	$haveposts = $loop->have_posts();



	if ( $haveposts || $nopost ) {
		$ret = '';
		$ret .= '<div class="clearfix custom-list ' . $layout . ' ' . $type . '-shortcode ' . $class . $paginationClass . '">';
			if($title) $ret .= '<' . $h . '>' . $title . '</' . $h . '>';
			if($content) $ret .= '<div class="' . $ownClass . ' descrizione">' . $content . '</div>';
			$ret .= '<ul class="' . $ownClass . ' ' . $type . '-list ' . $align . '">';
			if ( !$haveposts ) {
				$ret .= '<li class="underconstruction">' . _e( 'Sezione in aggiornamento', SCM_THEME ) . '</li>';
				$ret .= '</ul>';
			}else{
					while ( $loop->have_posts() ) : $loop->the_post();
						$ret .= '<li class="' . $ownClass . ' ' . $type . '-element">';
							$ret .= do_shortcode('[scm-link layout="' . $layout . '" class="' . $align . ' " type="' . $type . '" filesize="' . $filesize . '" icon="' . $icon . '" atitle="' . $atitle . '" dateclass="' . $dateclass . '" dateformat="' . $dateformat . '" datein="' . $datein . '" /]');
						$ret .= '</li>';
					endwhile;
				$ret .= '</ul>';
				if($more){
					$arch = __( 'Archivio', SCM_THEME );
					$archtit = $arch . ' ' . $title;
					$archurl = get_post_type_archive_link( $type );
					$ret .= '<a class="' . $ownClass . ' custom-more" href="' . $archurl . '" alt="' . $archtit . '" title="' . $archtit . '"><span>';
					if($moreicon && $moreicon != '') $ret .= '<i class="fa fa-' . $icn . '"></i> ';
					if($more == 1) $ret .=  $arch;
					elseif($more == 2) $ret .= $archtit;
					$ret .=  '</span></a>';
				}

			}
		$ret .= '</div>';
		$ret .= $pagination;
	}

	wp_reset_query();
    return $ret;
}

add_shortcode( 'scm-list', 'scm_list_shortcode' );

function scm_link_shortcode( $atts, $content = null ) {
	
	$a = shortcode_atts( array(
		'layout' => 'default',
    	'class' => '',
    	'icon' => null,
    	'filesize' => 1,
    	'type' => null,
    	'id' => null,
    	'cont' => null,
    	'atitle' => '',
    	'url' => '',
    	'dateclass' => '',
    	'dateformat' => null,
    	'datein' => 0,
    	'noextra' => 0,
    ), $atts );

	$ownClass = implode(' ', SCM('class'));

    $class = $a['class'];
    $layout = $a['layout'];
	$filesize = $a['filesize'];
	$icon = $a['icon'];
	$atitle = $a['atitle'];
	//$url = $a['url'];
	$dateclass = $a['dateclass'];
	$dateformat = explode(' ', $a['dateformat']);
	$datein = $a['datein'];
	$noextra = $a['noextra'];

	$id = $a['id'];
	$type = $a['type'];
	$cont = $a['cont'];

    if($id == null) $id = get_the_ID();
	
    if(!$type) $type = get_post_type( $id );
    
    if(!$cont) $cont = $content;
    if(!$cont) $cont = get_the_title($id);   

	$img = get_field('image', $id );

	$url = get_field('link', $id );
	
	$current_id = $id;
	$current_type = $type;
    if(is_array($url)){
    	$current_id = $url[0];
    	$current_type = get_post_type( $current_id );
    }
    
    $islink = 1;

    if($a['url'] != ''){
    	$url = $a['url'];
    	if($type == 'attachment'){
    		$islink = 0;
    	}
    }else{
    	$url = get_field('link', $current_id );
		if(!$url){
			$url = get_field( 'file', $current_id );
			$islink = 0;
		}
	}
	/*$isinternal = strpos( $url, scmTerms('domain') );*/
	$isinternal = strpos( $url, SCM_DOMAIN );
	if($url) $url = addHTTP($url);

	//$format = SCM_format($url, $current_type, $islink, $isinternal);


	// VIA NEWS DA MEDIA

	$format = get_field('media', 'formats', $current_type); ///////
	$name = $format['name'];
	$icn = $format['icon'];
	$tit = $format['title'];
	$ext = $format['ext'];
	$trg = $format['target'];
	$popup = $format['popup'];
	$islink = $format['islink'];
	$isfile = $format['isfile'];
	$perma = $format['perma'];
	$size = null;
	
	if($name == 'gallerie'){
	    $urls = getGalleryUrls($current_id);
		$size = sizeof($urls) . ' Foto';
		$url = 'var images = [' . getGalleryUrlsInline($current_id) . ']; jQuery.prettyPhoto.open(images)';
	}elseif($name == 'video'){
		$size = gmdate("H:i:s", getYouTubeDuration($url));
		$url = 'jQuery.prettyPhoto.open(\'' . $url . '\')';
	}elseif($name == 'file'){
		$sext = $ext;
		$ext = substr ( $url , strrpos ( $url , '.' , -1 ) + 1 );
		$tit = 'Download ' . strtoupper($ext);
		if($ext == 'pdf') $icn = 'file-pdf-o';
		elseif($ext == 'doc' || $ext == 'docx') $icn = 'file-word-o';
		elseif($ext == 'txt' || $ext == 'rtf') $icn = 'file-text-o';
		elseif($ext == 'ppt' || $ext == 'pptx' || $ext == 'pps' || $ext == 'ppsx') $icn = 'file-powerpoint-o';
		elseif($ext == 'xls' || $ext == 'xlsx') $icn = 'file-excel-o';
		elseif($ext == 'png' || $ext == 'gif' || $ext == 'jpg') $icn = 'file-image-o';
		elseif($ext == 'zip' || $ext == 'rar') $icn = 'file-archive-o';
		elseif($ext == 'mp4' || $ext == 'mov') $icn = 'file-video-o';
		else $ext = $sext;
		$head = array_change_key_case(get_headers($url, TRUE));
		$size = fileSizeConvert($head['content-length'], 0);
	}elseif($perma){
		$url = get_permalink($current_id);
	}
    
    if($atitle == 'url') $tit = $url;
    elseif($atitle == '' && $tit == '') $tit = $cont;
    
    if(!$filesize) $size = null;
    if(!$icon) $icn = null;

    $ret = '';

    if(!$noextra && $type == 'news' && !$datein) $ret .= getNewsDate($id , $dateclass, $dateformat);

    if ($popup){
    	$ret .= '<a href="#" onClick="' . $url . '" title="' . $tit . '" alt="' . $tit . '" class="scm-link ' . $class . ' ' . $ext . ' ' . $icn . '">';
 	}
	else $ret .= '<a href="' . $url . '" target="' . $trg . '" title="' . $tit . '" alt="' . $tit . '" class="scm-link ' . $class . '">';

		if(!$noextra && $type == 'news' && $datein) $ret .= getNewsDate($id , $dateclass, $dateformat);

		if($icn) $ret .= '<i class="fa fa-' . $icn . '"></i> ';
		if(!$noextra && $size) $ret .= '<strong class="' . $ownClass . ' small filesize">' . $size . '</strong>';		

		if($layout != 'thumb') $ret .= $cont;

		$ret .= '<div class="' . $ownClass . ' clearfix"></div>';

		$autore = get_field( "autore" );
		if(!$noextra && $autore){
			$ret .= '<span class="' . $ownClass . ' small align-left autore">';
				$ret .= 'di <strong>' . $autore . '</strong>';
			$ret .= '</span>';
		}

		if(!$noextra && strpos($layout,'thumb') !== false && $img) $ret .= '<div class="' . $ownClass . ' image"><img src="' . $img . '"></div>';

		if(!$noextra && $type == 'news') $ret .= getNewsInfo($id);
	$ret .= '</a>';

	if(!$noextra && $type == 'rassegna-stampa') $ret .= getRassegnaInfo($id);

	return $ret;

}
add_shortcode( 'scm-link', 'scm_link_shortcode' );

function scm_news_single_shortcode( $atts, $content = null ) {
	$a = shortcode_atts( array(
    	'title' => 'News',
    	'id' => null,
    	'icon' => 1,
    	'class' => '',
    	'opening' => null,
    	'dateclass' => '',
    	'dateformat' => null,
    	'datein' => null,
    	'datebelow' => null,
    	'back' => 0,
    	'backclass' => '',
    ), $atts );
	
	$back = $a['back'];
	$backclass = $a['backclass'];
	$title = $a['title'];
	$icon = $a['icon'];
	$class = $a['class'];
	$opening = $a['opening'];
	$datein = $a['datein'];
	$datebelow = $a['datebelow'];
	$dateclass = $a['dateclass'];
	$dateformat = explode(' ', $a['dateformat']);

	$ownClass = implode(' ', SCM('class'));
    $class .= ' ' . $ownClass;
    
	$id = $a['id'];
    if($id == null) $id = get_the_ID();
    $cont = get_field('content', $id );
    if(!$cont) $cont = $content;
	$img = get_field('image', $id );
	$type = get_post_type( $id );

	$format = get_field('media', 'formats', $type);
	$name = $format['name'];
	$icn = $format['icon'];
	
    if(!$icon) $icn = null;	

    $ret = '';

    if($opening){
    	$ret .= '<h1>' . $opening . '</h1>';
    	if($back){
			$ret .= do_shortcode('[back-button class="' . $backclass . '"]' . __( 'Indietro', SCM_THEME ) . '[/back-button]');
			$ret .= '<div class="clearfix"></div>';
    	}
    }

    if(!$datein && !$datebelow) $ret .= getNewsDate($id, $dateclass, $dateformat);

	$ret .= '<div class="news-main ' . $class . '">';

		if($datein && !$datebelow) $ret .= getNewsDate($id, $dateclass, $dateformat);
		
		$ret .= '<h2 class="' . $ownClass . ' news-title">';
			if($icn) $ret .= '<i class="fa fa-' . $icn . '"></i> ';
			$ret .= $title;
		$ret .= '</h2>';
		if($img) $ret .= '<div class="' . $ownClass . ' news-image"><img src="' . $img . '"></div>';
		$ret .= '<div class="' . $ownClass . ' news-content descrizione">' . $cont . '</div>';

		$ret .= '<div class="' . $ownClass . ' clearfix"></div>';

		if($datein && $datebelow) $ret .= getNewsDate($id, $dateclass, $dateformat);	

	$ret .= '</div>';

	if(!$datein && $datebelow) $ret .= getNewsDate($id, $dateclass, $dateformat);

	$ret .= '<div class="block att_share att_last">';
		$ret .= '<div class="att_par_title att_condividi">Condividi</div>';
		$ret .= do_shortcode('[ssba]');
	$ret .= '</div>';

	return $ret;

}
add_shortcode( 'news-single', 'scm_news_single_shortcode' );


function scm_attachments_shortcode( $atts, $content = null ) {
	
	$a = shortcode_atts( array(
    	'heading' => 'h2',
    	'class' => '',
    	'headingclass' => '',
    ), $atts );
	
	
	$heading = $a['heading'];
	$class = $a['class'];
	$classh = $a['headingclass'];

	
	// array(array(allegato => www...it, nome_allegato => nome ), ... );
	$att = get_field('link_allegati');
	// array(array(link => www...it, nome_link => nome ), ... );
	$ext = get_field('link_esterni');
	// array(id, id, id, ...)
	$int = get_field('link_interni');
	
	$ret = '';

	if($att){
		$ret .= '<div class="menu link_menu att_menu">';
		$ret .= '<' . $heading . ' class="attachments-heading ' . $classh . '">' . _e( 'Allegati', SCM_THEME ) . '</' . $heading . '>';
		foreach ($att as $elema) {
			$ret .= do_shortcode('[scm-link noextra=1 class="' . $class . '" type="attachment" icon=1 url="' . $elema['allegato'] . '" ]' . $elema['nome-allegato'] . '[/scm-link]');
		}
		$ret .= '</div>';
	}
	if($ext){
		$ret .= '<div class="menu link_menu ext_menu">';
		$ret .= '<' . $heading . ' class="attachments-heading ' . $classh . '">' . _e( 'Link esterni', SCM_THEME ) . '</' . $heading . '>';
		foreach ($ext as $elemb) {
			$ret .= do_shortcode('[scm-link noextra=1 class="' . $class . '" type="link" icon=1 url="' . $elemb['link'] . '" ]' . $elemb['nome-link'] . '[/scm-link]');
		}
		$ret .= '</div>';
	}
	if($int){
		$ret .= '<div class="menu link_menu int_menu">';
		$ret .= '<' . $heading . ' class="attachments-heading ' . $classh . '">' . _e( 'Link interni', SCM_THEME ) . '</' . $heading . '>';
		foreach ($int as $elemc) {
			$ret .= do_shortcode('[scm-link noextra=1 class="' . $class . '" icon=1 id="' . $elemc . '" /]');
		}
		$ret .= '</div>';
	}

	return $ret;
}

add_shortcode( 'scm-attachments', 'scm_attachments_shortcode' );

/*******************************************************************/

/**
* Elementi aggiuntivi al link (top e bottom)
*/

function getNewsDate( $id, $class, $frm ) {

    $tcode = get_the_time('c', $id);
    $tfull = get_the_time('', $id);
    $tm = get_the_time('M', $id);
    $td = get_the_time('d', $id);
    $ty = get_the_time('Y', $id);
    $th = get_the_time('H:i', $id);
    if(!$frm || sizeof($frm)<=0) $frm = array('month', 'day', 'year', 'time');
    $arr = array();

    $m = getByValue($frm, 'month');
    $arr[$m] = array('month', $tm);
    $d = getByValue($frm, 'day');
    $arr[$d] = array('day', $td);
    $y = getByValue($frm, 'year');
    $arr[$y] = array('year', $ty);
    $t = getByValue($frm, 'time');
    $arr[$t] = array('time', $th);

	$ret = '';
	
	$ret .= '<footer class="' . $class . ' date-special">';
		// class date removed VVV
		$ret .= '<time datetime="' . $tcode . '" title="' . $tfull . '">';
			if($arr[0]>-1) $ret .= '<span class="' . $arr[0][0] . '">' . $arr[0][1] . '</span>';
			if($arr[1]>-1) $ret .= '<span class="' . $arr[1][0] . '">' . $arr[1][1] . '</span>';
			if($arr[2]>-1) $ret .= '<span class="' . $arr[2][0] . '">' . $arr[2][1] . '</span>';
			if($arr[3]>-1) $ret .= '<span class="' . $arr[3][0] . '">' . $arr[3][1] . '</span>';
		$ret .= '</time>';
	$ret .= '</footer>';

	return $ret;
}


function getRassegnaInfo( $id ) {
	
	$testata = get_field( 'testata', $id );
	$data = get_field( 'data', $id );
	
	$ret = '';

	$ret .= '<ul class="inline-list line">';
		
	if($testata){
		$ret .= '<li class="small align-left testata">';
			$ret .= $testata;
		$ret .= '</li>';
	}
	if($data){
		$ret .= '<li class="small align-right data">';
			$ret .= $data;
		$ret .= '</li>';
	}
	$ret .= '</ul>';

	return $ret;
}

function getNewsInfo( $id ) {
	$testo = get_field('excerpt', $id );
	if(!$testo || $testo == '') return '';
	$ret = '<span class="excerpt">' . $testo . '</span>';
	return $ret;
}

/*******************************************************************/

/**
* Estrapola img url da Content e restituisce un Array di URL
*/

function getGallery( $id ) {
	$images = get_field('immagini', $id);
	return $images;
}

function getGalleryUrls( $id ) {
	$images = getGallery($id);

	$arr = array();
	foreach ($images as $image) {
		array_push($arr,$image['url']);		
	}
	return $arr;
}

function getGalleryUrlsInline( $id ) {
	$images = getGalleryUrls($id);
	$url = '';
	foreach ($images as $key => $value) {
		$url .= '\'' . $value . '\', ';
	}
	return $url;
}
?>