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

	//corrigir
	function getTotal(){
		// Responder com o número atual de pessoas na sala
		$stmt = $this->con->prepare("SELECT COUNT(*) as total FROM sensor WHERE evento = 'entrada'");
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$total_evento = $row['total'];

		return $total_evento;
	}


	function updateEventos($id, $data_hora, $tipo, $evento ){
		$stmt = $this->con->prepare("UPDATE sensor SET data_hora = ?, tipo = ?, evento = ?  WHERE id = ?");
		$stmt->bind_param("sssi", $data_hora, $tipo, $evento, $id);
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
}