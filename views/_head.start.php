<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Climedis - <?php echo $page; ?></title>
		<?php t_setCustomTypeface(); ?>
		<link href="/css/bootstrap.css" rel="stylesheet">
		<script src="/js/jquery-2.0.0.min.js"></script>
		<script src="/js/jquery-ui-1.10.3.custom.min.js"></script>
		<script src="/js/bootstrap.js"></script>
		<script src="/js/bootstrap-datepicker.js"></script>
		<script src="/js/bootstrap-datepicker.es.js"></script>
		<link href="/css/datepicker.css" rel="stylesheet">
		<script src="/js/bootstrap-timepicker.js"></script>
		<link href="/css/bootstrap-timepicker.css" rel="stylesheet">
		<link href="/css/is2.css" rel="stylesheet">
		<script src="/js/is2.js"></script>
		<style>
			.ar-clock {
				position: fixed;
				top: 110px;
				left: 10px;
				text-align: center;
				z-index: -1;
			}
			.ar-clock > span {
				display: block;
			}
			.ar-clock h1 {
				font-size: 100px;
				font-weight: 600;
				color: #ccc;
				text-shadow: 0 -2px 0 #fff;
				line-height: .7;
				opacity: .7;
			}
			.ar-clock-month {
				font-size: 50px;
				color: #fff;
				text-shadow: 0 -2px 0 #ccc;
				font-weight: 600;
				line-height: .4;
				position: relative;
				z-index: 100;
			}
			.ar-clock-year {
				font-size: 40px;
				font-weight: 600;
				color: #ddd;
				text-shadow: 0 -1px 0 #ccc;
				line-height: 1.5;
			}
			.ar-clock-time {
				font-size: 20px;
				font-weight: 600;
				color: #ddd;
				text-shadow: 0 -1px 0 #ccc;
			}
		</style>
		<script>
			$( function() {
				var $clock = $(
					'<div class="ar-clock">' +
						'<h1></h1>' +
						'<span class="ar-clock-month"></span>' +
						'<span class="ar-clock-year"></span>' +
						'<div class="ar-clock-time">' +
							'<span class="ar-clock-time-hours"></span>' +
							'<span>:</span>' +
							'<span class="ar-clock-time-minutes"></span>' +
						'</div>' +
					'</div>'
				);
				
				var padInteger = function( value ) {
					return value < 10 ? '0' + value : value;
				};
			
				var d = new Date(),
					date = d.getDate(),
					MONTHNAMES = [ 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre' ],
					month = MONTHNAMES[d.getMonth()];
					
				$clock.find( 'h1' ).html( padInteger( date ) );
				$clock.find( '.ar-clock-month' ).html( month );
				$clock.find( '.ar-clock-year' ).html( d.getFullYear() );
				
				var $hours = $clock.find( '.ar-clock-time-hours' ),
					$minutes = $clock.find( '.ar-clock-time-minutes' );
				
				var updateClock = function() {
					var d = new Date(),
						hours = d.getHours(),
						minutes =  d.getMinutes();
						
					$hours.html( padInteger( hours ) );
					$minutes.html( padInteger( minutes ) );
					
					nextTick();
				};
				
				var nextTick = function() {
					window.setTimeout( function() {
						updateClock();
					}, 60000 );
				};
				
				updateClock();
				
				$( 'body' ).append( $clock );
			} );
		</script>