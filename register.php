<?php




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
    <script type="module" src="js/account.js"></script>
</head>

<body style="overflow-y: hidden;">
    <div class="wrapper">
        <main style="margin: auto; margin-left: 10%;">
            <div class="main">
                <div class="card">
                    <h2>Register Account</h2>
                    <div class="card-body" id="form-student">
                        <table>
                            <tbody>
                                <tr>
                                    <td>Username</td>
                                    <td>: </td>
                                    <td><input class="input-design form-control" type="text" required name="username" id="username"></td>
                                </tr>
                                <tr>
                                    <td>Password</td>
                                    <td>: </td>
                                    <td><input class="input-design form-control" type="text" required name="password" id="password"></td>
                                </tr>
                                <tr>
                                    <td>Confirm Password</td>
                                    <td>:</td>
                                    <td><input class="input-design form-control" type="text" required name="confirm_password" id="confirm_password">
                                        <div id="message" style="font-size: small; margin-right: 2rem; position: absolute; transform: translateY(-60px);"></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="buttons-container">
                            <button type="submit" id="save">Save</button>
                        </div>

                    </div>
                </div>
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

</html>