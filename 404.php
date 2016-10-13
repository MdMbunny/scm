<?php

/**
 * 404.php
 *
 * Redirect to Part None.
 *
 * @link http://www.studiocreativo-m.it
 *
 * @package SCM
 * @subpackage Root/Templates
 * @since 1.0.0
 */

do_action( 'scm_action_404', $_SERVER['REQUEST_URI'] );

get_template_part( SCM_DIR_PARTS, 'none' );

?>