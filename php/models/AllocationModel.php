<?php
require_once __DIR__ . '/../../config/db.php';


class AllocationModel {

    public static function AllocationRecords($date) {
        $db = DB::connectionODAS();
        $sql = "SELECT `RID`, `OPERATOR`, `SHIFT`, `ATTENDANCE_STATUS` FROM 1_om.attendance_masterlist WHERE DATE = '$date'";
        $result = $db->query($sql);

        $records = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                
                $records[] = $row;
            }
        }

        return $records;
    }
    public static function RealtimeAllocationRecord($oldDateTime, $date){
        $db = DB::connectionODAS();

        date_default_timezone_set('Asia/Manila');
        $createdAt = date("Y-m-d H:i:s");

        $sql = "SELECT `RID`, `OPERATOR`, `SHIFT`, `ATTENDANCE_STATUS` FROM `attendance_masterlist` WHERE DATE = '$date' AND REALTIME_ACTION >= '$oldDateTime' AND REALTIME_ACTION <= '$createdAt'";
        $result = $db->query($sql);
        $num = $result->num_rows;

        if($num == 0){
            return 0;
        } else {
            $records = [];

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    
                    $records[] = array(
                        "id" => $row['OPERATOR'],
                        "EMPLOYEE_ID" => $row['OPERATOR'],
                        "EMPLOYEE_NAME" => '',
                        "ALLOCATION_ID" => $row['RID'],
                        "SHIFT" => $row['SHIFT'],
                        "ATTENDANCE_STATUS" => $row['ATTENDANCE_STATUS'],
                    );
                }
            }

            return $records;
        }

        
        // return $result->num_rows;
    }
    
    public static function AllocationLogsRecords() {
        $db = DB::connectionODAS();
        $sql = "SELECT `RID`, `OPERATOR`, `PROCESS`, `MACHINE_CODE`, `IN_DATETIME`, `IN_BY`, `OUT_DATETIME`, `OUT_BY`, `REMARKS` FROM `allocation_masterlist` WHERE COALESCE(DELETED_AT, '') = '' ORDER BY RID DESC";
        $result = $db->query($sql);

        $records = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $records[] = $row;
            }
        }

        return $records;
    }
    public static function GetAttendanceRecord($id){
        $db = DB::connectionODAS();
        $sql = "SELECT `RID`, `OPERATOR`, `DATE`, `SHIFT`, `ATTENDANCE_STATUS`, `CREATED_AT`, `CREATED_BY` FROM `attendance_masterlist` WHERE RID = $id";
        $result = $db->query($sql);

        if(mysqli_num_rows($result) == 0){
            return null;
        } else {
            $row = mysqli_fetch_assoc($result);

            return $row;
        }
    }
    //
    public static function InsertAttendance($records){
        $db = DB::connectionODAS();
        $userCode = $_SESSION['USER_CODE'];

        $operator = $db->real_escape_string($records->operator);
        $date = $db->real_escape_string($records->date);
        $shift = $db->real_escape_string($records->shift);
        $attendanceStatus = $db->real_escape_string($records->attendanceStatus);

        $sql = "INSERT INTO `attendance_masterlist`(
            `RID`,
            `OPERATOR`,
            `DATE`,
            `SHIFT`,
            `ATTENDANCE_STATUS`,
            `CREATED_BY`
        )
        VALUES(
            DEFAULT,
            '$operator',
            '$date',
            '$shift',
            '$attendanceStatus',
            '$userCode'
        )";

        $db->query($sql);

        return $db->insert_id;
    }

    public static function InsertAllocationLogs($records){
        $db = DB::connectionODAS();
        $userCode = $_SESSION['USER_CODE'];

        $attendanceID = $db->real_escape_string($records->attendanceID);
        $date = $db->real_escape_string($records->date);
        $operator = $db->real_escape_string($records->operator);
        $process = $db->real_escape_string($records->process);
        $machine = $db->real_escape_string($records->machine);
        $remarks = $db->real_escape_string($records->remarks);

        date_default_timezone_set('Asia/Manila');
        $createdAt = date("Y-m-d H:i:s");

        $sql = "INSERT INTO `allocation_masterlist`(
            `RID`,
            `ATTENDANCE_ID`,
            `DATE`,
            `OPERATOR`,
            `PROCESS`,
            `MACHINE_CODE`,
            `IN_DATETIME`,
            `IN_BY`,
            `REMARKS`,
            `CREATED_BY`
        )
        VALUES(
            DEFAULT,
            '$attendanceID',
            '$date',
            '$operator',
            '$process',
            '$machine',
            '$createdAt',
            '$userCode',
            '$remarks',
            '$userCode'
        )";
        return $db->query($sql);
    }
    public static function GetAllocationByAttendanceID($attendanceID){
        $db = DB::connectionODAS();

        $sql = "SELECT RID, PROCESS, MACHINE_CODE, REMARKS FROM `allocation_masterlist` WHERE ATTENDANCE_ID = '$attendanceID' AND OUT_DATETIME IS NULL";
        $result = mysqli_query($db,$sql);

        if(mysqli_num_rows($result) == 0){
            return 0;
        } else {
            $row = mysqli_fetch_assoc($result);

            return $row;
        }
    }
    public static function GetAttendanceRecordByDate($date){
        $db = DB::connectionODAS();

        $sql = "SELECT `RID`, `OPERATOR`, `DATE`, `SHIFT`, `ATTENDANCE_STATUS`, `CREATED_AT`, `CREATED_BY` FROM `attendance_masterlist` WHERE DATE = '$date' ORDER BY RID DESC";
        $result = mysqli_query($db,$sql);

        if(mysqli_num_rows($result) == 0){
            return [];
        } else {
            $records = [];
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $records[] = $row;
                }
            }

            return $records;
        }

    }
    public static function GetAllocationRecordByDate($date){
        $db = DB::connectionODAS();

        /* $sql = "SELECT
            attendance_masterlist.RID,
            attendance_masterlist.OPERATOR,
            attendance_masterlist.SHIFT,
            attendance_masterlist.ATTENDANCE_STATUS,
            allocation_masterlist.PROCESS,
            allocation_masterlist.MACHINE_CODE,
            allocation_masterlist.IN_DATETIME,
            allocation_masterlist.IN_BY,
            allocation_masterlist.OUT_DATETIME,
            allocation_masterlist.OUT_BY,
            allocation_masterlist.REMARKS
        FROM
            attendance_masterlist
        LEFT JOIN allocation_masterlist ON attendance_masterlist.RID = allocation_masterlist.ATTENDANCE_ID
        WHERE
            DATE = '$date'
            ORDER BY RID DESC
        "; */
        $sql = "SELECT `RID`, `ATTENDANCE_ID`, `DATE`, `OPERATOR`, `PROCESS`, `MACHINE_CODE`, `IN_DATETIME`, `IN_BY`, `OUT_DATETIME`, `OUT_BY`, `REMARKS` FROM `allocation_masterlist` WHERE DATE = '$date' ORDER BY RID DESC";
        $result = mysqli_query($db,$sql);

        if(mysqli_num_rows($result) == 0){
            return [];
        } else {
            $records = [];
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $records[] = $row;
                }
            }

            return $records;
        }
    }

    public static function UpdateOutAllocation($records){
        $db = DB::connectionODAS();
        $userCode = $_SESSION['USER_CODE'];
        $allocationID = $records->allocationID;
        $remarks = $db->real_escape_string($records->remarks);

        date_default_timezone_set('Asia/Manila');
        $createdAt = date("Y-m-d H:i:s");

        $sql = "UPDATE
                `allocation_masterlist`
            SET
                `OUT_DATETIME` = '$createdAt',
                `OUT_BY` = '$userCode',
                `REMARKS` = '$remarks',
                `UPDATED_BY` = '$userCode'
            WHERE
                `RID` = $allocationID";
                
        return $db->query($sql);
    }

    public static function SelectOutAttendance($shift, $date){
        $db = DB::connectionODAS();

        if($shift == '1'){
            //DAY SHIFT
            $sql = "SELECT `RID`, `IN_DATETIME`, `IN_BY`, `OUT_DATETIME`, `OUT_BY` FROM `allocation_masterlist` WHERE IN_DATETIME < '$date 19:00:00' AND OUT_DATETIME IS NULL";
        } else if($shift == '2'){
            //NIGHT SHIFT
            $sql = "SELECT `RID`, `IN_DATETIME`, `IN_BY`, `OUT_DATETIME`, `OUT_BY` FROM `allocation_masterlist` WHERE IN_DATETIME < '$date 07:00:00' AND OUT_DATETIME IS NULL";
        }
        
        $result = $db->query($sql);

        $records = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                
                $records[] = $row;
            }
        }

        return $records;
    }

    public static function AutomaticOutAttendance($shift, $date){
        $db = DB::connectionODAS();

        date_default_timezone_set('Asia/Manila');
        $createdAt = date("Y-m-d H:i:s");

        if($shift == '1'){
            //DAY SHIFT
            $sql = "UPDATE
                `allocation_masterlist`
            SET
                `OUT_DATETIME` = '$createdAt',
                `OUT_BY` = '1',
                `UPDATED_BY` = '1'
            WHERE IN_DATETIME < '$date 19:00:00' AND OUT_DATETIME IS NULL";
        } else if($shift == '2'){
            //NIGHT SHIFT
            $sql = "UPDATE
                `allocation_masterlist`
            SET
                `OUT_DATETIME` = '$createdAt',
                `OUT_BY` = '1',
                `UPDATED_BY` = '1'
            WHERE IN_DATETIME < '$date 07:00:00' AND OUT_DATETIME IS NULL";
        }
                
        return $db->query($sql);

    }


    // ========================================================================= //


}

?>