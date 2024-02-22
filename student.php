<?php
include 'process/student_fill.php';
include 'process/session_check.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/student.css">
    <link rel="stylesheet" href="css/table2.css">
    <script type="module" src="js/student_add.js"></script>
</head>

<body style="overflow-y: hidden;">
    <div class="wrapper">
        <main >
            <div class="main">
                <div class="box">
                    <div class="inner-box">
                        <img src="<?php echo isset($pic_path) && $pic_path != '' ? "$pic_path" : "Images/circle.png"; ?>" alt="" id='Pic2'>
                    </div>
                    <form action="" method="post" id="pic-upload">
                        <input class="input-file" type="file" accept="image/x-png,image/gif,image/jpeg" id="uploadfile" name="uploadfile"></td>
                    </form>
                </div>
                <div class="card">
                    <h2>Student Profile</h2>
                    <form class="card-body" id="form-student" method="post">
                        <table>
                            <tbody>
                                <tr>
                                    <td>Student No.</td>
                                    <td>: </td>
                                    <td>
                                        <input class="input-design form-control" type="text" <?php if (isset($type)) { ?> disabled <?php } ?> required name="student_no" id="student_no" value="<?php echo $student_no; ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Section</td>
                                    <td>: </td>
                                    <td><input class="input-design form-control" type="text" required name="Section" id="Section" value="<?php echo $Section; ?>"></td>
                                </tr>
                                <tr>
                                    <td>Name</td>
                                    <td>:</td>
                                    <td><input class="input-design form-control" type="text" required name="Name" id="Name" value="<?php echo $Name; ?>"></td>
                                </tr>
                                <tr>
                                    <td>Contact</td>
                                    <td>:</td>
                                    <td><input class="input-design form-control" type="text" name="Contact_Number" id="Contact_Number" value="<?php echo $Contact_Number; ?>"></td>
                                </tr>
                                <tr>
                                    <td>Pic Path</td>
                                    <td>:</td>
                                    <td><input class="input-design form-control" type="text" disabled name="pic_path" id="pic_path" value="<?php echo $pic_path; ?>"></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="buttons-container">
                            <button type="submit" id="<?php echo isset($type) ? "update" : "save"; ?>"><?php echo isset($type) ? "Update" : "Save"; ?></button>

                            <div class="download-container">
                                <button type="button" id="download">Download</button>
                                <svg id='prevMonth' viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" transform="matrix(-1, 0, 0, 1, 0, 0)" width=25>
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M10 7L15 12L10 17" stroke="#1450a3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </g>
                                </svg>
                                <span id='currentMonth' style="font-size: large;" class="form-control" name='currentMonth'>January</span>
                                <svg id='nextMonth' viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" width=25>
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M10 7L15 12L10 17" stroke="#1450a3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="top">
            </div>
            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr style="background-color: antiquewhite;">
                            <th>STUDENT NO.</th>
                            <th>ENTRY ID</th>
                            <th>TIME IN</th>
                            <th>TIME OUT</th>
                        </tr>
                    </thead>
                    <tbody style="color:white" id="myTable">
                        <?php
                        if (isset($result2) && isset($result3)) {
                            $entries = $result2->fetch_all(MYSQLI_ASSOC);
                            $timeOuts = $result3->fetch_all(MYSQLI_ASSOC);

                            foreach ($entries as $index => $entry) {
                                echo "  <tr class='hovertable clickable-row'>
                                            <td>{$entry['student_no']}</td>
                                            <td>{$entry['entry_id']}</td>
                                            <td>{$entry['time_in']}</td>";

                                if (isset($timeOuts[$index]['time_out'])) {
                                    echo "<td>{$timeOuts[$index]['time_out']}</td>";
                                } else {
                                    echo "<td></td>";
                                }
                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
        <!-- sidebar -->
        <div class="sidebar">
            <div class="box">
                <img src="Images/circle.png" alt="" srcset="" id="Pic">
                <h2 style="font-size: 2rem;padding: 1rem 0;color:var(--primary); font-weight:bolder; font-style:italic">ADMIN</h2>
                <div class="menu">
                    <a class="button" href="student.php">ADD</a>
                    <a class="button" href="">EDIT</a>
                    <a class="button" href="" id="delete">DELETE</a>
                    <a class="button" href="admin.php">REPORT</a>
                    <a class="button" href="register.php">REGISTER</a>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const monthNames = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];
        let currentMonthIndex = new Date().getMonth();

        // DOM elements
        const prevMonthSvg = document.getElementById("prevMonth");
        const nextMonthSvg = document.getElementById("nextMonth");
        const currentMonthSpan = document.getElementById("currentMonth");

        function updateMonthDisplay() {
            const selectedMonthName = monthNames[currentMonthIndex];
            currentMonthSpan.textContent = selectedMonthName;
            currentMonthSpan.value = selectedMonthName;
        }

        prevMonthSvg.addEventListener("click", function() {
            if (currentMonthIndex > 0) {
                currentMonthIndex--;
            } else {
                currentMonthIndex = 11; // December
            }
            updateMonthDisplay();
        });

        nextMonthSvg.addEventListener("click", function() {
            if (currentMonthIndex < 11) {
                currentMonthIndex++;
            } else {
                currentMonthIndex = 0; // January
            }
            updateMonthDisplay();
        });

        // delete
        document.getElementById("delete").addEventListener("click", function(e) {
            e.preventDefault();
            var selectedId = document.getElementById("student_no").value

            if (selectedId) {
                // Ask for confirmation
                var confirmed = window.confirm("Are you sure you want to delete this record?");

                if (confirmed) {
                    var formData = new URLSearchParams();
                    formData.append("student_no", selectedId);

                    console.log(formData);
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "process/student_delete.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            var result = JSON.parse(xhr.responseText);
                            if (result.ok) {
                                alert("Data successfully Deleted!");
                                window.location.href = "admin.php";
                            }
                        }
                    };
                    xhr.send(formData.toString());
                }
            } else {
                console.error("No row selected.");
            }
        });

        updateMonthDisplay();

    })
</script>

</html>