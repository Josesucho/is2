<?php

	class DB {
	
		private static $db;
		private static $replacements = array();
		
		private static $typesDict = array(
			'integer' => 'i',
			'string' => 's',
			'double' => 'd'
		);
		
		private static $errorsDict = array(
			'PROCEDURE is2.medico_no_antiende_fecha_hora_requerido does not exist' => 'fecha|hora'
		);
		private static $errorsCode = array(
			'1062' => 'duplicado',
			'1054' => 'columna desconocida',
			'1064' => 'error en el diseño de la query',
			'1451' => 'clave foreana restriccion'
		);
		private static $errorsList = array();
		
	// *** PUBLIC METHODS *** //
		static function init() {
		
			if( file_exists( './mysql.ini' ) ) {
				$credenciales = parse_ini_file( './mysql.ini' );
			} else {
				$credenciales = array(
					'usuario' => 'root',
					'clave' => ''
				);
			}

			self::$db = new mysqli( 'localhost', $credenciales['usuario'], $credenciales['clave'], 'is2' );
			if( self::$db->connect_errno ) {
			    die( 'Failed to connect to MySQL: ' . self::$db->connect_error );
			}

			self::$db->set_charset( 'utf8' );
		}
		
		static function select( $query, $replacements = array() ) {
		
			self::_log( $query, $replacements );
	
			$res = array();
			
			if( $stmt = self::$db->prepare( $query ) ) {
			
				if( self::_executeQuery( $stmt, $replacements ) ) {
					// debo conseguir el nombre de las columnas
					$metadata = $stmt->result_metadata();
					$columns = array();
					while( $field = $metadata->fetch_field() ) {
						$columns[] = $field->name;
					}
					// ahora por cada nombre de columna
					// creo una variable con ese nombre de columna
					foreach( $columns as $field ) {
					    $values[] = &${$field};
					}
					
					// internamente hace un $stmt->bind_result
					self::_bindResult( $stmt, $values );
				       
					// lito, solo queda iterar cada fila y guardarla en $res
					$res = array();
					$i = 0;
					// pido la fila actual y la proceso
					while( $stmt->fetch() ) {
						foreach( $columns as $field ) {
							$res[$i][$field] = $$field;
						}
						$i++;
					}
				}
				
				$stmt->close();
				
			} else {
				self::_err( self::$db->error );
			}
			
			return $res;
		}
		
		static function update( $query, $replacements ) {

			self::_log( $query, $replacements );

			$rowsAffected = -1;
			
			if( $stmt = self::$db->prepare( $query ) ) {
				
				if( self::_executeQuery( $stmt, $replacements ) ) {
					$rowsAffected = $stmt->affected_rows;
				}
				
				$stmt->close();
				
			} else {
				self::_err( self::$db->error );
			}
			
			return $rowsAffected;
		}
		
		static function delete( $query, $replacements ) {
			return self::update( $query, $replacements );
		}
		
		static function insert( $query, $replacements ) {
		
			self::_log( $query, $replacements );
		
			$insertId = null;
			
			if( $stmt = self::$db->prepare( $query ) ) {
				
				if( self::_executeQuery( $stmt, $replacements ) ) {
					$insertId = $stmt->insert_id;
				}
				
				$stmt->close();
				
			} else {
				self::_err( self::$db->error );
			}
			
			return $insertId;
		}
		
		static function batch( $queries ) {
			self::$db->autocommit( false );
			
			foreach( $queries as $type => $data ) {
				$exitCode = self::{$type}( $data['query'], $data['replacements'] );
				if( ( is_integer( $exitCode ) && $exitCode < 0 ) || ( is_bool( $exitCode ) && !$exitCode ) ) {
					self::$db->rollback();
					self::$db->autocommit( true );
					return false;
				}
			}
			self::$db->commit();
			self::$db->autocommit( true );
			return true;
		}
		
		static function getErrorList() {
			return self::$errorsList;
		}
		
	// *** PRIVATE METHODS *** //
		private static function _executeQuery( $stmt, $replacements ) {
			// capaz que no hay tokens a reemplezar
			if( count( $replacements ) ) {
				// internamente aca se hace un $stmt->bind_param()
				self::_bindParams( $stmt, self::_addParams( $replacements ) );
			}
			
			// ejecutamos la consultado
			if( !$stmt->execute() ) {
				self::_err( $stmt->error );
				return false;
			}
			
			return true;
		}
	
		private static function _addParams( $replacements ) {
			$types = '';
			self::$replacements = array();
			
			for( $i = 0, $l = count( $replacements ); $i < $l; $i++ ) {
				$types .= self::_gettype( $replacements[$i] );
				self::$replacements[] = &$replacements[$i];
			}

			// esto sera el argumento para $stmt->bind_param();
			$args = array_merge( array( $types ), self::$replacements );
			return $args;
		}
		
		private static function _gettype( $value ) {
			$type = gettype( $value );

			if( isset( self::$typesDict[$type] ) ) {
				return self::$typesDict[$type];
			}
			
			self::_err( 'Invalid data type: ' . $type );
		}
		
		private static function _bindParams( $stmt, $args ) {
			call_user_func_array( array( $stmt, 'bind_param' ), $args );
		}
		
		private static function _bindResult( $stmt, $args ) {
			call_user_func_array( array( $stmt, 'bind_result' ) , $args );
		}
		
		private static function _log( $query, $replacements ) {
			__log( 'executing the query: ' );
			__log( $query );
			__log( 'with the params: ' );
			__log( $replacements );
		}
		
		private static function _err( $msg ) {
			__err( $msg );
			
			$errorString = self::$db->error;
			if( isset( self::$errorsDict[$errorString] ) ) {
				self::$errorsList[] = self::$errorsDict[$errorString];
			} else {
				self::$errorsList[] = self::$errorsCode[self::$db->errno];
			}
		}
	}
	
?>