<?php

	$doctorID = Router::seg( 2 );
	
	if( !__issetPOST( array( 'id' ) ) ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	$appointmentID = __validateID( $_POST['id'] );
	if( !$appointmentID ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	$rowsAffected = DB::delete(
		'
			DELETE FROM
				horarios
			WHERE
				id = ? AND idMedico = ?
		',
		array( $appointmentID, $doctorID )
	);
	
	if( $rowsAffected != 1 ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	__echoJSON( array( 
		'success' => true,
		'data' => $appointmentID
	) );
	
?>