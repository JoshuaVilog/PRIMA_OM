<?php
require_once __DIR__ . '/../../config/db.php';

class ProcessModel{

    public static function DisplayRecords() {
        $db = DB::connectionODAS();
        $sql = "SELECT `RID`, `PROCESS_NAME`, `PROCESS_TYPE` FROM `process_list`";
        $result = $db->query($sql);
    
        $records = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $records[] = $row;
            }
        }
    
        return $records;
    }

    public static function DisplayProcessAndMachineRecords() {
        $db = DB::connectionODAS();
        $sql = "SELECT process_list.RID AS PROCESS_ID, process_list.PROCESS_NAME, machine_list.RID AS MACHINE_ID, machine_list.MACHINE_NAME FROM `process_list` LEFT JOIN `machine_list` ON process_list.RID = machine_list.MACHINE_TYPE";
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