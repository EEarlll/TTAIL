<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_FILES['uploadfile']['name'])) {
        $filename = $_FILES['uploadfile']['name'];
        $source = $_FILES['uploadfile']['tmp_name'];
        $dir = '../temp';
        $target = $dir . '/' . $filename;
        if (move_uploaded_file($source, $target)) {
            echo json_encode((['ok' => 1, 'temp_path' => substr($target, 3)]));
        } else {
            echo json_encode(['ok' => 0]);
        }
    }
}
