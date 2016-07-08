<?php

/**
 * scm-setup-classes.php.
 *
 * SCM setup classes.
 *
 * @link http://www.studiocreativo-m.it
 *
 * @package SCM
 * @subpackage Setup/Classes
 * @since 1.0.0
 */

/** Typekit_Client Class, for Adobe TypeKit Fonts integration. */
require_once( SCM_DIR_CLASSES . 'Typekit_Client.php' );

/** Get_Template_Part Class, extend WP function for passing arguments. */
require_once( SCM_DIR_CLASSES . 'Get_Template_Part.php' );

/** Custom_Type Class, for managing Custom Post Types. */
require_once( SCM_DIR_CLASSES . 'Custom_Type.php' );

/** Custom_Taxonomy Class, for managing Custom Taxonomies. */
require_once( SCM_DIR_CLASSES . 'Custom_Taxonomy.php' );

?>