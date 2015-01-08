<?php

/**
 * @package SCM
 */

?>

<?php get_header(); ?>

	<section class="error-404 not-found">
		<header class="page-header">
			<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', SCM_THEME ); ?></h1>
		</header><!-- .page-header -->

		<div class="page-content">
			<p><?php _e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', SCM_THEME ); ?></p>
		</div><!-- .page-content -->
	</section><!-- .error-404 -->

<?php get_footer(); ?>
