<?php
require_once __DIR__ . '/../../models/AllocationModel.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $date = $_POST['date'];
    $oldDateTime = $_POST['oldDateTime'];

    try {
        $records = AllocationModel::RealtimeAllocationRecord($oldDateTime, $date);

        echo json_encode($records);

    } catch (Exception $e){
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}