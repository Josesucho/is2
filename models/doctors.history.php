<?php

	$doctorID = Router::seg( 2 );
	
	$appointments = DB::select(
		'
			SELECT
				t.id, t.fecha, t.hora, t.estado,
				p.nombres, p.apellidos
			FROM
				turnos AS t
				INNER JOIN pacientes AS p
					ON p.id = t.idPaciente
			WHERE
				idMedico = ?
			ORDER BY
				t.fecha DESC, t.hora ASC
		',
		array( $doctorID )
	);
	
	for( $i = 0, $l = count( $appointments ); $i < $l; $i++ ) {
		$appointment = &$appointments[$i];
		$appointment['fecha'] = __dateISOToLocale( $appointment['fecha'] );
		$appointment['hora'] = __trimTime( $appointment['hora'] );
	}
	
	__echoJSON( array( 
		'success' => true,
		'data' => $appointments
	) );
	
?>