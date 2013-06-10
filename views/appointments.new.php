<?php t_startHead( 'Turnos - Crear' ); ?>
	<style>
		label {
			cursor: default;
		}
		.is2-availability-doctor {
			width: 250px;
		}
		.is2-patients-search-value {
			width: 430px;
		}
		.is2-dni .controls + * {
			margin: 5px 0 0 0;
		}
		.is2-availability-trigger {
			width: 190px;
		}
		.is2-patients-search-trigger {
			width: 190px;
		}
		
		.is2-popover-creationerror {
			height: 0;
			overflow: hidden;
			width: 300px;
		}
		.is2-popover-creationerror.is2-error-patient-popover {
			width: 625px;
		}
		.is2-error-msg {
			display: none;
		}
		.popover .is2-error-msg {
			display: block;
		}
		
		.is2-dni-wrapper {
			position: relative;
		}
		.is2-patients-search-remove {
			bottom: 4px;
			position: absolute;
			right: 315px;
			z-index: 10;
		}
		.is2-patients-selected {
			background: #fff;
			border-radius: 5px;
			bottom: 1px;
			left: 1px;
			list-style-type: none;
			margin: 0;
			padding: 4px;
			position: absolute;
			width: 434px;
		}
		.is2-patients-norecords {
			box-shadow: 0 1px 2px #B94A48;
			opacity: .8;
			padding: 3px 10px;
			position: absolute;
			width: 421px;
			text-shadow: 0 -1px 0 #fff;
		}
		
		.ui-autocomplete {
			max-height: 150px;
			width: 443px !important;
			overflow-y: auto;
			overflow-x: hidden;
			text-overflow: ellipsis;
			white-space: nowrap;
		}
		.is2-patient-autocompleteitem {
			display: block;
		}
		.is2-patient-autocompleteitem span {
			display: inline-block;
		}
		.is2-patient-autocompleteitem .is2-patient-name {
			font-weight: 600;
		}
		.is2-patient-autocompleteitem .is2-patient-phone {
			color: #11AA00;
		}
		.is2-patient-autocompleteitem .is2-patient-insurance {
			color: #BB0000;
			font-size: 11px;
		}
		.is2-patient-autocompleteitem .is2-patient-address {
			display: block;
			font-size: 12px;
			color: #777;
		}
		.ui-autocomplete .ui-menu-item > a:hover *, .ui-autocomplete .ui-menu-item > a.ui-state-hover *, .ui-autocomplete .ui-menu-item > a.ui-state-active *, .ui-autocomplete .ui-menu-item > a.ui-state-focus * {
			color: #fff !important;
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
						Utilice este campo para buscar el paciente mediante su número de DNI, ó por número de teléfono, ó por su nombre y/o apellido, para éste último caso, ingrese primero el apellido del paciente, seguido de una coma (,) y luego su nombre, por ejemplo para buscar al paciente <strong>Marcos Perez</strong>, debe ingresarlo de la siguiente forma: <strong>perez, marcos</strong>
					</div>
					<div class="is2-error-patient-popover is2-popover-creationerror"></div>
					<div class="alert alert-error is2-error-patientinsurancedisallowed is2-error-msg">
						El paciente posee una obra social que no es admitida por el médico en cuestión
					</div>
					<label class="control-label">Paciente</label>
					<div class="controls is2-dni-wrapper">
						<input type="text" class="input-xlarge is2-patients-search-value" placeholder="Buscar paciente por DNI, número de télefono, apellido ó nombre..." name="dni">
						<input type="hidden" class="is2-patients-search-result" name="idPaciente">
						<span class="is2-preloader is2-patients-search-preloader"></span>
						<span class="is2-patients-search-popover" data-html="true" data-trigger="hover">&nbsp;</span>
						<div class="is2-patients-search-remove" style="display:none">
							<button type="button" class="btn btn-mini btn-link btn-danger" title="Quitar este paciente para buscar otro">
								<i class="icon-remove-sign"></i>
							</button>
						</div>
						<ul class="is2-patients-selected"></ul>
						<div class="alert alert-error is2-patients-norecords" style="display:none">
							<strong>No se han encontrado resultados</strong>
						</div>
						<div class="alert alert-error is2-patient-search-popover-template is2-popover-template">
							<div>Debe seleccionar un paciente de la lista de resutados para poder proseguir con la creación del turno.</div>
							Ademas sepa que el paciente debe tener una obra social que sea admitida por el médico
						</div>
					</div>
					<div class="alert">
						Debido a que una búsqueda puede devolver muchos pacientes, esta se encuentra limitada a 50 resultados máximo, por eso se recomienda buscar por número de DNI ó por el télefono del paciente a asociar con este turno
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

	IS2.loadPrevState( 'is2-appointment-state', function( prevState ) {
		// debo realizar la busqyeda del paciente
		if( prevState['dni'] ) {
			$( '.is2-patients-search-value' ).attr( 'data-automatic-search', 'true' );
		}
	} );
	IS2.initTimepickers();
	IS2.initDatepickers(  $( '.is2-availability-date' ).val().trim() ? false : true );
	
// *** LA BUSQUEDA DE PACIENTE SE HACE MEDIATE AJAX *** //
	var isWaiting = false;
	var $dni = $( '.is2-patients-search-value' );
	var $dniPopover = $( '.is2-patients-search-popover' );
	$dniPopover.popover( { content: $( '.is2-patient-search-popover-template' ).prop( 'outerHTML' ) } );
	var $dniGroupControl = $( '.control-group.is2-dni' );
	var $preloaderSearch = $( '.is2-patients-search-preloader' );
	var $patientID = $( '.is2-patients-search-result' );
	var $removeSelectedClient = $( '.is2-patients-search-remove' );
	$removeSelectedClient.on( 'click', function( e ) {
		$dni.val( '' );
		$selectedPatient.hide();
		$patientID.val( '' );
		$removeSelectedClient.hide();
		$dni.focus();
	} );
	var $selectedPatient = $( '.is2-patients-selected' );
	var $noRecords = $( '.is2-patients-norecords' );
	
	// autocomplete functionality
	var autocompleteResponse;
	var searchedPatients = function( dataResponse ) {
		isWaiting = false;
		$preloaderSearch.css( 'visibility', 'hidden' );
		
		if( !dataResponse.success || !dataResponse.data.length ) {
			autocompleteResponse( [] );
			$noRecords.show();
			return;
		}
		$noRecords.hide();
		
		var patients = dataResponse.data, patient,
			source = [];
		while( patients.length ) {
			patient = patients.shift();
			source.push( {
				label: patient['apellidos'] + ', ' + patient['nombres'] + ' ' + patient['dni'] + ' ' + patient['obraSocialNombre'],
				value: patient['dni'],
				data: patient
			} );
		}
		
		autocompleteResponse( source );
	};
	var searchPatients = function( resquest, response ) {
		if( isWaiting ) {
			return;
		}
		
		var term = resquest.term.trim();
		if( term ) {
			autocompleteResponse = response;
			
			$preloaderSearch.css( 'visibility', 'visible' );
			isWaiting = true;
			
			$.ajax( {
				url: '/pacientes/buscar-para-turno',
				dataType: 'json',
				type: 'POST',
				data: {
					keyword: term
				},
				success: searchedPatients,
				error: searchedPatients
			} );
			return term;
		}
		
		return false;
	};
	
	var renderPatientResult = function( ul, item ) {
		var patient = item.data,
			$item = $( '<li></li>' );
		// no records found
		if( !patient ) {
			return $item.hide();
		}
		return $item.data( 'item.autocomplete', item ).attr( 'data-patient-id', patient.id ).append( '<a class="is2-patient-autocompleteitem"><span class="is2-patient-name">' + patient.apellidos + ', ' + patient.nombres + '</span> <span class="is2-patient-phone">' + patient.telefono + '</span> <span class="is2-patient-insurance">' + patient.obraSocialNombre + '</span><span class="is2-patient-address">' + patient.direccion + '</span></a>' ).appendTo( ul );
	};
	
	// init
	$dni.autocomplete( {
		source: searchPatients,
		select: function( e, ui ) {
			var patient = ui.item.data,
				$item = $( '.ui-menu-item[data-patient-id=' + patient.id + ']' ).clone();

			$selectedPatient.empty().append( $item ).show();
			$removeSelectedClient.show();
			// leave a mark
			$patientID.val( patient.id );
			$dni.blur();
		}
	} ).data( 'ui-autocomplete' )._renderItem = renderPatientResult;
	
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
			$( '<li></li>' ).html( availability.diaNombre + ' de ' + availability.horaIngreso + ' hasta ' + availability.horaEgreso ).appendTo( $availabilitiesWrapper );
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
		}
	} );
	
	var scrollToTheError = function( $el ) {
		$.scrollTo( $el, 600 );
	};
	
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
			scrollToTheError( $theForm );
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
			scrollToTheError( $theForm );
			return;
		}
		if( target - base > 604800000 ) {
			e.preventDefault();
			$dateGroupControl.addClass( 'error' );
			$datePopover.popover( { content: $( '.is2-template-overflow.is2-popover-date-template' ).prop( 'outerHTML' ) } ).popover( 'show' );
			scrollToTheError( $theForm );
			return;
		}
		$dateGroupControl.removeClass( 'error' );
		
		var time = $time.val().trim();
		if( !time ) {
			e.preventDefault();
			$timeGroupControl.addClass( 'error' );
			$timePopover.popover( 'show' );
			scrollToTheError( $theForm );
			return;
		}
		$timePopover.popover( 'hide' );
		$timeGroupControl.removeClass( 'error' );

		IS2.savePrevState( 'is2-appointment-state', 'patientID' );
	} );
	
// *** CUANDO VENGO DE UN ERROR DEBO INFORMAR EXACTAMENTE DONDE FALLO *** //
	// debo rebuscar al paciente?
	if( $dni.attr( 'data-automatic-search' ) ) {
		$dni.autocomplete( 'search' ).on( 'autocompleteopen', function( e, ui ) {
			$( '.is2-patient-autocompleteitem:first' ).click();
			$dni.off( 'autocompleteopen', arguments.callee );
		} );
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
	
	var $patientPopover = $( '.is2-error-patient-popover' );
	var $patientDoctorInsuranceIncompatible = $( '.is2-error-patientinsurancedisallowed' );
	
	var mapErrors = {
		turnos_medico_no_atiende: {
			$thePopover: $dateTimePopover,
			$popoverContent: $dateTimeUnavailableDoctorMsg,
			$scrollTo: $theForm,
			groupControl: [ $dateGroupControl, $timeGroupControl ]
		},
		turnos_medico_ocupado: {
			$thePopover: $dateTimePopover,
			$popoverContent: $dateTimeDuplicatedDoctorMsg,
			$scrollTo: $theForm,
			groupControl: [ $dateGroupControl, $timeGroupControl ]
		},
		turnos_paciente_ya_tiene_turno: {
			$thePopover: $dateTimePopover,
			$popoverContent: $dateTimePatientHasAppointment,
			$scrollTo: $theForm,
			groupControl: [ $dateGroupControl, $timeGroupControl ]
		},
		turnos_medico_con_licencia: {
			$thePopover: $dateTimePopover,
			$popoverContent: $dateDoctorHasLicense,
			$scrollTo: $theForm,
			groupControl: [ $dateGroupControl, $timeGroupControl ]
		},
		turnos_obra_social_incompatibe: {
			$thePopover: $patientPopover,
			$popoverContent: $patientDoctorInsuranceIncompatible,
			$scrollTo: $dni,
			groupControl: [ $dniGroupControl ]
		}
	};
	var errorData = mapErrors[errors];
	if( errorData ) {
		errorData.groupControl.forEach( function( $el ) {
			$el.addClass( 'error' );
		} );
		
		errorData.$thePopover.popover( {
			trigger: 'manual',
			html: true,
			content: errorData.$popoverContent.prop( 'outerHTML' )
		} ).popover( 'show' );
		setTimeout( function() {
			errorData.$thePopover.popover( 'hide' );
		}, 10000 );
		
		scrollToTheError( errorData.$scrollTo );
	}
	
})();
</script>