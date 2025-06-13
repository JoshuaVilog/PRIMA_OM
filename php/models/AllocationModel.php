<?php
require_once __DIR__ . '/../../config/db.php';


class AllocationModel {

    public static function AllocationRecords($date) {
        $db = DB::connectionODAS();
        $sql = "SELECT `RID`, `OPERATOR`, `SHIFT`, `ATTENDANCE_STATUS` FROM 1_odas.attendance_masterlist WHERE DATE = '$date'";
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
        $operator = $db->real_escape_string($records->operator);
        $process = $db->real_escape_string($records->process);
        $machine = $db->real_escape_string($records->machine);
        $remarks = $db->real_escape_string($records->remarks);

        date_default_timezone_set('Asia/Manila');
        $createdAt = date("Y-m-d H:i:s");

        $sql = "INSERT INTO `allocation_masterlist`(
            `RID`,
            `ATTENDANCE_ID`,
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

}

?>