<?php
require_once __DIR__ . '/../../config/db.php';

class PurposeModel {
    
    public static function DisplayRecords() {
        $db = DB::connectionODAS();
        $sql = "SELECT * FROM purpose_list WHERE COALESCE(DELETED_AT, '') = '' ORDER BY RID DESC";
        $result = $db->query($sql);

        $records = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $records[] = $row;
            }
        }

        return $records;
    }

    public static function GetRecord($id){
        $db = DB::connectionODAS();

        $sql = "SELECT * FROM purpose_list WHERE RID = $id";
        $result = mysqli_query($db,$sql);

        if(mysqli_num_rows($result) == 0){
            return null;
        } else {
            $row = mysqli_fetch_assoc($result);

            return $row;
        }
    }

    public static function CheckDuplicate($desc){
        $db = DB::connectionODAS();

        $sql = "SELECT RID FROM purpose_list WHERE CONCAT(PURPOSE_DESC, COALESCE(DELETED_AT, '')) = '$desc' ";
        $result = mysqli_query($db,$sql);

        if(mysqli_num_rows($result) == 0){
            return false;
        } else {
            return true;
        }
    }

    public static function InsertRecord($records){
        $db = DB::connectionODAS();
        $userCode = $_SESSION['USER_CODE'];

        $desc = $db->real_escape_string($records->desc);

        $sql = "INSERT INTO `purpose_list`(
            `RID`,
            `PURPOSE_DESC`
        )
        VALUES(
            DEFAULT,
            '$desc'
        )";
        return $db->query($sql);
    }
    public static function UpdateRecord($records){
        $db = DB::connectionODAS();
        $userCode = $_SESSION['USER_CODE'];

        $desc = $db->real_escape_string($records->desc);
        $id = $records->id;

        $sql = "UPDATE
            `purpose_list`
        SET
            `PURPOSE_DESC` = '$desc'
        WHERE
            `RID` = $id";
        return $db->query($sql);
    }
    public static function RemoveRecord($id){
        $db = DB::connectionODAS();
        $userCode = $_SESSION['USER_CODE'];

        date_default_timezone_set('Asia/Manila');
        $createdAt = date("Y-m-d H:i:s");

        $sql = "UPDATE
            `purpose_list`
        SET
            `DELETED_AT` = '$createdAt'
        WHERE
            `RID` = $id";
        
        return $db->query($sql);


    }


}

?>