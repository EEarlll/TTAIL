<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fieldArray = [];
    foreach ($_POST as $key => $value) {
        $fieldArray[] = $value;
    }
    // echo json_encode($fieldArray);
    $picpath = $fieldArray[4];

    if (str_starts_with($picpath, "temp/")) {
        $pic_filename = explode('temp/', $picpath)[1];
        rename('../' . $picpath, '../uploads/' . $pic_filename);
        $picpath = 'uploads/' . $pic_filename;
    }

    include 'db_connection.php';

    $conn = OpenCon();
    $sql = "UPDATE info_tbl 
    SET 
        Section = ?,
        Name = ?,
        Contact_Number = ?,
        pic_path = ?
    WHERE 
        student_no = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $fieldArray[1], $fieldArray[2], $fieldArray[3], $picpath, $fieldArray[0]);
    $stmt->execute();

    CloseCon($conn);
    echo json_encode([
        'ok' => 1,
    ]);
}
