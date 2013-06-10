<?php t_startHead( 'Pacientes' ); ?>
	<style>
		label {
			cursor: default;
		}
		.is2-grid-header th:nth-child( 1 ),
		.is2-grid-header th:nth-child( 2 ) {
			width: 164px;
		}
		.is2-grid-header th:nth-child( 4 ) {
			width: 105px;
			text-align: left !important;
		}
		.is2-grid-header th:nth-child( 4 ) > span {
			display: inline-block;
			text-align: center;
			width: 77px;
		}
		.is2-grid-header th:nth-child( 4 ) .is2-dropdownmenu {
			position: relative;
			top: -10px;
		}
		.is2-grid-header th:nth-child( 5 ) {
			width: 80px;
		}
		.is2-grid td {
			text-align: center !important;
			font-size: 13px;
		}
		.is2-grid td span {
			display: block;
			word-wrap: break-word;
		}
		.is2-grid td:nth-child( 1 ) span,
		.is2-grid td:nth-child( 2 ) span {
			width: 155px;
			text-align: left;
		}
		.is2-grid td:nth-child( 3 ) {
			width: 65px;
		}
		.is2-grid td:nth-child( 4 ) {
			width: 65px;
		}
		.is2-grid td:nth-child( 5 ) {
			width: 100px;
		}
		.is2-grid td:nth-child( 6 ) span {
			width: 150px;
			text-align: left;
		}
		.is2-grid td:nth-child( 7 ) span {
			width: 100px;
			text-transform: uppercase;
		}
		.is2-grid td:nth-child( 8 ) span {
			width: 130px;
		}
		.is2-grid td:nth-child( 9 ) span {
			text-align: center;
		}
		.is2-grid td:last-child {
			width: 95px;
		}
		.pagination {
			margin: 20px 0 10px 0;
		}
		.pager {
			margin: 20px 0 0 0;
		}
		
		.is2-search-trigger {
			float: right;
			margin: 0 0 10px;
		}
		.is2-insurances-listbox {
			height: 200px;
			margin: 0 0 0 10px;
			overflow-y: scroll;
		}
	</style>
	<style>
		/* popup de paciente detalles */
		#is2-modal-details {
			background: #fff;
			border-radius: 0;
			padding: 0;
			font-family: "Open Sans", cursive;
			width: 850px;
			max-height: 495px;
			z-index: 100000;
			box-shadow: 0 0 5px rgba(0, 0, 0, 0.2), inset 0 0 30px rgba(0, 0, 0, 0.1);
		}
		#is2-modal-details * {
			margin: 0;
		}
		#is2-modal-details .modal-body {
			line-height: 0;
			padding: 0;
			position: absolute;
			right: 4px;
			top: 5px;
			overflow: hidden;
		}
		.is2-modal-details-header {
			position: relative;
			font-size: 30px;
		}
		.is2-modal-details-header h1 {
			padding: 10px;
		}
		.is2-modal-details-header ul {
			padding: 0 10px 10px 10px;
		}
		.is2-modal-details-header li {
			list-style-type: none;
			display: inline-block;
			margin: 10px 0;
		}
		.is2-modal-details-header:after {
			border-bottom: 1px solid #ffaa9f;
			border-top: 1px solid #ffaa9f;
			height: 2px;
			width: 100%;
			content: '';
			position: absolute;
		}
		.is2-modal-details-body {
			margin: 15px 0;
		}
		.is2-modal-details-body li {
			display: block;
			font-size: 25px;
			border-bottom: 1px solid #ccc;
			line-height: 2;
			padding: 0 0 0 10px;
		}
		.is2-modal-details-body li:last-child {
			border-bottom: 0;
		}
		.is2-modal-details-appointments {
			height: 200px;
			overflow-y: scroll;
			margin: 5px 0 0 0;
			border-top: 1px solid #ccc;
			font-size: 25px;
		}

		.is2-modal-details-appointments tr:hover {
			background-color: #eee;
			-webkit-transition: 0.2s;
			-moz-transition:    0.2s;
			-ms-transition:     0.2s;
			-o-transition:      0.2s;
		}
		.is2-modal-details-appointments td {
			list-style: none;
			overflow: hidden;
			white-space: nowrap;
			text-overflow: ellipsis;
			padding: 10px 5px 10px 50px;
			border-top: 0;
			font-size: 22px;
		}
		.is2-modal-details-appointments tr {
			border-bottom: 1px dotted #ccc;
		}
		.is2-modal-details-appointments tr:last-child {
			border-bottom: 0;
		}
		.is2-modal-details-appointments-empty {
			text-align: center;
			padding: 10px 0 0 0;
			color: #ffaa9f;
		}
		.is2-patient-data-insurance {
			font-size: 20px;
			color: #777;
		}
	</style>

<?php t_endHead(); ?>
<?php t_startBody( $username, 'patients'  ); ?>
	
		<?php t_startWrapper(); ?>
			<?php if( $removeSuccess ): ?>
			<div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡El paciente han sido borrado satisfactoriamente!
			</div>
			<?php elseif( $removeError ): ?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				<p><strong>¡No se ha podido borrar al paciente!</strong></p>
				Recuerde que no puede borrar a un paciente que tenga turnos asociados.
			</div>
			<?php elseif( $editError ): ?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				<strong>No existe paciente con tal identificador cargado en el sistema.</strong>
			</div>
			<?php endif; ?>
		
			<div class="is2-pagetitle clearfix">
				<h3>Pacientes</h3>
				<a class="btn pull-right btn-warning" href="/pacientes/crear"><i class="icon-plus"></i> Crear un nuevo paciente</a>
				<form class="form-search pull-right is2-search-quick-form" method="post" action="/pacientes/busqueda-rapida">
					<div class="is2-search-quick-control input-append control-group <?php echo $searchQuickError ? 'error': ''; ?>">
						<input type="text" class="input-large search-query is2-search-quick-input" placeholder="Búsqueda rápida" name="keyword" value="<?php echo $quickSearchValue; ?>">
						<button type="submit" class="btn"><i class="icon-search"></i></button>
					</div>
				</form>
			</div>

			<div id="is2-search-patients-wrapper" class="accordion">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" data-toggle="collapse" href="#is2-search-patients" data-parent="#is2-search-patients-wrapper">
							Búsqueda avanzada...
						</a>
					</div>
					<div id="is2-search-patients" class="accordion-body collapse out">
						<form class="accordion-inner" method="post" action="/pacientes/busqueda-avanzada">
							<div class="alert">
								Sepa que puede combinar los campos entre si para realizar búsquedas más precisas
							</div>
							<div class="alert alert-info">
								Deje en blanco los campos que los cuales no desea filtrar la búsqueda de pacientes
							</div>
							<fieldset>
								<legend>Buscar pacientes con apellidos</legend>

								<label>Apellidos:</label>
								<input type="text" class="input-xxlarge" name="lastName" value="<?php echo __sanitizeValue( $persistValues['lastName'] ); ?>" placeholder="Para buscar por varios apellidos simplemente separelos con un espacio">
							</fieldset>
							<fieldset>
								<legend>Buscar pacientes con nombres</legend>
								<label>Nombres:</label>
								<input type="text" class="input-xxlarge" name="firstName" value="<?php echo __sanitizeValue( $persistValues['firstName'] ); ?>" placeholder="Para buscar por varios nombres simplemente separelos con un espacio">
							</fieldset>
							<fieldset>
								<legend>Buscar pacientes con numero de DNI</legend>
								<label>Número de DNI:</label>
								<input type="text" class="input-xxlarge" name="patientsList" value="<?php echo __sanitizeValue( $persistValues['patientsList'] ); ?>" placeholder="Para buscar por varios números de DNI simplemente separelos con un espacio">
							</fieldset>
							<fieldset class="form-inline">
								<legend>Buscar pacientes con fecha de nacimiento</legend>
								<div class="alert alert-info">
									Puede optar por dejar un limite vacío para realizar una busqueda sin limite superior/inferior
								</div>
								<label>Desde:
									<input type="text" class="input-small datepicker" name="birthDateStart" value="<?php echo __dateISOToLocale( $persistValues['birthDateStart'] ); ?>">
								</label>
								<label>hasta:
									<input type="text" class="input-small datepicker" name="birthDateEnd" value="<?php echo __dateISOToLocale( $persistValues['birthDateEnd'] ); ?>">
								</label>
							</fieldset>
							<fieldset>
								<legend>Buscar pacientes con obra social</legend>
								<label class="radio">
									<input type="radio" name="insuranceSearch" value="all" <?php echo !count( $persistValues['insurancesList'] ) ? 'checked' : ''; ?>>Incluir todas las obras sociales
								</label>
								<label class="radio">
									<input type="radio" name="insuranceSearch" value="custom" class="is2-search-patients-insurance-custom" <?php echo count( $persistValues['insurancesList'] ) ? 'checked' : ''; ?>>Solo los pacientes con las obras sociales...
								</label>
								<div class="is2-insurances-listbox alert alert-info">
								<?php foreach( $insurances as $insurance ): ?>
									<label class="checkbox">
										<input type="checkbox" name="insurancesList[]" value="<?php echo $insurance['id']; ?>" <?php echo isset( $persistValues['insurancesList'][$insurance['id']] ) ? 'checked' : ''; ?>>
										<?php echo $insurance['nombreCorto'] . ( $insurance['nombreCompleto'] ? ' (' . $insurance['nombreCompleto'] . ')' : '' ); ?>
									</label>
								<?php endforeach; ?>
								</div>
							</fieldset>
							<fieldset>
								<legend>Buscar pacientes con número de afiliado</legend>
								<label>Número de afiliado de la obra social:</label>
								<input type="text" class="input-xxlarge" name="affiliateInsuranceNumber" placeholder="Separe con espacios para buscar por varios números de afiliado" value="<?php echo __sanitizeValue( $persistValues['affiliateInsuranceNumber'] ); ?>">
							</fieldset>
							<button type="submit" class="btn btn-large btn-primary is2-search-trigger">Buscar</button>
						</form>
					</div>
				</div>
			</div>
			
			<div class="pagination pagination-centered">
				<ul>
			<?php foreach( range( 'A', 'Z' ) as $char ): ?>
					<li class="<?php echo $char == $letter ? 'active' : ''; ?>">
						<a class="" href="/pacientes/listar-por-letra/<?php echo $char; ?>"><?php echo $char; ?></a>
					</li>
			<?php endforeach; ?>
				</ul>
			</div>
			
			<?php if( count( $patients ) ): ?>
			<table class="table is2-grid-header btn-inverse">
				<thead>
					<tr>
						<th>
							Apellidos
							<?php t_lastNameMenu(); ?>
						</th>
						<th>
							Nombres
							<?php t_firstNameMenu(); ?>
						</th>
						<th>DNI</th>
						<th>
							<span>Fecha de</span>
							nacimiento
							<?php t_birthDateMenu(); ?>
						</th>
						<th>Teléfono</th>
						<th>Obra social</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
			<div class="is2-grid-wrapper">
				<table class="table is2-grid">
					<tbody>
					<?php foreach( $patients as $patient ): ?>
						<tr class="is2-patients-row" data-patient-id="<?php echo $patient['id']; ?>">
							<td>
								<span title="<?php echo $patient['apellidos']; ?>"><?php echo $patient['apellidos']; ?></span>
							</td>
							<td>
								<span title="<?php echo $patient['nombres']; ?>"><?php echo $patient['nombres']; ?></span>
							</td>
							<td><?php echo $patient['dni']; ?></td>
							<td><?php echo __dateISOToLocale( $patient['fechaNacimiento'] ); ?></td>
							<td>
								<span title="<?php echo $patient['telefono']; ?>"><?php echo $patient['telefono']; ?></span>
							</td>
							<td>
								<span title="<?php echo $patient['obraSocialNombre']; ?>"><?php echo $patient['obraSocialNombre']; ?></span>
							<td>
								<a class="btn btn-mini is2-patients-details-trigger" href="#is2-modal-details" data-toggle="modal" title="Ver en detalle" data-patient-id="<?php echo $patient['id']; ?>"><i class="icon-eye-open"></i></a>
								<a class="btn btn-mini" href="/pacientes/<?php echo $patient['id']; ?>/editar" title="Editar"><i class="icon-edit"></i></a>
								<a class="btn btn-mini btn-danger is2-trigger-remove" href="#is2-modal-remove" data-toggle="modal" data-patient-id="<?php echo $patient['id']; ?>" title="Borrar"><i class="icon-remove-sign icon-white"></i></a>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			
			<?php if( $isSingle ): ?>
			<div class="is2-popover">
				<div class="alert">
					<strong>¡Nuevo paciente ha sido creado satisfactoriamente!</strong>
				</div>
				<a class="btn btn-block" href="/pacientes">
					<i class="icon-arrow-left"></i>
					Listar pacientes
				</a>
				<button class="btn btn-link btn-mini is2-popover-close">¡Entendido!</button>
			</div>
			<?php else: ?>
			<ul class="pager">
				<li class="previous <?php echo $offset ? 'active': 'disabled'; ?>">
					<a href="<?php echo $offset == 0 ? '#' : $queryString . '&pagina=' . ($offset-1); ?>">&larr; Anterior</a>
				</li>
				<li class="next <?php echo $stillMorePages ? 'active': 'disabled'; ?>">
					<a href="<?php echo $stillMorePages ? $queryString . '&pagina=' . ($offset+1) : '#'; ?>">Siguiente &rarr;</a>
				</li>
			</ul>
			<?php endif; ?>
			
			<?php else: ?>
			<div class="alert alert-error">
				No se han encontrado pacientes según el criterio de búsqueda específicado
			</div>
			<?php endif; ?>

		<?php t_endWrapper(); ?>
		
		<!-- los modals -->
		<form method="post" action="/pacientes/borrar" id="is2-modal-remove" class="modal hide fade">
			<div class="modal-body">
				<button class="close" data-dismiss="modal">&times;</button>
				<p><strong>¿Estás seguro que desea borrar este paciente?</strong></p>
				Sepa que no se puede borrar un paciente que posea turnos registrados en el sistema. Primero debe borrar sus turnos asociados y luego si, podrá borrar a este paciete.
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal">Cancelar</button>
				<button class="btn btn-primary" type="submit">Borrar</button>
			</div>
			<input type="hidden" name="id">
		</form>
		
		<div id="is2-modal-details" class="modal hide fade">
			<div class="is2-modal-wrapper">
				<div class="progress progress-striped active is2-modal-preloader">
					<div class="bar"></div>
				</div>
				<div class="is2-modal-details-header">
					<div class="modal-body">
						<button class="btn btn-link" data-dismiss="modal">
							<i class="icon-remove-sign"></i>
						</button>
					</div>
					<h1 class="is2-patient-data"><span class="is2-patient-data" data-field-name="apellidos"></span>, <span class="is2-patient-data" data-field-name="nombres"></span></h1>
					<ul>
						<li class="is2-patient-data" data-field-name="dni"></li>
						<li class="is2-patient-data" data-field-name="fechaNacimiento"></li>
						<li class="is2-patient-data" data-field-name="edad"></li>
						<li class="is2-patient-data" data-field-name="direccion"></li>
					</ul>
				</div>
				<div class="is2-modal-details-body">
					<ul>
						<li>Teléfono: <strong class="is2-patient-data" data-field-name="telefono"></strong></li>
						<li>Obra social: <strong class="is2-patient-data" data-field-name="obraSocialAbbr"></strong> <strong class="is2-patient-data is2-patient-data-insurance" data-field-name="obraSocialNombre"></strong></li>
						<li>Número de afiliado: <strong class="is2-patient-data" data-field-name="nroAfiliado"></strong></li>
					</ul>
					<div class="is2-modal-details-appointments" style="display:none">
						<table class="table">
							<tr class="is2-modal-details-appointments-record">
								<td class="is2-appointment-data" data-field-name="fecha"></td>
								<td class="is2-appointment-data" data-field-name="hora"></td>
								<td><span class="is2-appointment-data" data-field-name="apellidos"></span>, <span class="is2-appointment-data" data-field-name="nombres"></span></td>
								<td class="is2-appointment-data" data-field-name="estado"></td>
								<td>
									<a href="#" class="btn btn-mini btn-link is2-appointment-data-link" title="Ir al turno">
										<i class="icon-share-alt"></i>
									</a>
								</td>
							</tr>
						</table>
						<div class="is2-modal-details-appointments-empty" style="display:none">
							<strong>Paciente sin turnos registrados hasta el momento</strong>
						</div>
					</div>
				</div>
			</div>
		</div>
		
<?php t_endBody(); ?>

<script>
(function() {

	IS2.initDatepickers();

	$( '.is2-grid' ).delegate( '.is2-trigger-remove', 'click', function( e ) {
		$( '#is2-modal-remove' ).find( 'input[name="id"]' ).val( $( this ).attr( 'data-patient-id' ) );
	} );
	
// *** PARA EL DETALLE DEL PACIENTE *** //
	var $patientDetailsModal = $( '#is2-modal-details');
	var $patientDetailsModalPreloader = $( '.is2-modal-preloader' );
	var $patientDetailsModalPreloaderBar = $patientDetailsModalPreloader.find( '.bar' );
	var isWaiting = false;
	var $patientFields = $( '.is2-patient-data' );
	var $appointmentRecord = $( '.is2-modal-details-appointments-record' ).clone();
	$( '.is2-modal-details-appointments-record' ).remove();
	var $appointmentsWrapper = $( '.is2-modal-details-appointments' );
	var $appointmentsGrid = $( '.is2-modal-details-appointments table' );
	var $emptyAppointments = $( '.is2-modal-details-appointments-empty' );
	var $patientDetailsContent = $( '.is2-modal-details-header, .is2-modal-details-body' );
	
	$patientDetailsModal .css( 'left', $( window ).outerWidth() /2 - 850 / 2 ).css( 'margin-left', 0 ).on( 'hidden', function( e ) {
		$( 'tr.is2-patients-row.is2-record-new' ).removeClass( 'is2-record-new' );
	} );
	
	var showPatientDetails = function( dataResponse ) {
		isWaiting = false;
		$patientDetailsModalPreloaderBar.css( 'width', '100%' );
		window.setTimeout( function() {
			$patientDetailsModalPreloader.fadeOut( 'fast' );
		}, 500 );
		if( !dataResponse.success ){
			return false;
		}
		
		$appointmentsGrid.empty();
		
		var data = dataResponse.data,
			patientData = data.patient,
			appointments = data.appointments;
			
		$patientFields.each( function() {
			var $el = $( this );
			$el.html( patientData[$el.attr( 'data-field-name' )] );
		} );
		
		var appointment,
			$record, $fields, $field,
			i, l, hasAppointments = appointments.length;
			
		while( appointments.length ) {
			appointment = appointments.shift();
			$record = $appointmentRecord.clone();
			$fields = $record.find( '.is2-appointment-data' );
			for( i = 0, l = $fields.length; i < l; i++ ) {
				$field = $fields.eq( i );
				$field.html( appointment[$field.attr( 'data-field-name' )] );
			}
			$record.find( '.is2-appointment-data-link' ).attr( 'href', '/turnos?id=' + appointment.id );
			$appointmentsGrid.append( $record );
		}
	
		if( !hasAppointments ) {
			$emptyAppointments.show();
		} else {
			$emptyAppointments.hide();
		}
		$appointmentsWrapper.slideDown( 'fast', function() {
			$patientDetailsContent.css( 'visibility', 'visible' );
		} );
	};
	
	$( '.is2-grid-wrapper' ).delegate( '.is2-patients-details-trigger', 'click', function( e ) {
		if( isWaiting ) {
			return;
		}
		isWaiting = true;
		$patientDetailsContent.css( 'visibility', 'hidden' );
		$patientDetailsModalPreloaderBar.css( 'width', '1%' );
		$patientDetailsModalPreloader.fadeIn( 'fast' );
		
		var patientID = $( this ).attr( 'data-patient-id' );
		$( 'tr.is2-patients-row[data-patient-id=' + patientID + ']' ).addClass( 'is2-record-new' );
	
		$.ajax( {
			url: '/pacientes/' + patientID,
			dataType: 'json',
			type: 'GET',
			success: showPatientDetails,
			error: showPatientDetails
		} );
	} );
	
// *** PARA LA BUSQUEDA AVANZADA *** //
	$( '.is2-insurances-listbox label' ).on( 'click', function( e ) {
		$( '.is2-search-patients-insurance-custom' ).click();
	} );
	
// *** CUANDO SE SORTEA LA GRID *** //
	var getQueryString = function( fieldName, callback ) {
		// tiro un redirect
		var queryString = window.location.search.replace( /^\?/, '' ),
			segs = queryString ? queryString.split( '&' ) : [], seg,
			pat = /(?:(apellido|nombre|fecha-de-nacimiento)=(asc|desc)|(exito|error|pagina|busqueda-avanzada|busqueda)=([^$]+))/,
			res = {}, m, q = [], prop;
		
		while( segs.length ) {
			seg = segs.shift();
			m = pat.exec( seg );
			if( m ) {
				res[m[1] || m[3]] = m[2] || m[4];
			}
		}
		
		if( !callback ) {
			callback = function() { return true; };
		}

		for( prop in res ) {
			if( prop !== fieldName && callback( prop ) ) {
				q.push( prop + '=' + res[prop] );
			}
		}
		
		return q.length ? q.join( '&' ) + '&' : '';
	};
	
	// cuando se buscar por fecha de nacimiento, no puede estar seteado apellido y nombre
	var skipNames = function( prop ) {
		return prop !== 'apellido' && prop !== 'nombre';
	};
	var skipBirthDate = function( prop ) {
		return prop !== 'fecha-de-nacimiento';
	};
	
	$( '.is2-dropdownmenu-trigger' ).on( 'click', function( e ) {
		e.preventDefault();
		var $el = $( this ),
			fieldName = $el.attr( 'data-field-name' ),
			orderBy = $el.attr( 'data-orderby' );
			
		window.location = window.location.pathname + '?' + getQueryString( fieldName, fieldName === 'fecha-de-nacimiento' ? skipNames : skipBirthDate ) + fieldName + '=' + orderBy;
	} );
	
// *** cuando vengo de crear un nuevo paciente *** //
	if( window.location.search.indexOf( 'id=' ) >= 0 && window.location.search.indexOf( 'exito=crear-paciente' ) >= 0 ) {
		IS2.showNewRecord( $( '.is2-patients-row' ) );
	}
	
})();
</script>