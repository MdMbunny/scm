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
/*	acf.add_action('ready append', function( $el ){

	// search $el for fields of type 'image'
	acf.get_fields({ type : 'image'}, $el).each(function(){
		
		// ru the initialize_field function on each found field 
		initialize_field( $(this) );
	
	});

});*/
		?>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					jQuery('div[data-name=select_columns_width] .acf-input input[type=hidden].select2-offscreen').each(function(){
							var value = jQuery(this).val();
							var parent = jQuery(this).closest('.acf-row');
							parent.removeClass (function (index, css) {
							    return (css.match (/\bcolumn-\S+/g) || []).join(' ');
							});
							parent.addClass( 'column-' + value );
							//alert();
						});

					jQuery( '#poststuff' ).click(function(){
						jQuery('div[data-name=select_columns_width] .acf-input input[type=hidden].select2-offscreen').each(function(){
							var value = jQuery(this).val();
							var parent = jQuery(this).closest('.acf-row');
							parent.removeClass (function (index, css) {
							    return (css.match (/\bcolumn-\S+/g) || []).join(' ');
							});
							parent.addClass( 'column-' + value );
							//alert();
						});
					});

					/*jQuery('#acf-field_54b5ae0e69c35-54b657c98844a-field_54b5ae0e69c45').change( function() {
					    //alert jQuery(this).val(); // works
					    //var theSelection = $(test).filter(':selected').text(); // doesn't work
					    alert(jQuery('#select2-chosen-1').text());
					    //var theSelection = $(test).select2('data').text;
					    //$('#selectedID').text(theID);
					    //$('#selectedText').text(theSelection);
					});

					jQuery('.acf-field').click(function(){
						//alert(jQuery('.select2-offscreen').val());
					});*/


				});
			</script>
		<?php
		}
	}

?>