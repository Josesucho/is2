<?php

	$doctorID = Router::seg( 2 );
	
	if( !__issetPOST( array( 'id' ) ) ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	$licenseID = __validateID( $_POST['id'] );
	if( !$licenseID ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	$rowsAffected = DB::delete( 
		'
			DELETE FROM
				licencias
			WHERE
				id = ? AND idMedico = ?
		',
		array( $licenseID, $doctorID )
	);
	
	if( $rowsAffected != 1 ) {
		__echoJSON( array(
			'success' => false,
			'data' => DB::getErrorList()
		) );
	}
	
	__echoJSON( array( 
		'success' => true,
		'data' => $licenseID
	) );
	
?>