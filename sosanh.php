<?php

require_once('func.php');

$loai = $_POST['loai'];
$dt1 = $_POST['dt1'];
$dt2 = $_POST['dt2'];

if($loai == 'diaChi'){
      $a = [];
     if(tamHop($dt1, $dt2)){
           array_push($a,'Tam Hợp');
     }
     if(nhiHop($dt1, $dt2)){
            array_push($a,'Nhị Hợp');
      }

      if(nhiHai($dt1, $dt2)){
            array_push($a,'Nhị Hại');
      }

      if(nhiXung($dt1, $dt2)){
            array_push($a,'Nhị Xung');
      }

      if(tamHinh($dt1, $dt2)){
            array_push($a,'Tam Hình');
      }
      $b = tuyetMo($dt1, $dt2);
      if($b['ketQua'] != '0'){
            array_push($a, $b['luan']);
      }
      echo "$dt1 so với $dt2 : ";
      foreach($a as $kq){
            echo $kq.", ";
            
      }
      echo "<br>";


}elseif($loai == 'nguHanh'){
      $a = nguHanhSinhKhac($dt1,$dt2);
      echo "$dt1 so với $dt2 : ";
      echo $a;
      echo '<br>';

}elseif($loai == 'lucThan'){
      $a = LucThanSinhKhac($dt1, $dt2);
      echo "$dt1 so với $dt2 : ";
      echo $a;
      echo '<br>';
}