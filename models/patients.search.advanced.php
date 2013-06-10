<?php

// ESTRUCTURA DEL $_POST
/**
	array(
		['lastName'] =>'lopez benavidez'
		['firstName'] =>'jorge fernadando'
		['patientsList'] =>'123 12334 12345'
		['birthDateStart'] =>'13/10/2012'
		['birthDateEnd'] =>	'13/10/2012'
		['insuranceSearch'] =>'all' || 'custom'
		['insurancesList'] => (puede no estar)
		array(
			[0] =>4
			[1] =>5
			[2] =>6
			[3] =>7
			[4] =>9
			[5] =>10
		)
		['affiliateInsuranceNumber'] =>'1234 332 43'
	)
*/

	// no se puede acceder a esta pagina sin el $_POST
	if( !__issetPOST( array( 'insuranceSearch' ) ) ) {
		__redirect( '/pacientes?error=buscar-paciente' );
	}
	
	$lastNames = array();
	foreach( explode( ' ', $_POST['lastName'] ) as $lastName ) {
		$lastNames[] = trim( $lastName );
	}
	$firstNames = array();
	foreach( explode( ' ', $_POST['firstName'] ) as $firstName ) {
		$firstNames[] = trim( $firstName );
	}
	
	$birthDateStart = __toISODate( $_POST['birthDateStart'] );
	$birthDateEnd = __toISODate( $_POST['birthDateEnd'] );

	$insuranceSearch = $_POST['insuranceSearch'];
	$insurancesList = array();
	// custom indica que se ha suministrado una lista de IDs de medicos
	if( $insuranceSearch == 'custom' ) {
		if( !isset( $_POST['insurancesList'] ) || !is_array( $_POST['insurancesList'] ) || !count( $_POST['insurancesList'] ) ) {
			__redirect( '/pacientes?error=buscar-paciente' );
		}
		$insurancesList = $_POST['insurancesList'];
	}

	$cleanDNIs = array();
	if( ( $dni = $_POST['patientsList'] ) ) {
		// make "1212 2321 3323" -> [ 1213, 2321 3323 ]
		$patientsList = explode( ' ', $dni );
		foreach( $patientsList as $dni ) {
			$dni = __cleanDNI( $dni );
			if( $dni ) {
				$cleanDNIs[] = $dni;
			}
		}
	}
	
	$affiliateInsuranceNumber = explode( ' ', $_POST['affiliateInsuranceNumber'] );
	
	// aca armo la query url, estas sera procesado en appointments.php
	$search = ( count( $lastNames ) ? implode( '-', $lastNames ) : '' ) . '|' . ( count( $firstNames ) ? implode( '-', $firstNames ) : '' ) . '|' . $birthDateStart . '@' . $birthDateEnd . '|' . ( count( $insurancesList ) ? implode( '-', $insurancesList ) : '' ) . '|' . ( count( $cleanDNIs ) ? implode( '-', $cleanDNIs ) : '' ) . '|' . ( count( $affiliateInsuranceNumber ) ? implode( '-', $affiliateInsuranceNumber ) : '' );
	
	__redirect( '/pacientes?busqueda-avanzada=' . base64_encode( $search ) );
	
?>