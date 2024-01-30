<?php
include 'process/student_fill.php';
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

<body>
    <div class="wrapper">
        <main>
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
                        <button type="submit" id="<?php echo isset($type) ? "update" : "save"; ?>"><?php echo isset($type) ? "Update" : "Save"; ?></button>

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
                            // Fetch both result sets independently
                            $entries = $result2->fetch_all(MYSQLI_ASSOC);
                            $timeOuts = $result3->fetch_all(MYSQLI_ASSOC);

                            // Iterate over the entries and display each row
                            foreach ($entries as $index => $entry) {
                                echo "  <tr class='hovertable clickable-row'>
                                            <td>{$entry['student_no']}</td>
                                            <td>{$entry['entry_id']}</td>
                                            <td>{$entry['time_in']}</td>
                                            <td>{$timeOuts[$index]['time_out']}</td>
                                        </tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
        <!-- sidebar -->
        <div class=" sidebar">
            <div class="box">
                <img src="Images/circle.png" alt="" srcset="" id="Pic">
                <h2 style="font-size: 5rem;padding: 1rem 0;color:var(--primary); font-weight:bolder; font-style:italic">ADMIN</h2>
                <div class="menu">
                    <a class="button" href="student.php">ADD</a>
                    <a class="button" href="">EDIT</a>
                    <a class="button" href="">DELETE</a>
                    <a class="button" href="admin.php">REPORT</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>