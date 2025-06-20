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

    public static function UpdateFixedAllocation($record){
        $db = DB::connectionODAS();
        $sql = "";
        
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