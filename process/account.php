<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $fieldArray = [];
    foreach ($_POST as $key => $value) {
        $fieldArray[] = $value;
    }
    // echo json_encode($fieldArray);
    $username = $fieldArray[0];
    $password = $fieldArray[1];

    include 'db_connection.php';

    $conn = OpenCon();
    $sql1 = "INSERT INTO account_tbl(username, password) VALUES(?, ?)";
    $stmt = $conn->prepare($sql1);
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $stmt->close();
    CloseCon($conn);

    echo json_encode([
        'ok' => 1,
    ]);    
}
