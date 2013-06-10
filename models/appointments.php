<?php

// ACA CONSTRUYO EL WHERE DE MI QUERY
	$replacements = array();
	$whereClause = array();
	$isLimitClause = false;
	// usada para mostrar turnos segun su estado, por defecto se muestran
	// todos , pero esto puede cambiar cuando se hace una busqueda avanazada
	$statusValue = false;
	// aca voy a guardar los parametros de busqueda (fecha, hora, etc)
	// para luego utilizarlo para rellenar el formulario de busqueda
	$persistValues = array(
		'fromDate' => '',
		'toDate' => '',
		'fromTime' => '',
		'toTime' => '',
		'doctorsList' => array(),
		'patientsDNI' => '',
		'status' => ''
	);
	$isSearch = false;
	$isQuickSearch = false;
	$quickSearchValue = false;

// ESTO ES CUANDO EL USUARIO HACE UNA BUSQUEDA AVANZADA
	if( ( $search = __GETField( 'busqueda-avanzada' ) ) ) {
		$isSearch = true;
	
		$searchParts = explode( '|', __sanitizeValue( base64_decode( $search ) ) );
		if( count( $searchParts ) != 5 ) {
			__redirect( '/turnos?error=buscar-turno' );
		}
		// la primera parte es la feha
		$dateRange = explode( '@', $searchParts[0] );
		// no pasa nada si se mete mano en estos datos
		if( isset( $dateRange[0] ) && $dateRange[0] ) {
			$whereClause[] = ' fecha >= ? ';
			$replacements[] = $persistValues['fromDate'] = $dateRange[0];
		}
		if( isset( $dateRange[1] ) && $dateRange[1] ) {
			$whereClause[] = ' fecha <= ? ';
			$replacements[] = $persistValues['toDate'] = $dateRange[1];
		}
		// la segunda parte el time range
		$timeRange = explode( '@', $searchParts[1] );
		if( isset( $timeRange[0] ) && $timeRange[0] ) {
			$whereClause[] = ' hora >= ? ';
			$replacements[] = $persistValues['fromTime'] = $timeRange[0];
		}
		if( isset( $timeRange[1] ) && $timeRange[1] ) {
			$whereClause[] = ' hora <= ? ';
			$replacements[] = $persistValues['toTime'] = $timeRange[1];
		}
		// la tercera parte es una lista de doctores
		$doctorsLists = explode( '-', $searchParts[2] );
		// hago el OR clause
		$doctorsOrClause = array();
		foreach( $doctorsLists as $doctorID ) {
			if( $doctorID ) {
				$doctorsOrClause[] = ' m.id = ? ';
				$replacements[] = $persistValues['doctorsList'][$doctorID] = $doctorID;
			}
		}
		if( count( $doctorsOrClause ) ) {
			$whereClause[] = ' ( ' . implode( ' OR ', $doctorsOrClause ) . ' ) ';
		}
		// la cuarta parte es una lista de pacientes de DNIs
		$patientsDNI = explode( '-', $searchParts[3] );
		// hago el OR clause
		$patientsOrClause = array();
		foreach( $patientsDNI as $dni ) {
			if( $dni ) {
				$patientsOrClause[] = ' p.dni = ? ';
				$replacements[] = $persistValues['patientsDNI'][] = $dni;
			}
		}
		if( count( $patientsOrClause ) ) {
			$whereClause[]	= ' ( ' . implode( ' OR ', $patientsOrClause ) . ' ) ';
			$persistValues['patientsDNI'] = implode( ' ', $persistValues['patientsDNI'] );
		}
		// la quinta parte es el estado del turno
		if( $searchParts[4] ) {
			$statusValue = $persistValues['status'] = $searchParts[4];
		};
		
		if( !count( $whereClause ) ) {
			$whereClause[] = ' 1 = 1 ';
		}
	
// ESTE ES CUANDO VENGO DE CREAR UN TURNO
	} else if( ( $newAppointment = __GETField( 'id' ) ) && __validateID( $newAppointment ) ) {
		$isSearch = true;
	
		$whereClause[] = ' t.id = ? ';
		$replacements[] = $newAppointment;
		
// ACA CUANDO HACE UNA BUSQUEDA RAPIDA
	} else if( ( $keyword = __GETField( 'busqueda' ) ) ) {
		$keyword = __sanitizeValue( base64_decode( $keyword ) );
		if( !$keyword ) {
			__redirect( '/turnos?error=buscar-turno-rapido' );
		}
		$keyword = explode( '=', $keyword );
		if( count( $keyword ) != 2 ) {
			__redirect( '/turnos?error=buscar-turno-rapido' );
		}
		
		$field =  $keyword[0];
		$value = $keyword[1];
		if( $field == 'fecha' ) {
			$whereClause[] = ' fecha = ? ';
			$replacements[] = $value;
			$value = __dateISOToLocale( $value );
			
		} else if( $field == 'hora' ) {
			$whereClause[] = ' hora = ? ';
			$replacements[] = $value;
			
		} else if( $field == 'estado' ) {
			$whereClause[] = ' estado = ? ';
			$replacements[] = $value;
			
		} else if( $field == 'comodin' ) {
			$whereClause[] = ' ( m.nombres LIKE ? OR m.apellidos LIKE ? OR p.apellidos LIKE ? OR p.nombres LIKE ? ) ';
			$replacements[] = '%' . $value . '%';
			$replacements[] = '%' . $value . '%';
			$replacements[] = '%' . $value . '%';
			$replacements[] = '%' . $value . '%';
		
		} else {
			__redirect( '/turnos?error=buscar-turno-rapido' );
		}
		
		$quickSearchValue = $value;
		$isQuickSearch = true;
		$isSearch = true;
		$isLimitClause = true;
	
// ESTE ES EL WHERE NORMAL, OSEA CUANDO SE ESTA ACCEDIENDO DIRECTAMENTE A /turnos
	} else {
		$whereClause[] = ' fecha >= ? ';
		$replacements[] = $startDate = date( 'Y-m-d' );
		$whereClause[] = ' fecha <= ? ';
		// en modo normal se muestran los turnos desde la fecha actual hasta + 7 dias
		$replacements[] = $endDate = date( 'Y-m-d', strtotime( '+7 days' ) );
	}
	
	// SE PUEDEN FILTAR LOS TURNOS MEDIANTE LA COLUMNA "ACCIONES" O MEDINATE UNA BUSQUEDA
	if( $statusValue && ( $statusValue = __getAppointmentStatus( $statusValue ) ) ) {
		$whereClause[] = ' estado = ? ';
		$replacements[] = $statusValue;
	}
	
	$searchError = false;
	$searchQuickError = false;
	$tooMuchRecords = false;
	if( __issetGETField( 'error', 'buscar-turno' ) ) {
		$searchError = true;
		$isSearch = true;
	} else if( __issetGETField( 'error', 'buscar-turno-rapido' ) ) {
		$searchQuickError = true;
	}
	
	// dont waste a sql query is error is setted up
	if( !$searchError && !$searchQuickError ) {
	
		$dummyQueries = array();
		$dummyReplacements = array();
		if( !$isSearch ) {
			// generate the dummy selects, with this will now include
			// in the results set days that dont have appointments
			$days = 7;
			$baseDate = strtotime( $startDate );
			while( $days-- ) {
				$dummyQueries[] = 
				'
					SELECT
						null AS id, ? AS fecha, null AS hora, null AS estado,
						null AS idMedico, null AS medicoNombres, null AS medicoApellidos, null AS medicoAvatar,
						null AS idPaciente, null AS pacienteNombres, null AS pacienteApellidos
				';
				$baseDate = strtotime( 'next day', $baseDate );
				$dummyReplacements[] = date( 'Y-m-d', $baseDate );
			}
		}
		
		$appointments = DB::select(
			'
			SELECT
				*
			FROM (
			' .
		
			( count( $dummyQueries ) ? implode( ' UNION ALL ', $dummyQueries ) . ' UNION ALL ' : '' ) .
		
		
			'
				SELECT 
					t.id, fecha, hora, estado,
					m.id AS idMedico, m.nombres AS medicoNombres, m.apellidos AS medicoApellidos, m.avatarMini AS medicoAvatar,
					p.id AS idPaciente, p.nombres AS pacienteNombres, p.apellidos AS pacienteApellidos
				FROM turnos AS t 
					INNER JOIN medicos AS m 
						ON m.id = t.idMedico 
					INNER JOIN pacientes AS p 
						ON p.id = t.idPaciente 
				WHERE ' .
					implode( ' AND ', $whereClause ) .
					
				( $isLimitClause ? ' LIMIT 0, 21 ' : '' ) .
				
			'
			) AS 
				appointments
			ORDER BY
				fecha ASC, hora ASC
			'
			,
			array_merge( $dummyReplacements, $replacements )
		);
		// too much records
		if( $isQuickSearch && count( $appointments ) == 21 ) {
			array_pop( $appointments );
			$tooMuchRecords = true;
		}
		
	} else {
		$appointments = array();
	}

// PIDO LOS MEDICOS, ESTOS ES DEBIDO A QUE LA BUSQUEDA DESPLIEGA UNA
// LISTA QUE CONTIENE TODOS LOS MEDICOS EN EL SISTEMA
	$doctors = q_getAllDoctors();
	
	$username = __getUsername();
	
	// esto es usado para mostrar un mensaje cuando se accede a /turnos
	// sobre de que los turnos que estan siendo mostrados son los desde la
	// la fecha actual hasta los siguiente 7 dias
	$currentDate = !$isSearch && !$isQuickSearch ? date( 'd/m/Y' ) : false;

	// to translate date( 'j' ) to its spanish correpsndece
	$DAYNAME = array(
		'Mon' => 'Lunes',
		'Tue' => 'Martes',
		'Wed' => 'Miércoles',
		'Thu' => 'Jueves',
		'Fri' => 'Viernes',
		'Sat' => 'Sábado',
		'Sun' => 'Domingo'
	);
	// to translate date( 'M' ) to spanish
	$MONTHNAME = array(
		'Jan' => 'Enero',
		'Feb' => 'Febrero',
		'Mar' => 'Marzo',
		'Apr' => 'Abril',
		'May' => 'Mayo',
		'Jun' => 'Junio',
		'Jul' => 'Julio',
		'Aug' => 'Agosto',
		'Sep' => 'Septiembre',
		'Oct' => 'Octubre',
		'Nov' => 'Noviembre',
		'Dec' => 'Diciembre'
	);
		
// LOAD THE VIEW
	__render( 
		'appointments', 
		array(
			'username' => $username,
			'currentDate' => $currentDate,
			'searchError' => $searchError,
			'searchQuickError' => $searchQuickError,
			'quickSearchValue' => $quickSearchValue,
			'tooMuchRecords' => $tooMuchRecords,
			'appointments' => $appointments,
			'doctors' => $doctors,
			'persistValues' => $persistValues,
			'DAYNAME' => $DAYNAME,
			'MONTHNAME' => $MONTHNAME
		)
	);

?>
