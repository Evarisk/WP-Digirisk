jQuery.fn.get_data = function( cb ) {
  this.each( function() {
    var data = {};

    for ( var i = 0; i <  jQuery( this )[0].attributes.length; i++ ) {
      var localName = jQuery( this )[0].attributes[i].localName;
      if (  localName.substr(0, 4) == 'data' ||
            localName == 'action') {

        localName = localName.substr(5);

        if ( localName == 'nonce' ) localName = '_wpnonce';
        localName = localName.replace( '-', '_' );
        data[localName] =  jQuery( this )[0].attributes[i].value;
      }
    }

    cb( data );
  } );
};
