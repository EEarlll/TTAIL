<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$filepath = __DIR__ . '/../storage/';

function HourFormat($time)
{
    return date('h:i A', strtotime($time));
}

function get_weekdays($year, $month){
    $first_day = strtotime("$year-$month-01");
    $num_days = date('t', $first_day);
    $weekday_list = array();

    // numeric representation of the first day of the month (0 for Sunday, 1 for Monday, ..., 6 for Saturday)
    $first_weekday = date('w', $first_day);

    // Adjust the start position to Monday if necessary
    $start_day = ($first_weekday == 0) ? 6 : $first_weekday - 1;

    // Create an array to store the weekdays starting from Monday
    $weekdays = array('MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN');

    // Iterate through each day in the month and append the weekday to the list
    for ($day = 1; $day <= $num_days; $day++) {
        $weekday = $weekdays[($start_day + $day - 1) % 7];
        $weekday_list[] = $weekday;
    }

    return $weekday_list;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fieldArray = [];
    $InArray = [];
    $OutArray = [];
    $InArrayResult = array_fill(0, 31, '');
    $OutArrayResult = array_fill(0, 31, '');
    $baseRow = 9;

    foreach ($_POST as $key => $value) {
        $fieldArray[] = $value;
    }
    //echo json_encode($fieldArray);

    include 'db_connection.php';

    $conn = OpenCon();
    $id = $fieldArray[0];
    $name = $fieldArray[2];
    $selectedMonth = $fieldArray[5];
    $dateTime = new DateTime($selectedMonth);
    $monthInTwoDigits = $dateTime->format('m');
    $currYear = date("Y");

    $sql1 = "SELECT time_in FROM time_in_tbl WHERE student_no = '$id' AND SUBSTRING(time_in, 6, 2) = '$monthInTwoDigits' AND SUBSTRING(time_in, 1,4) = '$currYear';";
    $sql2 = "SELECT time_out FROM time_out_tbl WHERE student_no = '$id' AND SUBSTRING(time_out, 6, 2) = '$monthInTwoDigits' AND SUBSTRING(time_out, 1,4) = '$currYear';";
    $result1 = $conn->query($sql1);
    $result2 = $conn->query($sql2);

    if ($result1->num_rows > 0 && $result2->num_rows > 0 && $result1 !== false && $result2 !== false) {
        while ($row = mysqli_fetch_assoc($result1)) {
            $InArray[] = $row['time_in'];
        }
        while ($row = mysqli_fetch_assoc($result2)) {
            $OutArray[] = $row['time_out'];
        }

        $month = date('F', strtotime($InArray[0]));
        $filename = $filepath . $name . " - " . $month . ".xlsx";

        foreach ($InArray as $time_In) {
            $day = date('d', strtotime($time_In));
            if ($day >= 1 && $day <= 31) {
                $InArrayResult[$day - 1] = $time_In;
            }
        }

        foreach ($OutArray as $time_Out) {
            $day = (int)date('d', strtotime($time_Out));
            if ($day >= 1 && $day <= 31) {
                $OutArrayResult[$day - 1] = $time_Out;
            }
        }

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("template.xlsx");
        $weekdays = get_weekdays($currYear, $month);
        $spreadsheet->getActiveSheet()->setCellValue('C3', $name);
        $spreadsheet->getActiveSheet()->setCellValue('D7', $month);

        foreach($weekdays as $index => $value){
            $spreadsheet->getActiveSheet()->setCellValue('B' . $baseRow + $index, $value);
        }

        foreach ($InArrayResult as $index => $value) {
            if ($value) {
                $spreadsheet->getActiveSheet()->setCellValue('C' . $baseRow + $index, HourFormat($value));
            }
        }
        foreach ($OutArrayResult as $index => $value) {
            if ($value) {
                $spreadsheet->getActiveSheet()->setCellValue('D' . $baseRow + $index, HourFormat($value));
            }
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="example.xlsx"');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    } 
    else {
        header('HTTP/1.1 204 No Content');
        echo json_encode(['status' => 'no_results', 'message' => 'No results found']);
    }
}


// debug
// INSERT INTO time_in_tbl(time_in, student_no)
// VALUES
// ("2024-02-01 09:15 AM", 123),
// ("2024-02-02 10:30 AM", 123),
// ("2024-04-03 11:45 AM", 123),
// ("2024-04-04 01:00 PM", 123),
// ("2024-02-05 02:15 PM", 123),
// ("2024-05-06 03:30 PM", 123),
// ("2024-05-07 04:45 PM", 123),
// ("2024-02-08 06:00 PM", 123),
// ("2024-08-09 07:15 PM", 123),
// ("2024-08-10 08:30 PM", 123),
// ("2024-02-11 09:45 PM", 123),
// ("2024-03-12 11:00 PM", 123),
// ("2024-03-13 12:15 AM", 123),
// ("2024-07-14 01:30 AM", 123),
// ("2024-07-15 02:45 AM", 123),
// ("2024-07-16 04:00 AM", 123),
// ("2024-07-17 05:15 AM", 123),
// ("2024-02-18 06:30 AM", 123),
// ("2024-09-19 07:45 AM", 123),
// ("2024-09-20 09:00 AM", 123),
// ("2024-11-21 10:15 AM", 123),
// ("2024-12-22 11:30 AM", 123),
// ("2024-11-23 01:45 PM", 123),
// ("2024-12-24 03:00 PM", 123),
// ("2024-02-25 04:15 PM", 123),
// ("2024-01-26 05:30 PM", 123),
// ("2024-01-27 06:45 PM", 123),
// ("2024-02-28 08:00 PM", 123),
// ("2024-02-29 09:15 PM", 123);

// INSERT INTO time_out_tbl(time_out, student_no)
// VALUES
// ("2024-02-01 08:00 AM", 123),
// ("2024-02-02 10:15 AM", 123),
// ("2024-04-03 01:30 PM", 123),
// ("2024-04-04 03:45 PM", 123),
// ("2024-02-05 06:00 PM", 123),
// ("2024-05-06 09:15 PM", 123),
// ("2024-05-07 11:30 PM", 123),
// ("2024-02-08 02:45 AM", 123),
// ("2024-08-09 05:00 AM", 123),
// ("2024-08-10 08:15 AM", 123),
// ("2024-02-11 11:30 AM", 123),
// ("2024-03-12 02:45 PM", 123),
// ("2024-03-13 06:00 PM", 123),
// ("2024-07-14 09:15 PM", 123),
// ("2024-07-15 11:30 PM", 123),
// ("2024-07-16 02:45 AM", 123),
// ("2024-07-17 05:00 AM", 123),
// ("2024-02-18 08:15 AM", 123),
// ("2024-09-19 11:30 AM", 123),
// ("2024-11-20 02:45 PM", 123),
// ("2024-12-21 06:00 PM", 123),
// ("2024-11-22 09:15 PM", 123),
// ("2024-12-23 11:30 PM", 123),
// ("2024-12-24 02:45 AM", 123),
// ("2024-02-25 05:00 AM", 123),
// ("2024-01-26 08:15 AM", 123),
// ("2024-01-27 11:30 AM", 123),
// ("2024-02-28 02:45 PM", 123),
// ("2024-02-29 06:00 PM", 123);
