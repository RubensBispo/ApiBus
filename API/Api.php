<?php 

	require_once '../includes/DbOperation.php';

	function isTheseParametersAvailable($params){
	
		$available = true; 
		$missingparams = ""; 
		
		foreach($params as $param){
			if(!isset($_POST[$param]) || strlen($_POST[$param])<=0){
				$available = false; 
				$missingparams = $missingparams . ", " . $param; 
			}
		}
		
		
		if(!$available){
			$response = array(); 
			$response['error'] = true; 
			$response['message'] = 'Parameters ' . substr($missingparams, 1, strlen($missingparams)) . ' missing';
			
			echo json_encode($response);
			
			die();
		}
	}
	

	$response = array();
	

	if(isset($_GET['apicall'])){
		
		switch($_GET['apicall']){
	
			case 'create_eventos':
				
				isTheseParametersAvailable(array('tipo', 'evento'));
				
				$db = new DbOperation();
				
				$result = $db->createEventos(
					$_POST['tipo'],
					$_POST['evento']
					
				);
				
				if($result){
					
					$response['error'] = false; 

					
					$response['message'] = 'Evento adicionado com sucesso';

					
					$response['sensor'] = $db->getEventos();
				}else{

					
					$response['error'] = true; 

				
					$response['message'] = 'Algum erro ocorreu por favor tente novamente';
				}
				
			break; 
			
			case 'get_intervalo':
				$db = new DbOperation();
				$response['error'] = false; 
				$response['message'] = 'Evento concluído com sucesso';
				$response['intervalo'] = $db->getIntervalo();

			break;
		
			case 'get_eventos':
				$db = new DbOperation();
				$response['error'] = false; 
				$response['message'] = 'Evento concluído com sucesso';
				$response['evento'] = $db->getEventos();

			break;

			case 'get_total':
				$db = new DbOperation();
				$response['error'] = false; 
				$response['message'] = 'Evento totalizado com sucesso';
				$response['total'] = $db->getTotal();

			break; 

			case 'get_simulacao':

				$db = new DbOperation();
				$response['error'] = false; 
				$response['message'] = 'Evento simulacao executada com sucesso';
				$response['total'] = $db->teste();

			break; 
			
		
			case 'update_eventos':
				isTheseParametersAvailable(array('id','data_hora','tipo','evento'));
				$db = new DbOperation();
				$result = $db->updateEventos(
					$_POST['id'],
					$_POST['data_hora'],
					$_POST['tipo'],
					$_POST['evento']
				
				);
				
				if($result){
					$response['error'] = false; 
					$response['message'] = 'Evento atualizado com sucesso';
					$response['evento'] = $db->getEventos();
				}else{
					$response['error'] = true; 
					$response['message'] = 'Algum erro ocorreu por favor tente novamente';
				}
			break; 
			
			case 'delete_eventos':

				if(isset($_GET['id'])){
					$db = new DbOperation();
					if($db->deleteEventos($_GET['id'])){
						$response['error'] = false; 
						$response['message'] = 'Evento excluído com sucesso';
						$response['evento'] = $db->getEventos();
					}else{
						$response['error'] = true; 
						$response['message'] = 'Algum erro ocorreu por favor tente novamente';
					}
				}else{
					$response['error'] = true; 
					$response['message'] = 'Não foi possível deletar, forneça um id por favor';
				}
			break; 
		}
		
	}else{
		 
		$response['error'] = true; 
		$response['message'] = 'Chamada de API inválida';
	}
	

	echo json_encode($response);