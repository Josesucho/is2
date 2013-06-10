<?php

// ESTAS VARIABLES SON LAS QUE SE USAN EL VIEW
	$username = __getUsername();
	
	$specialities = q_getAllSpecialities();
	
	$createSuccess = false;
	$createError = false;
	$editSuccess = false;
	$editError = false;
	$removeSuccess = false;
	$removeError = false;
	if( __issetGETField( 'exito', 'crear-especialidad' ) ) {
		$createSuccess = true;
	} else if( __issetGETField( 'error', 'crear-especialidad' ) ) {
		$createError = true;
	
	} else if( __issetGETField( 'exito', 'editar-especialidad' ) ) {
		$editSuccess = true;
	} else if( __issetGETField( 'error', 'editar-especialidad' ) ) {
		$editError = true;
	
	} else if( __issetGETField( 'exito', 'borrar-especialidad' ) ) {
		$removeSuccess = true;
	} else if( __issetGETField( 'error', 'borrar-especialidad' ) ) {
		$removeError = true;
	}
	
// LOAD THE VIEW
	__render( 
		'specialities', 
		array(
			'username' => $username,
			'createSuccess' => $createSuccess,
			'createError' => $createError,
			'editSuccess' => $editSuccess,
			'editError' => $editError,
			'removeSuccess' => $removeSuccess,
			'removeError' => $removeError,
			'specialities' => $specialities
		)
	);

?>
