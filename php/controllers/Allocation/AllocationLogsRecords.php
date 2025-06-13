<?php
require_once __DIR__ . '/../../models/AllocationModel.php';

header('Content-Type: application/json');

try {
    $records = AllocationModel::AllocationLogsRecords();
    echo json_encode(['status' => 'success', 'data' => $records]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

?>
