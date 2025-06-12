<?php
require_once __DIR__ . '/../../models/AllocationModel.php';

// header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $allocationID = $_POST['allocationID'];
    $remarks = $_POST['remarks'];

    try {
        $record = new AllocationModel();

        $record->allocationID = $allocationID;
        $record->remarks = $remarks;

        $record::UpdateOutAllocation($record);

        echo json_encode(['status' => 'success', 'message' => '']);
    } catch (Exception $e){
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

}