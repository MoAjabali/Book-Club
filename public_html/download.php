<?php
  $file = $_GET['file'];
  if(file_exists($file)) {
      header('Content-Description: File Transfer');
      header('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment; filename="'.basename($file).'"');
      readfile($file);
      echo "Thank You For Download";
      exit();
  } else {
      echo "file dose not exist";
  }
?>