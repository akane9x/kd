
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
                  'Thân','Tuất','Tý'
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

$diaChiNguHanh = [
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


// x(canhGio(13));
//  x($homNayAm);


 $al = $capsule->table('amlich')->get();

 $tong = [];

$gioGieo = $al[0]->gio;
$ngayGieo = $al[0]->ngay;
$thangGieo = $al[0]->thang;
$namGieo = $al[0]->nam;

$a = explode(' ', $ngayGieo);
$nhat = $a[1];
$nhatCan = $a[0];
$a = explode(' ', $thangGieo);
$nguyet = $a[1];
$nguyetCan = $a[0];
$a = explode(' ', $namGieo);
$tue = $a[1];
$tueCan = $a[0];

$tong['nhat'] = $nhat;
$tong['nguyet'] = $nguyet;
$tong['nhatCan'] = $nhatCan;
$tong['nguyetCan'] = $nguyetCan;
// $tong['tue'] = $tue;

//     [0] => 6   
//     [1] => 8
//     [2] => 2021
//     [3] => 7
//     [4] => 51
$haoDong = [];
$loai = '';
if(count($_GET) == 0){
      $maiHoa = gieoQueMaiHoa($namGieo, $homNayAm);
      //x($maiHoa);
      $haoDong = $maiHoa['dong'];
      $queChinh = queChinhMaiHoa($quePhucHy, $maiHoa['ha'], $maiHoa['thuong']);
}else{
      if(is_numeric($_GET['q'])){
            $queArr = str_split($_GET['q'],1);
            foreach($queArr as $qa){
                  if($qa > 1){ $loai = 'mh';}else{$loai = 'lh';}
            }

            if($loai == 'lh'){
                  $haoDong = str_split($_GET['d'],1);
                  $queChinh = queChinhLucHao($quePhucHy, $_GET['q']);
            }elseif($loai == 'mh'){

                  $queArr = str_split($_GET['q'],2);
                  $z = $queArr[2]%6;
                  if($z == 0) $z = 6;
                  $haoDong = [$z];
                  $z0 =  $queArr[0]%8;
                  if($z0 == 0) $z0 = 8;
                  $z1 =  $queArr[1]%8;
                  if($z1 == 0) $z1 = 8;
                  $queChinh = queChinhMaiHoa($quePhucHy, $z1, $z0);
            }
      }else{
            if($_GET['q'] == 'r'){
                  $queArr = [rand(0,99),rand(0,99),rand(0,99)];
                  $z = $queArr[2]%6;
                  if($z == 0) $z = 6;
                  $haoDong = [$z];
                  $z0 =  $queArr[0]%8;
                  if($z0 == 0) $z0 = 8;
                  $z1 =  $queArr[1]%8;
                  if($z1 == 0) $z1 = 8;
                  $queChinh = queChinhMaiHoa($quePhucHy, $z1, $z0);
            }else{
                  $maiHoa = gieoQueMaiHoa($namGieo, $homNayAm);
                  //x($maiHoa);
                  $haoDong = $maiHoa['dong'];
                  $queChinh = queChinhMaiHoa($quePhucHy, $maiHoa['ha'], $maiHoa['thuong']);
            }
      }
      
}

$queChinhArr = str_split($queChinh['que'], 1);
// x($queChinh);
// $queHo = queHo($queChinh, $quePhucHy);
// x($queHo);

$tong['thuong']['quai'] = $queChinh['thuong'];
$tong['thuong']['nguHanh'] = $queChinh['nguHanhThuong'];

$tong['ha']['quai'] = $queChinh['ha'];
$tong['ha']['nguHanh'] = $queChinh['nguHanhHa'];

$tong['hao'] = [
      0 => [
            'nghiThuong' => $queChinhArr[0]
      ],
      1 => [
            'nghiThuong' => $queChinhArr[1]
      ],
      2 => [
            'nghiThuong' => $queChinhArr[2]
      ],
      3 => [
            'nghiThuong' => $queChinhArr[3]
      ],
      4 => [
            'nghiThuong' => $queChinhArr[4]
      ],
      5 => [
            'nghiThuong' => $queChinhArr[5]
      ],

];

$queBien = queBien($queChinh['que'],$haoDong, $quePhucHy);
$queBienArr = str_split($queBien['que'], 1);

$tong['hao'][0]['nghiBien'] = $queBienArr[0];
$tong['hao'][1]['nghiBien'] = $queBienArr[1];
$tong['hao'][2]['nghiBien'] = $queBienArr[2];
$tong['hao'][3]['nghiBien'] = $queBienArr[3];
$tong['hao'][4]['nghiBien'] = $queBienArr[4];
$tong['hao'][5]['nghiBien'] = $queBienArr[5];

$tong['hao'][0]['haoDong'] = 0;
$tong['hao'][1]['haoDong'] = 0;
$tong['hao'][2]['haoDong'] = 0;
$tong['hao'][3]['haoDong'] = 0;
$tong['hao'][4]['haoDong'] = 0;
$tong['hao'][5]['haoDong'] = 0;

for($i = 0; $i < count($haoDong); $i++){
      for($x = 0; $x <=5; $x++ ){
            if($x+1 == $haoDong[$i]){
                  $tong['hao'][$x]['haoDong'] = 1;
            }
      }
}

$gd = giaDinh($queChinh['que'],$quePhucHy,$batQuaiNguHanh);
//   x($gd);
 $the = $gd['haoThe'] ;
 $ung = $gd['haoUng'] ;

//  x($ung);

for($i = 0; $i <= 5 ; $i++){
            if($i == $the-1){
                  $tong['hao'][$i]['the'] = 1;
            }else{
                  $tong['hao'][$i]['the'] = 0;
            }
      
}

for($i = 0; $i <= 5 ; $i++){
            if($i == $ung-1){
                  $tong['hao'][$i]['ung'] = 1;
            }else{
                  $tong['hao'][$i]['ung'] = 0;
            }
      
}

$tc = thienCan($queChinh['que'],$quePhucHy,$thienCan);
//x($tc);


$dc = diaChi($queChinh['que'],$quePhucHy,$diaChi);
 
$tong['hao'][0]['diaChi'] = $dc['diaChi'][0];
$tong['hao'][1]['diaChi'] = $dc['diaChi'][1];
$tong['hao'][2]['diaChi'] = $dc['diaChi'][2];
$tong['hao'][3]['diaChi'] = $dc['diaChi'][3];
$tong['hao'][4]['diaChi'] = $dc['diaChi'][4];
$tong['hao'][5]['diaChi'] = $dc['diaChi'][5];

$quaiThan = 0;
$thanQue = '';
for($i = 0; $i <= 5 ; $i++){
      if($tong['hao'][$i]['the'] == 1){
            $quaiThan = quaiThan($tong['hao'][$i]['diaChi']);
            $thanQue = thanQue($tong['hao'][$i]['nghiThuong'], $i);
      }
      
}
x($thanQue);
$dcQueGoc = diaChi($gd['queThuan'],$quePhucHy,$diaChi);
$dcnhQueGoc = diaChiNguHanh($dcQueGoc['diaChi'],$diaChiNguHanh);
$lucThanQueGoc = lucThan($gd['nguHanh'], $dcnhQueGoc);


$dcnh = diaChiNguHanh($dc['diaChi'],$diaChiNguHanh);
//  x($dcnh);
$tong['hao'][0]['nguHanh'] = $dcnh['nguHanh'][0];
$tong['hao'][1]['nguHanh'] = $dcnh['nguHanh'][1];
$tong['hao'][2]['nguHanh'] = $dcnh['nguHanh'][2];
$tong['hao'][3]['nguHanh'] = $dcnh['nguHanh'][3];
$tong['hao'][4]['nguHanh'] = $dcnh['nguHanh'][4];
$tong['hao'][5]['nguHanh'] = $dcnh['nguHanh'][5];



$lt = lucthan($gd['nguHanh'],$dcnh);
//  x($lt);

$tong['hao'][0]['lucThan'] = $lt['lucThan'][0];
$tong['hao'][1]['lucThan'] = $lt['lucThan'][1];
$tong['hao'][2]['lucThan'] = $lt['lucThan'][2];
$tong['hao'][3]['lucThan'] = $lt['lucThan'][3];
$tong['hao'][4]['lucThan'] = $lt['lucThan'][4];
$tong['hao'][5]['lucThan'] = $lt['lucThan'][5];


$kv = tuanKhong($ngayGieo);

for($i = 0; $i <= 5 ; $i++){
      $k = 0;
      for($y = 0; $y < count($kv['khongVong']) ; $y++){
            
            if($kv['khongVong'][$y] == $tong['hao'][$i]['diaChi']){
                  $k = 1;
            }
            $tong['hao'][$i]['khongVong'] = $k;
      }
}

$lucThu = lucThu($ngayGieo);
$tong['hao'][0]['lucThu'] = $lucThu['lucThu'][0];
$tong['hao'][1]['lucThu'] = $lucThu['lucThu'][1];
$tong['hao'][2]['lucThu'] = $lucThu['lucThu'][2];
$tong['hao'][3]['lucThu'] = $lucThu['lucThu'][3];
$tong['hao'][4]['lucThu'] = $lucThu['lucThu'][4];
$tong['hao'][5]['lucThu'] = $lucThu['lucThu'][5];

// x(vongTruongSinh('Kim'));
$dcNgay = explode(' ', $ngayGieo);

$vtsNgay = vongTruongSinh(nguHanhTheoDiaChi($dcNgay[1]));

$tong['hao'][0]['tsNgay'] = $vtsNgay[$tong['hao'][0]['diaChi']] ;
$tong['hao'][1]['tsNgay'] = $vtsNgay[$tong['hao'][1]['diaChi']] ;
$tong['hao'][2]['tsNgay'] = $vtsNgay[$tong['hao'][2]['diaChi']] ;
$tong['hao'][3]['tsNgay'] = $vtsNgay[$tong['hao'][3]['diaChi']] ;
$tong['hao'][4]['tsNgay'] = $vtsNgay[$tong['hao'][4]['diaChi']] ;
$tong['hao'][5]['tsNgay'] = $vtsNgay[$tong['hao'][5]['diaChi']] ;

$dcThang = explode(' ', $thangGieo);
$vtsThang = vongTruongSinh(nguHanhTheoDiaChi($dcThang[1]));

$tong['hao'][0]['tsThang'] = $vtsThang[$tong['hao'][0]['diaChi']] ;
$tong['hao'][1]['tsThang'] = $vtsThang[$tong['hao'][1]['diaChi']] ;
$tong['hao'][2]['tsThang'] = $vtsThang[$tong['hao'][2]['diaChi']] ;
$tong['hao'][3]['tsThang'] = $vtsThang[$tong['hao'][3]['diaChi']] ;
$tong['hao'][4]['tsThang'] = $vtsThang[$tong['hao'][4]['diaChi']] ;
$tong['hao'][5]['tsThang'] = $vtsThang[$tong['hao'][5]['diaChi']] ;

//////////

$gdQueBien = giaDinh($queBien['que'],$quePhucHy,$batQuaiNguHanh);

$tcQueBien = thienCan($queBien['que'],$quePhucHy,$thienCan);

$dcQueBien = diaChi($queBien['que'],$quePhucHy,$diaChi);

$tong['hao'][0]['diaChiBien'] = $dcQueBien['diaChi'][0];
$tong['hao'][1]['diaChiBien'] = $dcQueBien['diaChi'][1];
$tong['hao'][2]['diaChiBien'] = $dcQueBien['diaChi'][2];
$tong['hao'][3]['diaChiBien'] = $dcQueBien['diaChi'][3];
$tong['hao'][4]['diaChiBien'] = $dcQueBien['diaChi'][4];
$tong['hao'][5]['diaChiBien'] = $dcQueBien['diaChi'][5];

$dcnhQueBien = diaChiNguHanh($dcQueBien['diaChi'],$diaChiNguHanh);

$tong['hao'][0]['nguHanhBien'] = $dcnhQueBien['nguHanh'][0];
$tong['hao'][1]['nguHanhBien'] = $dcnhQueBien['nguHanh'][1];
$tong['hao'][2]['nguHanhBien'] = $dcnhQueBien['nguHanh'][2];
$tong['hao'][3]['nguHanhBien'] = $dcnhQueBien['nguHanh'][3];
$tong['hao'][4]['nguHanhBien'] = $dcnhQueBien['nguHanh'][4];
$tong['hao'][5]['nguHanhBien'] = $dcnhQueBien['nguHanh'][5];

$ltQueBien = lucthan($gdQueBien['nguHanh'],$dcnhQueBien);


$tong['hao'][0]['lucThanBien'] = $ltQueBien['lucThan'][0];
$tong['hao'][1]['lucThanBien'] = $ltQueBien['lucThan'][1];
$tong['hao'][2]['lucThanBien'] = $ltQueBien['lucThan'][2];
$tong['hao'][3]['lucThanBien'] = $ltQueBien['lucThan'][3];
$tong['hao'][4]['lucThanBien'] = $ltQueBien['lucThan'][4];
$tong['hao'][5]['lucThanBien'] = $ltQueBien['lucThan'][5];

$tong['hao'][0]['tsNgayBien'] = $vtsNgay[$tong['hao'][0]['diaChiBien']] ;
$tong['hao'][1]['tsNgayBien'] = $vtsNgay[$tong['hao'][1]['diaChiBien']] ;
$tong['hao'][2]['tsNgayBien'] = $vtsNgay[$tong['hao'][2]['diaChiBien']] ;
$tong['hao'][3]['tsNgayBien'] = $vtsNgay[$tong['hao'][3]['diaChiBien']] ;
$tong['hao'][4]['tsNgayBien'] = $vtsNgay[$tong['hao'][4]['diaChiBien']] ;
$tong['hao'][5]['tsNgayBien'] = $vtsNgay[$tong['hao'][5]['diaChiBien']] ;

$tong['hao'][0]['tsThangBien'] = $vtsThang[$tong['hao'][0]['diaChiBien']] ;
$tong['hao'][1]['tsThangBien'] = $vtsThang[$tong['hao'][1]['diaChiBien']] ;
$tong['hao'][2]['tsThangBien'] = $vtsThang[$tong['hao'][2]['diaChiBien']] ;
$tong['hao'][3]['tsThangBien'] = $vtsThang[$tong['hao'][3]['diaChiBien']] ;
$tong['hao'][4]['tsThangBien'] = $vtsThang[$tong['hao'][4]['diaChiBien']] ;
$tong['hao'][5]['tsThangBien'] = $vtsThang[$tong['hao'][5]['diaChiBien']] ;

$allDC = [$nguyet, $nhat];
$allDC = array_merge($allDC, $dc['diaChi']);
$allDCJson = json_encode($allDC, JSON_UNESCAPED_UNICODE);

$capsule->table('diachi')->where('id','=',1)->update([
      'dc' => $allDCJson,
      
]);

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
      

      <hr>
      <h4>Quẻ Tượng</h4>
      <hr>
      <table class="table table-striped table-hover">
            <tr>
                  <th>Quẻ</th>
                  <th>Luận</th>
            </tr>
            <tr class='text-left'>
                  <td>
                        <span class='badge bg-<?= mauNguHanh($gd['nguHanh']) ?>'><?= $queChinh['tenQue'] ?></span>      
                  </td>
                  <td>
                        <?= queTuong($queChinh['que']) ?>
                  </td>
            </tr>
            <tr class='text-left'>
                  <td>
                        <span class='badge bg-<?= mauNguHanh($gd['nguHanh']) ?>'><?= $queBien['tenQue'] ?></span>      
                  </td>
                  <td>
                        <?= queTuong($queBien['que']) ?>
                  </td>
            </tr>
      </table>
      <hr>
            <h5>Ngày <b><?= $al[0]->ngay ?></b>, tháng <b><?= $al[0]->thang ?></b>, năm <b><?= $al[0]->nam ?></b> <a class='btn btn-success float-end' href="getNgay.php">Cập nhật Thời gian</a></h5>
      <hr>

<hr>
<h4>Lục Hào</h4>
<hr>
      <table class="table table-hover">
            <tr>
                  <th>
                        <span class='badge bg-<?= mauNguHanh($gd['nguHanh']) ?>'><?= $queChinh['tenQue'] ?></span>
                        <span class='badge bg-<?= mauNguHanh($gd['nguHanh']) ?>'><?= $gd['nguHanh'] ?></span>
                        
                  </th>
                  <th>T/Ư</th>
                  <th>Thân / Địa chi</th>
                  <th>Phục</th>
                  <th>KV</th>
                  <th>Thú</th>
                  <th>TS Ngày</th>
                  <th>TS Tháng</th>
                  <th>Tinh Sát</th>
                  <!-- que bien  -->
                  <th>
                        <span class='badge bg-<?= mauNguHanh($gdQueBien['nguHanh']) ?>'><?= $queBien['tenQue'] ?></span>
                        <span class='badge bg-<?= mauNguHanh($gdQueBien['nguHanh']) ?>'><?= $gdQueBien['nguHanh'] ?>
                  </th>
                              
                  <th>Thân / Địa chi</th>
                  <th>KV</th>
                  <th>TS Ngày</th>
                  <th>TS Tháng</th>
                  <th>Tinh Sát</th>
            </tr>
            <?php
                  for($i =5 ; $i >= 0; $i--):
                        ?>
                              <tr class='hao<?= $i+1 ?>'>
                                    <td class='info' id='<?= 'haovi'.$i ?>'>
                                          <?php
                                                if(!in_array($i+1,$haoDong)){
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
                                                            ><span class='dong-am'>&nbsp;</span>
                                                      </p><?php
                                                      }
                                                }
                                                ?>
                                                            <script>
                                                                  $(document).ready(function () {
                                                                        $('#<?= 'haovi'.$i ?>').attr('title', `<?= haoVi($i) ?>`)
                                                                  });
                                                            </script>
                                                <?php
                                          ?>
                                    </td>
                                    <td class='info'>
                                          <?php 
                                          if($i == $gd['haoThe'] - 1){
                                          echo "Thế";
                                          }
                                          ?>
                                          <?php
                                                if($i == $gd['haoUng'] - 1){
                                                      echo "Ứng";
                                                }
                                          ?>
                                          <?php
                                                foreach($haoDong as $hd){
                                                      if($i == $hd -1){
                                                            echo 'Động';
                                                      }
                                                }
                                          ?>
                                          
                                    </td>
                                    
                                    <td class='info'>
                                          <?php
                                                echo $lt['lucThan'][$i];
                                                echo "<br>";
                                                echo $dc['diaChi'][$i];
                                                echo " - ";
                                                $mau = mauNguHanh($dcnh['nguHanh'][$i]);
                                                echo "<span class='badge bg-$mau'>".$dcnh['nguHanh'][$i]."</span>";
                                          ?>
                                    </td>
                                    
                                    
                                    <td class='info' id='<?= 'pt'.$i ?>'>
                                          <?php
                                                if(!in_array($lucThanQueGoc['lucThan'][$i],$lt['lucThan'])){
                                                      echo $lucThanQueGoc['lucThan'][$i];
                                                      echo "<br>";
                                                      echo $dcQueGoc['diaChi'][$i];
                                                      echo " - ";
                                                      $mau = mauNguHanh($dcnhQueGoc['nguHanh'][$i]);
                                                      echo "<span class='badge bg-$mau'>".$dcnhQueGoc['nguHanh'][$i]."</span>";
                                                      ?>
                                                            <script>
                                                                  $(document).ready(function () {
                                                                        $('#<?= 'pt'.$i ?>').attr('title', '<?= luanPhucThan($lucThanQueGoc['lucThan'][$i]) ?>')
                                                                  });
                                                            </script>
                                                      <?php
                                                      $tong['hao'][$i]['phucLucThan'] = $lucThanQueGoc['lucThan'][$i];
                                                      $tong['hao'][$i]['phucDiaChi'] = $dcQueGoc['diaChi'][$i];
                                                      $tong['hao'][$i]['phucNguHanh'] = $dcnhQueGoc['nguHanh'][$i];
                                                }else{
                                                      $tong['hao'][$i]['phucLucThan'] = '';
                                                      $tong['hao'][$i]['phucDiaChi'] = '';
                                                      $tong['hao'][$i]['phucNguHanh'] = '';
                                                }
                                                ?>
                                                
                                    </td>
                                    <td class='info'>
                                          <?php
                                                 if(in_array($dc['diaChi'][$i],$kv['khongVong'])){
                                                      echo "KV";
                                                }
                                          ?>
                                    </td>
                                    <td class='info'>
                                          <?php
                                                echo $lucThu['lucThu'][$i];
                                          ?>
                                    </td>
                                    <td class='info'>
                                          <?php
                                                $dcNgay = explode(' ', $ngayGieo);
                                                $vts = vongTruongSinh(nguHanhTheoDiaChi($dcNgay[1]));
                                                echo "<p>".$vts[$dc['diaChi'][$i]]."</p>";
                                                
                                          ?>
                                    </td>
                                    <td class='info'>
                                          <?php
                                                $dcThang = explode(' ', $thangGieo);
                                                $vts = vongTruongSinh(nguHanhTheoDiaChi($dcThang[1]));
                                                      echo "<p>".$vts[$dc['diaChi'][$i]]."</p>";
                                          ?>
                                    </td>

                                    <td class='info'>
                                          <?php
                                                if(quyNhan($tong['nhatCan'],$tong['hao'][$i]['diaChi'])) echo 'Quý<br>';
                                                if(locThan($tong['nhatCan'],$tong['hao'][$i]['diaChi'])) echo 'Lộc<br>';
                                                if(duongNhan($tong['nhatCan'],$tong['hao'][$i]['diaChi'])) echo 'Dương<br>';
                                                if(vanXuong($tong['nhatCan'],$tong['hao'][$i]['diaChi'])) echo 'Văn<br>';
                                                if(dichMa($tong['nhat'],$tong['hao'][$i]['diaChi'])) echo 'Mã<br>';
                                                if(daoHoa($tong['nhat'],$tong['hao'][$i]['diaChi'])) echo 'Đào<br>';
                                                if(tuongTinh($tong['nhat'],$tong['hao'][$i]['diaChi'])) echo 'Tương<br>';
                                                if(kiepSat($tong['nhat'],$tong['hao'][$i]['diaChi'])) echo 'Kiếp<br>';
                                                if(hoaCai($tong['nhat'],$tong['hao'][$i]['diaChi'])) echo 'Hoa<br>';
                                                if(muuTinh($tong['nhat'],$tong['hao'][$i]['diaChi'])) echo 'Mưu<br>';
                                                if(taiSat($tong['nhat'],$tong['hao'][$i]['diaChi'])) echo 'Tai<br>';
                                                if(thienY($tong['nguyet'],$tong['hao'][$i]['diaChi'])) echo 'Y<br>';
                                                if(thienHy($tong['nguyet'],$tong['hao'][$i]['diaChi'])) echo 'Hỷ<br>';
                                          ?>
                                    </td>

                                    <!-- que bien -->

                                    <td class='info'>
                                          <?php
                                                if(!in_array($i+1,$haoDong)){
                                                      if($queBienArr[$i] == 1){
                                                            ?><p><span class='duong'>&nbsp;</span></p><?php
                                                      }elseif($queBienArr[$i] == 0){
                                                            ?><p>
                                                            <span class='am'>&nbsp;</span
                                                            ><span class='cach-am'>&nbsp;</span
                                                            ><span class='am'>&nbsp;</span>
                                                      </p><?php
                                                      }
                                                }else{
                                                      if($queBienArr[$i] == 1){
                                                            ?><p><span class='dong-duong'>&nbsp;</span></p><?php
                                                      }elseif($queBienArr[$i] == 0){
                                                            ?><p>
                                                            <span class='dong-am'>&nbsp;</span
                                                            ><span class='cach-am'>&nbsp;</span
                                                            ><span class='dong-am'>&nbsp;</span>
                                                      </p><?php
                                                      }
                                                }
                                          ?>
                                    </td>
                                   
                                    <td class='info' id='<?= 'queBien'.$i ?>'>
                                          <?php
                                                echo $ltQueBien['lucThan'][$i];
                                                echo "<br>";
                                                echo $dcQueBien['diaChi'][$i];
                                                echo " - ";
                                                $mau = mauNguHanh($dcnhQueBien['nguHanh'][$i]);
                                                echo "<span class='badge bg-$mau'>".$dcnhQueBien['nguHanh'][$i]."</span>";

                                                if($tong['hao'][$i]['nghiThuong'] != $tong['hao'][$i]['nghiBien']){
                                                      ?>
                                                            <script>
                                                                  $(document).ready(function () {
                                                                        $('#<?= 'queBien'.$i ?>').attr('title', '<?= luanLucThanBien($lt['lucThan'][$i], $ltQueBien['lucThan'][$i]) ?>')
                                                                  });
                                                            </script>
                                                      <?php
                                                }
                                          ?>
                                    </td>
                                    
                                    <td class='info'>
                                          <?php
                                                 if(in_array($dcQueBien['diaChi'][$i],$kv['khongVong'])){
                                                      echo "KV";
                                                }
                                          ?>
                                    </td>
                                    <td class='info'>
                                          <?php
                                                
                                                echo "<p>".$vtsNgay[$dcQueBien['diaChi'][$i]]."</p>";
                                                
                                          ?>
                                    </td>
                                    <td class='info'>
                                          <?php
                                                
                                                      echo "<p>".$vtsThang[$dcQueBien['diaChi'][$i]]."</p>";
                                          ?>
                                    </td>
                                    <td class='info'>
                                          <?php
                                                if($tong['hao'][$i]['nghiThuong'] != $tong['hao'][$i]['nghiBien']){
                                                      if(quyNhan($tong['nhatCan'],$tong['hao'][$i]['diaChiBien'])) echo 'Quý<br>';
                                                      if(locThan($tong['nhatCan'],$tong['hao'][$i]['diaChiBien'])) echo 'Lộc<br>';
                                                      if(duongNhan($tong['nhatCan'],$tong['hao'][$i]['diaChiBien'])) echo 'Dương<br>';
                                                      if(vanXuong($tong['nhatCan'],$tong['hao'][$i]['diaChiBien'])) echo 'Văn<br>';
                                                      if(dichMa($tong['nhat'],$tong['hao'][$i]['diaChiBien'])) echo 'Mã<br>';
                                                      if(daoHoa($tong['nhat'],$tong['hao'][$i]['diaChiBien'])) echo 'Đào<br>';
                                                      if(tuongTinh($tong['nhat'],$tong['hao'][$i]['diaChiBien'])) echo 'Tương<br>';
                                                      if(kiepSat($tong['nhat'],$tong['hao'][$i]['diaChiBien'])) echo 'Kiếp<br>';
                                                      if(hoaCai($tong['nhat'],$tong['hao'][$i]['diaChiBien'])) echo 'Hoa<br>';
                                                      if(muuTinh($tong['nhat'],$tong['hao'][$i]['diaChiBien'])) echo 'Mưu<br>';
                                                      if(taiSat($tong['nhat'],$tong['hao'][$i]['diaChiBien'])) echo 'Tai<br>';
                                                      if(thienY($tong['nguyet'],$tong['hao'][$i]['diaChiBien'])) echo 'Y<br>';
                                                      if(thienHy($tong['nguyet'],$tong['hao'][$i]['diaChiBien'])) echo 'Hỷ<br>';
                                                }
                                          ?>
                                    </td>
                              </tr>

                              
                              
                        <?php
                  endfor;
                  ?> 
                 
      </table>
      


      <hr>
            <h5>Ngày <b><?= $al[0]->ngay ?></b>, tháng <b><?= $al[0]->thang ?></b>, năm <b><?= $al[0]->nam ?></b> <a class='btn btn-success float-end' href="getNgay.php">Cập nhật Thời gian</a></h5>
      <hr>
      <table class='table table-hover'>
            <tr>
                  <th>Hào</th>
                  <th>Thông Tin</th>
                  <th>Nguyệt</th>
                  <th>Nhật</th>
                  <th>Hào 6</th>
                  <th>Hào 5</th>
                  <th>Hào 4</th>
                  <th>Hào 3</th>
                  <th>Hào 2</th>
                  <th>Hào 1</th>
                  <th>Biến vs Động</th>
                  <th>Biến SV</th>
                  <th>Ám</th>
                  
            </tr>
            <?php
                  for($i = 5; $i >= 0; $i--){
                        $amDong = [0,0,0];
                        $stt1 = $i +1;
                        ?>
                        <tr class='hao<?= $i+1 ?>'>
                              <td class='info'>
                                    <?php
                                          if($i != $quaiThan){
                                                echo 'Hào '.$stt1;
                                          }else{
                                                echo 'Hào '.$stt1."<br>";
                                                echo "QT";  
                                          }

                                          if($tong['hao'][$i]['diaChi'] == $thanQue){
                                                echo '<br>TQ';
                                          }
                                    ?>
                              </td>
                              <td class='info <?= $dcnh['nguHanh'][$i] == $thanQue ? 'thanQue' : '' ?>'>
                                    <?php
                                          echo $lt['lucThan'][$i];
                                          echo "<br>";
                                          echo $dc['diaChi'][$i];
                                          echo " - ";
                                          $mau = mauNguHanh($dcnh['nguHanh'][$i]);
                                          echo "<span class='badge bg-$mau'>".$dcnh['nguHanh'][$i]."</span>";
                                    ?>
                              </td>
                              <td class='info'>
                                    <?php 
                                          $ss =  vuongTuong(nguHanhTheoDiaChi($tong['nguyet']), nguHanhTheoDiaChi($tong['hao'][$i]['diaChi']));
                                          echo $ss['luan']; 
                                          if($ss['code'] == 0 || $ss['code'] == 1 ){
                                                $amDong[0] = 1;
                                          }
                                    ?>
                              </td>
                              <td class='info'>
                                    <?php 
                                          $ss1 = sosanhHao($tong['nhat'], $tong['hao'][$i]['diaChi'], $allDC);
                                          echo $ss1['luan']; 
                                          
                                          $xung = nhiXung($tong['nhat'], $tong['hao'][$i]['diaChi']);
                                          if($xung['ketQua']){
                                                $amDong[1] = 1;
                                          }
                                    ?>
                              </td>
                              
                              <?php
                                    for($x = 5; $x >= 0; $x--){
                                          ?>
                                                <td class='info'>
                                                      <?php 
                                                            $ss2 = sosanhHao($tong['hao'][$i]['diaChi'],$tong['hao'][$x]['diaChi'], $allDC);
                                                            echo $ss2['luan'];

                                                            if($tong['hao'][$x]['haoDong'] == 1){
                                                                  if($ss2['ketQua'] == 5 || $ss['ketQua'] == 2 || $ss['ketQua'] == 3){
                                                                        $amDong[2] = 1;
                                                                  }
                                                            }
                                                      ?>
                                                </td>
                                          <?php
                                    }
                              ?>
                              <td class='info'>
                                    <?php
                                          if($tong['hao'][$i]['nghiThuong'] != $tong['hao'][$i]['nghiBien']){
                                                $ss3 = sosanhHao($tong['hao'][$i]['diaChiBien'],$tong['hao'][$i]['diaChi'], $allDC);
                                                echo $ss3['luan'];
                                          }
                                    ?>
                              </td>
                              <td class="info">
                                    <?php
                                          if($tong['hao'][$i]['nghiThuong'] != $tong['hao'][$i]['nghiBien']){
                                                $ss4 =  vuongTuong(nguHanhTheoDiaChi($tong['nguyet']), nguHanhTheoDiaChi($tong['hao'][$i]['diaChiBien']));
                                                echo $ss4['luan'];
                                                echo "<br>";
                                                $ss5 =  sosanhHaoBien( $tong['hao'][$i]['diaChiBien'],$tong['nhat']);
                                                echo $ss5['luan'];
                                          }
                                    ?>
                              </td>
                              <td class='info'>
                                    <?php
                                          if($amDong[0] == 1 && $amDong[1] == 1 && $amDong[2] == 1){
                                                echo 'Ám động';
                                          }
                                          // x($amDong);
                                    ?>
                              </td>

                        </tr>
                        
            <?php
                  if($tong['hao'][$i]['phucDiaChi'] != ''){
                        ?>
                              <tr class='hao<?= $i+1 ?>'>
                                    <td>Phục Thần</td>
                                    <td>
                                    <?php
                                                echo $tong['hao'][$i]['phucLucThan'];
                                                echo "<br>";
                                                echo $tong['hao'][$i]['phucDiaChi'];
                                                echo " - ";
                                                $mau = mauNguHanh($tong['hao'][$i]['phucNguHanh']);
                                                echo "<span class='badge bg-$mau'>".$tong['hao'][$i]['phucNguHanh']."</span>";
                                          ?>
                                    </td>
                                    <td class='info'>
                                    <?php 
                                          $ss =  vuongTuong(nguHanhTheoDiaChi($tong['nguyet']), nguHanhTheoDiaChi($tong['hao'][$i]['phucDiaChi']));
                                          echo $ss['luan']; 
                                    ?>
                                    </td>
                                    <td class='info'>
                                    <?php 
                                          $ss1 = sosanhHao($tong['hao'][$i]['phucDiaChi'],$tong['nhat'], $allDC);
                                          echo $ss1['luan']; 
                                    ?>
                                    </td>

                                    <?php
                                    for($x = 5; $x >= 0; $x--){
                                                ?>
                                                      <td class='info'>
                                                            <?php 
                                                                  $ss2 = sosanhHao($tong['hao'][$i]['phucDiaChi'], $tong['hao'][$x]['diaChi'], $allDC);
                                                                  echo $ss2['luan'];
                                                                  if($tong['hao'][$x]['haoDong'] == 1){
                                                                        if($ss2['ketQua'] == 5 || $ss['ketQua'] == 2 || $ss['ketQua'] == 3){
                                                                              $amDong[0] = 1;
                                                                        }
                                                                  }                                                            
                                                            ?>
                                                      </td>
                                                <?php
                                          }
                                    ?>
                                    <td class='info'><?= '' ?></td>
                                    <td class='info'><?= '' ?></td>
                              </tr>
                        <?php
                  }


                  }
            ?>

      </table>

      <hr>
      <h4>Luận lục thân gặp lục thú</h4>
      <hr>
      <table class="table table-striped table-hover">
            <tr>
                  <th>Hào</th>
                  <th>Thú</th>
                  <th>Thân</th>
                  <th>Luận</th>
            </tr>
            <?php
                  for($i = 5; $i >= 0; $i--){
                      $stt = $i + 1;
                        ?>
                              <tr class='text-left hao<?= $i+1 ?>>'>
                                    <td><?= 'Hào '.$stt ?> </td>
                                    <td><?= $tong['hao'][$i]['lucThu'] ?></td>
                                    <td><?= $tong['hao'][$i]['lucThan'] ?></td>
                                    <td><?= luanLucThanLucThu($tong['hao'][$i]['lucThan'], $tong['hao'][$i]['lucThu']) ?></td>
                              </tr>
                        <?php
                  }
                  
            ?>
      </table>
      <hr>
      <h4>Luận lục thú gặp địa chi</h4>
      <hr>
      <table class="table table-striped table-hover">
            <tr>
                  <th>Hào</th>
                  <th>Địa Chi</th>
                  <th>Thú</th>
                  <th>Luận</th>
            </tr>
            <?php
                  // x($tong);
                  for($i = 5; $i >= 0; $i--){
                      $stt2 = $i + 1;
                        ?>
                              <tr class='text-left hao<?= $i+1 ?>>'>
                                    <td><?= 'Hào '.$stt2 ?> </td>
                                    <td><?= $tong['hao'][$i]['diaChi'] ?></td>
                                    <td><?= $tong['hao'][$i]['lucThu'] ?></td>
                                    <td><?= luanLucThuDiaChi($tong['hao'][$i]['lucThu'], $tong['hao'][$i]['diaChi']) ?></td>
                              </tr>
                        <?php
                  }
                  
            ?>
      </table>


    <script>
          $(document).ready(function () {
                $('.info').on('click',function(){
                      if($(this).hasClass('chon')){
                            $(this).removeClass('chon')
                      }else{
                              $(this).addClass('chon')
                      }
                })
                
                $('.hao<?= $ung ?>').attr('style','background-color: #27ae60; ')
                $('.hao<?= $the ?>').attr('style','background-color: #74b9ff; ')
                
                <?php
                  foreach($haoDong as $hd){
                        echo "$('.hao".$hd."').attr('style','background-color: #2c3e50; color:white');";
                  }
                ?>
          });
    </script>
</body>
</html>

