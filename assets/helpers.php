<?php

	function __redirect( $url ) {
		$url = trim( $url );
	
		if( preg_match( '/:\/\//', $url ) ) {
			$url = '/404';
			
		} else if( $url{0} != '/' ) {
			$url = '/' . $url;
		}
		
		header( 'location: ' . $url, true );
		die;
	}
	
	function __echoJSON( $data ) {
		header( 'content-type: application/json', true );
		echo json_encode( $data );
		die;
	}
	
	function __throw404Error() {
		header( 'HTTP/1.0 404 Not Found' );
	}

	function __forceUTF8Enconding() {
		header( 'content-type: text/html; charset=utf-8' );
	}
	
// ************** /
// FIREPHP funcionality
// ************* /
	function __initDebugging() {
		global $DEBUG;
		if( $DEBUG ) {
			ob_start();
		}
	}
	
	function __log() {
		global $DEBUG;
		if( $DEBUG ) {
			require_once './debug/FirePHP.class.php';
			$firephp = FirePHP::getInstance( true );
			foreach( func_get_args() as $arg ) {
				$firephp->log( is_bool( $arg ) ? ( $arg ? 'true' : 'false' ) : $arg );
			}
		}
	}
	
	function __err() {
		global $DEBUG;
		if( $DEBUG ) {
			require_once './debug/FirePHP.class.php';
			$firephp = FirePHP::getInstance( true );
			foreach( func_get_args() as $arg ) {
				$firephp->log( is_bool( $arg ) ? ( $arg ? 'true' : 'false' ) : $arg );
			}
		}
	}
	
// ************** /
// $_GET & $_POST
// ************* /
	function __issetPOST( $fields ) {
		return $_SERVER['REQUEST_METHOD'] == 'POST' && count( $_POST ) > 0 && count( array_diff( $fields, array_keys( $_POST ) ) ) == 0;
	}
	
	// con este function me fijo si en el $_GET, existe $_GET[$name] = $value
	function __issetGETField( $name, $value ) {
		return count( $_GET ) > 0 && isset( $_GET[$name] ) && $_GET[$name] == $value;
	}

	function __GETField( $name ) {
		return count( $_GET ) > 0 && isset( $_GET[$name] ) ? __sanitizeValue( $_GET[$name] ) : false;
	}
	
	function __getGETComplete( $skip = '' ) {
		$q = array();
		if( count( $_GET ) ) {
			foreach( $_GET as $name => $value ) {
				if( $name != $skip ) {
					$q[] = $name . '=' . $value;
				}
			}
			return '?' . __sanitizeValue( implode( '&', $q ) );
		}
		return '?';
	}
	
// ************** /
// TODO ESTO HACE USO $_SESSION
// ************* /
	function __initSession() {
		session_start();
	}
	
	function __endSession() {
		session_destroy();
	}
	
	function __isUserLogged() {
		return isset( $_SESSION['is_logged'] ) && $_SESSION['is_logged'];
	}
	
	function __setUserLogin() {
		$_SESSION['is_logged'] = true;
	}
	
	function __setUsername( $username ) {
		$_SESSION['username'] = $username;
	}
	
	function __getUsername() {
		return $_SESSION['username'];
	}
	
// ************** /
// ACA TAN LOS SANITIZERS
// ************* /
	function __toISODate( $value ) {
		$value = explode( '/', trim( $value ) );
		if( count( $value ) != 3 ) {
			return false;
		}
		$year = $value[2];
		if( $year <= 0 || strlen( (int) $year ) != 4 ) {
			return false;
		}
		$month = $value[1];
		if( $month <= 0 || $month > 12 ) {
			return false;
		}
		if( $month < 10 ) {
			$month = '0' . (int) $month;
		}
		$date = $value[0];
		$yearMonth = $year . '-' . $month;
		if( $date <= 0 || $date > date( 't', strtotime( $yearMonth ) ) ) {
			return false;
		}
		if( $date < 10 ) {
			$date = '0' . (int) $date;
		}
		
		return $yearMonth . '-' . $date;
	}
	
	function __dateISOToLocale( $value ) {
		$value = explode( '-', $value );
		if( count( $value ) != 3 ) {
			return '';
		}
		return $value[2] . '/' . $value[1] . '/' . $value[0];
	}
	
	function __toISOTime( $value ) {
		if( !preg_match( '/^(\d{2}):(\d{2})(?: (PM|AM)|(:\d{2})?)$/i', trim( $value ), $m ) ) {
			return false;
		}
		if( count( $m ) < 3 ) {
			return false;
		}
		$hours = $m[1];
		$minutes = $m[2];
		$meridian = isset( $m[3] ) ? $m[3] : false;
		if( $meridian ) {
			if( $hours > 12 || $minutes > 59 ) {
				return false;
			}
			if( $meridian == 'PM' ) {
				$hours += 12;
			}
		}
		
		return $hours . ':' . $minutes . ( isset( $m[4] ) ? $m[4] : ':00' );
	}
	
	function __timeISOToLocale( $value ) {
		$value = explode( ':', $value );
		if( count( $value ) != 3 ) {
			return '';
		}
		$hours = $value[0];
		if( $hours > 12 ) {
			$hours = $hours - 12;
			$meridian = 'PM';
		} else {
			$meridian = 'AM';
		}
		if( $hours < 10 ) {
			$hours = '0' . (int) $hours;
		}
		
		return $hours . ':' . $value[1] . ' ' . $meridian;
	}
	
	function __trimTime( $value ) {
		return substr( $value, 0, 5 );
	}

	function __cleanDNI( $value ) {
		$value = str_replace( '.', '', trim( $value ) );
		return preg_match( '/^\d+$/', $value ) ? $value : false;
	}
	
	function __sanitizeValue( $value ) {
		return htmlspecialchars( $value );
	}
	
	function __validateID( $value ) {
		return $value > 0 ? (int) $value : false;
	}
	
	function __cleanTel( $value ) {
		return ( $m = preg_replace( '/^[^#*\d-()]+$/', '', trim( $value ) ) ) ? $m : false;
	}
	
	function __validateGender( $value ) {
		$value = strtoupper( $value );
		return in_array( $value, array( 'F', 'M' ) ) ? $value : false;
	}
	
	function __validateEmail( $value ) {
		return preg_match( '/^[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]+$/i', trim( $value ) ) ? $value : false;
	}
	
	function __getAppointmentStatus( $value ) {
		if( $value == 'confirmados' ) {
			return 'confirmado';
		} else if( $value == 'cancelados' ) {
			return 'cancelado';
		}
		return false;
	}
	
	function __getDayName( $dayIndex ) {
		$DAYNAME = [ 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo' ];
		return isset( $DAYNAME[$dayIndex-1] ) ? $DAYNAME[$dayIndex-1] : false;
	}
	
	function __validateDayIndex( $dayIndex ) {
		return in_array( $dayIndex, array( 1, 2, 3, 4, 5, 6, 7 ) ) ? $dayIndex : false;
	}
	
// ************** /
// RENDER VIEWS
// ************* /
	function __render( $__filename__, $vars = array() ) {
		
		$__fullPath__ =  './views/' . $__filename__ . '.php';
		if( !file_exists( $__fullPath__ ) ) {
			die( 'Specified view: "' . $__filename__ . '" does not exists at the path: "' . $__fullPath__ . '"' );
		}
		
		extract( $vars );
		require $__fullPath__;
	}
?>