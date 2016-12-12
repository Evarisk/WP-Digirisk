jQuery( document ).ready( function(){
	/**
	 * Transform default form into an ajax form for datas transfer treatment
	 */
	jQuery( "#wpdigi-datastransfer-form" ).ajaxForm({
		dataType: "json",
		beforeSubmit: function( formData, jqForm, options ) {
			/**	Adding loading class to form button	*/
			jqForm.children( "button.wp-digi-bton" ).addClass( "wp-digi-loading" );
		},
		success: function( responseText, statusText, xhr, $form ) {
			$form.children( "button.wp-digi-bton" ).removeClass( "wp-digi-loading" );
			if ( !responseText[ 'status' ] && responseText[ 'reload_transfert' ] ) {
				if ( 'element' == responseText[ 'sub_action' ] ) {
					jQuery( ".wpdigi-transfered-element-nb-" + responseText[ 'element_type' ] ).html( responseText[ 'main_element_nb' ] );
					if ( responseText[ 'main_element_nb' ] == jQuery( ".wpdigi-to-transfer-element-nb-" + responseText[ 'element_type' ] ).html() ) {
						jQuery( ".wp-digi-datastransfer-element-type-name-" + responseText[ 'element_type' ] ).addClass( 'dashicons-before dashicons-yes' );
					}
					jQuery( ".wpdigi-transfered-element-nb-" + responseText[ 'sub_element_type' ] ).html( responseText[ 'sub_element_nb' ] );
					if ( responseText[ 'sub_element_nb' ] == jQuery( ".wpdigi-to-transfer-element-nb-" + responseText[ 'sub_element_type' ] ).html() ) {
						jQuery( ".wp-digi-datastransfer-element-type-name-" + responseText[ 'sub_element_type' ] ).addClass( 'dashicons-before dashicons-yes' );
					}
					if ( undefined != ( responseText['treated_tree'] ) ) {
						jQuery( ".wpdigi-tree-check-" + responseText[ 'element_type' ] ).html( responseText['treated_tree'] );
					}
				} else {
					jQuery( ".wpdigi-transfered-element-nb-documents" ).html( responseText[ 'transfered' ] );
					jQuery( ".wpdigi-not-transfered-element-nb-documents" ).html( responseText[ 'not_transfered' ] );
					if ( ( responseText[ 'transfered' ] + responseText[ 'not_transfered' ] ) == jQuery( ".wpdigi-to-transfer-element-nb-wpdigi-to-transfer-element-nb-documents" ).html() ) {
						jQuery( "wp-digi-datastransfer-element-type-name-documents" ).addClass( 'dashicons-before dashicons-yes' );
					}
				}
				if ( 'config_components' == responseText[ 'old_sub_action' ] ) {
					jQuery( ".wp-digi-transfert-components" ).html( responseText[ 'display_components_transfer' ] );
					$form.children( "input[name=action]" ).val( $form.children( "input[name=action]" ).val().replace( '-config_components', '' ) );
				}
				$form.children( "input[name=element_type_to_transfert]" ).val( responseText[ 'element_type' ] );
				$form.children( "input[name=sub_action]" ).val( responseText[ 'sub_action' ] );
				$form.submit();
			}
			else if ( responseText[ 'status' ] ) {
				jQuery( '#wp-digi-transfert-message' ).html( responseText[ "message" ] ).show();
				jQuery( "#wpdigi-datastransfer-form .wp-digi-bton-first" ).hide();
				setTimeout( function(){
				 window.location.href = responseText['redirect_to_url'];
				}, '1500' );
			}
		}
	});

	jQuery( "input[name=wpdigi-dtrans-userid-behaviour]" ).click( function(){
		if ( jQuery( this ).is( ":checked" ) ) {
			jQuery( ".wp-digi-dtrans-userid-options-container" ).html( "" ).hide();
		}
		else {
			var data = {
				"action": "wpdigi-dtrans-transfert-options-load",
				"element_type": jQuery( this ).closest( "form" ).children( "input[name=element_type_to_transfert]" ).val(),
			};
			jQuery( ".wp-digi-dtrans-userid-options-container" ).load( ajaxurl, data ).show();
		}
	});
});

/**
 *	Get the number of element created during transfer in order to inform user
 */
function get_treated_element( element ) {
	var data = {
		action: "wpdigi-dtrans-get-done-element",
		element: element,
	};
	jQuery.post( ajaxurl, data, function( response ) {
		var i;
		for (i = 0; i < response['transfert'].length; i++) {
			jQuery( "#digi-datas-transfert-progression-container-" + response['transfert'][ i ][ 'type' ] ).html( response['transfert'][ i ][ 'text' ]);
		}

		if ( response[ "auto_reload" ] ) {
			setTimeout( function(){
				get_treated_element( element );
			}, "500");
		}
	}, "json");
}
