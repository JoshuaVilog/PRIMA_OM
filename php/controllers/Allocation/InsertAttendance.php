<?php
require_once __DIR__ . '/../../models/AllocationModel.php';

// header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $operator = $_POST['operator'];
    $operatorName = $_POST['operatorName'];
    $date = $_POST['date'];
    $shift = $_POST['shift'];
    $attendanceStatus = $_POST['attendanceStatus'];

    $process = $_POST['process'];
    $machine = $_POST['machine'];
    $remarks = $_POST['remarks'];

    try {
        $record = new AllocationModel();

        $record->operator = $operator;
        $record->date = $date;
        $record->shift = $shift;
        $record->attendanceStatus = $attendanceStatus;

        $record->process = $process;
        $record->machine = $machine;
        $record->remarks = $remarks;

        $attendanceID = $record::InsertAttendance($record);

        $record->attendanceID = $attendanceID;

        if($attendanceStatus == "1"){
            $record::InsertAllocationLogs($record);
        }

        $return = ['id' => $operator, 'ALLOCATION_ID' => $attendanceID, 'ATTENDANCE_STATUS' => $attendanceStatus, 'EMPLOYEE_ID' => $operator, 'EMPLOYEE_NAME' => $operatorName, 'SHIFT' => $shift,];


        echo json_encode(['status' => 'success', 'message' => $return]);
    } catch (Exception $e){
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

}