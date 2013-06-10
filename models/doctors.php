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
	
	__render( 
		'doctors', 
		array(
			'username' => $username,
			'doctors' => $doctors,
			'insurances' => $insurances
		)
	);
/* }}} */

?>
