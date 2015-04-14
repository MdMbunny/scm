<?php

	global $SCM_indent;
	indent( $SCM_indent+1, do_shortcode('[contact-form-7 id="' . get_the_ID() . '" title="' . get_the_title() . '"]'), 2 );

?>