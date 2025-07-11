<?php
require_once __DIR__ . '/../../models/MachineModel.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $machine = $_POST['machine'];
    $user = $_POST['user'];
    $purpose = $_POST['purpose'];

    try {
        $record = new MachineModel();

        $record->machine = $machine;
        $record->user = $user;
        $record->purpose = $purpose;

        $checkLogs = MachineModel::InsertMachineLogHistory($record);
        
        echo json_encode(['status' => 'success', 'message' => '']);
    } catch (Exception $e){
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

}