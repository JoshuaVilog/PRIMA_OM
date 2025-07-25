<?php
require_once __DIR__ . '/../../models/MachineModel.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $user = $_POST['user'];
    $rid = $_POST['rid'];
    $remarks = $_POST['remarks'];

    try {
        $record = new MachineModel();

        $record->user = $user;
        $record->rid = $rid;
        $record->remarks = $remarks;

        $checkLogs = MachineModel::UpdateMachineLogHistory($record);
        
        echo json_encode(['status' => 'success', 'message' => '']);
    } catch (Exception $e){
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

}