<?php t_startHead( 'Pacientes - ' . $page ); ?>
	<style>
		label {
			cursor: default;
		}
		.is2-popover-msg {
			display: none;
		}
		.popover .is2-popover-msg {
			display: block;
		}
		.is2-insurances-list {
			width: 284px;
		}
	</style>
<?php t_endHead(); ?>
<?php t_startBody( $username, 'patients'  ); ?>
	
		<?php t_startWrapper(); ?>

			<?php if( $createError ): ?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				<p><strong>¡Ha fallado la creación del nuevo paciente!</strong></p>
				<ul>
					<li>Sepa que todos los campos son obligatorios</li>
					<li>Sepa que no puede crear un paciente con un DNI el cual ya exista otro paciente con ese mismo DNI en el sistema</li>
					<li>Verifique que la fecha de nacimiento sea válida y con el formato: dd/mm/yyyy</li>
				</ul>
			</div>
			<?php elseif( $editSuccess ): ?>
			<div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				<strong>¡El paciente ha sido editado con satisfactoriamente!</strong>
			</div>
			<?php elseif( $editError ): ?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				<p><strong>¡Ha fallado la edición del paciente en cuestión!</strong></p>
				<ul>
					<li>Sepa que todos los campos son obligatorios</li>
					<li>Sepa que el número de DNI debe ser único</li>
					<li>Verifique que la fecha de nacimiento sea válida y con el formato: dd/mm/yyyy</li>
				</ul>
			</div>
			<?php endif; ?>
			
			<div class="is2-pagetitle clearfix">
				<h3>Pacientes - <?php echo $page; ?></h3>
				<a class="btn pull-right" href="/pacientes"><i class="icon-arrow-left"></i> Listar pacientes</a>
			</div>
			
			<form class="form-horizontal is2-patient-form" method="post" action="">
			
				<div class="control-group">
					<label class="control-label">Apellidos</label>
					<div class="controls">
						<input type="text" class="input-xlarge" placeholder="Apellidos" name="lastName" value="<?php echo $patient['apellidos']; ?>" data-html="true" data-trigger="manual">
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">Nombres</label>
					<div class="controls">
						<input type="text" class="input-xlarge" placeholder="Nombres" name="firstName" value="<?php echo $patient['nombres']; ?>" data-html="true" data-trigger="manual">
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">Sexo</label>
					<div class="controls">
						<select type="text" class="input-mini" name="gender">
							<option value="F" <?php echo $patient['sexo'] == 'F' ? 'selected' : ''; ?>>F</option>
							<option value="M" <?php echo $patient['sexo'] == 'M' ? 'selected' : ''; ?>>M</option>
						</select>
					</div>
				</div>
				
				<div class="control-group is2-patient-dni-wrapper">
					<label class="control-label">DNI</label>
					<div class="controls">
						<input type="text" class="input-xlarge is2-patient-dni" placeholder="Número de DNI" name="dni" value="<?php echo $patient['dni']; ?>" data-html="true" data-trigger="manual">
					</div>
					<div class="alert alert-error is2-patient-dni-popover-duplicated is2-popover-msg">
						Ya existe en el sistema un paciente registrado con el mismo número de documento
					</div>
					<div class="alert alert-error is2-patient-dni-popover-invalid is2-popover-msg">
						El número de documento no es válido
					</div>
				</div>
				
				<div class="control-group is2-patient-birthdate-wrapper">
					<label class="control-label">Fecha de nacimiento</label>
					<div class="controls">
						<input type="text" class="input-xlarge datepicker is2-patient-birthdate" placeholder="Fecha de nacimiento" name="birthDate" value="<?php echo __dateISOToLocale( $patient['fechaNacimiento'] ); ?>" data-html="true" data-trigger="manual">
					</div>
					<div class="alert alert-error is2-patient-birthdate-popover-overflow is2-popover-msg">
						La fecha de nacimiento excede al día presente
					</div>
					<div class="alert alert-error is2-patient-birthdate-popover-invalid is2-popover-msg">
						La fecha debe estar en el formato dd/mm/yyyy para ser reconocida como valida, por ejemplo algo como: 21/03/1940
					</div>
				</div>
				
				<div class="control-group is2-patient-phone-wrapper">
					<label class="control-label">Teléfono</label>
					<div class="controls">
						<input type="text" class="input-xlarge is2-patient-phone" placeholder="Teléfono" name="phone" value="<?php echo $patient['telefono']; ?>" data-html="true" data-trigger="manual">
					</div>
					<div class="alert alert-error is2-patient-phone-popover is2-popover-msg">
						El número de teléfono no es válido
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">Dirección</label>
					<div class="controls">
						<textarea class="input-xlarge is2-patient-address" placeholder="Dirección" name="address"><?php echo $patient['direccion']; ?></textarea>
					</div>
				</div>
				
				<div class="alert">
					Si el paciente no tiene obra social, eliga la opción <strong>LIBRE</strong>
				</div>
				<div class="control-group">
					<label class="control-label">Obra social</label>
					<div class="controls">
						<select type="text" class="input-xlarge is2-insurances-list" name="insuranceID">
						<?php foreach( $insurances as $insurance ): ?>
							<option value="<?php echo $insurance['id']; ?>" <?php echo $insurance['id'] == $patient['idObraSocial'] ? 'selected' : ''; ?>><?php echo $insurance['nombreCorto'] . ( $insurance['nombreCompleto'] ? ' (' . $insurance['nombreCompleto'] . ')' : '' ); ?></option>
						<?php endforeach; ?>
						</select>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">Número de afiliado</label>
					<div class="controls">
						<input type="text" class="input-xlarge is2-insurance-number" placeholder="Número de afiliado" name="insuranceNumber" value="<?php echo $patient['nroAfiliado']; ?>" data-html="true" data-trigger="manual">
					</div>
				</div>
				
				<div class="control-group">
					<div class="controls">
						<button type="submit" class="btn btn-primary btn-large"><?php echo $buttonLabel; ?></button>
					</div>
				</div>
			</form>
			
		<?php t_endWrapper(); ?>
		
<?php t_endBody(); ?>

<script>
(function() {

	IS2.initDatepickers();
	if( window.location.search.indexOf( 'exito=editar-paciente' ) >= 0 ) {
		IS2.cleanPrevState();
	} else {
		IS2.loadPrevState( 'is2-patient-state' );
	}

// *** NORMAL THINGS *** //
	var $insurancesList = $( '.is2-insurances-list' );
	var $insuranceNumber = $( '.is2-insurance-number' );
	$insurancesList.on( 'click', function( e ) {
		// es LIBRE
		if( $insurancesList.find( 'option' ).eq( $insurancesList[0].selectedIndex ).val() == 1 ) {
			$insuranceNumber.val( '---' );
		}
	} );
	
	var scrollTo = function( $el ) {
		$.scrollTo( $el, 800 );
	}
	
	var $pageTitle = $( '.is2-pagetitle' );
	var $birthDate = $( '.is2-patient-birthdate' );
	var $birthDateGroupError = $( '.is2-patient-birthdate-wrapper' );
	var $dni = $( '.is2-patient-dni' );
	var $dniGroupControl = $( '.is2-patient-dni-wrapper' );
	var $phone = $( '.is2-patient-phone' );
	var $phoneGroupControl = $( '.is2-patient-phone-wrapper' );
	var $theForm = $( '.is2-patient-form' );
	$theForm.on( 'submit', function( e ) {
		$birthDate.popover( 'destroy' );

		if( IS2.lookForEmptyFields( $theForm ) ) {
			e.preventDefault();
			scrollTo( $pageTitle );
			return;
		}
		
		// check birthDate validity
		var date = $birthDate.val().match( /^(\d{2})\/(\d{2})\/(\d{4})$/ );
		if( !date ) {
			e.preventDefault();
			$birthDate.popover( { content: $( '.is2-patient-birthdate-popover-invalid' ).prop( 'outerHTML' ) } ).popover( 'show' );
			$birthDateGroupError.addClass( 'error' );
			scrollTo( $dniGroupControl );
			return;
		}
		var target = new Date();
		target.setDate( 1 );
		target.setFullYear( date[3] );
		target.setMonth( date[2]-1 );
		target.setDate( date[1] );
		var base = new Date();
		base.setDate( base.getDate() + 1 );
		if( target > base ) {
			e.preventDefault();
			$birthDateGroupError.addClass( 'error' );
			$birthDate.popover( { content: $( '.is2-patient-birthdate-popover-overflow' ).prop( 'outerHTML' ) } ).popover( 'show' );
			scrollTo( $dniGroupControl );
			return;
		}
		$birthDateGroupError.removeClass( 'error' );
		
		var dni = $dni.val().replace( /\./g, '' );
		if( !/^\d+$/.test( dni ) ) {
			e.preventDefault();
			$dniGroupControl.addClass( 'error' );
			$dni.popover( { content: $( '.is2-patient-dni-popover-invalid' ).prop( 'outerHTML' ) } ).popover( 'show' );
			scrollTo( $dniGroupControl );
			return;
		}
		$dniGroupControl.removeClass( 'error' );
		
		var phone = $phone.val().trim();
		if( !/^[#*\d-()]+$/.test( phone ) ) {
			e.preventDefault();
			$phoneGroupControl.addClass( 'error' );
			$phone.popover( { content: $( '.is2-patient-phone-popover' ).prop( 'outerHTML' ) } ).popover( 'show' );
			scrollTo( $phoneGroupControl );
			return;
		}
		$phoneGroupControl.removeClass( 'error' );
		
		// ahora debo guardar los valores de los inputs
		IS2.savePrevState( 'is2-patient-state' );
	} );
	
// *** CUANDO VENGO DE UN ERROR AL EDITAR EL PACIENTE *** //
	if( window.location.search.indexOf( 'error' ) >= 0 ) {
		$dni.popover( { content: $( '.is2-patient-dni-popover-duplicated' ).prop( 'outerHTML' ) } );
		var errors;
		
		errors = window.location.search.match( /campos=([^&$]+)/ );
		if( errors ) {
			try {
				errors = atob( errors[1] );
			} catch( e ) {}
		}
		
		if( errors === 'duplicado' ) {
			$dni.popover( 'show' );
			$dniGroupControl.addClass( 'error' );
			scrollTo( $pageTitle );
		}
	}
	
})();
</script>