<?php
require_once __DIR__ . '/../../models/MachineModel.php';

// header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $desc = $_POST['desc'];
    $id = $_POST['id'];

    try {
       $record = new MachineModel();

       $record->desc = $desc;
       $record->id = $id;

       $isDuplicate = $record::CheckDuplicateMachine($desc);

       if($isDuplicate == true){

            echo json_encode(['status' => 'duplicate', 'message' => '']);
       } else if($isDuplicate == false){
            $record::UpdateRecord($record);
            echo json_encode(['status' => 'success', 'message' => '']);
       }
    } catch (Exception $e){
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

}