<?php

	function m_issetPOST() {
		return __issetPOST( array( 'apellidos', 'nombres', 'especialidad', 'telefono1', 'telefono2', 'direccion', 'matriculaProvincial', 'matriculaNacional' ) );
	}
	
	function m_processPOST( &$fields, &$errors ) {
		$lastName = __sanitizeValue( $_POST['apellidos'] );
		$firstName = __sanitizeValue( $_POST['nombres'] );
		$specialityID = __validateID( $_POST['especialidad'] );
		$tel1 = __cleanTel( $_POST['telefono1'] );
		$tel2 = __cleanTel( $_POST['telefono2'] );
		$address = __sanitizeValue( $_POST['direccion'] );
		$matProv = __sanitizeValue( $_POST['matriculaProvincial'] );
		$matNac = __sanitizeValue( $_POST['matriculaNacional'] );
		
		// check only the required fields
		if( !$lastName ) {
			$errors[] = 'lastName';
		}
		if( !$firstName ) {
			$errors[] = 'firstName';
		}
		if( !$specialityID ) {
			$errors[] = 'speciality';
		}
		
		$fields[] = $specialityID;
		$fields[] = $lastName;
		$fields[] = $firstName;
		$fields[] = $tel1;
		$fields[] = $tel2;
		$fields[] = $address;
		$fields[] = $matProv;
		$fields[] = $matNac;

		return count( $errors ) ? false : true;
	}
	
?>