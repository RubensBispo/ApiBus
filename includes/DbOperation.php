<?php

class DbOperation
{

	private $con;

	function __construct()
	{

		require_once dirname(__FILE__) . '/DbConnect.php';

		$db = new DbConnect();

		$this->con = $db->connect();
	}
	
	//Receber dados do sensor
	//$tipo = $_GET['tipo']; // Tipo do sensor (por exemplo, "movimento")
	//$evento = $_GET['evento']; // Tipo de evento (entrada ou saída)
	//$data_hora = $_GET['data_hora']; // data, hora do movimento 
	
	function createEventos($data_hora, $evento){
		//$date = date('m/d/Y h:i:s a', time());

		$tipo = 'movimento';

		$stmt = $this->con->prepare("INSERT INTO sensor (data_hora, tipo, evento) VALUES (?, ?, ?)");
		$stmt->bind_param("sss", $data_hora, $tipo, $evento);
		if($stmt->execute())
			return true; 			
		return false;
	}

	function getIntervalo(){
		
		$sql_intervalo = 'select min(id) as inicio, max(id) as fim from sensor';

		$stmt = $this->con->prepare($sql_intervalo);
		$stmt->execute();
		$stmt->bind_result($inicio,$fim);
		
		$intervalos = array(); 
		
		while($stmt->fetch()){
			$intervalo  = array();
			$intervalo['inicio'] = $inicio; 
			$intervalo['fim'] = $fim; 
			
			array_push($intervalos, $intervalo); 
		}
		
		return $intervalo; 
	}

	//corrigir
	function getTotal(){
		// Responder com o número atual de pessoas na sala
		$stmt = $this->con->prepare("SELECT COUNT(id) as result FROM sensor ");
		$stmt->execute();
		$stmt->bind_result($result);


		$res_totais = array(); 
		
		while($stmt->fetch()){
			$total  = array();
			$total['total'] = $result; 
			
			array_push($res_totais, $total); 
		}

		return $res_totais;
	}
	
	function getEventos(){
		
		$stmt = $this->con->prepare("SELECT id, data_hora, tipo, evento FROM sensor");
		$stmt->execute();
		$stmt->bind_result($id, $data_hora, $tipo, $evento);
		
		$sensores = array(); 
		
		while($stmt->fetch()){
			$sensor  = array();

			$sensor['id'] = $id; 
			$sensor['data_hora'] = $data_hora; 
			$sensor['tipo'] = $tipo; 
			$sensor['evento'] = $evento;  
			
			array_push($sensores, $sensor); 
		}
		
		return $sensores; 
	}

	function updateEventos($id, $evento ){

		$stmt = $this->con->prepare("UPDATE sensor SET  evento = ?  WHERE id = ?");
		$stmt->bind_param("si",  $evento, $id);
		if($stmt->execute())
			return true; 
		return false; 
	}

	function deleteEventos($id){
		$stmt = $this->con->prepare("DELETE FROM sensor WHERE id = ? ");
		$stmt->bind_param("i", $id);
		if($stmt->execute())
			return true; 
		return false; 
	}

	function addRemoveUpdateItems() {
	    //$db = new DbOperation()

	    // Adicionar um item com valores aleatórios entre 1 e 10
	    //$tipo = rand(1, 10);
	    //$evento = rand('entrada', 'saida');
	    //$date = date('m/d/Y h:i:s');
	    //$db->createEventos($evento);

	   // $db->getIntervalo();

	    // Remover um item (supondo que você tenha o ID do item a ser removido)
	    //$id = rand($db->inicio, $db->fim); // ID do item a ser removido, escolhido aleatoriamente
	    //$db->deleteEventos($id);

	}

	function teste()
	{
		$db = new DbOperation();
		while (true) 
		{
			$db->addRemoveUpdateItems();
	    	sleep(3); // Espera 10 segundos antes de executar novamente
	    	$db->getTotal();
	    }
	}


//entrada - saida


	function sensor()
	{
		$capacidade_sentados = 50;
		$capacidade_de_pe = 18;
		$capacidade_total = $capacidade_sentados +$capacidade_de_pe;		

		$entrada = rand(1,$capacidade_total);

		$saida = rand(1,$capacidade_total);
		
		//imprime capacidade
		echo 'Capacidade total: '.$capacidade_total.'<br>Capacidade de assentos :'.$capacidade_sentados.'<br>'.'Capacidade em pé  :'.$capacidade_de_pe.'<br>*********************************************<br>';

		if($entrada >= $capacidade_total){
			echo $entrada. '<br>';
			echo "<span style='color:red'>Ambiente lotado</stye><br><br> ";
			
		}elseif($entrada< ($capacidade_total - 3) && $entrada>$capacidade_sentados){
			echo 'Total: '.$entrada. '<br>';
			echo "<span style='color:orange'>Intermediário</stye><br><br>";
		}else{
			echo 'Total: '.$entrada. '<br>';
			echo "<span style='color:green'>Ambiente vazio</stye><br><br>";
		}		

	}

}

