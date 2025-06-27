<?php
require_once __DIR__ . '/../../models/ProcessModel.php';
require_once __DIR__ . '/../../models/AllocationModel.php';

header('Content-Type: application/json');

// GETTING RECORDS BY MACHINE
// STAND BY MUNA ETONG CODE

$date = $_POST['date'];

try {
    $records = AllocationModel::GetAllocationRecordByDate($date);
    $recordsProcessMachine = ProcessModel::DisplayProcessAndMachineRecords();

    $newRecords = array();

    foreach($recordsProcessMachine as $process){

        $newRow = array();

        $isAllocate = false;
        
        foreach($records as $record){

            if(($record['PROCESS'] == $process['PROCESS_ID'] && $record['MACHINE_CODE'] == $process['MACHINE_ID']) && $record['OUT_DATETIME'] == null){

                $newRow['PROCESS'] = $process['PROCESS_ID'];
                $newRow['MACHINE'] = $process['MACHINE_ID'];
                $newRow['OPERATOR'] = $record['OPERATOR'];

                $isAllocate = true;
                $newRecords[] = $newRow;
                // $newRecords[] = $record['PROCESS']. "-". $record['OPERATOR'];
                
                
            }
        }

        if($isAllocate == false){
            $newRow['PROCESS'] = $process['PROCESS_ID'];
            $newRow['MACHINE'] = $process['MACHINE_ID'];
            $newRow['OPERATOR'] = 0;

            $newRecords[] = $newRow;

        }



    }

    
    echo json_encode(['status' => 'success', 'data' => $newRecords]);
    // echo json_encode(['status' => 'success', 'data' => $records]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

?>
