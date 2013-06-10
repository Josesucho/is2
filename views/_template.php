<?php
	
// ************** /
// ESTAS FUNCIONES SE USAN EN LAS VIEWS
// ************* /
	function t_startHead( $page ) {
		require './views/_head.start.php';
	}
	
	function t_endHead() {
		require './views/_head.end.php';
	}
	
	function t_startBody( $username, $currentTab ) {
		require './views/_body.start.php';
	}
	
	function t_endBody() {
		require './views/_body.end.php';
	}
	
	function t_startWrapper() {
		require './views/_wrapper.start.php';
	}
	
	function t_endWrapper() {
		require './views/_wrapper.end.php';
	}
	
	function t_dateMenu() {
		require './views/_appointments.date.menu.php';
	}
	
	function t_timeMenu() {
		require './views/_appointments.time.menu.php';
	}
	
	function t_statusMenu() {
		require './views/_appointments.status.menu.php';
	}
	
	function t_appointmentNewRow( $appointmentDateLocale ) {
		require './views/_appointments.row.new.php';
	}
	
	function t_lastNameMenu() {
		require './views/_patients.lastname.menu.php';
	}
	
	function t_firstNameMenu() {
		require './views/_patients.firstname.menu.php';
	}

	function t_birthDateMenu() {
		require './views/_patients.birthname.menu.php';
	}
	
	function t_setCustomTypeface() {
		require './views/_custom.fontface.php';
	}

?>