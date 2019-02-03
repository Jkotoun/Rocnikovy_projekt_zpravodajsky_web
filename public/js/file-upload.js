'use strict';
;( function ( document, window, index )
{
	let inputs = document.querySelectorAll( '.inputfile' );
	Array.prototype.forEach.call( inputs, function( input )
	{
		let label	 = input.nextElementSibling;
		input.addEventListener( 'change', function( e )
		{
				let fileName = e.target.value.split( '\\' ).pop();
				label.querySelector( 'span' ).innerHTML = fileName;
		});
	});
}( document, window, 0 ));