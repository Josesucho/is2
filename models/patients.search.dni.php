<?php

// TENER EN CUENTA QUE ESTO SOLO DEVUELVE UN SOLO PACIENTE, NO VARIOS!!!

	if( !__issetPOST( array( 'dni', 'doctorID' ) ) ) {
		__echoJSON( array( 'success' => false ) );
	}

	$dni = __cleanDNI( $_POST['dni'] );
	$doctorID = __validateID( $_POST['doctorID'] );
	if( !$dni || !$doctorID ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	$patients = DB::select(
		'
			SELECT
				p.id, p.apellidos, p.nombres, p.sexo, p.dni, p.idObraSocial, p.fechaNacimiento, p.telefono, p.nroAfiliado,
				os.nombreCorto AS obraSocialNombre
			FROM
				pacientes AS p
			INNER JOIN obrasSociales AS os
				ON os.id = p.idObraSocial
			WHERE
				dni = ?
		',
		array( $dni )
	);
	if( !count( $patients ) ) {
		__echoJSON( array( 'success' => true, 'data' => null ) );
	}
	
	$patient = $patients[0];
	$patient['nombreCompleto'] = $patient['apellidos'] . ', ' . $patient['nombres'];
	$patient['edad'] = date_diff( date_create( $patient['fechaNacimiento'] ), date_create() )->format( '%Y' );
	$patient['fechaNacimiento'] = __dateISOToLocale( $patient['fechaNacimiento'] );
	
	// me fijo que si el paciente soporta la obra social del medico
	$res = DB::select(
		'
			SELECT
				id
			FROM 
				medicosObrasSociales
			WHERE
				idMedico = ? AND 
				idObraSocial = ?
		',
		array( $doctorID, $patient['idObraSocial'] )
	);
	$supportInsurance = (bool) count( $res );
	
	__echoJSON( array( 
		'success' => true,
		'data' => array( 
			'patient' => $patient,
			'supportInsurance' => $supportInsurance 
		) 
	) );
	
?>