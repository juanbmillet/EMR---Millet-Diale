<?php

include 'EMR.php';

$horario = date("d.m.y H:i:s");
$horariotransbordo = date("d.m.y H:i:s", strtotime('+1 hour'));

$colectivo144= new colectivo("rosariobus",144,54321);
$colectivo153 = new colectivo("semtur",153,12345);
$tarjeta1 = new tarjeta(0,1);														// $0, tarjeta comun
$tarjeta2 = new tarjeta(150,0);														// $150, tarjeta medio

assert($tarjeta1->pagarboleto(date("d.m.y H:i:s"), $colectivo144)==false);			// saldo insuficiente

assert($tarjeta1->saldo()==0);
$tarjeta1->recarga(100);
assert($tarjeta1->saldo()==100);

assert($tarjeta2->saldo()==150);
$tarjeta2->recarga(500);
assert($tarjeta2->saldo()==742);													// 150+500+92=742

assert($tarjeta1->pagarboleto($horario, $colectivo144)==true);
assert($tarjeta1->pagarboleto($horariotransbordo, $colectivo153)==true);		 	// transbordo comun
assert($tarjeta1->saldo()==92.35);													                 // 100-5.75-1.90=92.35

assert($tarjeta2->pagarboleto($horario, $colectivo144)==true);
assert($tarjeta2->pagarboleto($horariotransbordo, $colectivo153)==true);		
assert($tarjeta2->saldo()==738.14);											                        // 742-2.90-0.96=738.14

$tarjeta2->viajesrealizados();

	
?>
