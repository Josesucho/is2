<?php

	$doctorID = Router::seg( 2 );
	
	$licenses = DB::select(
		'
			SELECT
				id, fechaComienzo, fechaFin
			FROM
				licencias
			WHERE
				idMedico = ?
			ORDER BY
				fechaFin DESC
		',
		array( $doctorID )
	);
	
	for( $i = 0, $l = count( $licenses ); $i < $l; $i++ ) {
		$license = &$licenses[$i];
		$license['fechaComienzo'] = __dateISOToLocale( $license['fechaComienzo'] );
		$license['fechaFin'] = __dateISOToLocale( $license['fechaFin'] );
	}
	
	__echoJSON( array( 
		'success' => true,
		'data' => $licenses
	) );

?>