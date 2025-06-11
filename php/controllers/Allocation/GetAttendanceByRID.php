<?php
require_once __DIR__ . '/../../models/AllocationModel.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'];

    try {
        $records = AllocationModel::GetAttendanceRecord($id);
        
        echo json_encode($records);

    } catch (Exception $e){
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}