<?php

	if( !__issetPOST( array( 'id', 'shortName', 'fullName' ) ) ) {
		__redirect( '/obras-sociales?error=editar-obra-social' );
	}
	
	$shortName = __sanitizeValue( $_POST['shortName'] );
	$fullName = __sanitizeValue( $_POST['fullName'] );
	$id = __validateID( $_POST['id'] );
	if( !$shortName || !$fullName || !$id ) {
		__redirect( '/obras-sociales?error=editar-obra-social' );
	}
	
	$rowsAffected = DB::update(
		'
			UPDATE
				obrasSociales
			SET
				nombreCorto = ?,
				nombreCompleto = ?
			WHERE
				id = ?
		',
		array( strtolower( $shortName ), $fullName, $id )
	);
	
	// maybe a constraint error or id point to an inesisten record
	if( $rowsAffected != 1 ) {
		__redirect( '/obras-sociales?error=editar-obra-social' );
	}
	
	__redirect( '/obras-sociales?exito=editar-obra-social' );
	
?>
