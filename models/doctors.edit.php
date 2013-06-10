<?php

	// both edit and create patients funtionality share some common things
	require './models/_doctors.new.edit.php';
	
	// get the id seg from /medicos/122/editar
	$doctorID = Router::seg( 2 );

/* {{{ EDITAR MEDICO */
	if( m_issetPOST() ) {
		$fields = array();
		$errors = array();
		if( !m_processPOST( $fields, $errors ) ) {
			__redirect( '/medicos/' . $doctorID . '/editar?error=editar-medico&campos=' . base64_encode( implode( '|', $errors ) ) );
		}
		
		$fields[] = $doctorID;
		$rowsAffected = DB::update( 
			'
				UPDATE
					medicos
				SET
					idEspecialidad = ?,
					apellidos = ?,
					nombres = ?,
					telefono1 = ?,
					telefono2 = ?,
					direccion = ?,
					matriculaNacional = ?,
					matriculaProvincial = ?
				WHERE
					id = ?
			',
			$fields
		);
		// puede pasar que submitee el form tal cual esta, no pasa nada, y por el < 0
		if( $rowsAffected < 0 ) {
			__redirect( '/medicos/' . $doctorID . '/editar?error=editar-medico&campos=' . base64_encode( implode( '|', DB::getErrorList() ) ) );
		}
		
		__redirect( '/medicos/' . $doctorID . '/editar?exito=editar-medico' );
	}
/* }}} */

/* {{{ DEBO PEDIR EL MEDICO QUE ESTA EN LA URL */
	$doctors = DB::select(
		'
			SELECT
				id, idEspecialidad, apellidos, nombres, telefono1, telefono2, direccion, matriculaProvincial, matriculaNacional
			FROM
				medicos
			WHERE
				id = ?
		',
		array( $doctorID )
	);
	if( !count( $doctors ) ) {
		__redirect( '/medicos?error=editar-medico' );
	}
	$doctor = $doctors[0];
	
/* }}} */

/* {{{ */
	$username = __getUsername();
	
	$specialities = q_getAllSpecialities();
	
	$page = 'Editar';
	$buttonLabel = 'Editar médico';
	
	$editSuccess = false;
	$editError = false;
	if( __issetGETField( 'exito', 'editar-medico' ) ) {
		$editSuccess = true;
	} else if( __issetGETField( 'error', 'editar-medico' ) ) {
		$editError = true;
	}
	
	__render( 
		'doctors.new.edit', 
		array(
			'username' => $username,
			'specialities' => $specialities,
			'editError' => $editError,
			'editSuccess' => $editSuccess,
			'page' => $page,
			'buttonLabel' => $buttonLabel,
			'doctor' => $doctor,
// estas son las varaibles que son edit, y que debo
// conocer para no que '_doctors.new.edit' no se rompa
			'createError' => false
		)
	);
/* }}} */

?>
