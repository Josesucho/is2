SET NAMES 'utf8';

SET @startTime = UNIX_TIMESTAMP();

DROP DATABASE IF EXISTS is2;
CREATE DATABASE is2 CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE is2;
/**
*
*/
DROP TABLE IF EXISTS usuarios;
CREATE TABLE usuarios(
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	usuario VARCHAR( 255 ),
	clave CHAR( 40 ),
	UNIQUE INDEX( usuario )
);

INSERT INTO usuarios VALUES( null, 'admin', SHA( 123456 ) ), ( null, 'root', SHA( 123456 ) );
/**
*
*/
DROP TABLE IF EXISTS turnos;
CREATE TABLE turnos(
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	fecha DATE,
	hora TIME,
	idMedico INTEGER NULL,
	idPaciente INTEGER NULL,
	estado ENUM( 'confirmado', 'cancelado', 'esperando' )
) ENGINE=InnoDB;
/**
*
*/
DROP TABLE IF EXISTS medicos;
CREATE TABLE medicos(
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	idEspecialidad INTEGER NULL,
	apellidos VARCHAR( 255 ),
	nombres VARCHAR( 255 ),
	telefono1 VARCHAR( 255 ) NULL,
	telefono2 VARCHAR( 255 ) NULL,
	direccion TEXT NULL,
	matriculaNacional VARCHAR( 255 ) NULL,
	matriculaProvincial VARCHAR( 255 ) NULL,
	avatarMini VARCHAR( 255 ) NULL,
	avatar VARCHAR( 255 ) NULL
) ENGINE=InnoDB;

INSERT INTO medicos VALUES
	( null, 1, 'Inspector de', 'Boludos', '45001212', '153221110', '12 esq 58', '122434/21', '423/12', 'inspector-de-boludos.mini.png', 'inspector-de-boludos.png' ),
	( null, 2, 'Hora de', 'Aventura', '45001212', '153221110', '12 esq 58', '122434/21', '423/12','finn.mini.png', 'finn.png' ),
	( null, 3, 'Alf', 'de Melbac', '45001212', '153221110', '12 esq 58', '122434/21', '423/12','alf.mini.png', 'alf.png' ),
	( null, 4, 'El Holy', 'es hermoso', '45001212', '153221110', '12 esq 58', '122434/21', '423/12', 'el-holy.mini.png', 'el-holy.png' ),
	( null, 5, 'Ivan el', 'trolazo', '45001212', '153221110', '12 esq 58', '122434/21', '423/12', 'ivan-el-trolazo.mini.png', 'ivan-el-trolazo.png' ),
	( null, 6, 'Neonazi', 'Delia', '45001212', '153221110', '12 esq 58', '122434/21', '423/12', 'neonazi-delia.mini.png', 'neonazi-delia.png' ),
	( null, 7, 'Yao', 'Ming', '45001212', '153221110', '12 esq 58', '122434/21', '423/12', 'yao-ming.mini.png', 'yao-ming.png' ),
	( null, 8, 'Yaranaika', 'desu', '45001212', '153221110', '12 esq 58', '122434/21', '423/12','yaranaika.mini.png', 'yaranaika.png' ),
	( null, 1, 'Weon', 'Tesla', '45001212', '153221110', '12 esq 58', '122434/21', '423/12', 'tesla.mini.png', 'tesla.png' ),
	( null, 2, 'Patricio', 'Patricio', '45001212', '153221110', '12 esq 58', '122434/21', '423/12', 'patricio.mini.png', 'patricio.png' )
;
/**
*
*/
DROP TABLE IF EXISTS horarios;
CREATE TABLE horarios(
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	idMedico INTEGER NULL,
	horaIngreso TIME,
	horaEgreso TIME,
	dia ENUM( '1', '2', '3', '4', '5', '6', '7' ),
	UNIQUE INDEX( idMedico, horaIngreso, horaEgreso, dia )
) ENGINE=InnoDB;

INSERT INTO horarios VALUES
	( null, 1, '11:00:00', '17:00:00', 1 ),
	( null, 2, '12:00:00', '15:00:00', 1 ),
	( null, 3, '08:00:00', '20:00:00', 1 ),
	( null, 4, '15:00:00', '20:00:00', 1 ),
	( null, 5, '15:00:00', '19:00:00', 2 ),
	( null, 6, '16:00:00', '19:00:00', 2 ),
	( null, 7, '08:00:00', '13:00:00', 2 ),
	( null, 8, '09:00:00', '14:00:00', 2 ),
	( null, 9, '09:00:00', '14:00:00', 3 ),
	( null, 10, '09:00:00', '14:00:00', 3 ),
	( null, 1, '11:00:00', '17:00:00', 3 ),
	( null, 2, '12:00:00', '15:00:00', 3 ),
	( null, 3, '08:00:00', '20:00:00', 4 ),
	( null, 4, '15:00:00', '20:00:00', 4 ),
	( null, 5, '15:00:00', '19:00:00', 4 ),
	( null, 6, '16:00:00', '19:00:00', 4 ),
	( null, 7, '08:00:00', '13:00:00', 5 ),
	( null, 8, '09:00:00', '14:00:00', 5 ),
	( null, 9, '09:00:00', '14:00:00', 5 ),
	( null, 10, '09:00:00', '14:00:00', 5 ),
	( null, 1, '11:00:00', '17:00:00', 6 ),
	( null, 2, '12:00:00', '15:00:00', 6 ),
	( null, 3, '08:00:00', '20:00:00', 6 ),
	( null, 4, '15:00:00', '20:00:00', 6 ),
	( null, 5, '15:00:00', '19:00:00', 7 ),
	( null, 6, '16:00:00', '19:00:00', 7 ),
	( null, 7, '08:00:00', '13:00:00', 7 ),
	( null, 8, '09:00:00', '14:00:00', 7 ) 	
;
/**
*
*/
DROP TABLE IF EXISTS medicosObrasSociales;
CREATE TABLE medicosObrasSociales(
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	idMedico INTEGER NULL,
	idObraSocial INTEGER NULL
) ENGINE=InnoDB;

INSERT INTO medicosObrasSociales VALUES
	( null, 1, 1 ),
	( null, 2, 1 ),
	( null, 3, 1 ),
	( null, 4, 1 ),
	( null, 5, 1 ),
	( null, 6, 1 ),
	( null, 7, 1 ),
	( null, 8, 1 ),
	( null, 1, 2 ),
	( null, 2, 2 ),
	( null, 3, 2 ),
	( null, 4, 2 ),
	( null, 5, 2 ),
	( null, 6, 2 ),
	( null, 7, 2 ),
	( null, 8, 2 ),
	( null, 9, 1 ),
	( null, 9, 2 ),
	( null, 10, 1 ),
	( null, 10, 2 )
;
/**
*
*/
DROP TABLE IF EXISTS pacientes;
CREATE TABLE pacientes(
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	apellidos VARCHAR( 255 ),
	nombres VARCHAR( 255 ),
	sexo ENUM( 'F', 'M' ),
	dni VARCHAR( 255 ),
	fechaNacimiento DATE,
	telefono VARCHAR( 255 ),
	direccion TEXT,
	idObraSocial INTEGER NULL,
	nroAfiliado VARCHAR( 255 ) NULL,
	UNIQUE INDEX( dni )
) ENGINE=InnoDB;

LOAD DATA LOCAL INFILE "./_1000_patients.sql" INTO TABLE pacientes;
/**
*
*/
DROP TABLE IF EXISTS obrasSociales;
CREATE TABLE obrasSociales(
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	nombreCorto VARCHAR( 255 ),
	nombreCompleto TEXT NULL,
	UNIQUE INDEX( nombreCorto )
) ENGINE=InnoDB;

LOAD DATA LOCAL INFILE "./_200_insurances.sql" INTO TABLE obrasSociales;
/**
*
*/
DROP TABLE IF EXISTS especialidades;
CREATE TABLE especialidades(
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	nombre VARCHAR( 255 ),
	UNIQUE INDEX( nombre )
) ENGINE=InnoDB;

INSERT INTO especialidades VALUES
	( null, 'Sin asignar' ),
	( null, 'Otorrinolaringología' ),
	( null, 'Odontología' ),
	( null, 'Nefrología' ),
	( null, 'Endocrinología' ),
	( null, 'Urología' ),
	( null, 'Oftalmología' ),
	( null, 'Pediatría' ),
	( null, 'Psiquiatría' )
;
/**
*
*/
DROP TABLE IF EXISTS licencias;
CREATE TABLE licencias(
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	idMedico INTEGER NULL,
	fechaComienzo DATE,
	fechaFin DATE,
	UNIQUE INDEX( idMedico, fechaComienzo, fechaFin )
) ENGINE=InnoDB;
/**
*
*/
SOURCE ./_100_appointments.sql;
/**
*
*/

/**
* AHORA LAS REFERENCES
*/
ALTER TABLE turnos
	ADD CONSTRAINT turnos_idMedico
	FOREIGN KEY( idMedico )
		REFERENCES medicos( id )
		ON DELETE RESTRICT
;
		
ALTER TABLE turnos
	ADD CONSTRAINT turnos_idPaciente
	FOREIGN KEY( idPaciente )
		REFERENCES pacientes( id )
		ON DELETE RESTRICT
;

CREATE UNIQUE INDEX turnos_medico_ocupado
	ON turnos( fecha,  hora, idMedico )
;

CREATE UNIQUE INDEX turnos_paciente_ya_tiene_turno
	ON turnos( fecha, hora, idPaciente )
;

DELIMITER $$
CREATE TRIGGER turnos_crearTurno
	BEFORE INSERT ON turnos
	FOR EACH ROW
	BEGIN
		/** MIS VARIABLES */
		DECLARE dayNameIndex INTEGER;
		DECLARE daysCount INTEGER;
	
		/**
		* ESTE TRIGER SE FIJA SI TAL DIA A TAL HORARIO TAL MEDICO ATIENDE
		* NO CONFUNDIR CON ESTAR DISPONIBLE (QUE NO TENGA OTRO TURNO), 
		* EN ESTE CASO, LA CONSTRAINT UNIQUE( idMedico, fecha, hora ) 
		* DE turnos SE ENCARGARA DE ESTO
		*/
		SELECT DAYOFWEEK( NEW.fecha ) INTO dayNameIndex;
		IF ( 
			SELECT
					id
				FROM
					horarios
				WHERE
					idMedico = NEW.idMedico AND 
					NEW.hora >= horaIngreso AND NEW.hora <= horaEgreso AND 
					dia = ( SELECT CASE
						WHEN dayNameIndex = 1 THEN 7
						ELSE dayNameIndex - 1 END )
		) IS NULL THEN
			CALL medico_no_antiende_fecha_hora_requerido;
		END IF;
		
		/** UN TURNO NO PUEDE SER MAYOR AL DIA PRESENTE EN 7 DIAS HACIA DELANTE */
		SELECT DATEDIFF( NEW.fecha, CURRENT_DATE() ) INTO daysCount;
		IF daysCount > 7 THEN
			CALL turno_fecha_mayor_siete_dias;
		ELSEIF daysCount < 0 THEN
			CALL turno_fecha_negativo;
		END IF;
		
		/** HAY QUE CHECKEAR QUE EL MEDICO SOPORTE LA OBRA SOCIAL DEL PACIENTE */
		IF (
			SELECT
				p.id
			FROM 
				medicosObrasSociales AS mos
				INNER JOIN pacientes AS p
			WHERE
				mos.idMedico = NEW.idMedico AND 
				mos.idObraSocial = p.idObraSocial AND
				p.id = NEW.idPaciente
				
		) IS NULL THEN
			CALL medico_no_soporta_obra_social_paciente;
		END IF;
		
		/** SI EL MEDICO ESTA CON LICENCIA NO SE PUEDE CONTINUAR */
		IF (
			SELECT
				COUNT( l.idMedico )
			FROM
				licencias AS l
			WHERE
				l.idMedico = NEW.idMedico AND NEW.fecha >= l.fechaComienzo  AND NEW.fecha <= l.fechaFin
			GROUP BY
				l.idMedico
				
		) IS NOT NULL THEN
			CALL medico_esta_con_licencia;
		END IF;
		
		/**
		* SI YA EXISTE UN TURNO CON EL MISMO MEDICO, FECHA Y HORA
		* LA CONSTRAINT UNIQUE( idMedico, fecha, hora ) WILL TAKE CARE OF THIS
		*/
		
		/**
		* SI YA EL PACIENTE TIENE OTRO TURNO A LA MISMA FECHA Y HORA
		* LA CONSTRAINT UNIQUE( idPaciente, fecha, hora ) SE ENCARGARA DE ESTO
		*/
	END;
$$
DELIMITER ;

ALTER TABLE horarios
	ADD CONSTRAINT horarios_idMedico
	FOREIGN KEY( idMedico )
		REFERENCES medicos( id )
		ON DELETE RESTRICT
;

ALTER TABLE pacientes
	ADD CONSTRAINT pacientes_idObraSocial
	FOREIGN KEY( idObraSocial )
		REFERENCES obrasSociales( id )
		ON DELETE RESTRICT
;

ALTER TABLE medicos
	ADD CONSTRAINT medicos_idEspecialidad
	FOREIGN KEY( idEspecialidad )
		REFERENCES especialidades( id )
		ON DELETE RESTRICT
;

ALTER TABLE licencias
	ADD CONSTRAINT licencias_idMedico
	FOREIGN KEY( idMedico )
		REFERENCES medicos( id )
		ON DELETE RESTRICT
;

DELIMITER $$
CREATE TRIGGER licencias_crearLicencia
	BEFORE INSERT ON licencias
	FOR EACH ROW
	BEGIN
	
		/** COMPOBRA QUE fechaComienzo < fechaFin */
		IF NEW.fechaComienzo >= NEW.fechaFin THEN
			CALL licencia_rango_fechas_invalido;
		END IF;
	
		/** NO SE PUEDE CREAR UNA LICENCIA ANTERIOR AL DIA PRESENTE */
		IF ( SELECT DATEDIFF( NEW.fechaComienzo, CURRENT_DATE() ) ) < 0 THEN
			CALL licencia_en_pasado;
		END IF;
		
		/** NO PUEDO CREAR UNA LICENCIA DONDE ACTUALMENTE EL MEDICO ESTE CON UNA LICENCIA */
		IF (
			SELECT
				COUNT( idMedico )
			FROM
				licencias
			WHERE
				( fechaComienzo >= NEW.fechaComienzo OR NEW.fechaFin <= fechaFin ) AND idMedico = NEW.idMedico
			GROUP BY
				idMedico
				
		) IS NOT NULL THEN
			CALL licencia_medico_ya_esta_con_licencia;
		END IF;
		
		/** NO SE PUEDE CREAR UNA LICENCIA SI EL MEDICO EN CUESTION TIENE ACTUALMENTE TURNOS */
		IF (
			SELECT
				COUNT( idMedico )
			FROM
				turnos
			WHERE
				idMedico = NEW.idMedico AND fecha >= NEW.fechaComienzo AND estado <> 'confirmado'
			GROUP BY
				idMedico
				
		) IS NOT NULL THEN
			CALL licencia_medico_tiene_turnos;
		END IF;
	END;
$$
DELIMITER ;

SELECT CONCAT( UNIX_TIMESTAMP() - @startTime, ' seconds' ) AS ' ';
