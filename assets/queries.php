<?php

// PONER AQUI AQUELLAS QUERIES QUE SON USADAS MAS DE UNA
// VEZ POR LOS DIFERENTES MODELOS

	function q_getAllDoctors() {
		return DB::select(
			'
				SELECT
					*
				FROM 
					medicos
				ORDER BY
					apellidos, nombres
			'
		);
	}
	
	function q_getAllInsurances() {
		return DB::select(
			'
				SELECT
					*
				FROM
					obrasSociales
				ORDER BY
					nombreCorto
			'
		);
	}
	
	function q_getPatients( $whereCluase, $replacements, $orderByClause = array(), $offset = 0 ) {
	
		if( $offset ) {
			$offset = $offset * 30;
		}
		$replacements[] = $offset;
		
		return DB::select(
			'
				SELECT
					p.id, p.apellidos, p.nombres, p.sexo, p.dni, p.idObraSocial, p.fechaNacimiento, p.telefono, p.nroAfiliado,
					os.nombreCorto AS obraSocialNombre
				FROM
					pacientes AS p
				INNER JOIN obrasSociales AS os
					ON os.id = p.idObraSocial
				WHERE ' .
					implode( ' AND ', $whereCluase ) .
			
				( count( $orderByClause ) ? ' ORDER BY ' . implode( ', ', $orderByClause ) : ''  ) .
				
				' LIMIT ?, 31 '
				
			, $replacements
		);
	}

	function q_getDoctorAvailabilities( $doctorID, $availabilityID = null ) {
		$replacements = array();
		$replacements[] = $doctorID;
		if( $availabilityID ) {
			$replacements[] = $availabilityID;
		}
	
		return DB::select(
			'
				SELECT
					*
				FROM
					horarios
				WHERE
					idMedico = ?
			' .
				( $availabilityID ? ' AND id = ? ' : '' ) .
			'
				ORDER BY
					dia, horaIngreso, horaEgreso
			'
			,
			$replacements
		);
	}
	
	function q_getDoctorInsurances( $doctorID ) {
		return DB::select(
			'
				SELECT
					os.id, os.nombreCorto, os.nombreCompleto
				FROM
					medicosObrasSociales AS mos
					INNER JOIN obrasSociales AS os
						ON os.id = mos.idObraSocial
				WHERE
					mos.idMedico = ?
				ORDER BY
					os.nombreCorto
			',
			array( $doctorID )
		);
	}

?>