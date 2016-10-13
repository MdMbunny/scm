<?php

/**
 * archive.php
 *
 * Redirect to Part.
 *
 * @link http://www.studiocreativo-m.it
 *
 * @package SCM
 * @subpackage Root/Templates
 * @since 1.0.0
 */

do_action( 'scm_action_archive', $_SERVER['REQUEST_URI'] );

get_template_part( SCM_DIR_PARTS );

?>