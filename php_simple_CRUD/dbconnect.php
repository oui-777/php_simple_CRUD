<?php
// 1. connect to mysql database
$host = "localhost: 3307";
$user = "root";       // Username เริ่มต้นของ XAMPP
$password = "";       // Password เริ่มต้นของ XAMPP คือค่าว่าง
$database = "userDB"; // ชื่อฐานข้อมูลที่เราสร้างไว้

$conn = mysqli_connect($host, $user, $password, $database);

// เช็คว่าเชื่อมต่อสำเร็จหรือไม่
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>