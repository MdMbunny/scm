<?php

/**
 * sidebar.php
 *
 * Template for the sidebar.
 *
 * @link http://www.studiocreativo-m.it
 *
 * @package SCM
 * @subpackage Root/Templates
 * @since 1.0.0
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</div><!-- #secondary -->
