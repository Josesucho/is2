<?php

/* {{{ */
	$username = __getUsername();
	
	$doctors = DB::select(
		'
			SELECT
				m.id, m.apellidos, m.nombres, m.avatar,
				e.nombre AS especialidad
			FROM
				medicos AS m
				INNER JOIN especialidades AS e
					ON e.id = m.idEspecialidad
			ORDER BY
				m.apellidos ASC, m.nombres ASC
		'
	);
	
	$insurances = q_getAllInsurances();
	
	$removeSuccess = false;
	$removeError = false;
	if( __issetGETField( 'exito', 'borrar-medico' ) ) {
		$removeSuccess = true;
	// ... o de error
	} else if( __issetGETField( 'error', 'borrar-medico' ) ) {
		$removeError = true;
	}
	
	__render( 
		'doctors', 
		array(
			'username' => $username,
			'doctors' => $doctors,
			'insurances' => $insurances,
			'removeSuccess' => $removeSuccess,
			'removeError' => $removeError
		)
	);
/* }}} */

?>
