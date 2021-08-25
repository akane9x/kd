<?php

require_once('func.php');

$loaiTT = $_POST['loaiTT'];
$a = $_POST['dt1'];
$b = $_POST['dt2'];

$allDC = $capsule->table('diaChi')->get();
$diaChi = $allDC[0]->dc;
$diaChi = json_decode($diaChi);

if($a != $b){
      if($loaiTT == 'nguHanh'){
            $c = nguHanhSinhKhac($a, $b);
            echo $c['luan']; 
      }elseif($loaiTT == 'diaChi'){
            $tuyetMo = tuyetMo($a, $b);
            if($tuyetMo['ketQua']){
                  echo $tuyetMo['luan'];
            }else{
                  $tamHop = tamHop($a, $b, $diaChi);
                  if($tamHop['ketQua']){
                        echo $tamHop['luan'];
                  }else{
                        $nhiXung = nhiXung($a, $b);
                        if($nhiXung['ketQua']){
                              echo $nhiXung['luan'];
                        }else{
                              $d = nguHanhTheoDiaChi($a);
                              $e = nguHanhTheoDiaChi($b);
                              $nhsk = nguHanhSinhKhac($d, $e);
                              if($nhsk['ketQua']){
                                    echo "$a ".$nhsk['luan']." $b";
                              }
                        }
                  }
            }
      }elseif($loaiTT == 'lucThan'){
            $lt = lucThanSinhKhac($a, $b);
            echo $lt['luan'];
      }
}