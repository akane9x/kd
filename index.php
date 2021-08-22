
<?php

require_once('func.php');


$luongNghi = [
      '0' => 'Âm', 
      '1' => "Dương"
];

$tuTuong = [
      '00' => 'Thái âm',
      '01' => 'Thiếu Âm',
      '10' => 'Thiếu Dương',
      '11' => 'Thái Dương',
];
$batQuai = [
      '111',
      '110' ,
      '101',    
      '100' ,
      '011' ,   
      '010' ,
      '001' ,  
      '000' ,
];
$batQuaiTen = [
      '111' => 'Càn',
      '110' => 'Đoài',
      '101' => 'Ly',
      '100' => 'Chấn',
      '011' => 'Tốn',
      '010' => 'Khảm',
      '001' => 'Cấn',
      '000' => 'Khôn',
];
$batQuaiNguHanh = [
      '111' => 'Kim',
      '110' => 'Kim',
      '101' => 'Hỏa',
      '100' => 'Mộc',
      '011' => 'Mộc',
      '010' => 'Thủy',
      '001' => 'Thổ',
      '000' => 'Thổ',
];

$thuongQuai = ['Thiên','Trạch','Hỏa','Lôi','Phong','Thủy','Sơn','Địa'];
$haQuai = ['Thiên','Trạch','Hỏa','Lôi','Phong','Thủy','Sơn','Địa'];
// Chấn tốn mộc, càn đoàn kim
//Khảm thủy ly hỏa, cấn khôn thổ tầm

$quePhucHy = [
      '111111' => 'Thuần Càn', // Thiên Vi Càn
      '110111' => 'Thiên Trạch Lý',
      '101111' => 'Thiên Hỏa Đồng Nhân',
      '100111' => 'Thiên Lôi Vô Vọng',
      '011111' => 'Thiên Phong Cấu',
      '010111' => 'Thiên Thủy Tụng',
      '001111' => 'Thiên Sơn Độn',
      '000111' => 'Thiên Địa Bĩ',
      '111110' => 'Trạch Thiên Quải',
      '110110' => 'Thuần Đoài', // trạch vi đoài
      '101110' => 'Trạch Hỏa Cách',
      '100110' => 'Trạch Lôi Tùy',
      '011110' => 'Trạch Phong Đại Quá',
      '010110' => 'Trạch Thủy Khốn',
      '001110' => 'Trạch Sơn Hàm',
      '000110' => 'Trạch Địa Tụy',
      '111101' => 'Hỏa Thiên Đại Hữu',
      '110101' => 'Hỏa Trạch Khuê',
      '101101' => 'Thuần Ly', // Hỏa vi ly
      '100101' => 'Hỏa Lôi Phệ Hạp',
      '011101' => 'Hỏa Phong Đỉnh',
      '010101' => 'Hỏa Thủy Vị Tế',
      '001101' => 'Hỏa Sơn Lữ',
      '000101' => 'Hỏa Địa Tấn',
      '111100' => 'Lôi Thiên Đại Tráng',
      '110100' => 'Lôi Trạch Qui Muội',
      '101100' => 'Lôi Hỏa Phong',
      '100100' => 'Thuần Chấn', // Lôi vi chấn
      '011100' => 'Lôi Phong Hằng',
      '010100' => 'Lôi Thủy Giải',
      '001100' => 'Lôi Sơn Tiểu Quá',
      '000100' => 'Lôi Địa Dự',
      '111011' => 'Phong Thiên Tiểu Súc',
      '110011' => 'Phong Trạch Trung Phu',
      '101011' => 'Phong Hỏa Gia Nhân',
      '100011' => 'Phong Lôi Ích',
      '011011' => 'Thuần Tốn',// Phong vi Tốn
      '010011' => 'Phong Thủy Hoán',
      '001011' => 'Phong Sơn Tiệm',
      '000011' => 'Phong Địa Quán',
      '111010' => 'Thủy Thiên Nhu',
      '110010' => 'Thủy Trạch Tiết',
      '101010' => 'Thủy Hỏa Ký Tế',
      '100010' => 'Thủy Lôi Truân',
      '011010' => 'Thủy Phong Tĩnh',
      '010010' => 'Thuần Khảm',// Thủy vi khảm
      '001010' => 'Thủy Sơn Kiển',
      '000010' => 'Thủy Địa Tỷ',
      '111001' => 'Sơn Thiên Đại Súc',
      '110001' => 'Sơn Trạch Tổn',
      '101001' => 'Sơn Hỏa Bí',
      '100001' => 'Sơn Lôi Di',
      '011001' => 'Sơn Phong Cổ',
      '010001' => 'Sơn Thủy Mông',
      '001001' => 'Thuần Cấn', // Sơn vi cấn
      '000001' => 'Sơn Địa Bác',
      '111000' => 'Địa Thiên Thái',
      '110000' => 'Địa Trạch Lâm',
      '101000' => 'Địa Hỏa Minh Di',
      '100000' => 'Địa Lôi Phục',
      '011000' => 'Địa Phong Thăng',
      '010000' => 'Địa Thủy Sư',
      '001000' => 'Địa Sơn Khiêm',
      '000000' => 'Thuần Khôn',//địa vi khôn
];

$thienCan = [ // thuong truoc ha sau
      '111' => ['Nhâm',"Giáp"],
      '110' => ['Đinh',"Đinh"],
      '101' => ['Kỷ',"Kỷ"],    
      '100' => ['Canh',"Canh"],
      '011' => ['Tân',"Tân"],   
      '010' => ['Mậu',"Mậu"],
      '001' => ['Bính',"Bính"],  
      '000' => ['Quý',"Ất"],
];

$diaChi = [
      '111' => [
            [
                  'Tý', 'Dần','Thìn'
            ],
            [
                  'Ngọ','Thân','Tuất'
            ]
      ],//càn
      '110' => [
            [
                  'Tỵ', 'Mão','Sửu'
            ],
            [
                  'Hợi','Dậu','Mùi'
            ]
      ],//đoài
      '101' => [
            [
                  'Mão', 'Sửu','Hợi'
            ],
            [
                  'Dậu','Mùi','Tỵ'
            ]
      ],    //ly
      '100' => [
            [
                  'Tý', 'Dần','Thìn'
            ],
            [
                  'Ngọ','Thân','Tuất'
            ]
      ],//chấn giống càn
      '011' => [
            [
                  'Sửu', 'Hợi','Dậu'
            ],
            [
                  'Mùi','Tỵ','Mão'
            ]
      ],   //Tốn
      '010' => [
            [
                  'Dần', 'Thìn','Ngọ'
            ],
            [
                  'Thân','Tuấn','Tý'
            ]
      ],// khảm
      '001' => [
            [
                  'Thìn', 'Ngọ','Thân'
            ],
            [
                  'Tuất','Tý','Dần'
            ]
      ],  //Cấn
      '000' => [
            [
                  'Mùi', 'Tỵ','Mão'
            ],
            [
                  'Sửu','Hợi','Dậu'
            ]
      ], //Khôn
];

$lucThan = [ // sinh truoc khac sau
      'hude' => ['tton','ttai'],
      'tton' => ['ttai', 'qquy'],
      'ttai' => ['qquy', 'pmau'],
      'qquy' => ['pmau', 'hude'],
      'pmau' => ['hude', 'tton']
];

$conGiapNguHanh = [
      'Tý' => 'Thủy',
      'Sửu' => 'Thổ',
      'Dần' => 'Mộc',
      'Mão' => 'Mộc',
      'Thìn' => 'Thổ',
      'Tỵ' => 'Hỏa',
      'Ngọ' => 'Hỏa',
      'Mùi' => 'Thổ',
      'Thân' => 'Kim',
      'Dậu' => 'Kim',
      'Tuất' => 'Thổ',
      'Hợi' => 'Thủy',
];

$nguHanh = [
      'Kim' => ['sinh' => 'Thủy','khắc' => 'Mộc', 'dcSinh' => 'Thổ', 'biKhac' => "Hỏa"],
      'Thủy' => ['sinh' => 'Mộc','khắc' => 'Hỏa', 'dcSinh' => 'Kim', 'biKhac' => "Thổ"],
      'Mộc' => ['sinh' => 'Hỏa','khắc' => 'Thổ', 'dcSinh' => 'Thủy', 'biKhac' => "Kim"],
      'Hỏa' => ['sinh' => 'Thổ','khắc' => 'Kim', 'dcSinh' => 'Mộc', 'biKhac' => "Thủy"],
      'Thổ' => ['sinh' => 'Kim', 'khắc' => 'Thủy', 'dcSinh' => 'Hỏa', 'biKhac' => "Mộc"],
];


// TA là ngũ hành quẻ gốc
// Sinh ra ta : Phụ Mẫu
// Ta sinh ra : Tôn tử
// ta khắc : Thê Tài
// Khắc ta : Quan quỉ
// Cùng ngũ hành : Huynh Đệ

// x(canhGio(13));
// x($homNayAm);

 $al = $capsule->table('amLich')->get();
 x($al);

// $gioGieo = 'Nhâm Tý';
$ngayGieo = $al[0]->ngay;
$thangGieo = $al[0]->thang;
// $namGieo = 'Kỷ Mùi';

$haoDong = 3;
$queChinh = queChinh($batQuai, $quePhucHy, 4, 3);
$queChinh = ['dataName' => 'Quẻ Chính','que' => '011011'];
$queChinhArr = str_split($queChinh['que'], 1);
x($queChinh);
// $queHo = queHo($queChinh, $quePhucHy);
// x($queHo);

x(queBien($queChinh['que'],$haoDong, $quePhucHy));

$gd = giaDinh($queChinh['que'],$quePhucHy,$batQuaiNguHanh);
x($gd);

$tc = thienCan($queChinh['que'],$quePhucHy,$thienCan);
x($tc);

$dc = diaChi($queChinh['que'],$quePhucHy,$diaChi);
x($dc);

$dcnh = diaChiNguHanh($dc['diaChi'],$conGiapNguHanh);
x($dcnh);

$lt = lucthan($gd['nguHanh'],$dcnh);
x($lt);

xd(tuyetMo('Hợi',"Tỵ"));

x(conGiapThang(5));



$kv = tuanKhong($ngayGieo);

$lucThu = lucThu($ngayGieo);

x(vongTruongSinh('Kim'));

?>
<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Document</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
      <link rel="stylesheet" href="style.css?v=<?= microtime() ?>">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>
      <h4>Giờ <b><?= $al[0]->gio ?></b>, ngày <b><?= $al[0]->ngay ?></b>, tháng <b><?= $al[0]->thang ?></b>, năm <b><?= $al[0]->nam ?></b></h4>
<a class='btn btn-success' href="getNgay.php">Cập nhật Thời gian</a>
      <table id="table table-striped table-hover">
           
            <tr>
                  <td style='width:5%'>
                        <span class='badge bg-<?= mauNguHanh($gd['nguHanh']) ?>'><?= $queChinh['que'] ?></span>
                        <span class='badge bg-<?= mauNguHanh($gd['nguHanh']) ?>'><?= $gd['nguHanh'] ?>
                  </td>
                  <th style='width:1%'>Thế</th>
                  <th style='width:1%'>Ứng</th>
                  <th style='width:1%'>Động</th>
                  <th style='width:1%'>Địa chi</th>
                  <th style='width:1%'>Không Vong</th>
                  <th style='width:1%'>Ngũ Hành</th>
                  <th style='width:1%'>Lục Thân</th>
                  <th style='width:1%'>Lục Thú</th>
                  <th style='width:1%'>TS Ngày</th>
                  <th style='width:1%'>TS Tháng</th>
            </tr>
            
            <tr>
                  <td>
                        <?php
                              for($i = 5; $i >=0; $i--){
                                    if($i != $haoDong -1){
                                          if($queChinhArr[$i] == 1){
                                                ?><p><span class='duong'>&nbsp;</span></p><?php
                                          }elseif($queChinhArr[$i] == 0){
                                                ?><p>
                                                <span class='am'>&nbsp;</span
                                                ><span class='cach-am'>&nbsp;</span
                                                ><span class='am'>&nbsp;</span>
                                          </p><?php
                                          }
                                    }else{
                                          if($queChinhArr[$i] == 1){
                                                ?><p><span class='dong-duong'>&nbsp;</span></p><?php
                                          }elseif($queChinhArr[$i] == 0){
                                                ?><p>
                                                <span class='dong-am'>&nbsp;</span
                                                ><span class='cach-am'>&nbsp;</span
                                                ><span class='am dong'>&nbsp;</span>
                                          </p><?php
                                          }
                                    }
                              }
                        ?>
                  </td>
                  <td>
                        <?php
                              for($i = 5; $i >=0; $i--){
                                    if($i == $gd['haoThe'] - 1){
                                          echo "<p>Thế</p>";
                                    }else{
                                          echo "<p>&nbsp;</p>";
                                    }
                              }
                        ?>
                  </td>
                  <td>
                        <?php
                              for($i = 5; $i >=0; $i--){
                                    if($i == $gd['haoUng'] - 1){
                                          echo "<p>Ứng</p>";
                                    }else{
                                          echo "<p>&nbsp;</p>";
                                    }
                              }
                        ?>
                  </td>
                  <td>
                        <?php
                              for($i = 5; $i >=0; $i--){
                                    if($i == $haoDong - 1){
                                          echo "<p>Động</p>";
                                    }else{
                                          echo "<p>&nbsp;</p>";
                                    }
                              }
                        ?>
                  </td>
                  <td>
                        <?php
                              for($i = 5; $i >=0; $i--){
                                    echo "<p>".$dc['diaChi'][$i]."</p>";
                              }
                        ?>
                  </td>

                  <td>
                        <?php
                              for($i = 5; $i >=0; $i--){
                                    if(in_array($dc['diaChi'][$i],$kv['khongVong'])){
                                          echo "<p>KV</p>";
                                    }else{
                                          echo "<p>&nbsp;</p>";
                                    }
                              }
                        ?>
                  </td>

                  <td>
                        <?php
                              for($i = 5; $i >=0; $i--){
                                    $mau = mauNguHanh($dcnh['nguHanh'][$i]);
                                    echo "<p><span class='badge bg-$mau'>".$dcnh['nguHanh'][$i]."</span></p>";
                              }
                        ?>
                  </td>
                  <td>
                        <?php
                              for($i = 5; $i >=0; $i--){
                                    //$mau = mauNguHanh($dcnh[$i]);
                                    echo "<p>".$lt['lucThan'][$i]."</p>";
                              }
                        ?>
                  </td>
                  <td>
                        <?php
                              for($i = 5; $i >=0; $i--){
                                    //$mau = mauNguHanh($dcnh[$i]);
                                    echo "<p>".$lucThu['lucThu'][$i]."</p>";
                              }
                        ?>
                  </td>
                  <td>
                        <?php
                              $dcNgay = explode(' ', $ngayGieo);
                              $vts = vongTruongSinh(nguHanhTheoDiaChi($dcNgay[1]));
                              // x($vts);
                              for($i = 5; $i >=0; $i--){
                                    //$mau = mauNguHanh($dcnh[$i]);
                                    echo "<p>".$vts[$dc['diaChi'][$i]]."</p>";
                              }
                        ?>
                  </td>

                  <td>
                        <?php
                              $dcNgay = explode(' ', $thangGieo);
                              $vts = vongTruongSinh(nguHanhTheoDiaChi($dcNgay[1]));
                              // x($vts);
                              for($i = 5; $i >=0; $i--){
                                    //$mau = mauNguHanh($dcnh[$i]);
                                    echo "<p>".$vts[$dc['diaChi'][$i]]."</p>";
                              }
                        ?>
                  </td>
                  
            </tr>

            <div id="data"></div>
            
      </table>

    
</body>
</html>


























































