<?php
$student_no = '';
$Name = '';
$Balance = '';
$result2;
$cash_given = '';

if (isset($_GET['id'])) {
    include 'process/db_connection.php';
    $conn = OpenCon();
    $id = $_GET['id'];

    $sql = "
        SELECT info_tbl.student_no, info_tbl.Name, balance_tbl.balance
        FROM info_tbl
        LEFT JOIN (
            SELECT student_no, balance
            FROM balance_tbl
            WHERE student_no = ?
            ORDER BY transaction_date DESC
            LIMIT 1
        ) AS balance_tbl ON info_tbl.student_no = balance_tbl.student_no
        WHERE info_tbl.student_no = ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $id, $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $student_no = $row['student_no'];
        $Name = $row['Name'];
        $Balance = $row['balance'];
    }

    $sql = "
    SELECT 
        DATE_FORMAT(transaction_date, '%Y-%m-%d') AS day,
        transaction_type,
        transaction_amount,
        balance
    FROM 
        balance_tbl
    WHERE 
        student_no = ?
    ORDER BY 
        transaction_date DESC
";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $result1 = $stmt->get_result();
}
