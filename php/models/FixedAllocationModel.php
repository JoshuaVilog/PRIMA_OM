<?php
require_once __DIR__ . '/../../config/db.php';


class FixedAllocationModel {

    public static function FixedAllocationRecords() {
        $db = DB::connectionODAS();
        $sql = "SELECT `RID`, `OPERATOR`, `PROCESS`, `MACHINE_CODE`, `CREATED_AT`, `CREATED_BY` FROM `fixed_allocation_masterlist` WHERE `ALLOCATE_STATUS` = 1";
        $result = $db->query($sql);

        $records = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                
                $records[] = $row;
            }
        }

        return $records;
    }
    public static function FindOperatorFixedAllocation($operator){
        $db = DB::connectionODAS();
        $sql = "SELECT `RID`, `OPERATOR`, `PROCESS`, `MACHINE_CODE` FROM `fixed_allocation_masterlist` WHERE OPERATOR = $operator AND ALLOCATE_STATUS = 1";
        $result = mysqli_query($db,$sql);

        if(mysqli_num_rows($result) == 0){
            return null;
        } else {
            $row = mysqli_fetch_assoc($result);

            return $row;
        }
    }

    public static function InsertFixedAllocation($records){
        $db = DB::connectionODAS();
        $userCode = $_SESSION['USER_CODE'];

        $operator = $db->real_escape_string($records->operator);
        $process = $db->real_escape_string($records->process);
        $machine = $db->real_escape_string($records->machine);

        $sql = "INSERT INTO `fixed_allocation_masterlist`(
            `RID`,
            `OPERATOR`,
            `PROCESS`,
            `MACHINE_CODE`,
            `ALLOCATE_STATUS`,
            `CREATED_BY`
        )
        VALUES(
            DEFAULT,
            '$operator',
            '$process',
            '$machine',
            '1',
            '$userCode'
        )";
        
        return $db->query($sql);
    }

    public static function UpdatePrevAllocation($allocationID){
        $db = DB::connectionODAS();
        $userCode = $_SESSION['USER_CODE'];

        // $allocationID = $db->real_escape_string($records->allocationID);

        $sql = "UPDATE
            `fixed_allocation_masterlist`
        SET
            `ALLOCATE_STATUS` = 0
        WHERE
            `RID` = $allocationID";
        
        return $db->query($sql);

    }


}

/* 
if(operator == operator AND status == 1){
    // MAY NAKA FIX

} else {
    // PAG WALA NAKA FIX

    if(process == process AND machine == machine AND status == 1){
        //MAY NAKASET PERO IBANG OPERATOR

    } else {
        // PAG WALA NAKA FIX


    }


}


*/