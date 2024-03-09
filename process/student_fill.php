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

    $sql = "SELECT 
                DATE_FORMAT(time_in_tbl.time_in, '%Y-%m-%d') AS day,
                TIME_FORMAT(time_in_tbl.time_in, '%h:%i %p') AS time_in,
                TIME_FORMAT(time_out_tbl.time_out, '%h:%i %p') AS time_out
            FROM 
                time_in_tbl 
            LEFT JOIN 
                time_out_tbl ON DATE_FORMAT(time_in_tbl.time_in, '%Y-%m-%d') = DATE_FORMAT(time_out_tbl.time_out, '%Y-%m-%d')
            WHERE 
                time_in_tbl.student_no = '$id'
            ORDER BY 
                time_in_tbl.time_in DESC";
                
    $result1 = $conn->query($sql);
}
