<?php

	if( !__issetPOST( array( 'id' ) ) ) {
		__redirect( '/obras-sociales?error=borrar-obra-social' );
	}
	
	$id = __validateID( $_POST['id'] );
	if( !$id ) {
		__redirect( '/obras-sociales?error=borrar-obra-social' );
	}
	
	$rowsAffected = DB::update(
		'
			DELETE FROM
				obrasSociales
			WHERE
				id = ?
		',
		array( $id )
	);

	// maybe a constraint error or id point to an inesisten record
	if( $rowsAffected != 1 ) {
		__redirect( '/obras-sociales?error=borrar-obra-social' );
	}
	
	__redirect( '/obras-sociales?exito=borrar-obra-social' );
	
?>
