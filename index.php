<?php
require 'process/email.php';

$student_no = '';
$Section = '';
$Name = '';
$Contact_Number = '';
$pic_path = '';
$time_type = '1';

if (isset($_GET['id'])) {
    include 'process/db_connection.php';
    $conn = OpenCon();

    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $time_type = $_GET['time'];
    $sql = "SELECT * FROM `info_tbl` WHERE student_no = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $student_no = $row['student_no'];
        $Section = $row['Section'];
        $Name = $row['Name'];
        $Contact_Number = $row['Contact_Number'];
        $pic_path = $row['pic_path'];
        $currentTime = date("Y-m-d H:i:s");
        $type = "Update";

        if ($time_type == '1') {
            $sql2 = "INSERT INTO time_in_tbl(student_no) VALUES(?)";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("s", $student_no);
            $stmt2->execute();
            sendMail("earleustacio@gmail.com", "Student Name: $Name", "Time In: $currentTime");     // STC email
        } elseif ($time_type == '3') {
            $sql2 = "INSERT INTO time_out_tbl(student_no) VALUES(?)";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("s", $student_no);
            $stmt2->execute();
            sendMail("earleustacio@gmail.com", "Student Name: $Name", "Time Out: $currentTime");    // STC email
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
    <title>TTAIL</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container">
        <div class="box">
            <div class="inner-box">
                <img src="<?php echo isset($pic_path) && $pic_path != '' ? "$pic_path" : "Images/circle.png"; ?>" alt="" id='Pic'>
            </div>
            <form id="urlChangeForm">
                <input type="text" id="selectedId" onkeydown="handleKeyPress(event)">
            </form>
        </div>
        <form class="box" method="post">
            <img src="Images/logo.png" alt="" srcset="" style="width: 100%; height: auto; max-width:700px; padding-bottom: 2rem;">
            <div>
                <h1><?php echo (!empty($Name) ? $Name : 'First M. Last'); ?></h1>
                <p>NAME</h2>
                <h1><?php echo (!empty($Section) ? $Section : 'Grade & Section'); ?></h1>
                <p>GRADE & SECTION</h2>
                    <input type="button" name="student_no" value="<?php echo $student_no; ?>" style="display: none;">
                    <input type="button" name="time_in" value="<?php echo date('Y-m-d H:i:s'); ?>" style="display: none;">
                    <input type="button" name="time_out" value="<?php echo date('Y-m-d H:i:s'); ?>" style="display: none;">
            </div>
        </form>
    </div>
    <footer>
        <?php
            if($time_type == '1'){
                echo "
                <p id='time_type1' class ='selectedType'>PRESS [ - TIME IN</p>
                <p id='time_type3'>PRESS ] - TIME OUT</p>
                ";
            }else{
                echo "
                <p id='time_type1'>PRESS [ - TIME IN</p>
                <p id='time_type3' class ='selectedType'>PRESS ] - TIME OUT</p>
                ";
            }
        ?>

    </footer>
</body>
<script>
    var curr_time = localStorage.getItem('curr_time') || 1;

    function handleKeyGlobal(event) {
        if (event.key === '[' || event.key === ']') {
            // Set the global variable based on the pressed key
            curr_time = event.key === '[' ? 1 : event.key === ']' ? 3 : curr_time;
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
            window.location.href = "admin.php"
        }
    }

    function handleKeyPress(event) {
        // Get the user input
        if (event.key == "Enter") {
            var userInput = document.getElementById("selectedId").value;
            console.log(userInput);

            // Modify the URL
            var newUrl = "index.php?id=" + userInput + "&time=" + curr_time;
            window.location.href = newUrl;

            console.log("Updated URL:", newUrl);
            event.preventDefault();
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        document.addEventListener('keydown', handleKeyGlobal);
    });
</script>


</html>