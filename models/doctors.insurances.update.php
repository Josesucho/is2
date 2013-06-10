<?php

	$doctorID = Router::seg( 2 );
	
	if( !__issetPOST( array( 'insurances' ) ) ) {
		__echoJSON( array( 'success' => false ) );
	}
	$insurances = $_POST['insurances'];
	if( !is_array( $insurances ) ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	$setValuesClause = array();
	$replacements = array();
	foreach( $insurances as $insuranceID ) {
		$setValuesClause[] = ' ( null, ?, ?  ) ';
		$replacements[] = $doctorID;
		$replacements[] = $insuranceID;
	}
	
	$queries = array(
		'delete' => array(
			'query' => 'DELETE FROM medicosObrasSociales WHERE idMedico = ?',
			'replacements' => array( $doctorID )
		)
	);
	
	if( count( $setValuesClause ) ) {
		$queries['insert'] = array(
			'query' => 'INSERT INTO medicosObrasSociales VALUES ' . implode( ', ', $setValuesClause ),
			'replacements' => $replacements
		);
	}
	
	$exitCode = DB::batch( $queries );
	
	__echoJSON( array( 
		'success' => $exitCode,
		'data' => $insurances
	) );
	
?>