<?php
require_once __DIR__ . '/../../models/MachineModel.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $machine = $_POST['machine'];
    $user = $_POST['user'];

    try {

       $checkLogs = MachineModel::CheckMachineLogs($machine, $user);
       $rid = 0;
       $purpose = 0;
       $remarks = "";

        if($checkLogs == 0){
            $response = "IN";
        } else {
            $rid = $checkLogs['RID'];
            $purpose = $checkLogs['PURPOSE'];
            $remarks = $checkLogs['REMARKS'];
            $response = "OUT";
        }
        
        echo json_encode(['status' => 'success', 'status' => $response, 'rid' => $rid, 'message' => '', 'purpose' => $purpose, 'remarks' => $remarks]);
    } catch (Exception $e){
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

}