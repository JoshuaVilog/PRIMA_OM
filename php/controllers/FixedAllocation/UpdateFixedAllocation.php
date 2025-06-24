<?php
require_once __DIR__ . '/../../models/FixedAllocationModel.php';

// header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $allocationID = $_POST['allocationID'];
    $operator = $_POST['operator'];
    $process = $_POST['process'];
    $machine = $_POST['machine'];

    try {
        $record = new FixedAllocationModel();

        $record->allocationID = $allocationID;
        $record->operator = $operator;
        $record->process = $process;
        $record->machine = $machine;

        FixedAllocationModel::InsertFixedAllocation($record);

        if($allocationID != 0){
            // UPDATE PREVIOUS ALLOCATION
            FixedAllocationModel::UpdatePrevAllocation($allocationID);
            
        }

    } catch (Exception $e){
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

}