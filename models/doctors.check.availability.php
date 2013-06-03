<?php

	if( !__issetPOST( array( 'date', 'time', 'doctorID' ) ) ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	$date = __toISODate( $_POST['date'] );
	$time = __toISOTime( $_POST['time'] );
	$doctorID = __validateID( $_POST['doctorID'] );
	
	if( !$date || !$time || !$doctorID ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	// pido los horarios del medico
	// eso siempre va estar en la respuesta
	$doctorAvailibilities = DB::select(
		'
			SELECT
				*
			FROM
				horarios
			WHERE
				idMedico = ?
		',
		array( $doctorID )
	);
	
	// debo saber cual es dia en donde case $date
	$day = date( 'N', strtotime( $date ) );
	$res = DB::select( 
		'
			SELECT
				id
			FROM
				horarios
			WHERE
				idMedico = ? AND ? >= horaIngreso AND ? <= horaEgreso AND dia = ?
		',
		array( $doctorID, $time, $time, $day )
	);
	// el doctor antiende dia querido??
	$isDoctorAvailable = (bool) count( $res );
	
	// ahora debo fijarme que no tenga ya un turno para ese ida
	$res = DB::select(
		'
			SELECT
				id
			FROM
				turnos
			WHERE
				fecha = ? AND hora = ? AND idMedico = ?
		',
		array( $date, $time, $doctorID )
	);
	$hasAppointmentAlready = (bool) count( $res );
	
	__echoJSON( array( 
		'success' => true,
		'data' => array( 
			'availabilities' => $doctorAvailibilities,
			'isAvailable' =>$isDoctorAvailable,
			'hasAppointmentAlready' => $hasAppointmentAlready
		)
	) );
	
?>