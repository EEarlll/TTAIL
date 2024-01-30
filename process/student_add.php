<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Assuming that 'student_no' is the unique identifier for avoiding duplicates
    $studentNo = $_POST['student_no'];

    // Validate if the student number already exists
    include 'db_connection.php';
    $conn = OpenCon();

    $sqlCheckDuplicate = "SELECT COUNT(*) as count FROM info_tbl WHERE student_no = ?";
    $stmt = $conn->prepare($sqlCheckDuplicate);
    $stmt->bind_param('s', $studentNo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $row = $result->fetch_assoc();
        $count = $row['count'];

        if ($count > 0) {
            // Duplicate entry found
            echo json_encode([
                'error' => 'Duplicate entry for student number',
            ]);
            $stmt->close();
            CloseCon($conn);
            exit;
        }
    } else {
        // Handle the query error as needed
        echo json_encode([
            'error' => 'Database error',
        ]);
        $stmt->close();
        CloseCon($conn);
        exit;
    }

    $stmt->close();

    // Continue with the insertion if no duplicates found
    $fieldArray = [];
    foreach ($_POST as $key => $value) {
        $fieldArray[] = $value;
    }

    // Rest of your code for file handling
    $picpath = "";
    if ($fieldArray[4]) {
        $picpath = "../" . $fieldArray[4];
    }

    if (file_exists($picpath)) {
        $pic_filename = explode('temp/', $picpath)[1];
        rename($picpath, '../uploads/' . $pic_filename);
        $picpath = 'uploads/' . $pic_filename;
    }

    $sql1 = "INSERT INTO info_tbl(student_no, Section, Name, Contact_Number, pic_path) VALUES(?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql1);

    // Bind parameters
    $stmt->bind_param('sssss', $fieldArray[0], $fieldArray[1], $fieldArray[2], $fieldArray[3], $picpath);

    // Execute the statement
    $stmt->execute();
    $stmt->close();

    CloseCon($conn);

    echo json_encode([
        'ok' => 1,
    ]);
}
