<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');

/*
$horario = date("d.m.y H:i:s");
$horariotransbordo = date("d.m.y H:i:s", strtotime('+1 hour'));
		echo $horario;
		echo "<br>".$horariotransbordo;
*/

class tarjeta{
	
	var $saldo;
	var $viajes = [];
	var $tipo;
	var $ultlinea=0;
	var $count=0;

	function __construct($saldo,$tipo){
		$this->saldo = $saldo;
		$this->tipo=$tipo;
	}
	/*
	function agregarviaje($hora, $colectivo, $monto){
		$this->viajes->hora[] = $hora;
		$this->viajes->colectivo[] = $colectivo;
		$this->viajes->monto[] = $monto;
	}
	*/
	function pagarboleto($horario, $horariotransbordo, $colectivo){
		if($this->tipo == 1){ 											//tipo 1 = tarjeta comun
			if($horario < $horariotransbordo && $colectivo->linea!=$this->ultlinea && $this->count < 2){	// date(..) = hora actual
				if($this->saldo >= 1.90){
					$this->saldo = $this->saldo - 1.90;
					$this->viajes[]= new viajes($horario ,$colectivo->linea,1.90);
					echo "Disfrute su viaje transbordo";
					$this->ultlinea = $colectivo->linea;
					$this->count++;
					return true;
				}
				else{
					echo "Saldo insuficiente";
					return false;
				}
			}
			else{
				if($this->saldo >= 5.75){
					$this->saldo = $this->saldo - 5.75;
					$this->viajes[]= new viajes($horario,$colectivo->linea,5.75);
					$this->ultlinea = $colectivo->linea;
					echo "Disfrute su viaje";
					$this->count = 0;
					return true;
				}
				else{
					echo "Saldo insuficiente";
					return false;
				}

			}
		}
		else{														//tipo 2 = medio boleto
		if($horario > strtotime("00:00:00") and $horario < strtotime("06:00:00")){  //chequea si esta en horario funcional
			if($horario < $horariotransbordo && $colectivo->linea != $this->ultlinea && $this->count < 2){
				if($this->saldo >= 1.90){
					$this->saldo = $this->saldo - 1.90;
					$this->viajes[]= new viajes($horario ,$colectivo->linea,1.90);
					echo "Disfrute su viaje transbordo";
					$this->ultlinea = $colectivo->linea;
					$this->count++;
					return true;
				}
				else{
					echo "Saldo insuficiente";
					return false;
				}
			}
			else{
				if($this->saldo >= 5.75){
					$this->saldo = $this->saldo - 5.75;
					$this->viajes[]= new viajes($horario,$colectivo->linea,5.75);
					$this->ultlinea = $colectivo->linea;
					echo "Disfrute su viaje";
					$this->count=0;
					return true;
				}
				else{
					echo "Saldo insuficiente";
					return false;
				}

			}

		}
		else{										// dentro de horario funcional
			if($horario < $horariotransbordo && $colectivo->linea != $this->ultlinea && $this->count < 2){
				if($this->saldo >= 0.96 ){
					$this->saldo = $this->saldo - 0.96;
					$this->viajes[]= new viajes($horario,$colectivo->linea,0.96);
					echo "Disfrute su viaje transbordo";
					$this->ultlinea = $colectivo->linea;
					$this->count++;
					return true;
				}
				else{
					echo "Saldo insuficiente";
					return false;
				}
			}
			else{
				if($this->saldo >= 2.90){
					$this->saldo = $this->saldo - 2.90;
					$this->viajes[]= new viajes($horario,$colectivo->linea,2.90);
					$this->ultlinea = $colectivo->linea;
					echo "Disfrute su viaje";
					$this->count=0;
					return true;
				}
				else{
					echo "Saldo insuficiente";
					return false;
				}

			}

		}
	}
}

	function recarga($monto){
		if($monto<0){
			return;
		}
		if($monto < 196){
			$this->saldo = $this->saldo + $monto;
		}
		else{
			if($monto < 368){
				$this->saldo = $this->saldo + $monto + 34;
			}
			else{
				$this->saldo = $this->saldo + $monto + 92;
			}
		}
	}

	function saldo(){
		//echo '$';
		return $this->saldo;
	}

	function viajesrealizados(){
		print_r($this->viajes);
	}

}

class viajes{

	var $hora;
	var $colectivo;
	var $monto;

	function __construct($hora,$linea,$monto){
		$this->hora=$hora;
		$this->colectivo=$linea;
		$this->monto=$monto;
	}
}

class colectivo{

	var $empresa;
	var $linea;
	var $numero;

	function __construct($empresa, $linea, $numero){
		$this->empresa = $empresa;
		$this->linea = $linea;
		$this->numero = $numero;
	}
}


?>
