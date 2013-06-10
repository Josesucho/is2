<?php

	// con este variable puedo tirale mensaje a FirePHP
	// https://addons.mozilla.org/en-US/firefox/addon/firephp
	// los mensajes se tiran llamando a la funcion __log( 'message' );
	$DEBUG = true;
	if( $DEBUG ) {
		ini_set( 'display_errors', 1 );
		ini_set( 'display_startup_errors', 1 );
		error_reporting( -1 );
	}
	
	require './assets/db.php';
	require './assets/router.php';
	// las funciones helpers tienen como prefijo __
	require './assets/helpers.php';
	// las funciones template tienen como prefijo t_
	require './views/_template.php';
	// las queries tienen como prefijo q_
	require './assets/queries.php';
	// init some things
	DB::init();
	Router::init();
	__initSession();
	__initDebugging();
	// enforce utf8 output
	__forceUTF8Enconding();
	
	// hago a que no pueda acceder a una pagina que necesite
	// de que el usuario este logueado para verla
	Router::auth( array( '/', '/iniciar-sesion' ), '/iniciar-sesion' );

	$routes = array(
		'/' => 'login',
		'/iniciar-sesion' => 'login',
		'/cerrar-sesion' => 'logout',
		'/404' => '404',
		
// *** TURNOS *** //
		'/turnos' => 'appointments',
		'/turnos/confirmar' => 'appointments.confirm',
		'/turnos/cancelar' => 'appointments.cancel',
		'/turnos/borrar' => 'appointments.remove',
		'/turnos/reiniciar' => 'appointments.reset',
		'/turnos/busqueda-rapida' => 'appointments.search.quick',
		'/turnos/busqueda-avanzada' => 'appointments.search.advanced',
		'/turnos/crear' => 'appointments.new',

// *** MEDICOS *** //
		'/medicos/comprobar-horarios-disponibilidad' => 'doctors.check.availability',
		'/medicos' => 'doctors',
		'/medicos/:id' => 'doctors.details',
		'/medicos/:id/crear-horario' => 'doctors.availability.new',
		'/medicos/:id/borrar-horario' => 'doctors.availability.remove',
		'/medicos/:id/actualizar-obras-sociales-admitidas' => 'doctors.insurances.update',
		'/medicos/:id/historial' => 'doctors.history',
		'/medicos/:id/crear-licencia' => 'doctors.license.new',
		'/medicos/:id/licencias' => 'doctors.license',
		'/medicos/:id/borrar-licencia' => 'doctors.license.remove',
		
// *** PACIENTES *** //
		'/pacientes' => 'patients',
		'/pacientes/buscar/dni' => 'patients.search.dni',
		'/pacientes/borrar' => 'patients.remove',
		'/pacientes/crear' => 'patients.new',
		'/pacientes/:id/editar' => 'patients.edit',
		'/pacientes/listar-por-letra/:char' => 'patients',
		'/pacientes/busqueda-avanzada' => 'patients.search.advanced',
		'/pacientes/busqueda-rapida' => 'patients.search.quick',
		'/pacientes/:id' => 'patients.details',

// *** ESPECIALIDADES *** //
		'/especialidades' => 'specialities',
		'/especialidades/crear' => 'specialities.new',
		'/especialidades/editar' => 'specialities.edit',
		'/especialidades/borrar' => 'specialities.remove',

// *** OBRA SOCIALES *** //
		'/obras-sociales' => 'insurances',
		'/obras-sociales/crear' => 'insurances.new',
		'/obras-sociales/editar' => 'insurances.edit',
		'/obras-sociales/borrar' => 'insurances.remove'
	);
	
	require Router::start( $routes, '/404' );

?>