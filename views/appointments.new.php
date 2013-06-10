<?php t_startHead( 'Turnos - Crear' ); ?>
	<style>
		label {
			cursor: default;
		}
		.is2-availability-doctor {
			width: 250px;
		}
		.is2-patients-search-value {
			width: 235px;
		}
		.is2-availability-trigger {
			width: 190px;
		}
		.is2-patients-search-trigger {
			width: 190px;
		}
		
		.is2-error-datetime-popover {
			height: 0;
			overflow: hidden;
			width: 300px;
		}
		.is2-error-msg {
			display: none;
		}
		.popover .is2-error-msg {
			display: block;
		}
	</style>
<?php t_endHead(); ?>
<?php t_startBody( $username, 'appointments'  ); ?>
	
		<?php t_startWrapper(); ?>
			<?php if( $createError ): ?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				<p><strong>¡Ha fallado la creación del nuevo turno!</strong></p>
				<ul>
					<li>Verifique que la fecha del turno este dentro del rango de 7 días en adelante a partir de hoy</li>
					<li>No puede crear un turno con un mismo médico a la misma hora y fecha que ya exista en el sistema</li>
					<li>No puede crear un turno si el médico en cuestión está con licencia en la fecha requerida</li>
					<li>Verifique que la hora esté dentro del rango de horarios que posee el médico</li>
					<li>Verifique que el médico soporte la misma obra social que la del paciente</li>
				</ul>
			</div>
			<?php endif; ?>
			<div class="is2-pagetitle clearfix">
				<h3>Turnos - Crear</h3>
				<a class="btn pull-right" href="/turnos"><i class="icon-arrow-left"></i> Listar turnos</a>
			</div>
			
			<form class="form-horizontal is2-appointment-form" method="post" action="">
				<div class="alert">
					Sepa que no se pueden dar turnos más allá de la próxima semana desde la fecha actual
				</div>
				<div class="control-group is2-date">
					<label class="control-label">Fecha</label>
					<div class="controls">
						<input type="text" class="input-small datepicker is2-availability-date" placeholder="Fecha" name="fecha" value="<?php echo $wantedDate; ?>">
						<span class="is2-availability-date-popover" style="visibility:hidden" data-placement="right" data-html="true" data-trigger="hover">&nbsp;</span>
					</div>
					<div class="alert alert-error is2-popover-date-template is2-template-empty is2-popover-template">
						La fecha no es válida, debe estar en el formato dd/mm/yyyy, por ejemplo algo como: 21/03/2012
					</div>
					<div class="alert alert-error is2-popover-date-template is2-template-underflow is2-popover-template">
						La fecha no puede ser anterior al dia presenete
					</div>
					<div class="alert alert-error is2-popover-date-template is2-template-overflow is2-popover-template">
						La fecha no puede exceder los 7 días desde el día de hoy
					</div>
				</div>
				<div class="is2-error-datetime-popover is2-popover-creationerror"></div>
				<div class="alert alert-error is2-error-datetimedoctorunavailable is2-error-msg">
					El médico no atiende en la fecha y hora que han sido requeridos
				</div>
				<div class="alert alert-error is2-error-datetimedoctorduplicated is2-error-msg">
					El médico ya posee un turno registrado para la fecha y hora que han sido requeridos
				</div>
				<div class="alert alert-error is2-error-datetimepatienthasappointment is2-error-msg">
					El paciente ya posee un turno para la fecha y hora que han sido requeridos con otro médico
				</div>
				<div class="alert alert-error is2-error-datedoctorhaslicense is2-error-msg">
					El médico esta de licencia para la fecha que ha sido requerida
				</div>
				<div class="control-group is2-time">
					<label class="control-label">Hora</label>
					<div class="controls bootstrap-timepicker">
						<input type="text" class="input-small timepicker is2-availability-time" placeholder="Hora" name="hora">
						<span class="is2-time-popover" style="visibility:hidden" data-placement="right" data-html="true" data-trigger="hover">&nbsp;</span>
					</div>
					<div class="alert alert-error is2-time-popover-template is2-popover-template">
						Debe suministar de una hora para el turno
					</div>
				</div>
				<div class="control-group">
					<div class="alert alert-info">
						Tenga en cuenta debe estar disponible en la fecha y hora especifícadas para poder crear el turno
					</div>
					<label class="control-label">Medico</label>
					<div class="controls">
						<select class="input-xlarge is2-availability-doctor" name="idMedico">
						<?php foreach( $doctors as $doctor ): ?>
							<option value="<?php echo $doctor['id']; ?>"><?php echo $doctor['apellidos'] . ', ' . $doctor['nombres']; ?></option>
						<?php endforeach; ?>
						</select>
						<button type="button" class="btn btn-info is2-availability-trigger" data-trigger="hover" data-placement="right" data-title="Disponibilidad del médico" data-content="Haga click en este botón para informarse acerca de la disponibilidad de este médico" data-html="true" data-trigger="hover">Comprobar disponibilidad</button>
						<span class="is2-preloader is2-availability-preloader"></span>
					</div>
				</div>
				<div class="is2-availability-template" style="display:none">
					<strong>Este médico atiende los dias:</strong>
					<ul></ul>
					<hr>
					<div class="alert alert-error is2-availability-already is2-popover-template">
						<strong>El médico ya tiene un turno registrado para la fecha y hora requerido</strong>
					</div>
					<div class="alert alert-error is2-availability-unavailable is2-popover-template">
						<strong>El médico no está disponible para la fecha y hora requerido</strong>
					</div>
					<div class="alert alert-error is2-availability-license is2-popover-template">
						<strong>El médico se encuentra de licencia, no puede crear el turno para la fecha requerida</strong>
					</div>
					<div class="alert alert-success is2-availability-success is2-popover-template">
						<strong>¡El médico esta disponible para la fecha y hora especifícado!</strong>
					</div>
				</div>
				<div class="control-group is2-dni">
					<div class="alert alert-info">
						Utilice este campo para buscar el paciente mediante su número de DNI para poder asociarlo a éste turno
					</div>
					<label class="control-label">Paciente</label>
					<div class="controls">
						<input type="text" class="input-xlarge is2-patients-search-value" placeholder="Buscar paciente por DNI..." name="dni">
						<input type="hidden" class="is2-patients-search-result" name="idPaciente">
						<button type="button" class="btn btn-info is2-patients-search-trigger">Buscar paciente</button>
						<span class="is2-preloader is2-patients-search-preloader"></span>
						<span class="is2-patients-search-popover" data-paclement="right" data-html="true" data-trigger="hover">&nbsp;</span>
					</div>
					<div class="alert alert-error is2-patient-search-popover-template is2-popover-template">
						Debe buscar un paciente cuya obra social sea soportada por el médico en cuestón para poder crear el turno
					</div>
				</div>
				<div class="alert is2-patient-search-info">
					Aquí va a aparecer el paciente que se asociará a este turno en cuestión si la búsqueda es satisfactoria
				</div>
				<div class="alert alert-error is2-patient-search-error" style="display:none">
					<strong>¡No se ha encontrado paciente con tal número de DNI!</strong>
					<p>Intentelo nuevamente</p>
				</div>
				<div class="alert alert-success is2-patient-search-success" style="display:none">
					<strong>¡Paciente encontrado!</strong>
					<p>Acontinuación se muestran los datos del paciente que se asociará a éste turno</p>
					<ul>
						<li>
							<strong>Nombre completo:</strong>
							<span data-field-name="nombreCompleto"></span>
						</li>
						<li>
							<strong>Sexo:</strong>
							<span data-field-name="sexo"></span>
						</li>
						<li>
							<strong>Número de DNI:</strong>
							<span data-field-name="dni"></span>
						</li>
						<li>
							<strong>Fecha de nacimiento:</strong>
							<span data-field-name="fechaNacimiento"></span>
						</li>
						<li>
							<strong>Edad:</strong>
							<span data-field-name="edad"></span>
						</li>
						<li>
							<strong>Teléfono:</strong>
							<span data-field-name="telefono"></span>
						</li>
						<li>
							<strong>Obra social:</strong>
							<span data-field-name="obraSocialNombre"></span>
						</li>
						<li>
							<strong>Número de afiliado:</strong>
							<span data-field-name="nroAfiliado"></span>
						</li>
					</ul>
					<div class="alert alert-error is2-patient-search-insurance-error">
						<p><strong>¡Este médico no soporta la obra social de este paciente!</strong></p>
						No puede utilizar a este paciente para crear el turno
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button type="submit" class="btn btn-primary btn-large">Crear turno</button>
					</div>
				</div>
			</form>
		<?php t_endWrapper(); ?>
		
<?php t_endBody(); ?>

<script>
(function() {

	IS2.initDatepickers( true );
	IS2.initTimepickers();
	IS2.loadPrevState( 'is2-appointment-state', function( prevState ) {
		// debo realizar la busqyeda del paciente
		if( prevState['dni'] ) {
			$( '.is2-patients-search-value' ).attr( 'data-automatic-search', 'true' );
		}
	} );
	
// *** LA BUSQUEDA DE PACIENTE SE HACE MEDIATE AJAX *** //
	var isWaiting = false;
	var $dni = $( '.is2-patients-search-value' );
	var $dniPopover = $( '.is2-patients-search-popover' );
	$dniPopover.popover( { content: $( '.is2-patient-search-popover-template' ).prop( 'outerHTML' ) } );
	var $dniGroupControl = $( '.control-group.is2-dni' );
	var $preloaderSearch = $( '.is2-patients-search-preloader' );
	var $search = $( '.is2-patients-search-trigger' );
	var $errorMsg = $( '.is2-patient-search-error' );
	var $successMsg = $( '.is2-patient-search-success' );
	var $errorInsuranceMsg = $( '.is2-patient-search-insurance-error' );
	var $patientID = $( '.is2-patients-search-result' );
	
	var searchedPatient = function( dataResponse ) {
		isWaiting = false;
		$preloaderSearch.css( 'visibility', 'hidden' );
		
		if( !dataResponse.success ) {
			return;
		}
		$( '.is2-patient-search-info' ).hide();
		// si esto se setta es que hay paciente
		$patientID.val( '' );
		
		var data = dataResponse.data,
			patientData, supportInsurance;

		if( !data ) {
			// no hubo match
			$successMsg.hide();
			$errorMsg.show();
			
		} else {
			patientData = data.patient,
			supportInsurance = data.supportInsurance;
		
			$errorMsg.hide();
			$successMsg.find(  'span' ).each( function() {
				var $el = $( this );
				$el.html( patientData[$el.attr( 'data-field-name' )] );
			} );
			
			if( supportInsurance ) {
				// dejo la marca
				$patientID.val( patientData['id'] );
				$errorInsuranceMsg.hide();
			} else {
				$errorInsuranceMsg.show();
			}
			
			$successMsg.slideDown();
		}
	};
	
	$search.bind( 'click', function( e ) {
		if( isWaiting ) {
			return;
		}

		// clean previous state
		$dniPopover.popover( 'hide' );
		
		var dni = $dni.val().trim();
		if( !dni ) {
			$dniGroupControl.addClass( 'error' );
			$dniPopover.popover( 'show' );
			return;
		}
		
		$dniGroupControl.removeClass( 'error' );
		$preloaderSearch.css( 'visibility', 'visible' );
		isWaiting = true;
		
		$.ajax( {
			url: '/pacientes/buscar/dni',
			data: {
				dni: dni,
				doctorID: $doctor.val()
			},
			dataType: 'json',
			type: 'POST',
			success: searchedPatient,
			error: searchedPatient
		} );
	} );

// *** EL CHECKEO DE DISPONIBLIDAD SE HACE MEDIANTE AJAX *** //
	var $date = $( '.is2-availability-date' );
	var $datePopover = $( '.is2-availability-date-popover');
	var $dateGroupControl = $( '.is2-date' );
	var $time = $( '.is2-availability-time' );
	var $timePopover = $( '.is2-time-popover');
	$timePopover.popover( { content: $( '.is2-time-popover-template' ).prop( 'outerHTML' ) } );
	var $timeGroupControl = $( '.is2-time' );
	var $doctor = $( '.is2-availability-doctor' );
	var $preloaderAvailability = $( '.is2-availability-preloader' );
	var $availabilityTrigger = $( '.is2-availability-trigger' );
	$availabilityTrigger.popover();
	var defaultMsg = $availabilityTrigger.attr( 'data-content' );
	var $availabilityTemplate = $( '.is2-availability-template' );
	var DAYNAME = [ 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo' ];
	
	var padTime = function( value ) {
		return value.substring( 0, 5 );
	};

	var checkedAvailability = function( dataResponse ) {
		isWaiting = false;
		$preloaderAvailability.css( 'visibility', 'hidden' );
		
		if( !dataResponse.success ) {
			return;
		}
		var data = dataResponse.data;
		
		var $availabilitiesWrapper = $availabilityTemplate.find( 'ul' );
		$availabilitiesWrapper.empty();
		var availabilities = data.availabilities;
		var availability;
		while( availabilities.length ) {
			availability = availabilities.shift();
			$( '<li></li>' ).html( DAYNAME[availability.dia-1] + ' de ' + padTime( availability.horaIngreso ) + ' hasta ' + padTime( availability.horaEgreso ) ).appendTo( $availabilitiesWrapper );
		}
		
		$availabilityTemplate.find( '.alert' ).hide();
		if( data.hasLicense ) {
			$availabilityTemplate.find( '.is2-availability-license' ).show();
		} else if( data.hasAppointmentAlready ) {
			$availabilityTemplate.find( '.is2-availability-already' ).show();
		} else if( data.isAvailable ) {
			$availabilityTemplate.find( '.is2-availability-success' ).show();
		} else {
			$availabilityTemplate.find( '.is2-availability-unavailable' ).show();
		}
		
		$availabilityTrigger.popover( { content:  $availabilityTemplate.html() } ).popover( 'show' );
	};
	
	$availabilityTrigger.on( 'click', function( e ) {
		if( isWaiting ) {
			return;
		}
		
		var date = $date.val().trim(),
			time = $time.val().trim(),
			doctorID = $doctor.val();
			
		if( !date ) {
			$dateGroupControl.addClass( 'error' );
			return;
		}
		$dateGroupControl.removeClass( 'error' );
		if( !time ) {
			$timeGroupControl.addClass( 'error' );
			return;
		}
		$timeGroupControl.removeClass( 'error' );
		
		$preloaderAvailability.css( 'visibility', 'visible' );
		$availabilityTrigger.popover( 'destroy' );
		isWaiting = true;
		
		$.ajax( {
			url: '/medicos/comprobar-horarios-disponibilidad',
			data: {
				date: date,
				time: time,
				doctorID: doctorID
			},
			dataType: 'json',
			type: 'POST',
			success: checkedAvailability,
			error: checkedAvailability
		} );
	} );
	
	// reset popover
	$doctor.on( 'change', function( e ) {
		$availabilityTrigger.popover( 'destroy' );
		$availabilityTrigger.popover( { content: defaultMsg } );
	} );
	
// *** OTRAS YERBAS *** //
	// esto es por si apreta <ENTER> estando en DNI, evito que submitte el form
	$dni.on( 'keydown', function( e ) {
		if( e.keyCode === 13 ) {
			e.stopPropagation();
			e.preventDefault();
			$search.click();
		}
	} );
	
	// si no ha paciente elegido, no contunio
	var $theForm = $( '.is2-appointment-form' );
	$theForm.on( 'submit', function( e ) {
	
		if( IS2.lookForEmptyFields( $theForm ) ) {
			e.preventDefault();
			return;
		}

		$datePopover.popover( 'destroy' );
		// hide any popover from error post
		$( '.is2-popover-creationerror' ).popover( 'hide' );
		
		if( !$patientID.val().trim() || !$dni.val().trim() ) {
			e.preventDefault();
			$dniGroupControl.addClass( 'error' );
			$dniPopover.popover( 'show' );
			return;
		}
		$dniPopover.popover( 'hide' );
		$dniGroupControl.removeClass( 'error' );
		
		var date = $date.val(),
			target,
			base = new Date();
		
		date = date.match( /^(\d{2})\/(\d{2})\/(\d{4})$/ );
		if( !date ) {
			e.preventDefault();
			$dateGroupControl.addClass( 'error' );
			$datePopover.popover( { content: $( '.is2-template-empty.is2-popover-date-template' ).prop( 'outerHTML' ) } ).popover( 'show' );
			return;
		}
		target = new Date();
		target.setDate( 1 );
		target.setFullYear( date[3] );
		target.setMonth( date[2]-1 );
		target.setDate( date[1] );

		if( base > target ) {
			e.preventDefault();
			$dateGroupControl.addClass( 'error' );
			$datePopover.popover( { content: $( '.is2-template-underflow.is2-popover-date-template' ).prop( 'outerHTML' ) } ).popover( 'show' );
			return;
		}
		if( target - base > 604800000 ) {
			e.preventDefault();
			$dateGroupControl.addClass( 'error' );
			$datePopover.popover( { content: $( '.is2-template-overflow.is2-popover-date-template' ).prop( 'outerHTML' ) } ).popover( 'show' );
			return;
		}
		$dateGroupControl.removeClass( 'error' );
		
		var time = $time.val().trim();
		if( !time ) {
			e.preventDefault();
			$timeGroupControl.addClass( 'error' );
			$timePopover.popover( 'show' );
			return;
		}
		$timePopover.popover( 'hide' );
		$timeGroupControl.removeClass( 'error' );

		IS2.savePrevState( 'is2-appointment-state', 'patientID' );
	} );
	
// *** CUANDO VENGO DE UN ERROR DEBO INFORMAR EXACTAMENTE DONDE FALLO *** //
	// debo rebuscar al paciente?
	if( $dni.attr( 'data-automatic-search' ) ) {
		$search.click();
	}
	var errors = window.location.search.match( /campos=([^&$]+)/ );
	if( errors ) {
		try {
			errors = atob( errors[1] );
		} catch( e ) {
		}
	}
	
	var $dateTimePopover = $( '.is2-error-datetime-popover' );
	var $dateTimeUnavailableDoctorMsg = $( '.is2-error-datetimedoctorunavailable' );
	var $dateTimeDuplicatedDoctorMsg = $( '.is2-error-datetimedoctorduplicated' );
	var $dateTimePatientHasAppointment = $( '.is2-error-datetimepatienthasappointment' );
	var $dateDoctorHasLicense = $( '.is2-error-datedoctorhaslicense' );
	var mapErrors = {
		turnos_medico_no_atiende: $dateTimeUnavailableDoctorMsg,
		turnos_medico_ocupado: $dateTimeDuplicatedDoctorMsg,
		turnos_paciente_ya_tiene_turno: $dateTimePatientHasAppointment,
		turnos_medico_con_licencia: $dateDoctorHasLicense
	};
	var $theError = mapErrors[errors];
	if( $theError ) {
		$dateGroupControl.addClass( 'error' );
		$timeGroupControl.addClass( 'error' );
		$dateTimePopover.popover( {
			trigger: 'manual',
			html: true,
			content: $theError.prop( 'outerHTML' )
		} ).popover( 'show' );
		setTimeout( function() {
			$dateTimePopover.popover( 'hide' );
		}, 10000 );
	}
	
	
})();
</script>