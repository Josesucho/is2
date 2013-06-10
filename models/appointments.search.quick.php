<?php

	if( !__issetPOST( array( 'keyword' ) ) ) {
		__redirect( '/turnos?error=buscar-turno-rapido' );
	}
	
	$keyword = __sanitizeValue( $_POST['keyword'] );
	if( !$keyword ) {
		__redirect( '/turnos?error=buscar-turno-rapido' );
	}
	
	// es una fecha?
	if( ( $value = __toISODate( $keyword ) ) ) {
		$field = 'fecha';

	// es una hora?
	} else if( ( $value = __toISOTime( $keyword ) ) ) {
		$field = 'hora';

	// es un estado?
	} else if( ( $value = __getAppointmentStatus( $keyword ) ) ) {
		$field = 'estado';
	
	} else {
		$field = 'comodin';
		$value = trim( $keyword );
	}
	
	__redirect( '/turnos?busqueda=' . base64_encode( $field . '=' . $value ) );
	
?>