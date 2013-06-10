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
	
	// me fijo el medico esta de licencia para la fecha del turno requerido
	$res = DB::select(
		'
			SELECT
				id
			FROM
				licencias
			WHERE
				idMedico = ? AND ? >= fechaComienzo AND ? <= fechaFin
		',
		array( $doctorID, $date, $date )
	);
	$hasLicense = (bool) count( $res );
	
	// pido los horarios del medico
	// eso siempre va estar en la respuesta
	$doctorAvailibilities = q_getDoctorAvailabilities( $doctorID );
	
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
			'hasAppointmentAlready' => $hasAppointmentAlready,
			'hasLicense' => $hasLicense
		)
	) );
	
?>