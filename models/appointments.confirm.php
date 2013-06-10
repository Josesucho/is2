<?php
	
	// no se puede acceder a esta pagina sin el $_POST
	if( !__issetPOST( array( 'id' ) ) ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	// id del turno
	$id = $_POST['id'];
	if( !__validateID( $id ) ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	$rowsAffected = DB::update(
		'
			UPDATE
				turnos
			SET 
				estado = ?
			WHERE 
				id = ?
		',
		array( 'confirmado', $id )
	);
	
	// hubo un error en la query, por ejemplo
	// $id no es un entero, o este correponde
	// a un turno que no existe, etc
	if( $rowsAffected != 1 ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	__echoJSON( array( 'success' => true, 'data' => array( 'id' => $id ) ) );

?>