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

				jQuery.fn.setColumnWidth = function(e){

					return this.each( function(){

						var $this = jQuery(this);
						var $parent = $this.closest('.acf-row');
						var value = $this.val();

						if( $parent.hasClass( 'column-' + value ) )
							return this;
						
						$parent.removeClass( function (index, css) {
						    return (css.match (/\bcolumn-\S+/g) || []).join(' ');
						} );

						$parent.addClass( 'column-' + value );

					} );

				}

				jQuery(document).ready(function(){

					var $elem = jQuery('div[data-name=select_columns_width] .acf-input input[type=hidden].select2-offscreen');
					$elem.setColumnWidth();

					jQuery( 'body' ).mouseenter( function(e){
						e.stopPropagation();
						jQuery('div[data-name=select_columns_width] .acf-input input[type=hidden].select2-offscreen').setColumnWidth(e);
						return false;
					});

				});

			</script>
		<?php
		}
	}

?>