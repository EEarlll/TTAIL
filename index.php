<?php
require 'process/email.php';
include 'process/db_connection.php';
date_default_timezone_set('Asia/Singapore');
Session_start();
Session_destroy();

$student_no = '';
$Section = '';
$Name = '';
$Contact_Number = '';
$pic_path = '';
$time_type = '1';

function fast_request($url)
{
    $parts=parse_url($url);
    $fp = fsockopen($parts['host'],isset($parts['port'])?$parts['port']:80,$errno, $errstr, 30);
    $out = "GET ".$parts['path']." HTTP/1.1\r\n";
    $out.= "Host: ".$parts['host']."\r\n";
    $out.= "Content-Length: 0"."\r\n";
    $out.= "Connection: Close\r\n\r\n";

    fwrite($fp, $out);
    fclose($fp);
}

if (isset($_GET['id'])) {

    $conn = OpenCon();

    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $time_type = $_GET['time'];
    $sql = "SELECT * FROM `info_tbl` WHERE student_no = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $sqlCheck = "SELECT 
                EXISTS (SELECT 1 FROM time_in_tbl WHERE student_no = ? AND DATE(time_in) = CURDATE()) AS time_in_exists,
                EXISTS (SELECT 1 FROM time_out_tbl WHERE student_no = ? AND DATE(time_out) = CURDATE()) AS time_out_exists";

    $stmtCombined = $conn->prepare($sqlCheck);
    $stmtCombined->bind_param("ss", $id, $id);
    $stmtCombined->execute();
    $resultCombined = $stmtCombined->get_result();
    $resultCheck = $resultCombined->fetch_assoc();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $student_no = $row['student_no'];
        $Section = $row['Section'];
        $Name = $row['Name'];
        $Contact_Number = $row['Contact_Number'];
        $pic_path = $row['pic_path'];
        $currentTime = date("Y/m/d h:i A");
        $type = "Update";

        $message = $time_type == 1 ? "Name: " . $Name .  "\nTime in: " . $currentTime : "Name: " . $Name .  "\nTime Out: " . $currentTime;
        $url = 'http://localhost:3000/sendSMS/' . $Contact_Number . '/' . urlencode($message);
        fast_request($url);
        // sendMail("earleustacio@gmail.com", "Student Name: $Name", "Time In: $currentTime");     // STC email
        if ($time_type == '1' && !$resultCheck['time_in_exists']) {
            $sql2 = "INSERT INTO time_in_tbl(student_no,time_in) VALUES(?, ?)";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("ss", $student_no, $currentTime);
            $stmt2->execute();
        } elseif ($time_type == '3' && !$resultCheck['time_out_exists']) {
            $sql2 = "INSERT INTO time_out_tbl(student_no,time_out) VALUES(?, ?)";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("ss", $student_no, $currentTime);
            $stmt2->execute();
        }
    }
    $stmt->close();
    CloseCon($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <header>
        <div class="logo">
            <img src="Images2/LOGO.png" alt="" srcset="" style="width: 77%; padding-left: 1rem;">
        </div>
        <div class="time_preview">
            <p><?php echo date("Y/m/d") ?></p>
            <p><?php echo date("h:i A") ?></p>
        </div>
    </header>

    <form class="main-info" method="post">
        <div class="box">
            <img src="<?php echo isset($pic_path) && $pic_path != '' ? "$pic_path" : ""; ?>" alt="" id="Pic">
        </div>
        <div class="infos">
            <div class="upper-text">
                <p><?php echo (!empty($Name) ? $Name : 'First Name M. Last Name'); ?></p>
                <p>Name</p>
                <p><?php echo (!empty($Section) ? $Section : 'Grade & Section'); ?></p>
            </div>
            <div class="lower-text">
                <p id='time_type1'>Press F8 - TIME IN</p>
                <p id="time_type3">Press F9 - TIME OUT</p>
            </div>
        </div>
        <form class="box" method="post">
            <img src="Images/logo.png" alt="" srcset="" style="width: 100%; height: auto; max-width:700px; padding-bottom: 2rem;">
            <div>
                <h1><?php echo (!empty($Name) ? $Name : 'First M. Last'); ?></h1>
                <p>NAME</h2>
                <h1><?php echo (!empty($Section) ? $Section : 'Grade & Section'); ?></h1>
                <p>GRADE & SECTION</h2>
                <div style="margin-top: 1rem;">
                    <h6><?php if ($time_type == '1') {
                            echo "Time In";
                        } elseif ($time_type == '3') {
                            echo "Time Out";
                        } ?></h6>
                    <h6><?php echo date("Y/m/d h:i A"); ?></h6>
                </div>

                <input type="button" name="student_no" value="<?php echo $student_no; ?>" style="display: none;">
                <input type="button" name="time_in" value="<?php echo date('Y-m-d H:i:s'); ?>" style="display: none;">
                <input type="button" name="time_out" value="<?php echo date('Y-m-d H:i:s'); ?>" style="display: none;">
            </div>
        </div>
    </footer>

</body>
<script>
    var curr_time = localStorage.getItem('curr_time') || 1;

    function checkInput(event) {
        // Get the input element by its ID
        var inputElement = document.getElementById('selectedId');

        // Check if the entered value is [ or ]
        if (event.target.value.includes('[') || event.target.value.includes(']')) {
            // Clear the input if [ or ] is entered
            inputElement.value = '';
        }
    }


    function handleKeyGlobal(event) {
        if (event.key === 'F8' || event.key === 'F9') {
            document.getElementById('selectedId').value = ''
            // Set the global variable based on the pressed key
            curr_time = event.key === 'F8' ? 1 : event.key === 'F9' ? 3 : curr_time;
            if (curr_time === 1) {
                document.getElementById('time_type3').classList.remove('selectedType');
                document.getElementById('time_type1').classList.add('selectedType');
            } else if (curr_time === 3) {
                document.getElementById('time_type1').classList.remove('selectedType');
                document.getElementById('time_type3').classList.add('selectedType');
            }
            localStorage.setItem('curr_time', curr_time);
            console.log('Updated curr_time:', curr_time);
        }
        if (event.key === '/') {
            window.location.href = "login.php"
        }
    }

    function handleKeyPress(event) {
        // Get the user input
        if (event.key == "Enter") {
            var userInput = document.getElementById("selectedId").value;
            console.log(userInput);

            // Modify the URL
            var newUrl = "index2.php?id=" + userInput + "&time=" + curr_time;
            window.location.href = newUrl;

            console.log("Updated URL:", newUrl);
            event.preventDefault();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.addEventListener('keydown', handleKeyGlobal);
        window.onload = function() {
            document.getElementById('selectedId').focus();
        }
    });
</script>

</html>