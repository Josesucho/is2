<?php

	if( !__issetPOST( array( 'id', 'speciality' ) ) ) {
		__redirect( '/especialidades?error=editar-especialidad' );
	}
	
	$speciality = __sanitizeValue( $_POST['speciality'] );
	$id = __validateID( $_POST['id'] );
	if( !$speciality || !$id ) {
		__redirect( '/especialidades?error=editar-especialidad' );
	}
	
	$rowsAffected = DB::update(
		'
			UPDATE
				especialidades
			SET
				nombre = ?
			WHERE
				id = ?
		',
		array( strtolower( $speciality ), $id )
	);

	// maybe a constraint error or id point to an inesisten record
	if( $rowsAffected != 1 ) {
		__redirect( '/especialidades?error=editar-especialidad' );
	}
	
	__redirect( '/especialidades?exito=editar-especialidad' );
	
?>
