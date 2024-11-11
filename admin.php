<?php
include 'process/db_connection.php';
include 'process/session_check.php';

$conn = OpenCon();
$sql = "SELECT * FROM info_tbl ";
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_name = isset($_POST['search']) ? trim($_POST['search']) : '';
    $employee = isset($_POST['employee']) ? $_POST['employee'] : '';

    if (!empty($item_name)) {
        $sql = "SELECT * FROM info_tbl WHERE Name LIKE ? LIMIT 10000";
        $stmt = $conn->prepare($sql);
        $param = "%{$item_name}%";
        $stmt->bind_param("s", $param);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    } elseif (!empty($employee)) {
        $sql = "SELECT * FROM info_tbl WHERE Section = '$employee' LIMIT 10000";
        $result = $conn->query($sql);
    } else {
        $sql = "SELECT * FROM info_tbl WHERE Section != 'employee' LIMIT 10000";
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

<body style="overflow-y: hidden;">
    <div class="wrapper">
        <main>
            <form action="" method="post" id="searchForm">
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
                    <input type="text" id="isEmployee" name="employee" style="display: none;">
                    <input type="submit" value="Submit" style="display: none;">
                    <span class="icons" name='employee' id="employee">
                        <svg height="50px" width="50px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-158.72 -158.72 829.44 829.44" xml:space="preserve" fill="#000000">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <style type="text/css">
                                    .st0 {
                                        fill: #FFF0CE;
                                    }
                                </style>
                                <g>
                                    <path class="st0" d="M256.008,411.524c54.5,0,91.968-7.079,92.54-13.881c2.373-28.421-34.508-43.262-49.381-48.834 c-7.976-2.984-19.588-11.69-19.588-17.103c0-3.587,0-8.071,0-14.214c4.611-5.119,8.095-15.532,10.183-27.317 c4.857-1.738,7.627-4.524,11.095-16.65c3.69-12.93-5.548-12.5-5.548-12.5c7.468-24.715-2.357-47.944-18.825-46.246 c-11.358-19.857-49.397,4.54-61.31,2.841c0,6.818,2.834,11.92,2.834,11.92c-4.143,7.882-2.548,23.564-1.389,31.485 c-0.667,0-9.016,0.079-5.468,12.5c3.452,12.126,6.23,14.912,11.088,16.65c2.079,11.786,5.571,22.198,10.198,27.317 c0,6.143,0,10.627,0,14.214c0,5.413-12.35,14.548-19.611,17.103c-14.953,5.262-51.746,20.413-49.373,48.834 C164.024,404.444,201.491,411.524,256.008,411.524z"></path>
                                    <path class="st0" d="M404.976,56.889h-75.833v16.254c0,31.365-25.524,56.889-56.889,56.889h-32.508 c-31.366,0-56.889-25.524-56.889-56.889V56.889h-75.834c-25.444,0-46.071,20.627-46.071,46.071v362.969 c0,25.444,20.627,46.071,46.071,46.071h297.952c25.445,0,46.072-20.627,46.072-46.071V102.96 C451.048,77.516,430.421,56.889,404.976,56.889z M402.286,463.238H109.714V150.349h292.572V463.238z"></path>
                                    <path class="st0" d="M239.746,113.778h32.508c22.405,0,40.635-18.23,40.635-40.635V40.635C312.889,18.23,294.659,0,272.254,0 h-32.508c-22.406,0-40.635,18.23-40.635,40.635v32.508C199.111,95.547,217.341,113.778,239.746,113.778z M231.619,40.635 c0-4.492,3.634-8.127,8.127-8.127h32.508c4.492,0,8.127,3.635,8.127,8.127v16.254c0,4.492-3.635,8.127-8.127,8.127h-32.508 c-4.493,0-8.127-3.635-8.127-8.127V40.635z"></path>
                                </g>
                            </g>
                        </svg>
                    </span>
                    <span class="icons" name='student' id="student">
                        <svg height="50px" width="50px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-51.2 -51.2 614.40 614.40" xml:space="preserve" fill="#000000">
                            <g id="SVGRepo_bgCarrier" stroke-width="0">
                                <rect x="-51.2" y="-51.2" width="614.40" height="614.40" rx="307.2" fill="#FFF0CE" strokewidth="0"></rect>
                            </g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <style type="text/css">
                                    .st0 {
                                        fill: #1450a3;
                                    }
                                </style>
                                <g>
                                    <path class="st0" d="M505.837,180.418L279.265,76.124c-7.349-3.385-15.177-5.093-23.265-5.093c-8.088,0-15.914,1.708-23.265,5.093 L6.163,180.418C2.418,182.149,0,185.922,0,190.045s2.418,7.896,6.163,9.627l226.572,104.294c7.349,3.385,15.177,5.101,23.265,5.101 c8.088,0,15.916-1.716,23.267-5.101l178.812-82.306v82.881c-7.096,0.8-12.63,6.84-12.63,14.138c0,6.359,4.208,11.864,10.206,13.618 l-12.092,79.791h55.676l-12.09-79.791c5.996-1.754,10.204-7.259,10.204-13.618c0-7.298-5.534-13.338-12.63-14.138v-95.148 l21.116-9.721c3.744-1.731,6.163-5.504,6.163-9.627S509.582,182.149,505.837,180.418z"></path>
                                    <path class="st0" d="M256,346.831c-11.246,0-22.143-2.391-32.386-7.104L112.793,288.71v101.638 c0,22.314,67.426,50.621,143.207,50.621c75.782,0,143.209-28.308,143.209-50.621V288.71l-110.827,51.017 C278.145,344.44,267.25,346.831,256,346.831z"></path>
                                </g>
                            </g>
                        </svg>
                        </svg>
                    </span>
                    <span class="icons" name='balance' id="balance">
                        <svg viewBox="-0.5 0 25 25" height="50px" width="50px" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M12.7003 17.1099V18.22C12.7003 18.308 12.6829 18.395 12.6492 18.4763C12.6156 18.5576 12.5662 18.6316 12.504 18.6938C12.4418 18.7561 12.3679 18.8052 12.2867 18.8389C12.2054 18.8725 12.1182 18.8899 12.0302 18.8899C11.9423 18.8899 11.8551 18.8725 11.7738 18.8389C11.6925 18.8052 11.6187 18.7561 11.5565 18.6938C11.4943 18.6316 11.4449 18.5576 11.4113 18.4763C11.3776 18.395 11.3602 18.308 11.3602 18.22V17.0801C10.9165 17.0072 10.4917 16.8468 10.1106 16.6082C9.72943 16.3695 9.39958 16.0573 9.14023 15.6899C9.04577 15.57 8.99311 15.4226 8.99023 15.27C8.99148 15.1842 9.00997 15.0995 9.04459 15.021C9.0792 14.9425 9.12927 14.8718 9.19177 14.813C9.25428 14.7542 9.32794 14.7087 9.40842 14.679C9.4889 14.6492 9.57455 14.6359 9.66025 14.6399C9.74504 14.6401 9.82883 14.6582 9.90631 14.6926C9.98379 14.7271 10.0532 14.7773 10.1102 14.8401C10.4326 15.2576 10.8657 15.5763 11.3602 15.76V13.21C10.0302 12.69 9.36023 11.9099 9.36023 10.8999C9.38027 10.3592 9.5928 9.84343 9.9595 9.44556C10.3262 9.04769 10.8229 8.79397 11.3602 8.72998V7.62988C11.3602 7.5419 11.3776 7.45482 11.4113 7.37354C11.4449 7.29225 11.4943 7.21847 11.5565 7.15625C11.6187 7.09403 11.6925 7.04466 11.7738 7.01099C11.8551 6.97732 11.9423 6.95996 12.0302 6.95996C12.1182 6.95996 12.2054 6.97732 12.2867 7.01099C12.3679 7.04466 12.4418 7.09403 12.504 7.15625C12.5662 7.21847 12.6156 7.29225 12.6492 7.37354C12.6829 7.45482 12.7003 7.5419 12.7003 7.62988V8.71997C13.0724 8.77828 13.4289 8.91103 13.7485 9.11035C14.0681 9.30967 14.3442 9.57137 14.5602 9.87988C14.6555 9.99235 14.7117 10.1329 14.7202 10.28C14.7229 10.3662 14.7084 10.4519 14.6776 10.5325C14.6467 10.613 14.6002 10.6867 14.5406 10.749C14.481 10.8114 14.4096 10.8613 14.3306 10.8958C14.2516 10.9303 14.1665 10.9487 14.0802 10.95C13.99 10.9475 13.9013 10.9257 13.8202 10.886C13.7391 10.8463 13.6675 10.7897 13.6102 10.72C13.3718 10.4221 13.0575 10.1942 12.7003 10.0601V12.3101L12.9503 12.4099C14.2203 12.9099 15.0103 13.63 15.0103 14.77C14.9954 15.3808 14.7481 15.9629 14.3189 16.3977C13.8897 16.8325 13.3108 17.0871 12.7003 17.1099ZM11.3602 11.73V10.0999C11.1988 10.1584 11.0599 10.2662 10.963 10.408C10.8662 10.5497 10.8162 10.7183 10.8203 10.8899C10.8173 11.0676 10.8669 11.2424 10.963 11.3918C11.0591 11.5413 11.1973 11.6589 11.3602 11.73ZM13.5502 14.8C13.5502 14.32 13.2203 14.03 12.7003 13.8V15.8C12.9387 15.7639 13.1561 15.6427 13.3123 15.459C13.4685 15.2752 13.553 15.0412 13.5502 14.8Z" fill="#1450a3"></path>
                                <path d="M18 3.96997H6C4.93913 3.96997 3.92172 4.39146 3.17157 5.1416C2.42142 5.89175 2 6.9091 2 7.96997V17.97C2 19.0308 2.42142 20.0482 3.17157 20.7983C3.92172 21.5485 4.93913 21.97 6 21.97H18C19.0609 21.97 20.0783 21.5485 20.8284 20.7983C21.5786 20.0482 22 19.0308 22 17.97V7.96997C22 6.9091 21.5786 5.89175 20.8284 5.1416C20.0783 4.39146 19.0609 3.96997 18 3.96997Z" stroke="#1450a3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </g>
                        </svg>
                    </span>
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
                                    <tr class='hovertable clickable-row' data-student-no=$item[student_no] id=$item[student_no]'>
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
                <h2 style="font-size: 2rem;padding: 1rem 0;color:var(--primary); font-weight:bolder; font-style:italic">ADMIN</h2>
                <div class="menu">
                    <a class="button" href="student.php">ADD</a>
                    <button class="button" href="" id="editButton">EDIT</button>
                    <button class="button" id="delete">DELETE</button>
                    <a class="button" href="admin.php">REPORT</a>
                    <a class="button" href="register.php">REGISTER</a>
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
            rows[i].addEventListener("dblclick", function() {
                changeUrl();
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
        document.getElementById('balance').addEventListener('click', () => {
            window.location = 'balance.php'
        })

        document.getElementById('employee').addEventListener('click', () => {
            document.getElementById("isEmployee").value = 'employee';
            document.getElementById("searchForm").submit()

        })
        document.getElementById('student').addEventListener('click', () => {
            document.getElementById("isEmployee").value = null;
            document.getElementById("searchForm").submit()
        })


    });
</script>

</html>