<?php
require_once __DIR__ . '/../../models/MachineModel.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $machine = $_POST['machine'];
    $user = $_POST['user'];

    try {

       $checkLogs = MachineModel::CheckMachineLogs($machine, $user);
       $rid = 0;

        if($checkLogs == 0){
            $response = "IN";
        } else {
            $rid = $checkLogs;
            $response = "OUT";
        }
        
        echo json_encode(['status' => 'success', 'status' => $response, 'rid' => $rid, 'message' => '']);
    } catch (Exception $e){
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

}