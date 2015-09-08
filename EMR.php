<html>
<head>
<title>TP Millet-Diale</title>
<h1 align="center">EMR MILLET-DIALE (DAGOSTINO)</h1>
<br>
</head>

<body>

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
	var $viajes;
	var $tipo;

	function asignar($saldo,$tipo){
		$this->saldo = $saldo;
		//$tusviajes = new viajes;
	/*	$this->viajes->hora=[];
		$this->viajes->colectivo=[];
		$this->viajes->monto=[];*/
		$this->tipo=$tipo;
	}

	function agregarviaje($hora, $colectivo, $monto){
		$this->viajes->hora[] = $hora;
		$this->viajes->colectivo[] = $colectivo;
		$this->viajes->monto[] = $monto;
	}

	function pagarboleto($horariotransbordo, $colectivo){
		if($this->tipo == 1){ 										//tipo 1 = tarjeta comun
			if(date("d.m.y H:i:s") < $horariotransbordo){			// date(..) = hora actual
				if($this->saldo >= 1.90){
					$this->saldo = $this->saldo - 1.90;
					$this->agregarviaje(date("d.m.y H:i:s"), $colectivo, 1.90);
					echo "Disfrute su viaje transbordo";
				}
				else{
					echo "Saldo insuficiente";
				}
			}
			else{
				if($this->saldo >= 5.75){
					$this->saldo = $this->saldo - 5.75;
					$this->agregarviaje(date("d.m.y H:i:s"), $colectivo, 5.75);
					echo "Disfrute su viaje";
				}
				else{
					echo "Saldo insuficiente";
				}

			}
		}
		else{														//tipo 2 = medio boleto
		if(date("H:i:s") > strtotime("00:00:00") and date("H:i:s") < strtotime("06:00:00")){  //chequea si esta en horario funcional
			if(date("d.m.y H:i:s") < $horariotransbordo){
				if($this->saldo >= 1.90){
					$this->saldo = $this->saldo - 1.90;
					$this->agregarviaje(date("d.m.y H:i:s"), $colectivo, 1.90);
					echo "Disfrute su viaje transbordo";
				}
				else{
					echo "Saldo insuficiente";
				}
			}
			else{
				if($this->saldo >= 5.75){
					$this->saldo = $this->saldo - 5.75;
					$this->agregarviaje(date("d.m.y H:i:s"), $colectivo, 5.75);
					echo "Disfrute su viaje";
				}
				else{
					echo "Saldo insuficiente";
				}

			}

		}
		else{														// dentro de horario funcional
			if(date("d.m.y H:i:s") < $horariotransbordo){
				if($this->saldo >= 0.96){
					$this->saldo = $this->saldo - 0.96;
					$this->agregarviaje(date("d.m.y H:i:s"), $colectivo, 0.96);
					echo "Disfrute su viaje transbordo";
				}
				else{
					echo "Saldo insuficiente";
				}
			}
			else{
				if($this->saldo >= 2.90){
					$this->saldo = $this->saldo - 2.90;
					//$this -> $tusviajes -> agregarviaje(date("d.m.y H:i:s"), $colectivo, 2.90);
					$this->agregarviaje(date("d.m.y H:i:s"), $colectivo, 2.90);
					echo "Disfrute su viaje";
				}
				else{
					echo "Saldo insuficiente";
				}

			}

		}
	}
}

	function recarga($monto){
		if($monto < 196){
			$this->saldo = $this->saldo + $monto;
		}
		else{
			if($monto < 368){
				$this->saldo = $this->saldo + $monto + 34;
			}
			else{
				$this->saldo = $this->saldo + 92;
			}
		}
	}

	function saldo(){
		return $this->saldo;
	}



	function viajesrealizados(){
		return $this->viajes;
	}


}

class viajes{

	var $hora;
	var $colectivo;
	var $monto;

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

		<form method="post">
		<div align="center">
			<div>
			<h1>Crear Tarjeta</h1>
			</div>
			<div>
			<h2>Saldo</h2>
			<input type="number" name="saldo"required>
			</div>
			<div>
			<h2>Tipo de tarjeta</h2>
			<select name="formTarjeta">
  				<option value="">Selecciona...</option>
  				<option value="1">Tarjeta Normal</option>
  				<option value="2">Tarjeta Medio boleto</option>
			</select>
			</div>
			<br>
			<div align="center">
			<input type="submit" name="enviar" value="Crear Tarjeta">
			</div>
		</div>
	</form>
	<br>
	<br>
	<form method="post">
		<div align="center">
			<div>
			<h1>Cargar Tarjeta</h1>
			</div>
			<div>
			<h2>Monto a cargar</h2>
			<input type="number" name="monto"required>
			</div>
			<br>
			<div align="center">
			<input type="submit" name="enviar2" value="Cargar Tarjeta">
			</div>
		</div>
	</form>


<?php
if(isset($_POST['enviar'])){
	if(empty($_POST['formTarjeta'])){
		?>
		<h2 align="center">No seleccionaste el tipo de tarjeta!</h2>
		<?php
	}
	else{
		$tarjeta = new tarjeta;
		$tarjeta->saldo = $_POST['saldo'];
		$tarjeta->tipo = $_POST['formTarjeta'];
	}
}
if(isset($_POST['enviar2'])){
	$tarjeta->recarga($_POST['monto']);
}	

?>

</body>
</html>
