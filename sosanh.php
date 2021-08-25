<?php

require_once('func.php');

$loai = $_POST['loai'];
$dt1 = $_POST['dt1'];
$dt2 = $_POST['dt2'];




if($dt1 == $dt2){
      $a = "...";
      echo "$dt1 so với $dt2 : ";
      echo $a;
      echo '<br>';
}else{
      if($loai == 'diaChi'){
            $tamHop = tamHop($dt1, $dt2);
            $nhiHop = nhiHop($dt1, $dt2);
            $nhiHai = nhiHai($dt1, $dt2);
            $nhiXung = nhiXung($dt1, $dt2);
            $tamHinh = tamHinh($dt1, $dt2);
            $tuHinh = tuHinh($dt1, $dt2);
            $tuyetMo = tuyetMo($dt1, $dt2);

            $a = [];
           if($tamHop['ketQua']){
                 array_push($a,$tamHop['luan']);
           }
           if($nhiHop['ketQua']){
                  array_push($a,$nhiHop['luan']);
            }
      
            if($nhiHai['ketQua']){
                  array_push($a,$nhiHai['luan']);
            }
      
            if($nhiXung['ketQua']){
                  array_push($a,$nhiXung['luan']);
            }
      
            if($tamHinh['ketQua']){
                  array_push($a,$tamHinh['luan']);
            }
            if($tuHinh['ketQua']){
                  array_push($a,$tuHinh['luan']);
            }

            if($tuyetMo['ketQua']){
                  array_push($a,$tuyetMo['luan']);
            }
            echo "$dt1 so với $dt2 : ";
            if(count($a) > 0){
                  foreach($a as $kq){
                        echo $kq.", ";
                        
                  }
            }else{
                  echo "...";
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
}