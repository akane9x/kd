<?php

require_once('func.php');

$alJson = str_replace('Tí', 'Tý', $_POST['ngayThang'] ); 

$amlich = json_decode($alJson);

$capsule->table('amlich')->where('id','=',1)->update([
      'gio' => $amlich[0],
      'ngay' => $amlich[1],
      'thang' => $amlich[2],
      'nam' => $amlich[3],
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