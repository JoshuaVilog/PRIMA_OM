<?php
session_start();
header("Access-Control-Allow-Origin: *");

class DB {
    private static $conn;

    public static function connectionODAS() {
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $database = "1_om";

        if (!self::$conn) {
            self::$conn = new mysqli($hostname, $username, $password, $database);

            if (self::$conn->connect_error) {
                die("Connection failed: " . self::$conn->connect_error);
            }
        }
        return self::$conn;
    }
    public static function connectionHRIS() {
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $database = "1_hris";

        if (!self::$conn) {
            self::$conn = new mysqli($hostname, $username, $password, $database);

            if (self::$conn->connect_error) {
                die("Connection failed: " . self::$conn->connect_error);
            }
        }
        return self::$conn;
    }
}
?>