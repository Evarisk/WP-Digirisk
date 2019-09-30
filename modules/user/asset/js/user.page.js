jQuery(document).ready(function($){

	jQuery( "#digi-phone-number" ).keyup(function() {
		var content = jQuery( this ).val();
    	if( ! content ){
    		return;
    	}
    	var text = content.match(/\d/g);

    	if( text == null ){
    		jQuery( this ).val( '' );
    		return;
    	}
    	content = text.join("");

		var lengthMin = jQuery( this ).closest( '.digi-phone-user' ).find( '.list-country-calling-code option:selected').attr( 'data-lengthmin' );
		var lengthMax = jQuery( this ).closest( '.digi-phone-user' ).find( '.list-country-calling-code option:selected').attr( 'data-lengthmax' );
		var callingCode = jQuery( this ).closest( '.digi-phone-user' ).find( '.list-country-calling-code option:selected').attr( 'data-countryCode' );

		content.replace( /\./g, '' ); // On enleve les points
		content.replace( /\-/g, '' ); // On enleve les tirets

		if( lengthMax != null && lengthMax > 0 && lengthMin != null && lengthMin > 0 ){
			if( content.length > lengthMax ){
				jQuery( this ).css( 'border-bottom' , 'solid 2px red' );

			}else if( content.length < lengthMin ){
				jQuery( this ).css( 'border-bottom' , 'solid 2px red' );

			}else{
				if( callingCode == "FR" ){ // Téléphone français
					content = content.replace(/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/, '$1.$2.$3.$4.$5');
				}
				jQuery( this ).css( 'border-bottom' , 'solid 2px green' );
			}
		}

		jQuery( this ).val( content );
	});
});
