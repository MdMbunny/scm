<?php

//*****************************************************
//*
//	Add Class to Columns Select
//*
//*****************************************************


// *****************************************************
// ******* ACTIONS AND FILTERS
// *****************************************************


	add_action('admin_footer', 'scm_jquery_admin_columns_select');



// *****************************************************
// *      COLUMNS SELECT
// *****************************************************

	//Add Class to Columns Select
	if ( ! function_exists( 'scm_jquery_admin_columns_select' ) ) {
		function scm_jquery_admin_columns_select(){

		?>
			<script type="text/javascript">
				jQuery(document).ready(function(){

					jQuery('.acf-field').click(function(){
						//alert(jQuery('.select2-offscreen').val());
					});


				});
			</script>
		<?php
		}
	}

?>