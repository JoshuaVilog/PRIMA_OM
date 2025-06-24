<?php
require_once __DIR__ . '/../../models/MachineModel.php';
require_once __DIR__ . '/../../models/AllocationModel.php';

header('Content-Type: application/json');

// GETTING

$date = $_POST['date'];

try {
    $records = AllocationModel::AllocationRecords($date);

    

    
    echo json_encode(['status' => 'success', 'data' => $records]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

?>
