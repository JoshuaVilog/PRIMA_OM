<?php
require_once __DIR__ . '/../../models/EmployeeModel.php';
require_once __DIR__ . '/../../models/AllocationModel.php';

header('Content-Type: application/json');

// GETTING ALL ALLOCATION RECORDS BY DATE....
// GETTING ALL ALLOCATION RECORDS BY DATE....
// GETTING ALL ALLOCATION RECORDS BY DATE....

$date = $_POST['date'];

try {
    $records = AllocationModel::GetAllocationRecordByDate($date);
    
    echo json_encode(['status' => 'success', 'data' => $records]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

?>
