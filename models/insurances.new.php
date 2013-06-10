<?php

	if( !__issetPOST( array( 'shortName', 'fullName' ) ) ) {
		__redirect( '/obras-sociales?error=crear-obra-social' );
	}
	
	$shortName = __sanitizeValue( $_POST['shortName'] );
	$fullName = __sanitizeValue( $_POST['fullName'] );
	if( !$shortName || !$fullName ) {
		__redirect( '/obras-sociales?error=crear-obra-social' );
	}
	
	$insertId = DB::insert(
		'
			INSERT INTO
				obrasSociales
			VALUES
				( null, ?, ? )
		',
		array( strtolower( $shortName ), $fullName )
	);
	
	// maybe a constraint error
	if( !$insertId ) {
		__redirect( '/obras-sociales?error=crear-obra-social' );
	}
	
	__redirect( '/obras-sociales?exito=crear-obra-social' );
	
?>
