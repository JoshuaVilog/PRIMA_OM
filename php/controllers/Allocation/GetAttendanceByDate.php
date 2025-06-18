<?php
require_once __DIR__ . '/../../models/EmployeeModel.php';
require_once __DIR__ . '/../../models/AllocationModel.php';

header('Content-Type: application/json');

$date = $_POST['date'];

try {
    $recordsAllocation = AllocationModel::AllocationRecords($date);
    $recordsOperator = EmployeeModel::DisplayOperatorRecords();

    $records = [];

    foreach($recordsOperator as $operator){
        
        $newRow = array();

        $allocationID = 0;
        $allocationShift = 0;
        $allocationAttendanceStatus = 0;

        foreach($recordsAllocation as $allocation){
            if($operator['EMPLOYEE_ID'] == $allocation['OPERATOR']){

                $allocationID = $allocation['RID'];
                $allocationShift = $allocation['SHIFT'];
                $allocationAttendanceStatus = $allocation['ATTENDANCE_STATUS'];
                break;
            }
        }

        $newRow['id'] = $operator['EMPLOYEE_ID'];
        $newRow['EMPLOYEE_ID'] = $operator['EMPLOYEE_ID'];
        $newRow['EMPLOYEE_NAME'] = $operator['EMPLOYEE_NAME'];
        $newRow['ALLOCATION_ID'] = $allocationID;
        $newRow['SHIFT'] = $allocationShift;
        $newRow['ATTENDANCE_STATUS'] = $allocationAttendanceStatus;

        $records[] = $newRow;
    }


    echo json_encode(['status' => 'success', 'data' => $records]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

?>
