<?php

	// both edit and create doctors funtionality share some common things
	require './models/_doctors.new.edit.php';

/* {{{ CUANDO SE CREAR UN NUEVO MEDICO */
	if( m_issetPOST() ) {
		$fields = array();
		$errors = array();
		if( !m_processPOST( $fields, $errors ) ) {
			__redirect( '/medicos/crear?error=crear-medico&campos=' . base64_encode( implode( '|', $errors ) ) );
		}
		
		// add the avatars
		$fields[] = 'default.mini.png';
		$fields[] = 'default.png';

		$insertId = DB::insert( 
			'
				INSERT INTO
					medicos
				VALUES
					( null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )
			',
			$fields
		);
		
		if( !$insertId ) {
			__redirect( '/medicos/crear?error=crear-medico&campos=' . base64_encode( implode( '|', DB::getErrorList() ) ) );
		}
		
		__redirect( '/medicos?exito=crear-medico#id=' . $insertId );
	}
/* }}} */

/* {{{ */
	$username = __getUsername();
	
	$specialities = q_getAllSpecialities();
	
	$page = 'Crear';
	$buttonLabel = 'Crear médico';
	
// VENGO DE UN $_POST PERO HUBO PROBLEMAS
	if( __GETField( 'error' ) ) {
		$createError = true;
	} else {
		$createError = false;
	}
	
	__render( 
		'doctors.new.edit', 
		array(
			'username' => $username,
			'specialities' => $specialities,
			'createError' => $createError,
			'page' => $page,
			'buttonLabel' => $buttonLabel,
// estas son las varaibles que son edit, y que debo
// conocer para no que '_doctors.new.edit' no se rompa
			'editError' => false,
			'editSuccess' => false,
			'doctor' => array(
				'idEspecialidad' => '',
				'apellidos' => '',
				'nombres' => '',
				'telefono1' => '',
				'telefono2' => '',
				'direccion' => '',
				'matriculaProvincial' => '',
				'matriculaNacional' => ''
			)
		)
	);
/* }}} */

?>
