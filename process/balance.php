<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $studentNo = $_POST['student_no'];

    include 'db_connection.php';
    $conn = OpenCon();

    $fieldArray = [];
    foreach ($_POST as $key => $value) {
        $fieldArray[] = $value;
    }
    $student_no = $fieldArray[0];
    $transaction_type = $fieldArray[4];
    $transaction_amount = preg_replace('/[^0-9.]/', '', $fieldArray[3]);


    $sql1 = "INSERT INTO balance_tbl(student_no, transaction_type, transaction_amount,balance) VALUES(?, ?, ?, ?)";
    $stmt1 = $conn->prepare($sql1);

    // Calculate the updated balance directly
    $sql2 = "SELECT balance FROM balance_tbl WHERE student_no = ? ORDER BY transaction_date DESC LIMIT 1";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param('s', $student_no);
    $stmt2->execute();
    $stmt2->bind_result($current_balance);

    if ($stmt2->fetch()) {
        $stmt2->close();

        // Check if balance is enough for the transaction if it is a deduction
        if ($transaction_type === 'withdrawal' && $current_balance < $transaction_amount) {
            http_response_code(401);
            echo json_encode(['error' => 'Insufficient balance for transaction']);
            exit;
        }

        // Calculate the new balance based on the transaction type
        $new_balance = $transaction_type === 'deposit'
            ? $current_balance + $transaction_amount
            : $current_balance - $transaction_amount;
    } else {
        // No previous balance found, start from zero
        if ($transaction_type === 'withdrawal' && $transaction_amount > 0) {
            http_response_code(401);
            echo json_encode(['error' => 'Insufficient balance for transaction']);
            exit;
        }

        $new_balance = $transaction_type === 'deposit' ? $transaction_amount : 0;
        $stmt2->close();
    }

    $stmt1->bind_param('ssdd', $student_no, $transaction_type, $transaction_amount, $new_balance);
    $stmt1->execute();
    $stmt1->close();

    echo json_encode(['success' => 'Balance updated successfully', 'new_balance' => $new_balance]);
}
