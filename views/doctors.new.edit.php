<?php t_startHead( 'Médicos - ' . $page ); ?>
	<style>
		label {
			cursor: default;
		}
		select {
			width: 285px !important;
		}
	</style>

<?php t_endHead(); ?>
<?php t_startBody( $username, 'doctors'  ); ?>
	
		<?php t_startWrapper(); ?>
		
			<?php if( $createError ): ?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				<strong>¡Ha fallado la creación del nuevo médico!</strong>
			</div>
			<?php elseif( $editSuccess ): ?>
			<div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				<strong>¡El médico ha sido editado con satisfactoriamente!</strong>
			</div>
			<?php elseif( $editError ): ?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				<strong>¡Ha fallado la edición del médico en cuestión!</strong>
			</div>
			<?php endif; ?>
			
			<div class="is2-pagetitle clearfix">
				<h3>Médicos</h3>
				<a class="btn pull-right" href="/medicos"><i class="icon-arrow-left"></i> Listar médicos</a>
			</div>
			
			<form class="form-horizontal is2-doctor-form" method="post" action="">
				<?php if( $page == 'Crear' ): ?>
				<div class="alert">
					Complete este formulario para crear un nuevo médico en el sistema
				</div>
				<?php endif; ?>
				<div class="control-group">
					<label class="control-label">Apellidos</label>
					<div class="controls">
						<input type="text" class="input-xlarge is2-required" placeholder="Apellidos" name="apellidos" value="<?php echo $doctor['apellidos']; ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Nombres</label>
					<div class="controls">
						<input type="text" class="input-xlarge is2-required" placeholder="Nombres" name="nombres" value="<?php echo $doctor['nombres']; ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Especialidad</label>
					<div class="controls">
						<select name="especialidad" class="input-xlarge is2-required">
						<?php foreach( $specialities as $speciality ): ?>
							<option value="<?php echo $speciality['id']; ?>" <?php echo $doctor['idEspecialidad'] == $speciality['id'] ? 'selected' : ''; ?>><?php echo $speciality['nombre']; ?></option>
						<?php endforeach; ?>
						</select>
					</div>
				</div>
				
				<div class="alert alert-info">
					Los siguiente campos son opcionales, puede dejarlos en blanco si lo desea
				</div>
				<div class="control-group">
					<label class="control-label">Teléfono de casa</label>
					<div class="controls">
						<input type="text" class="input-xlarge is2-doctor-tel1" placeholder="Teléfono" name="telefono1" value="<?php echo $doctor['telefono1']; ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Teléfono movil</label>
					<div class="controls">
						<input type="text" class="input-xlarge is2-doctor-tel2" placeholder="Teléfono auxiliar" name="telefono2" value="<?php echo $doctor['telefono2']; ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Dirección personal</label>
					<div class="controls">
						<textarea class="input-xlarge" placeholder="Dirección personal" name="direccion"><?php echo $doctor['direccion']; ?></textarea>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Matrícula provincial</label>
					<div class="controls">
						<input type="text" class="input-medium" placeholder="Matrícula provincial" name="matriculaProvincial" value="<?php echo $doctor['matriculaProvincial']; ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Matrícula nacional</label>
					<div class="controls">
						<input type="text" class="input-medium" placeholder="Matrícula nacional" name="matriculaNacional" value="<?php echo $doctor['matriculaNacional']; ?>">
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

	if( window.location.search.indexOf( 'exito=editar-medico' ) >= 0 ) {
		IS2.cleanPrevState();
	} else {
		IS2.loadPrevState( 'is2-doctor-state' );
	}

	var $theForm = $( '.is2-doctor-form' );
	var $requiredFields = $( '.is2-required' );
	var $tel1 = $( '.is2-doctor-tel1' );
	var $tel2 = $( '.is2-doctor-tel2' );
	
	var cleanTel = function( $el ) {
		$el.val( $el.val().trim().replace( /^[^-*()\d]+$/, '' ) );
	};
	
	$theForm.on( 'submit', function( e ) {
		if( IS2.lookForEmptyFields( $requiredFields, false, true ) ) {
			e.preventDefault();
			$.scrollTo( $theForm, 600 );
			return;
		}
		
		// validate the non required fields
		cleanTel( $tel1 );
		cleanTel( $tel2 );
		
		IS2.savePrevState( 'is2-doctor-state' );
	} );
})();
</script>