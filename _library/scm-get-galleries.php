<?php

	header("Content-type: text/javascript");

	global $SCM_galleries;

	//consoleLog($SCM_galleries);

	echo json_encode( $SCM_galleries );

?>