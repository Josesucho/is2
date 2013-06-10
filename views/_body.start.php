	<body>
		<header class="clearfix">
			<h1>Climedis</h1>
			<div class="alert alert-info is2-welcome">
				Hola, <strong><?php echo $username; ?></strong>
				<a href="/cerrar-sesion" class="btn btn-info btn-mini">Salir</a>
			</div>
			<nav class="navbar">
				<div class="navbar-inner">
					<ul class="nav">
<li class="<?php echo $currentTab == 'appointments' ? 'active' : ''; ?>">
							<a href="/turnos">Turnos</a>
						</li>
<li class="<?php echo $currentTab == 'doctors' ? 'active' : ''; ?>">
							<a href="/medicos">Médicos</a>
						</li>
<li class="<?php echo $currentTab == 'patients' ? 'active' : ''; ?>">
							<a href="/pacientes">Pacientes</a>
						</li>
<li class="<?php echo $currentTab == 'insurances' ? 'active' : ''; ?>">
							<a href="/obras-sociales">Obras sociales</a>
						</li>
<li class="<?php echo $currentTab == 'specialities' ? 'active' : ''; ?>">
							<a href="/especialidades">Especialidades</a>
						</li>
					</ul>
				</div>
			</nav>
		</header>