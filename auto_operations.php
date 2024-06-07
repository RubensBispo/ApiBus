<?php

require_once '../includes/DbOperation.php';

function addRemoveUpdateItems() {
    $db = new DbOperation();

    // Adicionar um item com valores aleatórios entre 1 e 10
    $tipo = rand(1, 10);
    $evento = rand('entrada', 'saida');
    $date = date('m/d/Y h:i:s a', time());
    $db->createEventos($data, $evento);

    
    $db->getIntervalo();

    // Remover um item (supondo que você tenha o ID do item a ser removido)
    $id = rand($db->inicio, $db->fim); // ID do item a ser removido, escolhido aleatoriamente
    $db->deleteEventos($id);

    // Atualizar um item (supondo que você tenha os novos dados do item)

    //$id = rand(1, 10); // ID do item a ser atualizado, escolhido aleatoriamente
    //$data_hora = "2024-06-05 12:00:00"; // Nova data e hora
    //$tipo = rand(1, 10);
   // $evento = rand(1, 10);
    //$db->updateEventos($id, $data_hora, $tipo, $evento);
}

// Loop infinito para executar as operações a cada 10 segundos
while (true) {
    addRemoveUpdateItems();
    sleep(10); // Espera 10 segundos antes de executar novamente
}
