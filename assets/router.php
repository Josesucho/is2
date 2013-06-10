<?php

	class Router {
	
		// aca se guarda el matcheo de la url
		private static $m;
		
		static function init() {
		}
		
		static function auth( $guestPages = array(), $loginPage = '' ) {
			$page = Router::_getPage();
			// debo saber si la pagina aonde ira el usuario
			// solo puede ser accedida por usuarios loguedaos
			for( $i = 0, $l = count( $guestPages ); $i < $l; $i++ ) {
				$guest = $guestPages[$i];
				// la pagina que quiere ver el usuario no necesita
				// de que el usuario este logueado para verla, terminado
				if( $guest == $page ) {
					break;
				}
			}
			// la pagina que quiere ver el usuario es protegida
			// vemos si el usuario esta logueado
			if( $i == $l && !__isUserLogged() ) {
				// redirect then, after success login to the page that user
				// wants in at first instance
				if( $loginPage{0} != '/' ) {
					$loginPage = '/' . $loginPage;
				}
				__redirect( $loginPage . '?destino=' . $page . Router::_getQuery() );
			}
		}
		
		static function start( $routes = array(), $fallbackRoute = '' ) {
			$page = Router::_getPage();
			$count = 0;
			foreach( $routes as $route => $model ) {
				if( Router::test( $route, $page ) ) {
					$path = './models/' . $model . '.php';
					if( !file_exists( $path ) ) {
						die( 'Specified model "' . $model . '" does not exists at "' . $path . '"' );
					}
					return $path;
				} else {
					$count++;
				}
			}
			// la pagina que se quiere acceder no existe
			if( $count == count( $routes ) ) {
				if( $fallbackRoute{0} != '/' ) {
					$fallbackRoute = '/' . $fallbackRoute;
				}
				__redirect( $fallbackRoute . '?destino=' . $page . Router::_getQuery() );
			}
		}
		
		static function test( $pat = '', $page = '' ) {
			Router::$m = array();
		
			// just a /clients/list == /clients/list
			if( $pat == $page ) {
				return true;
			}
			// aca tengo algo como /clients/edit/:id
			$pat = explode( '/', $pat );
			// aca tengo algo cmo /clients/edit/123
			$page = explode( '/', $page );
			$l = count( $page );
			if( count( $pat ) == $l ) {
				for( $i = 0; $i < $l; $i++ ) {
					// aca tengo 123
					$seg = $page[$i];
					// aca tengo :id
					$cmp = $pat[$i];
					// es :id entonces seg debe un entero
					if( $cmp == ':id' ) {
						if( $seg <= 0 ) {
							return false;
						}
					} else if( $cmp == ':char' ) {
						if( !in_array( strtoupper( $seg ), range( 'A', 'Z' ) ) ) {
							return false;
						}
					// si $cmp no es algo como :id entonces es
					// $seg y $cmp deben ser iguales para poder continuar
					} else if( $seg != $cmp ) {
						return false;
					}
					// keep saving the matches
					Router::$m[] = $seg;
				}
				return true;
			}
			return false;
		}
		
		static function seg( $i = 0 ) {
			return isset( Router::$m[$i] ) ? Router::$m[$i] : null;
		}
		
		private static function _getPage() {
			// veo adonde quiere ir el usuario
			$url = parse_url( $_SERVER['REQUEST_URI'] );
			return preg_replace( '/\/?index\.php\/?/', '/', $url['path'] );
		}
		
		private static function _getQuery() {
			$query = $_SERVER['QUERY_STRING'];
			return $query ? '?' . $query : '';
		}
		
	}

?>