<?php t_startHead( 'Médicos' ); ?>
	<style>
		.is2-doctor-presentation {
			display: inline-block;
			width: 300px;
			padding: 5px 5px 20px;
			margin: 0 0 20px 0;
			white-space: nowrap;
			border-radius: 10px;
			transition: all 300ms ease-in-out;
			position: relative;
			background-color: #fff;
		}
		.is2-doctor-presentation img {
			border-radius: 50px;
			display: inline-block;
			margin: 0 10px 0 0;
			vertical-align: middle;
		}
		.is2-doctor-presentation-name {
			display: inline-block;
			vertical-align: bottom;
		
		}
		.is2-doctor-presentation-name h3 {
			font-size: 20px;
			white-space: pre-wrap;
			width: 210px;
			word-wrap: break-word;
			transition: all 300ms linear;
		}
		.is2-doctor-presentation-name div {
			transition: all 300ms linear; 
		}
		.is2-doctor-actions {
			margin: 10px 0 0 0;
		}
		
		/* animation effect */
		@keyframes moveFromBottom {
			from {
				opacity: 0;
				transform: translateY(200%);
			}
			to {
				opacity: 1;
				transform: translateY(0%);
			}
		}
		@keyframes moveFromTop {
			from {
				opacity: 0;
				transform: translateY(-200%);
			}
			to {
				opacity: 1;
				transform: translateY(0%);
			}
		}
		@-webkit-keyframes moveFromTop {
			from {
				opacity: 0;
				-webkit-transform: translateY(-200%);
			}
			to {
				opacity: 1;
				-webkit-transform: translateY(0%);
			}
		}
		@-webkit-keyframes moveFromBottom {
			from {
				opacity: 0;
				-webkit-transform: translateY(200%);
			}
			to {
				opacity: 1;
				-webkit-transform: translateY(0%);
			}
		}	
		.is2-doctor-presentation:hover img {
			box-shadow: 0 0 10px #32a2c3;
		}
		.is2-doctor-presentation:hover .is2-doctor-presentation-name h3 {
			animation: moveFromTop 300ms ease-in-out;
			-webkit-animation: moveFromTop 300ms ease-in-out;
		}
		.is2-doctor-presentation:hover .is2-doctor-presentation-name-speciality {
			animation: moveFromBottom 300ms ease-in-out;
			-webkit-animation: moveFromBottom 300ms ease-in-out;
		}
		
		/* modal */
		#is2-modal-doctor {
			background: #fff;
			padding: 0;
			width: 850px;
			height: 495px;
			z-index: 100000;
			overflow: hidden;
		}
		.is2-modal-preloader {
			left: 54%;
		}
		.is2-modal-details-header {
			z-index: 1000000;
			position: relative;
		}
		#is2-modal-doctor .modal-body {
			line-height: 0;
			overflow: hidden;
			padding: 0;
			position: absolute;
			right: 4px;
			top: 5px;
		}
		.is2-modal-details-body {
			height: 495px;
			overflow: hidden;
		}
		.is2-modal-details-body h3 {
			margin: 5px 0 0 0;
		}
		
		.is2-modal-doctor-information {
			float: left;
			width: 200px;
			padding: 30px;
			height: 100%;
			text-align: center;
			text-shadow: 0 -1px 0 #555;
			border-right: 1px solid #58CAF5;
			position: relative;
			z-index: 100;
		}
		.is2-modal-doctor-information img {
			border-radius: 50px;
			display: block;
			margin: 0 auto;
			box-shadow: 0 -2px 0 #555;
		}
		.is2-modal-details-tabs {
			position: absolute;
			left: 0;
			top: 0;
			width: 100%;
			overflow: hidden;
			z-index: 10;
		}
		.is2-modal-details-tabs .nav {
			margin: 0 0 0 261px;
			padding: 3px 0 0 3px;
			border: 0;
		}
		.is2-modal-details-tabs .nav a {
			color: #fff;
			font-variant: small-caps;
			border-radius: 0;
			width: 145px;
			text-align: center;
		}
		.is2-modal-details-tabs .nav a:first-letter {
			font-weight: 600;
		}
		.nav-tabs > .active > a, .nav-tabs > .active > a:hover, .nav-tabs > .active > a:focus {
			color: #555;
			text-shadow: none;
		}
		.nav > li > a:hover, .nav > li > a:focus {
			background-color: #F1F1F1;
			color: #555;
			text-decoration: none;
			text-shadow: 0 1px 0 #F1F1F1;
		}
	
		#is2-doctor-availability-insurances {
			height: 495px;
			border-left: 1px solid #0C688A;
			padding: 35px 0 0 0;
		}
		.is2-modal-doctor-availability {
			float: left;
			width: 300px;
			padding: 0 10px;
			height: 100%;
			border-right: 1px solid #ddd;
		}
		.is2-doctor-insurances {
			float: left;
			width: 250px;
			padding: 0 0 20px 10px;
			height: 100%;
		}
		.is2-doctor-insurances-grid {
			overflow-y: scroll;
			height: 380px;
		}
		
		.is2-input-grid td {
			padding: 5px 0;
		}
		.is2-grid-header {
			background: #fbfbfb;
			border-radius: 0;
			border-top: 1px solid #ddd;
			color: #555;
			text-shadow: 0 1px 0 #fff;
		}
		.is2-grid-header th:first-child,
		.is2-doctor-availability-grid td:first-child {
			width: 60px;
		}
		.is2-grid-header th:nth-child( 2 ) {
			width: 75px;
		}
		.is2-grid-header th:nth-child( 3 ) {
			width: 70px;
		}
		.is2-doctor-availability-grid td:last-child,
		.is2-doctor-insurances-grid td:last-child {
			width: 28px;
		}
		.is2-doctor-availability-grid td {
			text-align: center
		}
		.bootstrap-timepicker-widget td {
			border: 0;
		}
		
		.record-removed * {
			text-decoration: line-through;
		}
		.record-removed .btn {
			visibility: hidden;
		}
		
		.is2-modal-doctor-status {
			left: 33%;
			opacity: .9;
			padding-right: 14px;
			position: absolute;
			text-align: center;
			top: 39px;
			width: 500px;
		}
		
		#is2-doctor-appointments {
			padding: 40px 0 0 0;
			border-left: 1px solid #0C688A;
		}
		.is2-doctor-appointments-grid {
			overflow-y: scroll;
			height: 455px;
		}
		.is2-doctor-appointments-grid td {
			text-align: center;
			padding: 0;
			font-size: 13px;
		}
		.is2-doctor-appointments-grid td a {
			font-size: 13px;
		}
		.is2-doctor-appointments-grid table {
			margin: 2px auto 0;
			width: 99%;
		}
		.is2-doctor-appointments-grid table tr:first-child td { 
			border-top: 0;
		}
		.is2-doctor-appointments-grid td:last-child {
			width: 110px;
		}
		
		#is2-doctor-licenses {
			padding: 50px 10px;
			border-left: 1px solid #0C688A;
			height: 455px;
		}
		.is2-doctor-licenses-form {
			margin: 0 0 5px 0;
		}
		.is2-doctor-licenses-form label {
			margin: 0 5px 0 0;
		}
		.is2-doctor-licenses-form .control-group {
			display: inline-block;
		}

		.is2-licenses-legend {
			margin: 0;
		}
		.is2-licenses-wrapper {
			height: 250px;
			overflow-y: scroll;
		}
		.is2-licenses-table td {
			text-transform: none !important;
		}
		.is2-licenses-table tr:first-child td { 
			border-top: 0;
		}
		.is2-licenses-table td:last-child {
			text-align: right;
		}
		.is2-licenses-record-empty {
			margin: 5px 10px 0;
			text-align: center;
		}
	</style>

<?php t_endHead(); ?>
<?php t_startBody( $username, 'doctors'  ); ?>
	
		<?php t_startWrapper(); ?>
		
		<div class="is2-pagetitle clearfix">
			<h3>Médicos</h3>
			<a class="btn pull-right btn-warning" href="/medicos/crear"><i class="icon-plus"></i> Crear un nuevo médico</a>
		</div>
		
		<div class="alert alert-info">
			A continuación se muestran todos los médicos actualmente cargados en el sistema
		</div>
		<div class="is2-doctors-grid">
		<?php foreach( $doctors as $doctor ): ?>
			<div class="is2-doctor-presentation">
				<img src="/img/<?php echo $doctor['avatar']; ?>">
				<div class="is2-doctor-presentation-name">
					<h3><?php echo $doctor['apellidos'] . ', ' . $doctor['nombres']; ?></h3>
					<div class="is2-doctor-presentation-name-speciality"><?php echo $doctor['especialidad']; ?></div>
					<div class="is2-doctor-actions">
						<button class="btn btn-mini is2-doctor-presentation-trigger" data-doctor-id="<?php echo $doctor['id']; ?>" title="Ver en detalle"><i class="icon-eye-open"></i></button>
						<a href="/medicos/<?php echo $doctor['id']; ?>/editar" class="btn btn-mini" title="Editar datos personales"><i class="icon-edit"></i></a>
						<button class="btn btn-mini btn-danger" data-doctor-id="<?php echo $doctor['id']; ?>"  title="Borrar médico del sistema"><i class="icon-remove-sign icon-white"></i></button>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
		</div>
		
		<a class="is2-modal-doctor-trigger" href="#is2-modal-doctor" data-toggle="modal" style="display:none"></a>
		<div id="is2-modal-doctor" class="modal hide fade">
			<div class="is2-modal-wrapper">
				<div class="progress progress-striped active is2-modal-preloader">
					<div class="bar"></div>
				</div>
				<div class="is2-modal-details-header">
					<div class="modal-body">
						<button class="btn btn-link is2-modal-close" data-dismiss="modal">
							<i class="icon-remove-sign icon-white"></i>
						</button>
					</div>
				</div>
				<div class="is2-modal-details-body">
					<div class="is2-modal-doctor-information btn-info">
						<img src="" class="is2-modal-doctor-avatar">
						<h3><span class="is2-modal-doctor-field" data-field-name="apellidos"></span>, <span class="is2-modal-doctor-field" data-field-name="nombres"></span></h3>
						<p class="is2-modal-doctor-field" data-field-name="especialidad"></p>
						<div class="is2-modal-doctor-information-misc">
							<p>Mat. nac.: <strong class="is2-modal-doctor-field" data-field-name="matriculaNacional"></strong></p>
							<p>Mat. prov.: <strong class="is2-modal-doctor-field" data-field-name="matriculaProvincial"></strong></p>
							<p>Teléfonos:<br><strong class="is2-modal-doctor-field" data-field-name="telefono1"></strong><br><strong class="is2-modal-doctor-field" data-field-name="telefono2"></strong></p>
							<p>Dirección personal:<br><strong class="is2-modal-doctor-field" data-field-name="direccion"></strong></p>
						</div>
					</div>
					
					<div class="is2-modal-details-tabs btn-inverse">
						<ul class="nav nav-tabs">
							<li class="active">
								<a class="is2-modal-details-tabs-default" href="#is2-doctor-availability-insurances" data-toggle="tab">Horarios y obras sociales</a>
							</li>
							<li>
								<a class="is2-doctor-appointments-trigger" href="#is2-doctor-appointments" data-toggle="tab">Historial de turnos</a>
							</li>
							<li>
								<a class="is2-doctor-licenses-trigger" href="#is2-doctor-licenses" data-toggle="tab">Licencias</a>
							</li>
						</ul>
					</div>
					
					<div class="tab-content">
						<div id="is2-doctor-availability-insurances" class="tab-pane active">
							<div class="is2-modal-doctor-status alert alert-success is2-new-availability" style="display:none">
								Nuevo horario del médico ha sido creado satisfactoriamente
							</div>
							<div class="is2-modal-doctor-status alert alert-success is2-remove-availability" style="display:none">
								El horario del médico ha sido eliminado satisfactoriamente
							</div>
							<div class="is2-modal-doctor-status alert alert-success is2-update-insurances" style="display:none">
								Obras sociales admitidas por el médico han sido actualizadas satisfactoriamente
							</div>
							
							<div class="is2-modal-doctor-availability">
								<h3>Horarios</h3>
								<table class="table is2-grid-header">
									<tr>
										<th>Día</th>
										<th>Hora de ingreso</th>
										<th>Hora de egreso</th>
										<th></th>
									</tr>
								</table>
								<table class="table is2-doctor-availability-grid">
									<tr class="is2-doctor-availability-record">
										<td class="is2-field" data-field-name="diaNombre"></td>
										<td class="is2-field" data-field-name="horaIngreso"></td>
										<td class="is2-field" data-field-name="horaEgreso"></td>
										<td>
											<a class="btn btn-mini btn-danger is2-doctor-availability-record-remove" href="#" data-toggle="modal" title="Borrar"><i class="icon-remove-sign icon-white"></i></a>
										</td>
									</tr>
								</table>
								<form class="is2-doctor-availability-form">
									<table class="table is2-input-grid">
										<tr>
											<td class="control-group is2-doctor-availability-day">
												<input type="text" class="input-mini is2-doctor-availability-day" name="diaNombre" placeholder="Día">
											</td>
											<td class="control-group is2-doctor-availability-in">
												<div class="bootstrap-timepicker">
													<input type="text" class="input-mini timepicker is2-doctor-availability-in" name="horaIngreso" placeholder="Hora de ingreso">
												</div>
											</td>
											<td class="control-group is2-doctor-availability-out">
												<div class="bootstrap-timepicker">
													<input type="text" class="input-mini timepicker is2-doctor-availability-out" name="horaEgreso" placeholder="Hora de egreso">
												</div>
											</td>
											<td>
												<button class="btn btn-info is2-doctor-availability-trigger" title="Agregar nuevo horario">Agregar</button>
											</td>
										</tr>
									</table>
								</form>
								<div class="is2-doctor-availability-popover alert alert-error is2-popover">
									El médico ya posee un horario registrado con estos mismo parametros
								</div>
							</div>
							
							<form class="is2-doctor-insurances">
								<h3>Obras sociales</h3>
								<div class="is2-doctor-insurances-grid-wrapper" style="display:none">
									<div class="is2-doctor-insurances-grid">
									<?php foreach( $insurances as $insurance ): ?>
										<label class="checkbox" data-insurance-id="<?php echo $insurance['id']; ?>">
											<span class="is2-field" data-field-name="nombreCorto"><?php echo $insurance['nombreCorto']; ?></span>
											<span class="is2-field" data-field-name="nombreCompleto"><?php echo $insurance['nombreCompleto']; ?></span>
											<input type="checkbox" name="insurancesList[]" value="<?php echo $insurance['id']; ?>">
										</label>
									<?php endforeach; ?>
									</div>
								</div>
								<button class="btn btn-info is2-doctor-insurances-trigger" title="Actualizar obras sociales admitidas por el medico">Actualizar</button>
							</form>
						</div><!-- is2-doctor-availability-insurances -->
						
						<div id="is2-doctor-appointments" class="tab-pane">
							<div class="is2-doctor-appointments-grid">
								<table class="table is2-doctor-appointments-table">
									<tr class="is2-doctor-appointments-record">
										<td class="is2-field" data-field-name="fecha"></td>
										<td class="is2-field" data-field-name="hora"></td>
										<td><span class="is2-field" data-field-name="apellidos"></span>, <span class="is2-field" data-field-name="nombres"></span></td>
										<td class="is2-field" data-field-name="estado"></td>
										<td>
											<a href="" class="btn btn-link is2-doctor-appointment-link" target="_blank">Ir al turno <i class="icon-share-alt"></i></a>
										</td>
									</tr>
								</table>
							</div>
						</div>
						
						<div id="is2-doctor-licenses" class="tab-pane">
							<div class="is2-modal-doctor-status alert alert-error is2-error-lincense-duplicated" style="display:none">
								El médico ya posee una licencia en el rango de fechas suministrado
							</div>
							<div class="is2-modal-doctor-status alert alert-error is2-error-lincense-busy" style="display:none">
								<strong>El médico actualmente posee turnos que debe cumplir, no se puede crear la licencia bajo esta circunstancia</strong>
							</div>
							<div class="is2-modal-doctor-status alert alert-error is2-error-lincense-underflow" style="display:none">
								<strong>No puede crear una licencia para tiempo pasado</strong>
							</div>
							<div class="is2-modal-doctor-status alert alert-success is2-success-lincense" style="display:none">
								<div>La licencia del médico ha sido creada satisfactoriamente</div>
								<strong>Recuerde que durante la duración de la licencia, no se podrán crear nuevos turnos para este médico</strong>
							</div>
							<legend>Utilice este formulario para crear una licencia para este médico</legend>
							<div class="alert">
								Sepa que no puede crear una licencia para este médico, si es que este posee turnos que actualmente debe cumplir
							</div>
							<form class="is2-doctor-licenses-form form-inline">
								<div class="control-group is2-doctor-licenses-start">
									<label class="control-label">Desde la fecha
										<input type="text" placeholder="desde" class="input-small datepicker is2-doctor-licenses-start">
									</label>
								</div>
								<div class="control-group is2-doctor-licenses-end">
									<label class="control-label">hasta el:
										<input type="text" placeholder="hasta" class=" input-small datepicker is2-doctor-licenses-end">
									</label>
								</div>
								<button type="submit" class="btn btn-info">Crear licencia</button>
							</form>
							<div class="alert alert-error is2-popover">
								El médico ya posee una licencia para la fecha especificada
							</div>
							<div class="alert alert-error is2-popover">
								No se pudo crear la licencia porque este médico posee actualmente turnos que debe cumplir
							</div>
							<div class="alert alert-error is2-popover is2-licenses-date-invalid">
								La fecha es invalida, debe estar en el formato dd/mm/yyyy, por ejemplo algo como: 20/10/2010
							</div>
							<div class="alert alert-error is2-popover is2-licenses-date-range">
								La fecha <strong>desde</strong> es mayor que la fecha <strong>hasta</strong>
							</div>
							<div class="alert alert-error is2-popover is2-licenses-date-underflow">
								La fecha <strong>desde</strong> no puede ser anteror al día presente
							</div>
							<legend class="is2-licenses-legend">Historial de licencias</legend>
							<div class="is2-licenses-wrapper">
								<table class="table is2-licenses-table" style="display:none">
									<tr class="is2-licenses-record">
										<td>
										Desde el <strong class="is2-field" data-field-name="fechaComienzo"></strong> hasta el <strong class="is2-field" data-field-name="fechaFin"></strong>
										</td>
										<td>
											<button class="btn btn-mini btn-danger is2-license-remove-trigger" title="Borrar licencia"><i class="icon-remove-sign icon-white"></i></button>
										</td>
									</tr>
								</table>
								<div class="alert alert-info is2-licenses-record-empty" style="display:none">
									<strong>Médico sin licencias registradas hasta el momento</strong>
								</div>
							</div>
						</div>
					</div>
					
				</div><!-- is2-modal-details-body -->
			</div><!-- is2-modal-wrapper -->
		</div>

		<?php t_endWrapper(); ?>
	
<?php t_endBody(); ?>
<script>
(function() {

// *** modal functionality *** //
	var $triggerModal = $( '.is2-modal-doctor-trigger' );
	var $doctorModal = $( '#is2-modal-doctor' );
	var $defaultTab = $( '.is2-modal-details-tabs-default' );
	$doctorModal.on( 'hidden', function( e ) {
		e.stopPropagation();
		window.location.hash = 'dummy';
		$doctorModal.removeAttr( 'data-doctor-id' );
		$appointmentsWrapper.hide().empty();
		$licensesGrid.hide().empty();
		$defaultTab.click();
		$doctorModal.find( '.popover' ).hide();
		$doctorModal.find( '.error' ).removeClass( 'error' );
		
	} ).css( 'left', $( window ).outerWidth() /2 - 850 / 2 ).css( 'margin-left', 0 );
	var cleanAllInputs = function() {
		$availabilityForm.find( 'input' ).val( '' );
		$licensesForm.find( 'input' ).val( '' );
	};
	var $doctorModalPreloader = $( '.is2-modal-preloader' );
	var $doctorModalPreloaderBar = $doctorModalPreloader.find( '.bar' );
	var showPreloader = function() {
		$doctorModalPreloaderBar.css( 'width', '1%' );
		$doctorModalPreloader.fadeIn( 'fast' );
	};
	var hidePreloader = function() {
		$doctorModalPreloaderBar.css( 'width', '100%' );
		window.setTimeout( function() {
			$doctorModalPreloader.fadeOut( 'fast' );
		}, 500 );
	};
	var isWaiting = false;
	
	var getDoctorID = function() {
		return $doctorModal.attr( 'data-doctor-id' );
	};
	
	var $doctorFields = $( '.is2-modal-doctor-field' );
	var $doctorAvatar = $( '.is2-modal-doctor-avatar' );
	
	var $doctorAvailabilitiesWrapper = $( '.is2-doctor-availability-grid' );
	var $doctorAvailabilitiesRecord = $( '.is2-doctor-availability-record' ).clone();
	$( '.is2-doctor-availability-record' ).remove();
	
	var $doctorInsurancesWrapper = $( '.is2-doctor-insurances-grid-wrapper' );
	var $doctorInsurancesGrid = $( '.is2-doctor-insurances-grid' ).clone();
	$( '.is2-doctor-insurances-grid' ).remove();
	
	var showAvailabilities = function( data, appendOnly ) {
		if( !appendOnly ) {
			$doctorAvailabilitiesWrapper.empty();
		}
		var recordData, $record, $fields, $field,
			i, l;
		while( data.length ) {
			recordData = data.shift();
			$record = $doctorAvailabilitiesRecord.clone();
			
			$fields = $record.find( '.is2-field' );
			for( i = 0, l = $fields.length; i < l; i++ ) {
				$field = $fields.eq( i );
				$field.html( recordData[$field.attr( 'data-field-name' )] );
			}
			$record.attr( 'data-availability-id', recordData.id ).find( '.is2-doctor-availability-record-remove' ).attr( 'data-availability-id', recordData.id );
			
			$doctorAvailabilitiesWrapper.append( $record );
		}
	};

	var showDoctorDetails = function( dataResponse ) {
		isWaiting = false;
		hidePreloader();
		if( !dataResponse.success ) {
			return;
		}
		
		var data = dataResponse.data,
			doctorData = data.doctor,
			availabilities = data.availabilities,
			insurances = data.insurances;
			
		var i = 0, l = $doctorFields.length, $field;
		for( ; i < l; i++ ) {
			$field = $doctorFields.eq( i );
			$field.html( doctorData[$field.attr( 'data-field-name' )] );
		}
		$doctorAvatar.attr( 'src', '/img/' + doctorData['avatar'] );
		
		showAvailabilities( availabilities );
		
		$doctorInsurancesWrapper.hide().empty();
		var selectedInsurances = [],
			$doctorInsurancesGridCloned = $doctorInsurancesGrid.clone(),
			insurance, $insurance;
		while( insurances.length ) {
			insurance = insurances.shift();
			$insurance = $doctorInsurancesGridCloned.find( 'label[data-insurance-id=' + insurance + ']' );
			$insurance.find( 'input[type=checkbox]' ).attr( 'checked', 'checked' );
			selectedInsurances.push( $insurance );
		}
		// reoder the grid
		$doctorInsurancesGridCloned.children().first().before( selectedInsurances );
		setTimeout( function() {
			$doctorInsurancesWrapper.append( $doctorInsurancesGridCloned ).show();
		}, 500 );
	};
	
	$( '.is2-doctor-presentation-trigger' ).on( 'click', function( e ) {
		if( isWaiting ) {
			return;
		}
		
		cleanAllInputs();
		// show modal
		$triggerModal.click();
		showPreloader();
		isWaiting = true;

		var doctorID = $( this ).attr( 'data-doctor-id' );
		$doctorModal.attr( 'data-doctor-id', doctorID );
		window.location.hash = 'id=' + doctorID;
		// get doctor availabilities and insurances support
		$.ajax( {
			url: '/medicos/' + doctorID,
			dataType: 'json',
			type: 'GET',
			success: showDoctorDetails,
			error: showDoctorDetails
		} );
	} );
	
	// crear nuevo horario funcionalidad
	var DAYSNAME = [ 'lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo' ];
	$( '.is2-doctor-availability-day' ).typeahead( {
		source: DAYSNAME,
		items: 3
	} ).attr( 'autocomplete', 'off' );
	IS2.initTimepickers();
	
	var isWaiting = false;
	
	var $dayName = $( 'input.is2-doctor-availability-day' );
	var $dayNameGroupControl = $( '.control-group.is2-doctor-availability-day' );
	
	var $timeEntryIn = $( 'input.is2-doctor-availability-in' );
	var $timeEntryInGroupControl = $( '.control-group.is2-doctor-availability-in' );
	var $timeEntryOut = $( 'input.is2-doctor-availability-out' );
	var $timeEntryOutGroupControl = $( '.control-group.is2-doctor-availability-out' );
	var timeRegex = /^(?:[0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/;
	var isTimeValid = function( $input, $groupControl ) {
		var time = $input.val().trim().match( timeRegex );
		if( !time ) {
			$groupControl.addClass( 'error' );
			return false;
		}
		$groupControl.removeClass( 'error' );
		return time;
	};
	
	var $newAvailability = $( '.is2-new-availability' );
	
	var createdAvailability = function( dataResponse ) {
		isWaiting = false;
		hidePreloader();
		
		if( !dataResponse.success ) {
			// duplicated entry
			$availabilityForm.popover( 'show' );
			$dayNameGroupControl.addClass( 'error' );
			$timeEntryInGroupControl.addClass( 'error' );
			$timeEntryOutGroupControl.addClass( 'error' );
			return;
		}
		cleanAllInputs();
		hidePopover( $availabilityForm );

		showAvailabilities( [ dataResponse.data ], true );
		
		$( '.is2-doctor-availability-record:last' ).effect( 'highlight', null, 1500 );
		
		IS2.showCrudMsg( $newAvailability, 2 );
	};
	
	var hidePopover = function( $el ) {
		var popover = $el.data( 'popover' );
		if( popover ) {
			popover.tip().hide();
		}
	};
	
	var $availabilityForm = $( '.is2-doctor-availability-form' );
	$availabilityForm.popover( {
		html: true,
		content: $( '.is2-doctor-availability-popover' ).prop( 'outerHTML' ),
		trigger: 'manual'
	
	// create mode
	} ).on( 'submit', function( e ) {
		e.stopPropagation();
		e.preventDefault();
		if( isWaiting ) {
			return;
		}
		
		hidePopover( $availabilityForm );
		
		if( IS2.lookForEmptyFields( $availabilityForm, true ) ) {
			$dayNameGroupControl.addClass( 'error' );
			return;
		}
		
		var dayName = $dayName.val().trim().toLowerCase().replace( /á/g, 'a' ).replace( /é/g, 'e' ),
			dayIndex = DAYSNAME.indexOf( dayName );
		if( dayIndex < 0 ) {
			$dayNameGroupControl.addClass( 'error' );
			return;
		}
		dayIndex++;
		$dayNameGroupControl.removeClass( 'error' );
		
		var timeEntryIn;		
		if( !( timeEntryIn = isTimeValid( $timeEntryIn, $timeEntryInGroupControl ) ) ) {
			return;
		}
		timeEntryIn = timeEntryIn[0]
		
		var timeEntryOut;
		if( !( timeEntryOut = isTimeValid( $timeEntryOut, $timeEntryOutGroupControl ) ) ) {
			return;
		}
		timeEntryOut = timeEntryOut[0];

		var d1 = timeEntryIn.split( ':' ),
			d2 = timeEntryOut.split( ':' );
			
		if( d1[0] >= d2[0] && d1[1] >= d2[1] ) {
			$timeEntryInGroupControl.addClass( 'error' );
			$timeEntryOutGroupControl.addClass( 'error' );
			return;
		}
		$timeEntryInGroupControl.removeClass( 'error' );
		$timeEntryOutGroupControl.removeClass( 'error' );

		isWaiting = true;
		$doctorModalPreloaderBar.css( 'width', '1%' );
		$doctorModalPreloader.fadeIn( 'fast' );

		$.ajax( {
			url: '/medicos/' + getDoctorID() + '/crear-horario',
			data: {
				dayIndex: dayIndex,
				timeEntryIn: timeEntryIn,
				timeEntryOut: timeEntryOut
			},
			dataType: 'json',
			type: 'POST',
			success: createdAvailability,
			error: createdAvailability
		} );
	} );
	
	// *** remover un horario *** //
	var $removeAvailability = $( '.is2-remove-availability' );
	var removedAvailability = function( dataResponse ) {
		isWaiting = false;
		hidePreloader();
		if( !dataResponse.success ) {
			return;
		}
		var appointmentID = dataResponse.data;
		$( '.is2-doctor-availability-record[data-availability-id=' + appointmentID + ']' ).addClass( 'record-removed' );
		IS2.showCrudMsg( $removeAvailability, 2 );
	};
	
	$doctorModal.delegate( '.is2-doctor-availability-record-remove', 'click', function( e ) {
		e.preventDefault();
		if( isWaiting ) {
			return;
		}
		
		hidePopover( $availabilityForm );
		
		$doctorModalPreloaderBar.css( 'width', '1%' );
		$doctorModalPreloader.fadeIn( 'fast' );
		isWaiting = true;
		
		var availabilityID = $( this ).attr( 'data-availability-id' );
		$.ajax( {
			url: '/medicos/' + getDoctorID() + '/borrar-horario',
			type: 'POST',
			dataType: 'json',
			data: {
				id: availabilityID
			},
			success: removedAvailability,
			error: removedAvailability
		} );
	} );
	
// *** obra sociales functionality *** //
	var $updatedInsurances = $( '.is2-update-insurances' );
	var updatedInsurancesSupport = function( dataResponse ) {
		isWaiting = false;
		hidePreloader();
		if( !dataResponse.success ) {
			return;
		}
		var insurances = dataResponse.data;
		while( insurances.length ) {
			$( 'label[data-insurance-id=' + insurances.shift() + ']' ).effect( 'highlight', null, 1500 );
		}
		IS2.showCrudMsg( $updatedInsurances, 2 );
	};
	
	$( '.is2-doctor-insurances' ).on( 'submit', function( e ) {
		e.preventDefault();
		if( isWaiting ) {
			return;
		}
		var $insurances = $doctorInsurancesWrapper.find( 'input[type="checkbox"]:checked' ),
			insurancesSelected = [],
			i = 0, l = $insurances.length;
			
		for( ; i < l; i++ ) {
			insurancesSelected.push( $insurances.eq( i ).val() );
		}
		
		isWaiting = true;
		showPreloader();
		
		// save a refrence for latter
		$.ajax( {
			url: '/medicos/' + getDoctorID() + '/actualizar-obras-sociales-admitidas',
			dataType: 'json',
			type: 'POST',
			data: {
				insurances: insurancesSelected
			},
			success: updatedInsurancesSupport,
			error: updatedInsurancesSupport
		} );
	} );
	
// *** cuando se hace click en "Historial de turnos" *** ///
	var $appointmentsWrapper = $( '.is2-doctor-appointments-table' );
	var $appointmentRecord = $( '.is2-doctor-appointments-record' ).clone();
	$( '.is2-doctor-appointments-record' ).remove();
	
	var showAppointmentsHistory = function( dataResponse ) {
		hidePreloader();
		if( !dataResponse.success ) {
			return;
		}
		
		$appointmentsWrapper.hide().empty();
		var appointments = dataResponse.data, appointment,
			$fields, $field, i, l;
			
		while( appointments.length ) {
			appointment = appointments.shift();
			$appointment = $appointmentRecord.clone();
			$fields = $appointment.find( '.is2-field' );
			for( i = 0, l = $fields.length; i < l; i++ ) {
				$field = $fields.eq( i );
				$field.html( appointment[$field.attr( 'data-field-name' )] );
			}
			$appointment.find( '.is2-doctor-appointment-link' ).attr( 'href', '/turnos?id=' + appointment.id );
			
			$appointmentsWrapper.append( $appointment );
		}
		$appointmentsWrapper.show();
	};

	$( '.is2-doctor-appointments-trigger' ).on( 'click', function( e ) {
		e.preventDefault();
		// dont request agina the appontmets if already has been loaded
		if( $appointmentsWrapper.find( 'tr.is2-doctor-appointments-record' ).length ) {
			return;
		}
		
		showPreloader();
		
		$.ajax( {
			url: '/medicos/' + getDoctorID() + '/historial',
			dataType: 'json',
			type: 'GET',
			success: showAppointmentsHistory,
			error: showAppointmentsHistory
		} );
	} );
	
// *** licencias funionalidad *** //
	// cuando hace click en mostrar licencias
	var $licensesGrid = $( '.is2-licenses-table' );
	var $licensesRecord = $( '.is2-licenses-record' ).clone();
	$( '.is2-licenses-record' ).remove();
	var $licenseEmpty = $( '.is2-licenses-record-empty' );
	
	var populateLicensesGrid = function( licenses, isAppend ) {
		if( !isAppend ) {
			$licensesGrid.hide().empty();
		}
		
		var license, $license, $fields, $field,
			i, l;
			
		if( licenses.length ) {
			while( licenses.length ) {
				license = licenses.shift();
				$license = $licensesRecord.clone();
				$fields = $license.find( '.is2-field' );
				for( i = 0, l = $fields.length; i < l; i++ ) {
					$field = $fields.eq( i );
					$field.html( license[$field.attr( 'data-field-name' )] );
				}
				$license.attr( 'data-license-id', license.id ).find( '.is2-license-remove-trigger' ).attr( 'data-license-id', license.id );
				
				$licensesGrid.append( $license );
			}
			$licenseEmpty.hide();
			$licensesGrid.show();
		} else {
			$licensesGrid.hide();
			$licenseEmpty.show();
		}
	};
	
	var showLicensesHistory = function( dataResponse ) {
		hidePreloader();
		
		if( !dataResponse.success ) {
			return;
		}
		
		populateLicensesGrid( dataResponse.data );
	};
	
	$( '.is2-doctor-licenses-trigger' ).on( 'click', function( e ) {
		e.preventDefault();
		if( $licensesGrid.find( 'tr.is2-licenses-record' ).length || $licenseEmpty.css( 'display' ) === 'block' ) {
			return;
		}
		
		showPreloader();
		
		$.ajax( {
			url: '/medicos/' + getDoctorID() + '/licencias',
			dataType: 'json',
			type: 'GET',
			success: showLicensesHistory,
			error: showLicensesHistory
		} );
	} );

	// crear licencia funcionalidad
	IS2.initDatepickers();
	var $licensesForm = $( '.is2-doctor-licenses-form' );
	
	var $startDate = $( 'input.is2-doctor-licenses-start' );
	$startDate.popover( {
		html: true,
		placement: 'bottom',
		trigger: 'manual'
	} );
	var $startDateControlGroup = $( '.control-group.is2-doctor-licenses-start' );
	var $endDate = $( 'input.is2-doctor-licenses-end' );
	$endDate.popover( {
		html: true,
		placement: 'bottom',
		trigger: 'manual'
	} );
	var $endDateControlGroup = $( '.control-group.is2-doctor-licenses-start' );
	var validateDate = function( $el ) {
		var date = $el.val().trim().match( /^(\d{2})\/(\d{2})\/(\d{4})$/ );
		var $controlGroup = IS2.findGroupControl( $el );
		if( !date ) {
			$controlGroup.addClass( 'error' );
			$el.popover( {
				content: $( '.is2-licenses-date-invalid' ).prop( 'outerHTML' ),
				trigger: 'manual',
				placement: 'bottom',
				html: true
			} ).popover( 'show' );
			return false;
		}
		$controlGroup.removeClass( 'error' );
		return true;
	};
	
	var $licenseErrorDuplicated = $( '.is2-error-lincense-duplicated' );
	var $licenseErrorBusy = $( '.is2-error-lincense-busy' );
	var $licenseErrorUnderflow = $( '.is2-error-lincense-underflow' );
	var $licenseSuccess = $( '.is2-success-lincense' );
	
	var createDateObject = function( val ) {
		val = val.trim().split( '/' );
		var d = new Date();
		d.setDate( 1 );
		d.setFullYear( val[2] );
		d.setMonth( val[1]-1 );
		d.setDate( val[0] );
		return d;
	};
	
	var validateDateRange = function( $start, $end ) {
		var start = createDateObject( $start.val() ),
			end = createDateObject( $end.val() ),
			$startControlGroup = IS2.findGroupControl( $start ),
			$endControlGroup = IS2.findGroupControl( $end );
			
		hidePopover( $start );
		hidePopover( $end );

		if( start < new Date() - 86400000 ) {
			$startControlGroup.addClass( 'error' );
			$start.data( 'popover' ).options.content = $( '.is2-licenses-date-underflow' ).prop( 'outerHTML' );
			$start.popover( 'show' );
			return false;
		}
		$startControlGroup.removeClass( 'error' );
		
		if( start >= end ) {
			$startControlGroup.addClass( 'error' );
			$start.data( 'popover' ).options.content = $( '.is2-licenses-date-range' ).prop( 'outerHTML' );
			$start.popover( 'show' );
			return false;
		}
		$startControlGroup.removeClass( 'error' );
		
		return true;
	};
	
	var createdLicense = function( dataResponse ) {
		isWaiting = false;
		hidePreloader();
		var data = dataResponse.data;
		if( !dataResponse.success ) {
			if( data[0] === 'licencia-medico-tiene-turnos' ) {
				IS2.showCrudMsg( $licenseErrorBusy, 2, 5000 );
			} else if( data[0] === 'licencia-en-pasado' ) {
				IS2.showCrudMsg( $licenseErrorUnderflow, 2 );
			} else {
				IS2.showCrudMsg( $licenseErrorDuplicated, 2 );
			}
			return;
		}
		IS2.showCrudMsg( $licenseSuccess , 2, 20000 );
		
		populateLicensesGrid( [ dataResponse.data ], true );
		// some hack
		$( '.is2-licenses-record:first' ).before( $( '.is2-licenses-record:last' ).effect( 'highlight', null, 1500 ) );
		
		cleanAllInputs();
	};
	
	$licensesForm.on( 'submit', function( e ) {
		e.preventDefault();
		hidePopover( $startDate );
		hidePopover( $endDate );
		hidePopover( $licensesForm );
		if( isWaiting ) {
			return;
		}
		
		if( IS2.lookForEmptyFields( $licensesForm, true ) ) {
			return;
		}
		
		if( !validateDate( $startDate ) || !validateDate( $endDate ) ) {
			return;
		}
		
		if( !validateDateRange( $startDate, $endDate ) ) {
			return;
		}
		
		isWaiting = true;
		showPreloader();
		
		$.ajax( {
			url: '/medicos/' + getDoctorID() + '/crear-licencia',
			dataType: 'json',
			type: 'POST',
			data: {
				start: $startDate.val(),
				end: $endDate.val()
			},
			success: createdLicense,
			error: createdLicense
		} );
	} );
	
	var removedLicense = function( dataResponse ) {
		isWaiting = false;
		hidePreloader();
		
		if( !dataResponse.success ) {
			return;
		}
		
		var licenseID = dataResponse.data;
		$( 'tr.is2-licenses-record[data-license-id=' + licenseID + ']' ).addClass( 'record-removed' );
	};
	
	// borrar licencia
	$licensesGrid.delegate( '.is2-license-remove-trigger', 'click', function( e ) {
		e.preventDefault();
		if( isWaiting ) {
			return;
		}
		
		var licenseID = $( this ).attr( 'data-license-id' );
		
		isWaiting = true;
		showPreloader();
		
		$.ajax( {
			url: '/medicos/' + getDoctorID() + '/borrar-licencia',
			dataType: 'json',
			type: 'POST',
			data: {
				id: licenseID
			},
			success: removedLicense,
			error: removedLicense
		} );
	} );
	
// *** change hash listener *** //
	var $window = $( window );
	$window.on( 'hashchange', function( e ) {
		var hash = window.location.hash,
			doctorID = hash.match( /id=(\d+)/ );
			
		if( doctorID ) {
			doctorID = doctorID[1];
			$( '.is2-doctor-presentation-trigger[data-doctor-id=' + doctorID + ']' ).click();
			
		} else {
			$doctorModal.find( '.is2-modal-close' ).click();
		}
		
	} );
	
	window.setTimeout( function() {
		$window.trigger( 'hashchange' );
	}, 300 );
	
})();
</script>