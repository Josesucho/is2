<?php

	if( !__issetPOST( array( 'keyword' ) ) ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	$whereClause = array();
	$replacements = array();
	$keyword = trim( $_POST['keyword'] );
	// is a dni or tel
	if( ( $m = preg_replace( '/^[^\d]+$/', '', $keyword ) ) && is_numeric( $m ) ) {
		$whereClause[] = ' p.dni = ? ';
		$replacements[] = $m;
		$whereClause[] = ' p.telefono = ? ';
		$replacements[] = $m;
	
	// search by apellidos and names
	} else {
		$fullname = explode( ',', $keyword );
		// too much commas
		if( count( $fullname ) > 2 ) {
			__echoJSON( array( 'success' => false ) );
		}
		$whereClause[] = ' p.apellidos LIKE ? ';
		$replacements[] = '%' . $fullname[0] . '%';
		if( isset( $fullname[1] ) ) {
			$whereClause[] = ' p.nombres LIKE ? ';
			$replacements[] = '%' . $fullname[1] . '%';
		}
	}

	$patients = DB::select(
		'
			SELECT
				p.id, p.apellidos, p.nombres, p.dni, p.telefono, p.direccion,
				os.nombreCorto AS obraSocialNombre
			FROM
				pacientes AS p
				INNER JOIN obrasSociales AS os
					ON os.id = p.idObraSocial
			WHERE
			' .
				implode( ' OR ', $whereClause ) .
			'
			ORDER BY
				p.apellidos ASC, p.nombres ASC
			LIMIT
				50
		',
		$replacements
	);
	
	__echoJSON( array( 
		'success' => true,
		'data' => $patients
	) );
	
?>