<?php
require_once __DIR__ . '/../../config/db.php';


class MachineModel {

    public static function DisplayRecords() {
        $db = DB::connectionODAS();
        $sql = "SELECT `RID`, `MACHINE_NAME`, `MACHINE_TYPE` FROM `machine_list`";
        $result = $db->query($sql);

        $records = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $records[] = $row;
            }
        }

        return $records;
    }

    public static function CheckMachineLogs($machine, $user){
        $db = DB::connectionODAS();

        $find = $machine."-".$user;
        // $sql = "SELECT RID FROM machine_log_history WHERE MACHINE_CODE = '$machine' AND IN_BY = '$user' AND OUT_BY IS NULL";
        $sql = "SELECT RID, PURPOSE, REMARKS FROM machine_log_history WHERE CONCAT(MACHINE_CODE, '-', IN_BY, COALESCE(OUT_BY, ''))  = '$find'";
        $result = mysqli_query($db,$sql);

        $rid = 0;

        if(mysqli_num_rows($result) != 0){
            // IN
            $row = mysqli_fetch_assoc($result);

            // $rid = $row['RID'];
            $rid = $row;
        } else {
            
        }

        return $rid;
    }

    public static function CheckDuplicate($records){
        $db = DB::connectionODAS();

        $machine = $db->real_escape_string($records->machine);
        $user = $db->real_escape_string($records->user);

        $find = $machine."-".$user;
        $sql = "SELECT RID FROM `machine_log_history` WHERE CONCAT(MACHINE_CODE, '-', IN_BY, COALESCE(OUT_BY, ''))  = '$find'";
        $result = mysqli_query($db,$sql);

        if(mysqli_num_rows($result) != 0){
            // DUPLICATE
            return true;
        } else {
            return false;
        }


    }

    public static function InsertMachineLogHistory($records){
        $db = DB::connectionODAS();
        // $userCode = $_SESSION['USER_CODE'];

        $machine = $db->real_escape_string($records->machine);
        $user = $db->real_escape_string($records->user);
        $purpose = $db->real_escape_string($records->purpose);
        $remarks = $db->real_escape_string($records->remarks);

        date_default_timezone_set('Asia/Manila');
        $createdAt = date("Y-m-d H:i:s");

        $sql = "INSERT INTO `machine_log_history`(
            `RID`,
            `MACHINE_CODE`,
            `IN_DATETIME`,
            `IN_BY`,
            `PURPOSE`,
            `REMARKS`
        )
        VALUES(
            DEFAULT,
            '$machine',
            '$createdAt',
            '$user',
            '$purpose',
            '$remarks'
        )";
        return $db->query($sql);
    }

    public static function UpdateMachineLogHistory($records){
        $db = DB::connectionODAS();
        $user = $db->real_escape_string($records->user);
        $rid = $db->real_escape_string($records->rid);
        $remarks = $db->real_escape_string($records->remarks);

        date_default_timezone_set('Asia/Manila');
        $createdAt = date("Y-m-d H:i:s");

        $sql = "UPDATE
            `machine_log_history`
        SET
            `OUT_DATETIME` = '$createdAt',
            `OUT_BY` = '$user',
            `REMARKS` = '$remarks'
        WHERE
            `RID` = $rid";
        return $db->query($sql);
    }

    public static function DisplayMachineLogsRecords() {
        $db = DB::connectionODAS();
        $sql = "SELECT `RID`, `MACHINE_CODE`, `IN_DATETIME`, `IN_BY`, `OUT_DATETIME`, `OUT_BY`, `DURATION`, `PURPOSE`, `CREATED_AT`, `UPDATED_AT`, `REALTIME_ACTION` FROM `machine_log_history` ORDER BY RID DESC";
        $result = $db->query($sql);

        $records = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $records[] = $row;
            }
        }

        return $records;
    }
    public static function DisplayMachineLogsRecordsByDate($startDate, $endDate) {
        $db = DB::connectionODAS();
        $sql = "SELECT `RID`, `MACHINE_CODE`, `IN_DATETIME`, `IN_BY`, `OUT_DATETIME`, `OUT_BY`, `DURATION`, `PURPOSE`, `CREATED_AT`, `UPDATED_AT`, `REALTIME_ACTION` FROM `machine_log_history` WHERE CREATED_AT BETWEEN '$startDate 00:00:00' AND '$endDate 23:59:00' ORDER BY RID DESC";
        $result = $db->query($sql);

        $records = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $records[] = $row;
            }
        }

        return $records;
    }
    public static function DisplayMachineLogsRecordsByUser($user) {
        $db = DB::connectionODAS();
        $sql = "SELECT `RID`, `MACHINE_CODE`, `IN_DATETIME`, `IN_BY`, `OUT_DATETIME`, `OUT_BY`, `DURATION`, `PURPOSE`, `CREATED_AT`, `UPDATED_AT`, `REALTIME_ACTION` FROM `machine_log_history` WHERE IN_BY = '$user' ORDER BY RID DESC";
        $result = $db->query($sql);

        $records = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $records[] = $row;
            }
        }

        return $records;
    }
}


?>