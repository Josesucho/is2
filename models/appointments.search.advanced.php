<?php

// ESTRUCTURA DEL $_POST
/* array
	'fromDate' => string '08/05/2013' (length=10)
	'toDate' => string '21/05/2013' (length=10)
	'fromTime' => string '02:00 AM' (length=8)
	'toTime' => string '02:00 AM' (length=8)
	'doctorsSearch' => all || custom
	'doctorsList' => // PUEDE NO ESTAR!!!!
		array
			0 => string '3' (length=1)
			1 => string '4' (length=1)
			2 => string '6' (length=1)
			3 => string '8' (length=1)
	'patientsSearch' => all || custom
	'patientsList' => string '7.432.211 4.533.667 7.667.888' (length=29)
	'status' => all || confirmed || cancellled
*/
	
	// no se puede acceder a esta pagina sin el $_POST
	if( !__issetPOST( array( 'fromDate', 'toDate', 'fromTime', 'toTime', 'doctorsSearch', 'patientsSearch', 'patientsList', 'status' ) ) ) {
		__redirect( '/turnos?error=buscar-turno' );
	}
	
	// estos campos puede estar vacios
	$fromDate = __toISODate( $_POST['fromDate'] );
	$toDate = __toISODate( $_POST['toDate'] );
	$fromTime = __toISOTime( $_POST['fromTime'] );
	$toTime = __toISOTime( $_POST['toTime'] );
	
	$doctorsSearch = $_POST['doctorsSearch'];
	$doctorsList = array();
	// custom indica que se ha suministrado una lista de IDs de medicos
	if( $doctorsSearch == 'custom' ) {
		if( !isset( $_POST['doctorsList'] ) || !is_array( $_POST['doctorsList'] ) || !count( $_POST['doctorsList'] ) ) {
			__redirect( '/turnos?error=buscar-turno' );
		}	
		$doctorsList = $_POST['doctorsList'];
	}	
	
	$patientsSearch = $_POST['patientsSearch'];
	$cleanDNIs = array();
	if( $patientsSearch == 'custom' && ( $patientsList = trim( $_POST['patientsList'] ) ) ) {
		// make "1212 2321 3323" -> [ 1213, 2321 3323 ]
		$patientsList = explode( ' ', $patientsList );
		foreach( $patientsList as $dni ) {
			$dni = __cleanDNI( $dni );
			if( $dni ) {
				$cleanDNIs[] = $dni;
			}
		}
	}
	
	$status = $_POST['status'];
	
	// aca armo la query url, estas sera procesado en appointments.php
	$search = $fromDate . '@' . $toDate . '|' . $fromTime . '@' . $toTime . '|' . ( count( $doctorsList ) ? implode( '-', $doctorsList ) : '' ) . '|' . ( count( $cleanDNIs ) ? implode( '-', $cleanDNIs ) : '' ) . '|' . $status;
	
	__redirect( '/turnos?busqueda-avanzada=' . base64_encode( $search ) );
	
?>