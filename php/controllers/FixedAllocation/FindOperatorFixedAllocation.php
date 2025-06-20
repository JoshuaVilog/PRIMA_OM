<?php
require_once __DIR__ . '/../../models/FixedAllocationModel.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $operator = $_POST['operator'];

    try {
        $records = FixedAllocationModel::FindOperatorFixedAllocation($operator);
        
        echo json_encode(['status' => 'error', 'message' =>$records]);

    } catch (Exception $e){
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

}