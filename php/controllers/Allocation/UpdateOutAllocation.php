<?php
require_once __DIR__ . '/../../models/AllocationModel.php';

// header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $attendanceID = $_POST['attendanceID'];
    $remarks = $_POST['remarks'];

    try {
        $record = new AllocationModel();

        $record->attttendanceID = $attendanceID;
        $record->remarks = $remarks;

        $allocationID = $record::GetAllocationByAttendanceID($attendanceID);

        if($allocationID != NULL){

            $record->allocationID = $allocationID;
            
            $record::UpdateOutAllocation($record);

        }

        echo json_encode(['status' => 'success', 'message' => '']);
    } catch (Exception $e){
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

}