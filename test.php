<?php

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = $_POST['message'];
    $number = $_POST['number'];
    $url = 'http://localhost:3000/sendSMS/' . $number . '/' . $message;
    fast_request($url);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="post">
        <input type="text" name="number">
        <input type="text" name="message">
        <button type="submit">Submit</button>
    </form>
</body>

</html>