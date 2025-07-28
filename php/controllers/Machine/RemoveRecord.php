<?php
require_once __DIR__ . '/../../models/MachineModel.php';

// header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'];

    try {
       $record = MachineModel::RemoveRecord($id);

       echo json_encode($record);

    } catch (Exception $e){
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

}