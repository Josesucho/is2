<?php

	function m_issetPOST() {
		return __issetPOST( array( 'lastName', 'firstName', 'gender', 'dni', 'birthDate', 'phone', 'address', 'insuranceID', 'insuranceNumber' ) );
	}
	
	function m_processPOST( &$fields, &$errors ) {
		$lastName = __sanitizeValue( $_POST['lastName'] );
		$firstName = __sanitizeValue( $_POST['firstName'] );
		$gender = __validateGender( $_POST['gender'] );
		$dni = __cleanDNI( $_POST['dni'] );
		$birthDate = __toISODate( $_POST['birthDate'] );
		// la fecha de nacimiento no puede ser mayor al dia presente
		if( strtotime( $birthDate ) > strtotime( 'today +1 day' ) ) {
			$birthDate = false;
		}
		$phone = __cleanTel( $_POST['phone'] );
		$address = __sanitizeValue( $_POST['address'] );
		$insuranceID = $_POST['insuranceID'];
		if( $insuranceID === 1 ) {
			$insuranceNumber = '---';
		} else {
			$insuranceNumber = trim( $_POST['insuranceNumber'] );
		}
		
		if( !$lastName ) {
			$errors[] = 'lastName';
		}
		if( !$firstName ) {
			$errors[] = 'firstName';
		}
		if( !$dni ) {
			$errors[] = 'dni';
		}
		if( !$gender ) {
			$errors[] = 'gender';
		}
		if( !$birthDate ) {
			$errors[] = 'birthDate';
		}
		if( !$phone ) {
			$errors[] = 'phone';
		}
		if( !$address ) {
			$errors[] = 'address';
		}
		if( !$insuranceID ) {
			$errors[] = 'insuranceID';
		}
		if( !$insuranceNumber ) {
			$errors[] = 'insuranceNumber';
		}
		
		$fields[] = $lastName;
		$fields[] = $firstName;
		$fields[] = $gender;
		$fields[] = $dni;
		$fields[] = $birthDate;
		$fields[] = $phone;
		$fields[] = $address;
		$fields[] = $insuranceID;
		$fields[] = $insuranceNumber;

		return count( $errors ) ? false : true;
	}
	
?>