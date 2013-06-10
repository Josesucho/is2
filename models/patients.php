<?php

/* {{{ ESTE ES CUANDO VIENE DE SORTEAR LA GRID */
	$orderByType = false;
	$orderByCustom = array();
	// se puede ordenar por apellidos y nombres a la vez...
	if( ( $orderByType = __GETField( 'apellido' ) ) ) {
		$orderByCustom['apellidos'] = $orderByType;
	}
	if( ( $orderByType = __GETField( 'nombre' ) ) ) {
		$orderByCustom['nombres'] = $orderByType;
	}
	// ..pero no se puede cobinar con fecha-de-nacimiento
	if( !count( $orderByCustom ) && ( $orderByType = __GETField( 'fecha-de-nacimiento' ) ) ) {
		$orderByCustom['fechaNacimiento'] = $orderByType;
	}
	// validate
	$orderByClause = array();
	if( count( $orderByCustom ) ) {
		foreach( $orderByCustom as $orderByCol => $orderByType ) {
			// si me metio mano, poner ASC
			if( !in_array( strtoupper( $orderByType ), array( 'ASC', 'DESC' ) ) ) {
				$orderByClause[] = ' p.' . $orderByCol . ' ASC ';
			} else {
				$orderByClause[] = ' p.' . $orderByCol . ' ' . $orderByType . ' ';
			}
		}
	// default order by
	} else {
		$orderByClause = array( ' p.apellidos ASC ' , ' p.nombres ASC ' );
	}
/* }}} */

	$whereClause = array();
	$replacements = array();
	$letter = false;
	$isSingle = false;

	$isSearch = false;
	$isQuickSearch = false;
	$quickSearchValue = false;
	$persistValues = array(
		'lastName' => '',
		'firstName' => '',
		'patientsList' => '',
		'birthDateStart' => '',
		'birthDateEnd' => '',
		'insurancesList' => array(),
		'affiliateInsuranceNumber' => ''
	);
/* {{{ ESTO ES CUANDO EL USUARIO HACE UNA BUSQUEDA AVANZADA */
	if( ( $search = __GETField( 'busqueda-avanzada' ) ) ) {
		$isSearch = true;
		
		$searchParts = explode( '|', __sanitizeValue( base64_decode( $search ) ) );
		if( count( $searchParts ) != 6 ) {
			__redirect( '/pacientes?error=buscar-turno' );
		}
		
		// lo primero son los apellidos
		$lastNames = explode( '-', $searchParts[0] );
		$lastNamesOrClause = array();
		foreach( $lastNames as $lastName ) {
			if( $lastName ) {
				$lastNamesOrClause[] = ' p.apellidos = ? ';
				$replacements[] = $persistValues['lastName'][] = $lastName;
			}
		}
		if( count( $lastNamesOrClause ) ) {
			$whereClause[]	= ' ( ' . implode( ' OR ', $lastNamesOrClause ) . ' ) ';
			$persistValues['lastName'] = implode( ' ', $persistValues['lastName'] );
		}
		
		// lo segundo son los nombres
		$firstNames = explode( '-', $searchParts[1] );
		$firstNamesOrClause = array();
		foreach( $firstNames as $firstName ) {
			if( $firstName ) {
				$lastNamesOrClause[] = ' p.nombres = ? ';
				$replacements[] = $persistValues['firstName'][] = $firstName;
			}
		}
		if( count( $firstNamesOrClause ) ) {
			$whereClause[]	= ' ( ' . implode( ' OR ', $firstNamesOrClause ) . ' ) ';
			$persistValues['firstName'] = implode( ' ', $persistValues['firstName'] );
		}
		
		// lo tercero el rango de fecha de nacimiento
		$birthDateRange = explode( '@', $searchParts[2] );
		if( isset( $birthDateRange[0] ) && $birthDateRange[0] ) {
			$whereClause[] = ' p.fechaNacimiento >= ? ';
			$replacements[] = $persistValues['birthDateStart'] = $birthDateRange[0];
		}
		if( isset( $birthDateRange[1] ) && $birthDateRange[1] ) {
			$whereClause[] = ' p.fechaNacimiento <= ? ';
			$replacements[] = $persistValues['birthDateEnd'] = $birthDateRange[1];
		}
		
		// lo cuarto es una lista de obra sociales
		$insurancesList = explode( '-', $searchParts[3] );
		// hago el OR clause
		$insurancesOrClause = array();
		foreach( $insurancesList as $insuranceID ) {
			if( $insuranceID ) {
				$insurancesOrClause[] = ' os.id = ? ';
				$replacements[] = $persistValues['insurancesList'][$insuranceID] = $insuranceID;
			}
		}
		if( count( $insurancesOrClause ) ) {
			$whereClause[] = ' ( ' . implode( ' OR ', $insurancesOrClause ) . ' ) ';
		}
		
		// lo quinto es una lista de dnis
		$patientsDNI = explode( '-', $searchParts[4] );
		$patientsOrClause = array();
		foreach( $patientsDNI as $dni ) {
			if( $dni ) {
				$patientsOrClause[] = ' p.dni = ? ';
				$replacements[] = $persistValues['patientsList'][] = $dni;
			}
		}
		if( count( $patientsOrClause ) ) {
			$whereClause[]	= ' ( ' . implode( ' OR ', $patientsOrClause ) . ' ) ';
			$persistValues['patientsList'] = implode( ' ', $persistValues['patientsList'] );
		}
		
		// la sexta parte es una lista de numero de afiliados
		$affiliateNumbers = explode( '-', $searchParts[5] );
		$affiliateNumbersOrClause = array();
		foreach( $affiliateNumbers as $affiliateNumber ) {
			if( $affiliateNumber ) {
				$affiliateNumbersOrClause[] = ' p.nroAfiliado = ? ';
				$replacements[] = $persistValues['affiliateInsuranceNumber'][] = $affiliateNumber;
			}
		}
		if( count( $affiliateNumbersOrClause ) ) {
			$whereClause[]	= ' ( ' . implode( ' OR ', $affiliateNumbersOrClause ) . ' ) ';
			$persistValues['affiliateInsuranceNumber'] = implode( ' ', $persistValues['affiliateInsuranceNumber'] );
		}
/* }}} */
/* {{{ ACA CUANDO VIENE DE BUSQUEDA-RAPIDA */
	} else if( ( $keyword = __GETField( 'busqueda' ) ) ) {
		$keyword = __sanitizeValue( base64_decode( $keyword ) );
		if( !$keyword ) {
			__redirect( '/pacientes?error=buscar-paciente-rapido' );
		}
		$keyword = explode( '=', $keyword );
		if( count( $keyword ) != 2 ) {
			__redirect( '/pacientes?error=buscar-paciente-rapido' );
		}
		
		$field =  $keyword[0];
		$value = $keyword[1];
		if( $field == 'fechaNacimiento' ) {
			$whereClause[] = ' p.fechaNacimiento = ? ';
			$replacements[] = $value;
			
		} else if( $field == 'dni|telefono' ) {
			$whereClause[] = ' p.dni = ? OR p.telefono = ? ';
			$replacements[] = $value;
			$replacements[] = $value;

		} else if( $field == 'comodin' ) {
			$whereClause[] = ' ( p.nombres LIKE ? OR p.apellidos LIKE ? OR os.nombreCorto LIKE ? ) ';
			$replacements[] = '%' . $value . '%';
			$replacements[] = '%' . $value . '%';
			$replacements[] = '%' . $value . '%';
		
		} else {
			__redirect( '/pacientes?error=buscar-paciente-rapido' );
		}
		
		$quickSearchValue = $value;
		$isQuickSearch = true;
		$isSearch = true;
		
/* }}} */
/* {{{ ESTE ES CUANDO VENGO DE CREAR UN TURNO */
	} else if( ( $newPatient = __GETField( 'id' ) ) && __validateID( $newPatient ) ) {
		$isSingle = true;
		$whereClause[] = ' p.id = ? ';
		$replacements[] = $newPatient;
/* }}} */
/* {{{ ESTO ES CUANDO ESTOY ASI: pacientes/listar-por-letra/B SI FUERA EL CASO,
CASO CONTRARIO LISTO LOS APELLIDO QUE EMPIECEN CON 'A' */
	} else {
		$letter = Router::seg( 3 ) ?: 'A';
		$whereClause[] = ' p.apellidos LIKE ?';
		$replacements[] = $letter . '%';
	}
/* }}} */

/* {{{ VARIABLES QUE SERAN USADAS EN LA VIEW */
	$username = __getUsername();
	// veo si tengo que paginar
	$offset = __validateID( __GETField( 'pagina' ) );
	if( !$offset ) {
		$offset = 0;
	}
	// pido los pacientes en base a un $offset
	$patients = q_getPatients( $whereClause, $replacements, $orderByClause, $offset );
	// veo si tengo que SEGUIR paginar
	if( count( $patients ) == 31 ) {
		array_pop( $patients );
		$stillMorePages = true;
	} else {
		$stillMorePages = false;
	}
	
	$removeSuccess = false;
	$removeError = false;
	$editError = false;
	$searchError = false;
	$searchQuickError = false;
	$tooMuchRecords = false;
	if( __issetGETField( 'exito', 'borrar-paciente' ) ) {
		$removeSuccess = true;
	// ... o de error
	} else if( __issetGETField( 'error', 'borrar-paciente' ) ) {
		$removeError = true;
		
	} else if( __issetGETField( 'error', 'editar-paciente' ) ) {
		$editError = true;
	
	} else if( __issetGETField( 'error', 'buscar-paciente' ) ) {
		$searchError = true;
		$isSearch = true;
	} else if( __issetGETField( 'error', 'buscar-paciente-rapido' ) ) {
		$searchQuickError = true;
	}
	
	$queryString = __getGETComplete( 'pagina' );
	
	$insurances = q_getAllInsurances();
	
	__render( 
		'patients', 
		array(
			'username' => $username,
			'patients' => $patients,
			'removeSuccess' => $removeSuccess,
			'removeError' => $removeError,
			'editError' => $editError,
			'letter' => $letter,
			'stillMorePages' => $stillMorePages,
			'offset' => $offset,
			'isSingle' => $isSingle,
			'queryString' => $queryString,
			'insurances' => $insurances,
			'persistValues' => $persistValues,
			'searchQuickError' => $searchQuickError,
			'quickSearchValue' => $quickSearchValue
		)
	);
/* }}} */

?>
