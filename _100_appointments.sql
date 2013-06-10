/**
*
*/
SET NAMES 'utf8';
SET GLOBAL log_bin_trust_function_creators = 1;
USE is2;
/**
*
*/
TRUNCATE TABLE turnos;
/**
*
*/
DROP FUNCTION IF EXISTS getDayNameIndex;
DELIMITER $$
CREATE FUNCTION getDayNameIndex( offset INTEGER )
RETURNS INTEGER
BEGIN
	DECLARE today INTEGER;
	SELECT DAYOFWEEK( ADDDATE( CURRENT_DATE(), INTERVAL offset DAY ) ) INTO today;
	SELECT IF( today = 1, 7, today - 1 ) INTO today;
	RETURN today;
END$$
DELIMITER ;
/**
*/
DROP FUNCTION IF EXISTS getPatientWithNonInsurance;
DELIMITER $$
CREATE FUNCTION getPatientWithNonInsurance( avoidThisPatientID INTEGER )
RETURNS INTEGER
BEGIN
	DECLARE lastID INTEGER;
	DROP TEMPORARY TABLE IF EXISTS t_patientsWithNonInsurance;
	CREATE TEMPORARY TABLE t_patientsWithNonInsurance(
		id INTEGER
	);
	INSERT INTO t_patientsWithNonInsurance SELECT id FROM pacientes WHERE idObraSocial = 1 AND id > avoidThisPatientID LIMIT 10;
	SELECT id FROM t_patientsWithNonInsurance ORDER BY id DESC LIMIT 1 INTO lastID;
	RETURN lastID;
END$$
DELIMITER ;
/**
*/
/*DROP FUNCTION IF EXISTS getDoctorIDBasedOnADayNameIndex;
DELIMITER $$
CREATE FUNCTION getDoctorIDBasedOnADayNameIndex( dayNameIndex INTEGER )
RETURNS INTEGER
BEGIN
	DECLARE doctorID INTEGER;
	SELECT m.id FROM medicos AS m INNER JOIN horarios AS h ON h.idMedico = m.id WHERE h.dia = dayNameIndex LIMIT 1 INTO doctorID;
	RETURN doctorID;
END$$
DELIMITER ;*/
/**
*/
DROP PROCEDURE IF EXISTS getDoctorsIDBasedOnADayNameIndex;
DELIMITER $$
CREATE PROCEDURE getDoctorsIDBasedOnADayNameIndex( dayNameIndex INTEGER )
BEGIN
	DROP TEMPORARY TABLE IF EXISTS t_doctorsForAGivenDay;
	CREATE TEMPORARY TABLE t_doctorsForAGivenDay(
		id INTEGER
	);
	INSERT INTO t_doctorsForAGivenDay SELECT m.id FROM medicos AS m INNER JOIN horarios AS h ON h.idMedico = m.id WHERE h.dia = dayNameIndex;
END$$
DELIMITER ;
/**
*/
DROP FUNCTION IF EXISTS getDoctorEntryTimeWithID;
DELIMITER $$
CREATE FUNCTION getDoctorEntryTimeWithID( doctorID INTEGER )
RETURNS TIME
BEGIN
	DECLARE entryTime TIME;
	SELECT h.horaIngreso FROM medicos AS m INNER JOIN horarios AS h ON h.idMedico = m.id WHERE m.id = doctorID LIMIT 1 INTO entryTime;
	RETURN entryTime;
END$$
DELIMITER ;
/**
*/
DROP FUNCTION IF EXISTS getAppointmentDate;
DELIMITER $$
CREATE FUNCTION getAppointmentDate( offset INTEGER )
RETURNS DATE
BEGIN
	DECLARE appointmentDate DATE;
	SELECT ADDDATE( CURRENT_DATE(), INTERVAL offset DAY ) INTO appointmentDate;
	RETURN appointmentDate;
END$$
DELIMITER ;
/**************************************************************/
/**************************************************************/
/**************************************************************/
DROP PROCEDURE IF EXISTS insertAppointmentsForTheCurrentWeek;
DELIMITER $$
CREATE PROCEDURE insertAppointmentsForTheCurrentWeek()
BEGIN
	DECLARE lastPatientID INTEGER DEFAULT 0;
	/*DECLARE doctorID INTEGER;
	DECLARE entryTime TIME;*/
	DECLARE appointmentDate DATE;
	
	DECLARE currentDayIndex INTEGER DEFAULT 0;
	DECLARE currentDateNumber INTEGER DEFAULT 0;
	DECLARE daysCount INTEGER DEFAULT 7;

	DECLARE patientID1, patientID2, patientID3, patientID4, patientID5, patientID6, patientID7, patientID8, patientID9, patientID10 INTEGER; 
	
	DECLARE doctorID1, doctorID2, doctorID3, doctorID4 INTEGER;
	DECLARE entryTime1, entryTime2, entryTime3, entryTime4 TIME;
	
	theLoop: LOOP
		SELECT getPatientWithNonInsurance( (SELECT lastPatientID) ) INTO lastPatientID;
		
		/*SELECT getDoctorIDBasedOnADayNameIndex( getDayNameIndex( (SELECT currentDayIndex) ) ) INTO doctorID;*/
		CALL getDoctorsIDBasedOnADayNameIndex( (SELECT currentDayIndex) );
		SELECT id FROM t_doctorsForAGivenDay LIMIT 1 INTO doctorID1;
		SELECT id FROM t_doctorsForAGivenDay LIMIT 1,1 INTO doctorID2;
		SELECT id FROM t_doctorsForAGivenDay LIMIT 2,1 INTO doctorID3;
		SELECT id FROM t_doctorsForAGivenDay LIMIT 3,1 INTO doctorID4;
	
		SELECT currentDayIndex + 1 INTO currentDayIndex;
		
		/*SELECT getDoctorEntryTimeWithID( (SELECT doctorID) ) INTO entryTime;*/
		SELECT getDoctorEntryTimeWithID( (SELECT doctorID1) ) INTO entryTime1;
		SELECT getDoctorEntryTimeWithID( (SELECT doctorID2) ) INTO entryTime2;
		SELECT getDoctorEntryTimeWithID( (SELECT doctorID3) ) INTO entryTime3;
		SELECT getDoctorEntryTimeWithID( (SELECT doctorID4) ) INTO entryTime4;
		

		SELECT getAppointmentDate( (SELECT currentDateNumber) ) INTO appointmentDate;
		SELECT currentDateNumber + 1 INTO currentDateNumber;

		SELECT id FROM t_patientsWithNonInsurance LIMIT 1 INTO patientID1;
		SELECT id FROM t_patientsWithNonInsurance LIMIT 1,1 INTO patientID2;
		SELECT id FROM t_patientsWithNonInsurance LIMIT 2,1 INTO patientID3;
		SELECT id FROM t_patientsWithNonInsurance LIMIT 3,1 INTO patientID4;
		SELECT id FROM t_patientsWithNonInsurance LIMIT 4,1 INTO patientID5;
		SELECT id FROM t_patientsWithNonInsurance LIMIT 5,1 INTO patientID6;
		SELECT id FROM t_patientsWithNonInsurance LIMIT 6,1 INTO patientID7;
		SELECT id FROM t_patientsWithNonInsurance LIMIT 7,1 INTO patientID8;
		SELECT id FROM t_patientsWithNonInsurance LIMIT 8,1 INTO patientID9;
		SELECT id FROM t_patientsWithNonInsurance LIMIT 9,1 INTO patientID10;

		INSERT INTO
			turnos
		VALUES
			( null, (SELECT appointmentDate), ADDTIME( (SELECT entryTime1), '00:00:00' ), (SELECT doctorID1), (SELECT patientID1), 'esperando' ),
			( null, (SELECT appointmentDate), ADDTIME( (SELECT entryTime2), '00:15:00' ), (SELECT doctorID2), (SELECT patientID2), 'esperando' ),
			( null, (SELECT appointmentDate), ADDTIME( (SELECT entryTime3), '00:30:00' ), (SELECT doctorID3), (SELECT patientID3), 'esperando' ),
			( null, (SELECT appointmentDate), ADDTIME( (SELECT entryTime4), '00:45:00' ), (SELECT doctorID4), (SELECT patientID4), 'esperando' ),
			( null, (SELECT appointmentDate), ADDTIME( (SELECT entryTime1), '01:00:00' ), (SELECT doctorID1), (SELECT patientID5), 'esperando' ),
			( null, (SELECT appointmentDate), ADDTIME( (SELECT entryTime2), '01:15:00' ), (SELECT doctorID2), (SELECT patientID6), 'esperando' ),
			( null, (SELECT appointmentDate), ADDTIME( (SELECT entryTime3), '01:30:00' ), (SELECT doctorID3), (SELECT patientID7), 'esperando' ),
			( null, (SELECT appointmentDate), ADDTIME( (SELECT entryTime4), '01:45:00' ), (SELECT doctorID4), (SELECT patientID8), 'esperando' ),
			( null, (SELECT appointmentDate), ADDTIME( (SELECT entryTime1), '02:00:00' ), (SELECT doctorID1), (SELECT patientID9), 'esperando' ),
			( null, (SELECT appointmentDate), ADDTIME( (SELECT entryTime2), '02:15:00' ), (SELECT doctorID2), (SELECT patientID10), 'esperando' )
		;

		/*INSERT INTO
			turnos
		VALUES
			( null, (SELECT appointmentDate), ADDTIME( (SELECT entryTime), '00:00:00' ), (SELECT doctorID), (SELECT patientID1), 'esperando' ),
			( null, (SELECT appointmentDate), ADDTIME( (SELECT entryTime), '00:15:00' ), (SELECT doctorID), (SELECT patientID2), 'esperando' ),
			( null, (SELECT appointmentDate), ADDTIME( (SELECT entryTime), '00:30:00' ), (SELECT doctorID), (SELECT patientID3), 'esperando' ),
			( null, (SELECT appointmentDate), ADDTIME( (SELECT entryTime), '00:45:00' ), (SELECT doctorID), (SELECT patientID4), 'esperando' ),
			( null, (SELECT appointmentDate), ADDTIME( (SELECT entryTime), '01:00:00' ), (SELECT doctorID), (SELECT patientID5), 'esperando' ),
			( null, (SELECT appointmentDate), ADDTIME( (SELECT entryTime), '01:15:00' ), (SELECT doctorID), (SELECT patientID6), 'esperando' ),
			( null, (SELECT appointmentDate), ADDTIME( (SELECT entryTime), '01:30:00' ), (SELECT doctorID), (SELECT patientID7), 'esperando' ),
			( null, (SELECT appointmentDate), ADDTIME( (SELECT entryTime), '01:45:00' ), (SELECT doctorID), (SELECT patientID8), 'esperando' ),
			( null, (SELECT appointmentDate), ADDTIME( (SELECT entryTime), '02:00:00' ), (SELECT doctorID), (SELECT patientID9), 'esperando' ),
			( null, (SELECT appointmentDate), ADDTIME( (SELECT entryTime), '02:15:00' ), (SELECT doctorID), (SELECT patientID10), 'esperando' )
		;*/
		
		SELECT daysCount - 1 INTO daysCount;
		IF daysCount <= 0 THEN
			LEAVE theLoop;
		END IF;
		
	END LOOP theLoop;
END$$
DELIMITER ;
/**************************************************************/
/**************************************************************/
/**************************************************************/
CALL insertAppointmentsForTheCurrentWeek();