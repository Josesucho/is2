<?php

	if( !__issetPOST( array( 'speciality' ) ) ) {
		__redirect( '/especialidades?error=crear-especialidad' );
	}
	
	$speciality = __sanitizeValue( $_POST['speciality'] );
	if( !$speciality ) {
		__redirect( '/especialidades?error=crear-especialidad' );
	}
	
	$insertId = DB::insert(
		'
			INSERT INTO
				especialidades
			VALUES
				( null, ? )
		',
		array( strtolower( $speciality ) )
	);
	
	// maybe a constraint error
	if( !$insertId ) {
		__redirect( '/especialidades?error=crear-especialidad' );
	}
	
	__redirect( '/especialidades?exito=crear-especialidad' );
	
?>
