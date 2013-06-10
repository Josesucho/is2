<?php

	$doctorID = Router::seg( 2 );
	
	if( !__issetPOST( array( 'dayIndex', 'timeEntryIn', 'timeEntryOut' ) ) ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	$dayIndex = __validateDayIndex( $_POST['dayIndex'] );
	$timeEntryIn = __toISOTime( $_POST['timeEntryIn'] );
	$timeEntryOut = __toISOTime( $_POST['timeEntryOut'] );
	
	if( !$dayIndex || !$timeEntryIn || !$timeEntryOut ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	$insertId = DB::insert(
		'
			INSERT INTO
				horarios
			VALUES
				( null, ?, ?, ?, ? )
		',
		array( $doctorID, $timeEntryIn, $timeEntryOut, $dayIndex )
	);
	
	if( !$insertId ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	$availabilities = q_getDoctorAvailabilities( $doctorID, $insertId );
	$availability = $availabilities[0];
	$availability['diaNombre'] = __getDayName( $availability['dia'] );
	$availability['horaEgreso'] = __trimTime( $availability['horaEgreso'] );
	$availability['horaIngreso'] = __trimTime( $availability['horaIngreso'] );
	
	__echoJSON( array( 
		'success' => true,
		'data' => $availability
	) );
	
?>