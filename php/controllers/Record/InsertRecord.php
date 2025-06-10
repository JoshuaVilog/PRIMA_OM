<?php
require_once __DIR__ . '/../../models/RecordModel.php';

// header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $desc = $_POST['desc'];

    try {
       $record = new RecordModel();

       $record->desc = $desc;

       $record::InsertRecord($record);

    } catch (Exception $e){
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

}