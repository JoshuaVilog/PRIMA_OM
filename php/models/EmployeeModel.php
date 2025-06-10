<?php
require_once __DIR__ . '/../../config/db.php';


class EmployeeModel {

    public static function CheckAccount($username, $password){
        $db = DB::connectionHRIS();

        //$password = md5($password);

        $sql = "SELECT EMPLOYEE_ID, EMPLOYEE_NAME, RFID, PASSWORD, ACTIVE, ROLE FROM 1_employee_masterlist_tb WHERE RFID = '$username'";
        $result = mysqli_query($db,$sql);

        if(mysqli_num_rows($result) == 0){
            return null;
        } else {
            $row = mysqli_fetch_assoc($result);

            if (password_verify($password, $row['PASSWORD'])) {
                return $row;
            } else {
                echo null;
            }
        }
    }
    public static function DisplayOperatorRecords() {
        $db = DB::connectionHRIS();
        $sql = "SELECT EMPLOYEE_ID, RFID, EMPLOYEE_NAME, F_NAME, L_NAME, M_NAME, DEPARTMENT_ID, JOB_POSITION_ID FROM 1_hris.1_employee_masterlist_tb WHERE DEPARTMENT_ID = 8 AND JOB_POSITION_ID = 63  AND DELETED_STATUS = '0'";
        $result = $db->query($sql);

        $records = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $records[] = $row;
            }
        }

        return $records;
    }
    public static function DisplayEmployeeRecords() {
        $db = DB::connectionHRIS();
        $sql = "SELECT EMPLOYEE_ID, RFID, EMPLOYEE_NAME, F_NAME, L_NAME, M_NAME, ACTIVE FROM 1_hris.1_employee_masterlist_tb WHERE DELETED_STATUS = '0'";
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