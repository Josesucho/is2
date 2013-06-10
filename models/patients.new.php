<?php

	// both edit and create patients funtionality share some common things
	require './models/_patients.new.edit.php';
	
/* {{{ */
	if( m_issetPOST() ) {
		$fields = array();
		$errors = array();
		if( !m_processPOST( $fields, $errors ) ) {
			__redirect( '/pacientes/crear?error=crear-paciente&campos=' . base64_encode( implode( '|', $errors ) ) );
		}

		$insertId = DB::insert( 
			'
				INSERT INTO
					pacientes
				VALUES
					( null, ?, ?, ?, ?, ?, ?, ?, ?, ? )
			',
			$fields
		);

		if( !$insertId ) {
			__redirect( '/pacientes/crear?error=crear-paciente&campos=' . base64_encode( implode( '|', DB::getErrorList() ) ) );
		}
		
		__redirect( '/pacientes?exito=crear-paciente&id=' . $insertId );
	}
/* }}} */

/* {{{ */
	$insurances = q_getAllInsurances();

	$username = __getUsername();
	
	$page = 'Crear';
	$buttonLabel = 'Crear paciente';
	
// VENGO DE UN $_POST PERO HUBO PROBLEMAS
	if( __GETField( 'error' ) ) {
		$createError = true;
	} else {
		$createError = false;
	}

	__render( 
		'patients.new.edit', 
		array(
			'username' => $username,
			'createError' => $createError,
			'insurances' => $insurances,
			'page' => $page,
			'buttonLabel' => $buttonLabel,
// estas son las varaibles que son edit, y que debo
// conocer para no que '_patients.new.edit' no se rompa
			'editSuccess' => false,
			'editError' => false,
			'patient' => array(
				'apellidos' => '',
				'nombres' => '',
				'sexo' => '',
				'dni' => '',
				'fechaNacimiento' => '',
				'telefono' => '',
				'direccion' => '',
				'idObraSocial' => '',
				'nroAfiliado' => ''
			)
		)
	);
/* }}} */
	
?>