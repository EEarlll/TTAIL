<?php
include 'process/db_connection.php';
$conn = OpenCon();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user = $_POST['user'];
    $pass = $_POST['password'];
    $sql = "SELECT COUNT(*) AS count FROM account_tbl WHERE username = '$user' AND password = '$pass'";
    $result = mysqli_fetch_assoc($conn->query($sql));

    if ($result['count'] > 0 && $user != "" && $pass != "") {
        $sql = "SELECT * FROM account_tbl WHERE username = '$user' AND password = '$pass';";
        $result = mysqli_fetch_assoc($conn->query($sql));
        $loginSucess = true;
        session_start();
        $_SESSION['username'] = $result['username'];
        $_SESSION['employee_id'] = $result['id'];
        header("Refresh:0; url=admin.php");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div class="ring">
        <form class="login" method="post">
            <h2>Login</h2>
            <img src="Images/logo2.png" alt="" width="100px">
            <div class="inputBx">
                <input type="text" placeholder="Username" name="user">
            </div>
            <div class="inputBx">
                <input type="password" placeholder="Password" name="password">
            </div>
            <div class="inputBx">
                <input type="submit" value="Sign in">
            </div>
        </form>
    </div>
</body>

</html>