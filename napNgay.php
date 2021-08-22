<?php

require_once('func.php');


$amLich = json_decode($_POST['ngayThang']);

$capsule->table('amLich')->where('id','=',1)->update([
      'gio' => $amLich[0],
      'ngay' => $amLich[1],
      'thang' => $amLich[2],
      'nam' => $amLich[3],
]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Document</title>
</head>
<body>
      <script>
            window.location.replace("index.php");
      </script>
</body>
</html>