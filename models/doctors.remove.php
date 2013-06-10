<?php

	if( !__issetPOST( array( 'id' ) ) ) {
		__redirect( '/medicos?error=borrar-medico' );
	}
	
	$id = __validateID( $_POST['id'] );
	if( !$id ) {
		__redirect( '/medicos?error=borrar-medico' );
	}

	$rowsAffected = DB::delete(
		'
			DELETE FROM
				medicos
			WHERE
				id = ?
		',
		array( $id )
	);
	// error si borrar un paciente con turnos
	if( $rowsAffected != 1 ) {
		__redirect( '/medicos?error=borrar-medico' );
	}
	
	__redirect( '/medicos?exito=borrar-medico' );
	
?>
