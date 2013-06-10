<?php

	if( !__issetPOST( array( 'id' ) ) ) {
		__redirect( '/especialidades?error=borrar-especialidad' );
	}
	
	$id = __validateID( $_POST['id'] );
	if( !$id ) {
		__redirect( '/especialidades?error=borrar-especialidad' );
	}
	
	$rowsAffected = DB::update(
		'
			DELETE FROM
				especialidades
			WHERE
				id = ?
		',
		array( $id )
	);

	// maybe a constraint error or id point to an inesisten record
	if( $rowsAffected != 1 ) {
		__redirect( '/especialidades?error=borrar-especialidad' );
	}
	
	__redirect( '/especialidades?exito=borrar-especialidad' );
	
?>
