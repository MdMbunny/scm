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

do_action( 'scm_action_content_none', get_option( 'scm-screen' ) );

wp_redirect( home_url() );
exit();

?>