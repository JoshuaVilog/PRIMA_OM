<?php
require_once __DIR__ . '/../../models/MachineModel.php';

header('Content-Type: application/json');

$user = $_POST['user'];

try {
    $records = MachineModel::DisplayMachineLogsRecordsByUser($user);
    
    echo json_encode(['status' => 'success', 'data' => $records]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

?>
