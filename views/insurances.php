<!DOCTYPE html>
<html lang="es">
	<head>
		<?php t_headTag( 'Obras Sociales' ); ?>
		<style>
			label {
				cursor: default;
			}
			.table td:first-child {
				text-transform: uppercase;
			}
			.table td:not( :first-child ) {
				text-transform: none;
			}
		</style>
	</head>
	<body>
		<?php t_headerTag( $username, 'insurances' ); ?>
	
		<div class="container">
			<?php if( $createSuccess ): ?>
			<div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡ La nueva obra social ha sido creada satisfactoriamente !
			</div>
			<?php elseif( $createError ): ?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				<strong>¡ No se ha podido crear la nueva obra social !</strong> 
				Es posible que ya exista una con el mismo nombre corto en el sistema.
			</div>
			<?php elseif( $editSuccess ): ?>
			<div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡ La obra social ha sido editada satisfactoriamente !
			</div>
			<?php elseif( $editError ): ?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				<strong>¡ No se ha podido editar la obra social !</strong> 
				Es posible que ya exista una con el mismo nombre abreviado en el sistema.
			</div>
			<?php elseif( $removeSuccess ): ?>
			<div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡ La obra social ha sido borrada satisfactoriamente !
			</div>
			<?php elseif( $removeError ): ?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				<strong>¡ No se ha podido borrar la obra social !</strong> Intentelo nuevamente.
			</div>
			<?php endif; ?>
		
			<div class="is2-pagetitle clearfix">
				<h3>Obras Sociales</h3>
			</div>
			
			<form class="form-horizontal" method="post" action="/obras-sociales/crear">
				<fieldset>
					<legend>Crear una nueva obra social</legend>
					<div class="alert alert-info">
						Utilice este formulario para crear una nueva obra social en el sistema.
					</div>
					<div class="control-group">
						<label class="control-label">Nombre abreviado:</label>
						<div class="controls">
							<input type="text" class="input-xlarge" name="shortName">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Nombre completo:</label>
						<div class="controls">
							<input type="text" class="input-xlarge" name="fullName">
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<button type="submit" class="btn btn-primary">Crear</button>
						</div>
					</div>
				</fieldset>
			</form>
			<hr>
			
			<legend>Listado de obras sociales</legend>
			<div class="alert">
				A continuación se muestran todas las obra sociales cargadas en el sistema.
			</div>
			<table class="table table-striped is2-grid">
				<thead>
					<tr>
						<th>Nombre abreviado</th>
						<th>Nombre completo</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach( $insurances as $insurance ): ?>
					<tr data-insurance-id="<?php echo $insurance['id']; ?>">
						<td class="is2-insurance-shortName"><?php echo $insurance['nombreCorto']; ?></td>
						<td class="is2-insurance-fullName"><?php echo $insurance['nombreCompleto']; ?></td>
						<td>
							<a class="btn is2-trigger-edit" href="#is2-modal-edit" data-toggle="modal" data-insurance-id="<?php echo $insurance['id']; ?>">Editar</a>
							<a class="btn btn-danger is2-trigger-remove" href="#is2-modal-remove" data-toggle="modal" data-insurance-id="<?php echo $insurance['id']; ?>">Borrar</a>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			
		</div>
		
		<!-- los modals -->
		<form method="post" action="/obras-sociales/editar" id="is2-modal-edit" class="modal hide fade">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<strong>Editar obra social</strong>
			</div>
			<div class="modal-body">
				<div class="control-group">
					<label class="control-label">Nombre abreviado:</label>
					<div class="controls">
						<input type="text" class="input-xlarge" name="shortName">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Nombre completo:</label>
					<div class="controls">
						<input type="text" class="input-xlarge" name="fullName">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal">Cancelar</button>
				<button class="btn btn-primary" type="submit">Editar</button>
			</div>
			<input type="hidden" name="id">
		</form>
		
		<form method="post" action="/obras-sociales/borrar" id="is2-modal-remove" class="modal hide fade">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<span><strong>¿ Está seguro que desea borrar esta obra social del sistema ?</strong></span>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal">Cancelar</button>
				<button class="btn btn-primary" type="submit">Borrar</button>
			</div>
			<input type="hidden" name="id">
		</form>
		
		<?php t_footerTag(); ?>
	</body>
</html>
<script>
(function() {
	$( '.is2-grid' ).delegate( '.is2-trigger-edit', 'click', function( e ) {
		var insuranceID = $( this ).attr( 'data-insurance-id' );
		$( '#is2-modal-edit input[name=id]' ).val( insuranceID );
		$( '#is2-modal-edit input[name=shortName]' ).val( $( 'tr[data-insurance-id=' + insuranceID + '] .is2-insurance-shortName'  ).html() );
		$( '#is2-modal-edit input[name=fullName]' ).val( $( 'tr[data-insurance-id=' + insuranceID + '] .is2-insurance-fullName'  ).html() );
	} );
	$( '.is2-grid' ).delegate( '.is2-trigger-remove', 'click', function( e ) {
		$( '#is2-modal-remove input[name=id]' ).val( $( this ).attr( 'data-insurance-id' ) );
	} );
})();
</script>