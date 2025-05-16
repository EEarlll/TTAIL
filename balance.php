<?php
include 'process/balance_fill.php';
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
    <link rel="stylesheet" href="css/calculator.css">
    <script type="module" src="js/balance.js"></script>

</head>

<body style="overflow-y: hidden;">
    <div class="wrapper">
        <main>
            <div class="main">
                <div class="card">
                    <h2>Student Balance Profile</h2>
                    <form class="card-body" id="form-student" method="post">
                        <table>
                            <tbody>
                                <tr>
                                    <td>Student No.</td>
                                    <td>: </td>
                                    <td>
                                        <input class="input-design form-control" autofocus type="text" <?php if (isset($type)) { ?> disabled <?php } ?> required name="student_no" id="student_no" value="<?php echo $student_no; ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Name</td>
                                    <td>:</td>
                                    <td><input class="input-design form-control" type="text" name="Name" id="Name" disabled value="<?php echo $Name; ?>"></td>
                                </tr>
                                <tr>
                                    <td>Balance</td>
                                    <td>: </td>
                                    <td><input class="input-design form-control" type="text" name="Balance" id="Balance" disabled value="<?php echo $Balance; ?>"></td>
                                </tr>
                                <tr>
                                    <td>New balance</td>
                                    <td>: </td>
                                    <td><input class="input-design form-control" type="text" name="newBalance" id="newBalance"></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="buttons-container">
                            <input type="text" class="form-control" style="display: none" value="withdrawal" id="transaction_type" name="transaction_type">
                            <button type="submit" id="Info">Info</button>
                            <button type="button" id="Add">Add</button>
                            <button type="button" id="Minus">Spend</button>
                        </div>
                    </form>

                </div>
                <div class="box">
                    <div class="inner-box calculator">
                        <div class="">
                            <div id="history" style="margin-top: 1rem;">

                            </div>
                            <div class="col">
                                <input class="input-design btn-control" style="margin-bottom: 1rem;" name='cash_given' value='<?php echo $cash_given ?>' aria-label="Amount (to the nearest dollar)" id="Cash">
                                <div style="display: flex; justify-content: space-between;">
                                    <button type="button" class="btn btn-primary" onclick="handleCalculator()">Calculate Change</button>
                                    <button type="button" class="btn btn-primary" onclick="handleCalculatorButton('C')">C</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-buttons">
                                <button type="button" class="btn btn-dark" onclick="handleCalculatorButton('/')">/</button>
                                <button type="button" class="btn btn-dark" onclick="handleCalculatorButton('*')">*</button>
                                <button type="button" class="btn btn-dark" onclick="handleCalculatorButton('-')">-</button>
                                <button type="button" class="btn btn-dark" onclick="handleCalculatorButton('+')">+</button>
                                <button type="button" class="btn btn-dark" onclick="handleCalculatorButton('9')">9</button>
                                <button type="button" class="btn btn-dark" onclick="handleCalculatorButton('8')">8</button>
                                <button type="button" class="btn btn-dark" onclick="handleCalculatorButton('7')">7</button>
                                <button type="button" class="btn btn-dark" onclick="handleCalculatorButton('6')">6</button>
                                <button type="button" class="btn btn-dark" onclick="handleCalculatorButton('5')">5</button>
                                <button type="button" class="btn btn-dark" onclick="handleCalculatorButton('4')">4</button>
                                <button type="button" class="btn btn-dark" onclick="handleCalculatorButton('3')">3</button>
                                <button type="button" class="btn btn-dark" onclick="handleCalculatorButton('2')">2</button>
                                <button type="button" class="btn btn-dark" onclick="handleCalculatorButton('1')">1</button>
                                <button type="button" class="btn btn-dark" onclick="handleCalculatorButton('0')">0</button>
                                <button type="button" class="btn btn-dark" onclick="handleCalculatorButton('.')">.</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="top">
            </div>
            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr style="background-color: antiquewhite;">
                            <th>Date</th>
                            <th>Balance Transaction</th>
                            <th>Balance Total
                            <th>
                        </tr>
                    </thead>
                    <tbody style="color:white" id="myTable">
                        <?php
                        if (isset($result1)) {

                            $entries = $result1->fetch_all(MYSQLI_ASSOC);

                            foreach ($entries as $index => $entry) {
                                $amountColor = $entry['transaction_type'] === 'deposit' ? 'green' : 'red';

                                echo "  <tr class='hovertable clickable-row'>
                                            <td>{$entry['day']}</td>
                                            <td style='color: {$amountColor};'>{$entry['transaction_amount']}</td>
                                            <td>{$entry['balance']}</td>";
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
    <script src="js/calculator.js" defer></script>
</body>

</html>