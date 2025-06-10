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
}

?>