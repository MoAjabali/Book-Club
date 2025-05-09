<?php
$file = $_GET['file'];
$fullPath = $_SERVER['DOCUMENT_ROOT'] . '/' . $file;

if(file_exists($fullPath) && is_readable($fullPath)) {
    header('Content-Type: application/pdf');
    header('Content-Length: ' . filesize($fullPath));
    header('Accept-Ranges: bytes');
    header('Cache-Control: public, must-revalidate, max-age=0');
    header('Pragma: public');
    header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    readfile($fullPath);
    exit();
} else {
    echo "File not found or not readable";
}
?>