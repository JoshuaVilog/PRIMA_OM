<?php
require_once __DIR__ . '/../../config/db.php';

class RecordModel {
    
    public static function DisplayRecords() {
        $db = DB::connectionODAS();
        $sql = "SELECT * FROM purpose_list";
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



}

?>