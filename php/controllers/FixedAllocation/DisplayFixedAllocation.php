

<?php
require_once __DIR__ . '/../../models/EmployeeModel.php';
require_once __DIR__ . '/../../models/FixedAllocationModel.php';

header('Content-Type: application/json');


try {
    $recordsAllocation = FixedAllocationModel::FixedAllocationRecords();
    $recordsOperator = EmployeeModel::DisplayOperatorRecords();

    $records = [];

    foreach($recordsOperator as $operator){

        $newRow = array();

        $process = 0;
        $machineCode = 0;

        foreach($recordsAllocation as $allocation){

            if($operator['EMPLOYEE_ID'] == $allocation['OPERATOR']){

                $process = $allocation['PROCESS'];
                $machineCode = $allocation['MACHINE_CODE'];
                break;
            }
        }

        $newRow['id'] = $operator['EMPLOYEE_ID'];
        $newRow['OPERATOR'] = $operator['EMPLOYEE_ID'];
        $newRow['OPERATOR_NAME'] = $operator['EMPLOYEE_NAME'];
        $newRow['PROCESS'] = $process;
        $newRow['MACHINE_CODE'] = $machineCode;

        $records[] = $newRow;

    }


    echo json_encode(['status' => 'success', 'data' => $records]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

?>
