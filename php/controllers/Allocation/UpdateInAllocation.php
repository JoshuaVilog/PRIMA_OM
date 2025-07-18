<?php
require_once __DIR__ . '/../../models/AllocationModel.php';

// header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $operator = $_POST['operator'];
    $date = $_POST['date'];
    $attendanceID = $_POST['attendanceID'];
    $process = $_POST['process'];
    $machine = $_POST['machine'];
    $remarks = $_POST['remarks'];

    try {
        $record = new AllocationModel();

        $record->operator = $operator;
        $record->date = $date;
        $record->process = $process;
        $record->machine = $machine;
        $record->remarks = $remarks;
        $record->attendanceID = $attendanceID;

        $record::InsertAllocationLogs($record);


        echo json_encode(['status' => 'success', 'message' => '']);
    } catch (Exception $e){
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

}