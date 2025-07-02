<?php
require_once __DIR__ . '/../../models/AllocationModel.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // $date = $_POST['date'];
    // $oldDateTime = $_POST['oldDateTime'];

    try {
        // Set timezone to Philippines
        date_default_timezone_set('Asia/Manila');
        $currentHour = (int)date("H"); // 24-hour format
        $datetime = date("Y-m-d H:i:s");

        if($currentHour >= 19 && 7 >= $currentHour){
            //NIGHTSHIFT
            // echo "OUT DAYSHIFT ";

            if(7 >= $currentHour){

                $date = date("Y-m-d", strtotime('-1 day'));
            } else {

                $date = date("Y-m-d");
            }
            
            $shift = "1";
        } else if($currentHour >= 7 && 19 >= $currentHour){
            //DAYSHIFT
            // echo "OUT NIGHTSHIFT ";

            $date = date("Y-m-d");
            $shift = "2";
        }
        // echo $date;
        $records = AllocationModel::SelectOutAttendance($shift, $date);

        if(count($records) > 0){
            //AUTOMATIC UPDATE
            AllocationModel::AutomaticOutAttendance($shift, $date);

            echo json_encode(['status' => 'success', 'message' => 'Automatic Update Success. As of '.$datetime]);
        }

        echo json_encode(['status' => 'success', 'message' => 'Search Attendance Done. '.count($records) ." searched records. As of ".$datetime]);
    } catch (Exception $e){
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}