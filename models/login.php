<?php

	// se quiere hacer el pillo
	if( __isUserLogged() ) {
		__redirect( '/turnos' );
	}

	// defaults variales que son usadas en la view
	$isErrorLogin = false;

	// el usuario ha hecho click en el button "Iniciar sesion"
	// procedemos a validar sus credenciales
	if( __issetPOST( array( 'username', 'password' ) ) ) {
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		// vemos si el usuario existe en la db
		$res = DB::select(
			'
				SELECT 
					id 
				FROM 
					usuarios 
				WHERE 
					usuario = ? AND clave = SHA( ? )
			', 
			array( $username, $password )
		);
		
		// hubo exito en la query
		if( count( $res ) == 1 ) {
			__setUserLogin();
			__setUsername( $username );
			// check if the user comes from: /iniciar-sesion?destino=/turnos for example
			__redirect( __GETField( 'destino' ) ?: '/turnos' );
		}
		
		$isErrorLogin = true;
	}
	
// LOAD THE VIEW
	__render( 
		'login', 
		array(
			'isErrorLogin' => $isErrorLogin
		)
	);

?>