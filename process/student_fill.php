<?php
$student_no = '';
$Section = '';
$Name = '';
$Contact_Number = '';
$pic_path = '';
$result2;

if (isset($_GET['id'])) {
    include 'process/db_connection.php';
    $conn = OpenCon();
    $id = $_GET['id'];
    $sql = "SELECT * FROM `info_tbl` WHERE student_no = '$id';";
    $result = mysqli_fetch_assoc($conn->query($sql));
    $student_no = $result['student_no'];
    $Section = $result['Section'];
    $Name = $result['Name'];
    $Contact_Number = $result['Contact_Number'];
    $pic_path = $result['pic_path'];
    $type = 'Update';

    $sql2 = "SELECT * FROM time_in_tbl WHERE student_no ='$id'";
    $sql3 = "SELECT * FROM time_out_tbl WHERE student_no ='$id'";
    $result2 = $conn->query($sql2);
    $result3 = $conn->query($sql3);
}
