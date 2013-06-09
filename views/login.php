<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Iniciar sesión Josesucho</title>
		<link href="css/bootstrap.css" rel="stylesheet">
		<script src="js/jquery-2.0.0.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<style>
			body {
				background-color: #eee;
			}
			.form-signin {
				background-color: #fff;
				border: 1px solid #E5E5E5;
				border-radius: 5px 5px 5px 5px;
				box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
				margin: 0 auto;
				max-width: 300px;
				padding: 0 20px;
			}
			.alert {
				width: 350px;
				margin: 10px auto;
				text-align: center;
				padding-right: 14px;
			}
			.alert + div .form-signin {
				margin: 0 auto;
			}
			.container {
				text-align: center;
			}
			
			footer {
				width: 300px;
				margin: 10px auto;
			}
			footer span {
				font-size: 11px;
				text-shadow: 0 -1px 0 #fff;
				float: right;
			}
			h1 {
				text-shadow: 0 1px 0 #fff;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<?php if( $isErrorLogin ): ?>
			<div class="alert alert-error">
				¡Nombre de usario y/o contraseña no son validos!
			</div>
			<?php endif; ?>
			<h1>Climedis</h1>
			<div>
				<form class="form-signin" method="post">
					<h3>Iniciar sesión</h3>
					<ul class="nav control-group<?php echo $isErrorLogin ? ' error' : '' ?>">
						<li>
							<input type="text" placeholder="Usuario" name="username">
						</li>
						<li>
							<input type="password" placeholder="Contraseña" name="password">
						</li>
						<li>
							<button class="btn btn-medium btn-primary" type="submit">Iniciar sesión</button>
						</li>
					</ul>
				</form>
			</div>
		</div> <!-- /container -->
		
		<footer>
			<img src="/img/logo.footer.png">
			<span>Todos los derechos reservados &copy; 2013</span>
		</footer>
</html>