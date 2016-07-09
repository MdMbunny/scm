<?php

/**
 * content-none.php
 *
 * Part None content.
 *
 * @link http://www.studiocreativo-m.it
 *
 * @package SCM
 * @subpackage Parts/None
 * @since 1.0.0
 */

if( strpos( SCM_SCREEN, '/API' ) )
	wp_redirect( SCM_URI_API );
else
	wp_redirect( home_url() );

exit();

?>