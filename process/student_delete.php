<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    $fieldArray = [];
    foreach ($_POST as $key => $value) {
        $fieldArray[] = $value;
    }
    //echo json_encode($fieldArray);
    include 'db_connection.php';

    $conn = OpenCon();
    $sql = "DELETE FROM info_tbl WHERE student_no = '$fieldArray[0]'";

    $conn->query($sql);
    CloseCon($conn);
    echo json_encode([
        'ok' => 1,
    ]);
}
