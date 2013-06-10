<?php

	$patientID = Router::seg( 2 );
	
	$patientData = DB::select(
		'
			SELECT
				p.id, p.apellidos, p.nombres, p.fechaNacimiento, p.dni, p.telefono, p.direccion, p.nroAfiliado,
				os.nombreCorto AS obraSocialAbbr, os.nombreCompleto AS obraSocialNombre
			FROM
				pacientes AS p
				INNER JOIN obrasSociales AS os
					ON os.id = p.idObraSocial
			WHERE
				p.id = ?
		',
		array( $patientID )
	);
	
	if( !count( $patientData ) ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	$patient = $patientData[0];
	$patient['edad'] = date_diff( date_create( $patient['fechaNacimiento'] ), date_create() )->format( '%Y' );
	$patient['fechaNacimiento'] = __dateISOToLocale( $patient['fechaNacimiento'] );
	
	$appointments = DB::select(
		'
		SELECT
			t.id, t.fecha, t.hora, t.estado,
			m.id AS idMedico, m.apellidos, m.nombres
		FROM
			turnos AS t
			INNER JOIN medicos AS m
				ON m.id = t.idMedico
		WHERE
			t.idPaciente = ?
		ORDER BY
			t.fecha DESC, t.hora ASC
		',
		array( $patientID )
	
	);
	for( $i = 0, $l = count( $appointments ); $i < $l; $i++ ) {
		$appointment = &$appointments[$i];
		$appointment['fecha'] = __dateISOToLocale( $appointment['fecha'] );
		$appointment['hora'] = __trimTime( $appointment['hora'] );
	}
	
	__echoJSON( array( 
		'success' => true,
		'data' => array(
			'patient' => $patient,
			'appointments' => $appointments
		)
	) );
	
?>