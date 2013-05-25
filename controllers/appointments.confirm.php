<?php
	
	// no se puede acceder a esta pagina sin el $_POST
	if( !__issetPOST( array( 'id' ) ) ) {
		__redirect( '/turnos?error=confirmar-turno' );
	
	} else {
		// id del turno
		$id = $_POST['id'];
		
		$rowsAffected = $db->update(
			'UPDATE turnos SET estado = ? WHERE id = ?',
			array( 'confirmado', $id )
		);
		
		// hubo un error en la query, por ejemplo
		// $id no es un entero, o este correponde
		// a un turno que no existe, etc
		if( $rowsAffected != 1 ) {
			__redirect( '/turnos?error=confirmar-turno' );
		
		} else {
			__redirect( '/turnos?exito=confirmar-turno' );
		}
	}

?>