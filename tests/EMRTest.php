<?php

require 'EMR.php';

class TarjetaTest extends PHPUnit_Framework_TestCase{

	public $tarjeta1;
	protected $tarjeta2;
	protected $tarjeta3;
	protected $tarjeta4;
	protected $colectivo144;
	protected $colectivo153;
	protected $horario;
	protected $horariotransbordo;

	public function setUp(){
		$this->tarjeta1 = new tarjeta(0,1);						// $0, tarjeta comun
		$this->tarjeta2 = new tarjeta(150,0);						// $150, tarjeta medio boleto
		$this->tarjeta4 = new tarjeta(0,0);						// $0, tarjeta medio boleto
		$this->tarjeta3 = new tarjeta(100,1);						// $100, tarjeta comun
		$this->colectivo144 = new colectivo("rosariobus",144,54321);			//colectivo 144
		$this->colectivo153 = new colectivo("semtur",153,12345);			//colectivo 154
		$this->horario = date("d.m.y H:i:s");						// hora actual
		$this->horariotransbordo = date("d.m.y H:i:s", strtotime('+1 hour'));		//hora actual + 1 hora
	}

	public function testPagarBoleto(){

	$this->assertFalse($this->tarjeta1->pagarboleto($this->horario, $this->horario, $colectivo144));		// saldo insuficiente comun

	$this->assertEquals($this->tarjeta3->pagarboleto($horario, $horario , $colectivo144), true);		// pasaje comun
	$this->assertEquals($this->tarjeta3->pagarboleto($horario, $horariotransbordo, $colectivo153), true);	// transbordo comun
	$this->assertEquals($this->tarjeta3->saldo(), 92.35);							// 100-5.75-1.90=92.35


	$this->assertEquals($this->tarjeta4->pagarboleto($horario, $horario, $colectivo153), false);		// saldo insuficiente medio boleto

	$this->assertEquals($this->tarjeta2->pagarboleto(strtotime("03:00:00"), strtotime("01:00:00"), $colectivo144), true); 	//pasaje normal con tarjeta medio boleto
	$this->assertEquals($this->tarjeta2->pagarboleto(strtotime("03:10:00"), strtotime("04:00:00"), $colectivo153), true);	//transbordo normal con tarjeta medio boleto
	$this->assertEquals($this->tarjeta2->pagarboleto($horario, strtotime("04:10:00"), $colectivo144), true);			// pasaje medio boleto
	$this->assertEquals($this->tarjeta2->pagarboleto($horario, $horariotransbordo, $colectivo153), true);			// transbordo medioboleto
	$this->assertEquals($this->tarjeta2->saldo(), 138.49);									// 150 - 5,75 - 1,90 - 2,90 - 0,96 = 138.49
	
	

	}

	public function testRecarga(){

		$this->tarjeta1->recarga(-12);
		$this->assertEquals($this->tarjeta1->saldo(), 0);				// Si recarga negativo no cambia el valor de saldo

		$this->tarjeta1->recarga(100);
		$this->assertEquals($this->tarjeta1->saldo(), 100);			// 0+100=100

		$this->tarjeta2->recarga(200);
		$this->assertEquals($this->tarjeta2->saldo(), 384);			// 150+200+34=384

		$this->tarjeta3->recarga(400);
		$this->assertEquals($this->tarjeta3->saldo(), 592);			// 100+400+92=592

		$this->tarjeta3->recarga(0);
		$this->assertEquals($this->tarjeta3->saldo(), 592);			// 592+0=592

	}
}

	
?>
