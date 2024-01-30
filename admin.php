<?php
include 'process/db_connection.php';

$conn = OpenCon();
$sql = "SELECT * FROM info_tbl ";
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_name = isset($_POST['search']) ? trim($_POST['search']) : '';

    if (!empty($item_name)) {
        $sql = "SELECT * FROM info_tbl WHERE Name LIKE ? LIMIT 10000";
        $stmt = $conn->prepare($sql);
        $param = "%{$item_name}%";
        $stmt->bind_param("s", $param);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    } else {
        $sql = "SELECT * FROM info_tbl LIMIT 10000";
        $result = $conn->query($sql);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TTAIL</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/table.css">

</head>

<body>
    <div class="wrapper">
        <main>
            <form action="" method="post">
                <div style="display: flex;">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" width='50' id='backIcon' style="cursor: pointer;">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M8.60112 16.5308C8.89426 16.8234 9.36913 16.823 9.66178 16.5299C9.95442 16.2367 9.95402 15.7619 9.66088 15.4692L8.60112 16.5308ZM5.52988 11.3452C5.23674 11.0526 4.76187 11.053 4.46922 11.3461C4.17658 11.6393 4.17698 12.1141 4.47012 12.4068L5.52988 11.3452ZM4.48682 11.3291C4.18475 11.6125 4.16964 12.0871 4.45306 12.3892C4.73648 12.6912 5.21111 12.7064 5.51318 12.4229L4.48682 11.3291ZM9.64418 8.54694C9.94625 8.26352 9.96136 7.78889 9.67794 7.48682C9.39452 7.18475 8.91989 7.16964 8.61782 7.45306L9.64418 8.54694ZM5 11.126C4.58579 11.126 4.25 11.4618 4.25 11.876C4.25 12.2902 4.58579 12.626 5 12.626V11.126ZM15.37 11.876L15.3723 11.126H15.37V11.876ZM17.9326 10.8234L18.4614 11.3553V11.3553L17.9326 10.8234ZM19.75 8.26907C19.7511 7.85486 19.4163 7.51815 19.0021 7.517C18.5879 7.51586 18.2511 7.85072 18.25 8.26493L19.75 8.26907ZM9.66088 15.4692L5.52988 11.3452L4.47012 12.4068L8.60112 16.5308L9.66088 15.4692ZM5.51318 12.4229L9.64418 8.54694L8.61782 7.45306L4.48682 11.3291L5.51318 12.4229ZM5 12.626H15.37V11.126H5V12.626ZM15.3677 12.626C16.5267 12.6295 17.6395 12.1724 18.4614 11.3553L17.4038 10.2916C16.8641 10.8282 16.1333 11.1283 15.3723 11.126L15.3677 12.626ZM18.4614 11.3553C19.2833 10.5382 19.7468 9.42801 19.75 8.26907L18.25 8.26493C18.2479 9.02598 17.9435 9.755 17.4038 10.2916L18.4614 11.3553Z" fill="#0b3366"></path>
                        </g>
                    </svg>
                    <div class="icon-search"></div>
                    <input type="text" class="searchbar" name="search">
                </div>
            </form>
            <!-- table -->
            <div class="top">
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr style="background-color: antiquewhite;">
                            <th>STUDENT NO.</th>
                            <th>NAME</th>
                            <th>DEPARTMENT</th>
                            <th>NUMBER</th>
                            <th>PICTURE</th>
                        </tr>
                    </thead>
                    <tbody style="color:white" id="myTable">
                        <?php
                        if ($result) {
                            while ($item = $result->fetch_assoc()) {
                                echo "
                                    <tr class='hovertable clickable-row' data-student-no=$item[student_no]>
                                        <td>$item[student_no]</td>
                                        <td>$item[Name]</td>
                                        <td>$item[Section]</td>
                                        <td>$item[Contact_Number]</td>
                                        <td><img src='" . (($item['pic_path'] != null) ? $item['pic_path'] : "Images/placeholder.jpg") . "' width='30' height='30' alt='Placeholder Image'></td>
                                    </tr>
                                    ";
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
                <h2 style="font-size: 5rem;padding: 1rem 0;color:var(--primary); font-weight:bolder; font-style:italic">ADMIN</h2>
                <div class="menu">
                    <a class="button" href="student.php">ADD</a>
                    <button class="button" href="" id="editButton">EDIT</button>
                    <button class="button" id="delete">DELETE</button>
                    <a class="button" href="admin.php">REPORT</a>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var selectedId;

        // select row
        var table = document.getElementById("myTable");
        var rows = table.getElementsByTagName("tr");

        for (var i = 0; i < rows.length; i++) {
            rows[i].addEventListener("click", function() {
                // Remove the "selected" class from all rows
                for (var j = 0; j < rows.length; j++) {
                    rows[j].classList.remove("selected");
                }
                // Add the "selected" class to the clicked row
                selectedId = this.getAttribute('data-student-no')
                console.log(selectedId)
                this.classList.add("selected");
            });
        }

        function changeUrl() {
            if (selectedId) {
                var newUrl = 'student.php?id=' + selectedId;
                window.location.href = newUrl;
            } else {
                console.error("No row selected.");
            }
        }

        // delete
        document.getElementById("delete").addEventListener("click", function(e) {
            e.preventDefault();

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

        document.getElementById('editButton').addEventListener('click', changeUrl);
        document.getElementById('backIcon').addEventListener('click', () => {
            window.location = 'index.php'
        })

    });
</script>

</html>