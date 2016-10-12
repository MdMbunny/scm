<?php

/**
 * content-import.php
 *
 * Part Import content.
 *
 * @link http://www.studiocreativo-m.it
 *
 * @package SCM
 * @subpackage Parts/Import
 * @since 1.0.0
 */

do_action( 'scm_action_content_import', $_SERVER['REQUEST_URI'] );

get_template_part( SCM_DIR_PARTS );

?>