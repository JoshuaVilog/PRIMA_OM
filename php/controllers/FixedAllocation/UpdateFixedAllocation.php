<?php
require_once __DIR__ . '/../../models/RecordModel.php';

// header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $operator = $_POST['operator'];
    $process = $_POST['process'];
    $machine = $_POST['machine'];

    try {
       $record = new RecordModel();

       $record->desc = $desc;
       $record->id = $id;

       $record::UpdateRecord($record);

    } catch (Exception $e){
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

}