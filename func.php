<?php

require_once('vendor/autoload.php');
use Carbon\Carbon;
//abc
require_once('db.php');

function x($a){
      echo "<pre>";
      print_r($a);
      echo "</pre>";
}



function xd($a){
      echo "<pre>";
      var_dump($a);
      echo "</pre>";
}

function canhGio($gioDuong){
      $gioAm = ['Tý','Tý','Sửu','Sửu','Dần','Dần','Mẹo','Mẹo','Thìn','Thìn','Tỵ','Tỵ','Ngọ','Ngọ','Mùi','Mùi','Thân','Thân','Dậu','Dậu','Tuất','Tuất','Hợi','Hợi'];

      return $gioAm[$gioDuong];

}


class d2a
{
	public function INT( $d )
	{
		return floor( $d ) ;
	}
 
	public function jdFromDate( $dd, $mm, $yy )
	{
		$a = $this::INT( ( 14 - $mm ) / 12 ) ;
		$y = $yy + 4800 - $a ;
		$m = $mm + 12 * $a - 3 ;
		$jd = $dd + $this::INT( ( 153 * $m + 2 ) / 5 ) + 365 * $y + $this::INT( $y / 4 ) - $this::INT( $y /
						100 ) + $this::INT( $y / 400 ) - 32045 ;
		if ( $jd < 2299161 )
		{
						$jd = $dd + $this::INT( ( 153 * $m + 2 ) / 5 ) + 365 * $y + $this::INT( $y / 4 ) -
										32083 ;
		}
		return $jd ;
	}
 
	public function jdToDate( $jd )
	{
		if ( $jd > 2299160 )
		{ // After 5/10/1582, Gregorian calendar
						$a = $jd + 32044 ;
						$b = $this::INT( ( 4 * $a + 3 ) / 146097 ) ;
						$c = $a - $this::INT( ( $b * 146097 ) / 4 ) ;
		}
		else
		{
						$b = 0 ;
						$c = $jd + 32082 ;
		}
		$d = $this::INT( ( 4 * $c + 3 ) / 1461 ) ;
		$e = $c - $this::INT( ( 1461 * $d ) / 4 ) ;
		$m = $this::INT( ( 5 * $e + 2 ) / 153 ) ;
		$day = $e - $this::INT( ( 153 * $m + 2 ) / 5 ) + 1 ;
		$month = $m + 3 - 12 * $this::INT( $m / 10 ) ;
		$year = $b * 100 + $d - 4800 + $this::INT( $m / 10 ) ;
		//echo "day = $day, month = $month, year = $year\n";
		return array(
						$day,
						$month,
						$year
					);
	}
 
	public function getNewMoonDay( $k, $timeZone )
	{
		$T = $k / 1236.85; // Time in Julian centuries from 1900 January 0.5
		$T2 = $T * $T;
		$T3 = $T2 * $T;
		$dr = M_PI / 180;
		$Jd1 = 2415020.75933 + 29.53058868 * $k + 0.0001178 * $T2 - 0.000000155 * $T3;
		$Jd1 = $Jd1 + 0.00033 * sin( ( 166.56 + 132.87 * $T - 0.009173 * $T2 ) * $dr); // Mean new moon
		$M = 359.2242 + 29.10535608 * $k - 0.0000333 * $T2 - 0.00000347 * $T3; // Sun's mean anomaly
		$Mpr = 306.0253 + 385.81691806 * $k + 0.0107306 * $T2 + 0.00001236 * $T3; // Moon's mean anomaly
		$F = 21.2964 + 390.67050646 * $k - 0.0016528 * $T2 - 0.00000239 * $T3; // Moon's argument of latitude
		$C1 = ( 0.1734 - 0.000393 * $T ) * sin( $M * $dr ) + 0.0021 * sin( 2 * $dr * $M );
		$C1 = $C1 - 0.4068 * sin( $Mpr * $dr ) + 0.0161 * sin( $dr * 2 * $Mpr);
		$C1 = $C1 - 0.0004 * sin( $dr * 3 * $Mpr);
		$C1 = $C1 + 0.0104 * sin( $dr * 2 * $F ) - 0.0051 * sin( $dr * ( $M + $Mpr));
		$C1 = $C1 - 0.0074 * sin( $dr * ( $M - $Mpr ) ) + 0.0004 * sin( $dr * ( 2 * $F + $M ));
		$C1 = $C1 - 0.0004 * sin( $dr * ( 2 * $F - $M ) ) - 0.0006 * sin( $dr * ( 2 * $F + $Mpr ));
		$C1 = $C1 + 0.0010 * sin( $dr * ( 2 * $F - $Mpr ) ) + 0.0005 * sin( $dr * ( 2 * $Mpr + $M ));
		if ( $T < -11 )
		{
						$deltat = 0.001 + 0.000839 * $T + 0.0002261 * $T2 - 0.00000845 * $T3 - 0.000000081 * $T * $T3 ;
		}
		else
		{
						$deltat = -0.000278 + 0.000265 * $T + 0.000262 * $T2;
		}
		
		$JdNew = $Jd1 + $C1 - $deltat;
		//echo "JdNew = $JdNew\n";
		return $this::INT( $JdNew + 0.5 + $timeZone / 24 );
	}
 
	public function getSunLongitude( $jdn, $timeZone )
	{
		$T = ( $jdn - 2451545.5 - $timeZone / 24 ) / 36525; // Time in Julian centuries from 2000-01-01 12:00:00 GMT
		$T2 = $T * $T;
		$dr = M_PI / 180; // degree to radian
		$M = 357.52910 + 35999.05030 * $T - 0.0001559 * $T2 - 0.00000048 * $T * $T2; // mean anomaly, degree
		$L0 = 280.46645 + 36000.76983 * $T + 0.0003032 * $T2; // mean longitude, degree
		$DL = ( 1.914600 - 0.004817 * $T - 0.000014 * $T2 ) * sin( $dr * $M );
		$DL = $DL + ( 0.019993 - 0.000101 * $T ) * sin( $dr * 2 * $M ) + 0.000290 * sin( $dr * 3 * $M );
		$L = $L0 + $DL; // true longitude, degree
		//echo "\ndr = $dr, M = $M, T = $T, DL = $DL, L = $L, L0 = $L0\n";
		// obtain apparent longitude by correcting for nutation and aberration
		$omega = 125.04 - 1934.136 * $T;
		$L = $L - 0.00569 - 0.00478 * sin( $omega * $dr );
		$L = $L * $dr;
		$L = $L - M_PI * 2 * ( $this::INT( $L / ( M_PI * 2 ) ) ); // Normalize to (0, 2*PI)
		return $this::INT( $L / M_PI * 6 );
	}
 
	public function getLunarMonth11( $yy, $timeZone )
	{
		$off = $this->jdFromDate( 31, 12, $yy ) - 2415021;
		$k = $this::INT( $off / 29.530588853 );
		$nm = $this::getNewMoonDay( $k, $timeZone );
		$sunLong = $this::getSunLongitude( $nm, $timeZone ); // sun longitude at local midnight
		if ( $sunLong >= 9 )
		{
						$nm = $this::getNewMoonDay( $k - 1, $timeZone );
		}
		return $nm;
	}
 
	public function getLeapMonthOffset( $a11, $timeZone )
	{
		$k = $this::INT( ( $a11 - 2415021.076998695 ) / 29.530588853 + 0.5 );
		$last = 0;
		$i = 1; // We start with the month following lunar month 11
		$arc = $this::getSunLongitude( $this::getNewMoonDay( $k + $i, $timeZone ), $timeZone );
		do
		{
			$last = $arc;
			$i = $i + 1;
			$arc = $this::getSunLongitude( $this::getNewMoonDay( $k + $i, $timeZone ), $timeZone );
		} 
		while ( $arc != $last && $i < 14 );
		return $i - 1 ;
	}
 
	/* Comvert solar date dd/mm/yyyy to the corresponding lunar date */
	public function convertSolar2Lunar( $dd, $mm, $yy, $timeZone )
	{
		$dayNumber = $this::jdFromDate( $dd, $mm, $yy );
		$k = $this::INT( ( $dayNumber - 2415021.076998695 ) / 29.530588853 );
		$monthStart = $this::getNewMoonDay( $k + 1, $timeZone );
		if ($monthStart > $dayNumber)
		{
			$monthStart = $this::getNewMoonDay( $k, $timeZone );
		}
		$a11 = $this::getLunarMonth11( $yy, $timeZone ) ;
		$b11 = $a11 ;
		if ( $a11 >= $monthStart )
		{
			$lunarYear = $yy;
			$a11 = $this::getLunarMonth11( $yy - 1, $timeZone );
		}
		else
		{
			$lunarYear = $yy + 1;
			$b11 = $this::getLunarMonth11( $yy + 1, $timeZone );
		}
		$lunarDay = $dayNumber - $monthStart + 1 ;
		$diff = $this::INT( ( $monthStart - $a11 ) / 29 ) ;
		$lunarLeap = 0 ;
		$lunarMonth = $diff + 11 ;
		if ( $b11 - $a11 > 365 )
		{
			$leapMonthDiff = $this::getLeapMonthOffset( $a11, $timeZone ) ;
			if ( $diff >= $leapMonthDiff )
			{
							$lunarMonth = $diff + 10 ;
							if ( $diff == $leapMonthDiff )
							{
											$lunarLeap = 1 ;
							}
			}
		}
		if ( $lunarMonth > 12 )
		{
			$lunarMonth = $lunarMonth - 12 ;
		}
		if ( $lunarMonth >= 11 && $diff < 4 )
		{
			$lunarYear -= 1 ;
		}
		return array(
						$lunarDay,
						$lunarMonth,
						$lunarYear,
						$lunarLeap ) ;
	}
 
	/* Convert a lunar date to the corresponding solar date */
	public function convertLunar2Solar( $lunarDay, $lunarMonth, $lunarYear, $lunarLeap,
					$timeZone )
	{
		if ( $lunarMonth < 11 )
		{
						$a11 = $this::getLunarMonth11( $lunarYear - 1, $timeZone ) ;
						$b11 = $this::getLunarMonth11( $lunarYear, $timeZone ) ;
		}
		else
		{
						$a11 = $this::getLunarMonth11( $lunarYear, $timeZone ) ;
						$b11 = $this::getLunarMonth11( $lunarYear + 1, $timeZone ) ;
		}
		$k = $this::INT( 0.5 + ( $a11 - 2415021.076998695 ) / 29.530588853 ) ;
		$off = $lunarMonth - 11 ;
		if ( $off < 0 )
		{
						$off += 12 ;
		}
		if ( $b11 - $a11 > 365 )
		{
						$leapOff = $this::getLeapMonthOffset( $a11, $timeZone ) ;
						$leapMonth = $leapOff - 2 ;
						if ( $leapMonth < 0 )
						{
										$leapMonth += 12 ;
						}
						if ( $lunarLeap != 0 && $lunarMonth != $leapMonth )
						{
										return array(
														0,
														0,
														0 ) ;
						}
						else
										if ( $lunarLeap != 0 || $off >= $leapOff )
										{
														$off += 1 ;
										}
		}
		$monthStart = $this::getNewMoonDay( $k + $off, $timeZone ) ;
		return $this::jdToDate( $monthStart + $lunarDay - 1 ) ;
	}
}

$dt = new Carbon;

$homNay = $dt->now('Asia/Ho_Chi_Minh');

$d2a = new d2a;

$homNayAm = $d2a->convertSolar2Lunar($homNay->day, $homNay->month, $homNay->year,7);
array_pop($homNayAm);
array_push($homNayAm, $homNay->hour);
array_push($homNayAm, $homNay->minute);

function queChinhMaiHoa($quePH, $ha, $thuong){
	if($ha == 0) $ha = 6;
	if($thuong == 0) $thuong = 6;
	$bQ = [
		'111',
		'110' ,
		'101',    
		'100' ,
		'011' ,   
		'010' ,
		'001' ,  
		'000' ,
	];
	$bqTen = [
		'111' => 'Càn',
		'110' => 'Đoài',
		'101' => 'Ly',
		'100' => 'Chấn',
		'011' => 'Tốn',
		'010' => 'Khảm',
		'001' => 'Cấn',
		'000' => 'Khôn',
	];
	$bqng = [
		'111' => 'Kim',
		'110' => 'Kim',
		'101' => 'Hỏa',
		'100' => 'Mộc',
		'011' => 'Mộc',
		'010' => 'Thủy',
		'001' => 'Thổ',
		'000' => 'Thổ',
	];
      $que = $bQ[$ha-1].$bQ[$thuong-1];
      return [
		'dataName' => 'Quẻ Chính',
            "que" => $que,
            'tenQue' => $quePH[$que],
		'thuong' => $bqTen[$bQ[$thuong-1]],
		'nguHanhThuong' => $bqng[$bQ[$thuong-1]],
		'ha' => $bqTen[$bQ[$ha-1]],
		'nguHanhHa' => $bqng[$bQ[$ha-1]],
      ];
}

function dao($a){
	$b == $a;
	if($b == '1'){
		$b = '0';
	}elseif($b == '0'){
		$b = '1';
	}
	return $b;
}

function queChinhLucHao($quePH, $que){
	$queLH = str_split($que, 3);
	$ha = $queLH[0];
	$thuong = $queLH[1];
	$bQ = [
		'111',
		'110' ,
		'101',    
		'100' ,
		'011' ,   
		'010' ,
		'001' ,  
		'000' ,
	];
	$bqTen = [
		'111' => 'Càn',
		'110' => 'Đoài',
		'101' => 'Ly',
		'100' => 'Chấn',
		'011' => 'Tốn',
		'010' => 'Khảm',
		'001' => 'Cấn',
		'000' => 'Khôn',
	];
	$bqng = [
		'111' => 'Kim',
		'110' => 'Kim',
		'101' => 'Hỏa',
		'100' => 'Mộc',
		'011' => 'Mộc',
		'010' => 'Thủy',
		'001' => 'Thổ',
		'000' => 'Thổ',
	];
      
      return [
		'dataName' => 'Quẻ Chính',
            "que" => $que,
            'tenQue' => $quePH[$que],
		'thuong' => $bqTen[$thuong],
		'nguHanhThuong' => $bqng[$thuong],
		'ha' => $bqTen[$ha],
		'nguHanhHa' => $bqng[$ha],
      ];
}

function queHo($queChinh, $quePH){
      $bQ = str_split($queChinh['que'],1);
      $thuong = $bQ[2].$bQ[3].$bQ[4];
      $ha = $bQ[1].$bQ[2].$bQ[3];
      $queHo = $ha.$thuong;
      return[
		'dataName' => 'Quẻ Hỗ',
            'que' => $queHo,
            'tenQue' => $quePH[$queHo]
      ];
}

function dong($a,$b){

      if($a[$b] == 0){
            $a[$b] = 1;
      }elseif($a[$b] == 1){
            $a[$b] = 0;
      }
      return $a;
}

function isThuan($que){
      $b = str_split($que,3);
      $c = false;
      if($b[0] == $b[1]){
            $c = true;
      }
      return $c;
}
function isThuanArray($que){
      $a = implode('',$que);
      $b = str_split($a, 3);
      $c = false;
      if($b[0] == $b[1]){
            $c = true;
      }
      return $c;
}

function queBien($queChinh, $haoDong,$quePH){

      if(count($haoDong)){
		$b = str_split($queChinh,1);
		$c = [];
	for($i = 0; $i < count($haoDong); $i++){
		$a = $haoDong[$i] -1;
		if($i == 0){
			$c = dong($b, $a);
		}else{
			$c = dong($c, $a);
		}
	}

      $d = implode('',$c);
      return [
		'dataName' => 'Quẻ Biến',
            'que' => $d,
            'tenQue' => $quePH[$d]
      ];
	}else{
		return [
			'dataName' => 'Quẻ Biến',
			'que' => $queChinh,
			'tenQue' => $quePH[$queChinh]
		];
	}
}

function giaDinh($que, $quePH, $nguHanh){
      $a = str_split($que,1);
	$b = implode('',$a);
      $c = str_split($b,3);
      if(isThuanArray($a)){
            return [
			'dataName' => 'Gia Đình Quẻ',
                  'que' => $que,
                  'tenQue' => $quePH[$que] ,
                  'queThuan' => $que,
                  'tenQueThuan' => $quePH[$que],
			'nguHanh' => $nguHanh[$c[0]],
                  'haoThe' => 6,
                  'haoUng' => 3
            ];
      }else{
            
            $haodong = '';
            for($i = 0; $i < 6; $i++){
                  if($i < 5){
                        $a = dong($a,$i);
                        if(isThuanArray($a)){
					$b = implode('',$a);
      				$c = str_split($b,3);
                              $hao = $i +1 ;
                              break;
                        }
                  }elseif($i == 5){
                        $a = dong($a,3);
                        if(isThuanArray($a)){
					$b = implode('',$a);
      				$c = str_split($b,3);
                              $hao =4;
                              break;
                        }
                        $a = dong($a,2);
                        $a = dong($a,1);
                        $a = dong($a,0);
                        if(isThuanArray($a)){
					$b = implode('',$a);
      				$c = str_split($b,3);
                              $hao = 3;
                              break;
                        }
                  }
            }
            
            $ung = 0;
            if($hao > 3){
                  $ung = $hao -3;
            }else{
                  $ung = $hao +3;
            }
            return [
			'dataName' => 'Gia Đình Quẻ',
                  'que' => $que,
                  'tenQue' => $quePH[$que],
                  'queThuan' => $b,
                  'tenQueThuan' => $quePH[$b],
                  'nguHanh' => $nguHanh[$c[0]],
                  'haoThe' => $hao,
                  'haoUng' => $ung
            ];
      }
}

function thienCan($que,$quePH ,$thienCan){
      $a = str_split($que, 3);
      return [
		'dataName' => 'Thiên Can các Hào',
            'que' => $que,
            'tenQue' => $quePH[$que],
            'thuongGiap' => $thienCan[$a[1]][0],
            'haGiap' => $thienCan[$a[0]][1],
      ];
}

function diaChi($que,$quePH ,$diaChi){
      $a = str_split($que, 3);
      $anDiaChi = array_merge($diaChi[$a[0]][0],$diaChi[$a[1]][1]);
      return [
		'dataName' => 'Địa Chi Của Các Hào',
            'que' => $que,
            'tenQue' => $quePH[$que],
            'diaChi' => $anDiaChi
      ];
}

function diaChiNguHanh($diaChiQue, $conGiapNguHanh){
      $a = [];
      for($i = 0; $i <6;$i++){
            array_push($a, $conGiapNguHanh[$diaChiQue[$i]]);
      }
      return [
		'dataName' => 'Ngũ Hành của các Hào',
		'nguHanh' => $a
	];
}

// function nguHanhSinhKhac($nguHanhQue, $nguHanhHao){
//       $a = '';
// 	$kq = false;
//       if($nguHanhQue == $nguHanhHao) $a = 'Trùng';
//       $nguHanh = [
//             'Kim' => ['Sinh' => 'Thủy','Khắc' => 'Mộc', 'Được Sinh' => 'Thổ', 'Bị Khắc' => "Hỏa"],
//             'Thủy' => ['Sinh' => 'Mộc','Khắc' => 'Hỏa', 'Được Sinh' => 'Kim', 'Bị Khắc' => "Thổ"],
//             'Mộc' => ['Sinh' => 'Hỏa','Khắc' => 'Thổ', 'Được Sinh' => 'Thủy', 'Bị Khắc' => "Kim"],
//             'Hỏa' => ['Sinh' => 'Thổ','Khắc' => 'Kim', 'Được Sinh' => 'Mộc', 'Bị Khắc' => "Thủy"],
//             'Thổ' => ['Sinh' => 'Kim', 'Khắc' => 'Thủy', 'Được Sinh' => 'Hỏa', 'Bị Khắc' => "Mộc"],
//       ];
//       foreach($nguHanh[$nguHanhQue] as $c => $v){
//             if($v == $nguHanhHao){
//                   $a = $c;
// 			$kq = true;
//             }
//       }
//       return [
// 		'ketQua' => $kq,
// 		'luan' => $a
// 	];
// }

function nguHanhSinhKhac($n1, $n2){
	$tv1 = ['Kim', 'Thủy', 'Mộc', 'Hỏa', 'Thổ'];
	$tv2 = ['Kim', 'Thủy', 'Mộc', 'Hỏa', 'Thổ','Kim', 'Thủy', 'Mộc', 'Hỏa', 'Thổ'];

	$pos1 = array_search($n1,$tv1);
	$dem = 0;
	for($i = $pos1; $i < count($tv2); $i++){
		
		if($tv2[$i] == $n2){
			break;
		}
		$dem++;
	}
	$luan = '';
	if($dem == 1){
		$luan = "$n1 <b>Sinh</b> $n2";
	}elseif($dem == 0){
		$luan = "$n1 <b>Tỷ Hòa</b>";
	}elseif($dem == 2){
		$luan = "$n1 <b>Khắc</b> $n2";
	}elseif($dem == 3){
		$luan = "$n2 <b>Khắc</b> $n1";
	}elseif($dem == 4){
		$luan = "$n2 <b>Sinh</b> $n1";
	}

	return [
		'ketQua' => true,
		'luan' => $luan,
		'code' => $dem
	];
}

function lucThan($nguHanhQue, $diaChiQue){
      $a = [];
      for($i = 0; $i < 6; $i++){
            $ss = nguHanhSinhKhac($nguHanhQue, $diaChiQue['nguHanh'][$i]);
            if($ss['code'] == 0){
                  array_push($a,'Huynh Đệ');
            }elseif($ss['code'] == 1){
                  array_push($a,'Tử Tôn');
            }elseif($ss['code'] == 2){
                  array_push($a,'Thê Tài');
            }elseif($ss['code'] == 4){
                  array_push($a,'Phụ Mẫu');
            }elseif($ss['code'] == 3){
                  array_push($a,'Quan Quỷ');
            }
      }
      return [
		'dataName' => 'Lục Thân của các Hào',
		'lucThan' => $a
	];
}


function lucThanSinhKhac($lt1, $lt2){
      $a = '';
      if($lt1 == $lt2) $a = 'Trùng';
      $lucThan = [
            'Huynh Đệ' => ['Sinh' => 'Tử Tôn','Khắc' => 'Thê Tài', 'Được Sinh' => 'Phụ Mẫu', 'Bị Khắc' => "Quan Quỷ"],
            'Tử Tôn' => ['Sinh' => 'Thê Tài','Khắc' => 'Quan Quỷ', 'Được Sinh' => 'Huynh Đệ', 'Bị Khắc' => "Phụ Mẫu"],
            'Thê Tài' => ['Sinh' => 'Quan Quỷ','Khắc' => 'Phụ Mẫu', 'Được Sinh' => 'Tử Tôn', 'Bị Khắc' => "Huynh Đệ"],
            'Quan Quỷ' => ['Sinh' => 'Phụ Mẫu','Khắc' => 'Huynh Đệ', 'Được Sinh' => 'Thê Tài', 'Bị Khắc' => "Tử Tôn"],
            'Phụ Mẫu' => ['Sinh' => 'Huynh Đệ', 'Khắc' => 'Tử Tôn', 'Được Sinh' => 'Quan Quỷ', 'Bị Khắc' => "Thê Tài"],
      ];
      foreach($lucThan[$lt1] as $c => $v){
            if($v == $lt2){
                  $a = $c;
            }
      }
      return [
		'ketQua' =>true,
		'luan' => $a
	];
}

function tamHop($c1, $c2, $all){
	$tamHop = [
		['Thân','Tý','Thìn','Thủy Cục'], // thủy cục
		['Dần','Ngọ','Tuất','Hỏa Cục'], //Hỏa cục
		['Hợi', 'Mão', 'Mùi', 'Mộc Cục'], // Mộc cục
		['Tỵ', 'Dậu','Sửu','Kim Cục'] // kim cục
		// trường sinh -- đế vượng -- mộ (xoay trong vòng trường sinh)
	];
	$kq = false;
	$luan = '';
	if($c1 != $c2){
		foreach($tamHop as $th){
			if(in_array($c1, $th)){
				if(in_array($c2, $th)){
	
					$dem = array_count_values($all);
					if(array_key_exists($th[0],$dem) && array_key_exists($th[1],$dem) && array_key_exists($th[2],$dem)){
						if($dem[$th[0]] == 1 && $dem[$th[1]] == 1 && $dem[$th[2]] == 1){
							$kq = true;
							$luan = "$c1 và $c2 tam hợp tạo $th[3]";
						}
					}
	
				}
			}
		}
	}
	return [
		'ketQua' => $kq,
		'luan' => $luan,
	];
}

function nhiHop($c1, $c2){
	$nhiHop = [
		['Tý','Sửu'],
		['Hợi','Dần'],
		['Mão','Tuất'],
		['Thìn','Dậu'],
		['Tỵ','Thân'],
		['Ngọ','Mùi'],
	];
	$kq = false;
	$luan = '';
	if($c1 != $c2){
		foreach($nhiHop as $nh){
			if(in_array($c1, $nh)){
				if(in_array($c2, $nh)){
					$kq = true;
					$luan = "$c1 <b>hợp</b> $c2";
				}
			}
		}
	}
	return [
		'ketQua' => $kq,
		'luan' => $luan,
	];
}

function nhiHai($c1, $c2){
	$nhiHai = [
		['Tuất','Dậu'],
		['Hợi','Thân'],
		['Tý','Mùi'],
		['Sửu','Ngọ'],
		['Dần','Tỵ'],
		['Mão','Thìn'],
	];
	$kq = false;
	$luan = '';
	foreach($nhiHai as $nh){
		if(in_array($c1, $nh)){
			if(in_array($c2, $nh)){
				$kq = true;
				$luan = "$c1 và $c2 hại nhau";
			}
		}
	}
	return [
		'ketQua' => $kq,
		'luan' => $luan,
	];
}

function nhiXung($c1, $c2){
	$nhiXung = [
		['Tý','Ngọ'],
		['Sửu','Mùi'],
		['Dần','Thân'],
		['Mão','Dậu'],
		['Thìn','Tuất'],
		['Tỵ','Hợi'],
	];
	$kq = false;
	$luan = '';
	if($c1 != $c2){
		foreach($nhiXung as $nx){
			if(in_array($c1, $nx)){
				if(in_array($c2, $nx)){
					$kq = true;
					$luan = "$c1 và $c2 xung nhau";
				}
			}
		}
	}
	return [
		'ketQua' => $kq,
		'luan' => $luan,
	];
}

function tuHinh($c1, $c2){
	$tuHinh = [
		['Tý', 'Mão'],
		['Thìn','Ngọ','Dậu','Hợi'] //tự hình
	];
	$a = '';
	$b = false;
	if(in_array($c1,$tuHinh[0])){
		if(in_array($c2,$tuHinh[0])){
			$a = "$c1 và $c2 hình nhau";
			$b = true;
		}
	}

	if(in_array($c1,$tuHinh[1])){
		if($c1 == $c2){
			$a = "$c1 tự hình";
			$b = true;
		}
	}


	return [
		'ketQua' => $b,
		'luan' => $a,
	];

}

function tamHinh($c1, $c2){
	$tamHinh = [
		['Dần','Tỵ','Thân'],
		['Sửu','Tuất','Mùi'],
	];

	$kq = false;
	$luan = '';

	for($i = 0; $i < 2; $i++ ){
			if(in_array($c1, $tamHinh[$i])){
				if(in_array($c2, $tamHinh[$i])){
					$a = array_search($c1,$tamHinh[$i]);
					$b =  array_search($c2,$tamHinh[$i]);

					if($a == 0 && $b == 1){
						$luan = $c1." hình ".$c2;
						$kq = true;
					}elseif($a == 1 && $b == 2){
						$kq = true;
						$luan = $c1." hình ".$c2;
					}elseif($a == 2 && $b == 0){
						$kq = true;
						$luan = $c1." hình ".$c2;
					}

					
				}
			}
	}

 return [
		'ketQua' => $kq,
		'luan' => $luan,
	];
}

function tuyetMo($c1, $c2){
	$tuyetMo = [ // tuyệt trước, mộ sau
		'Tý' => ['Tỵ','Thìn'],//
		'Sửu' => ['Tỵ','Thìn'],
		'Dần' => ['Thân','Mùi'],//
		'Mão' => ['Thân','Mùi'],//
		'Thìn' => ['Tỵ','Thìn'],
		'Tỵ' => ['Hợi','Tuất'],
		'Ngọ' => ['Hợi','Tuất'],
		'Mùi' => ['Tỵ','Thìn'],
		'Thân' => ['Dần','Sửu'],
		'Dậu' => ['Dần','Sửu'],
		'Tuất' => ['Tỵ','Thìn'],
		'Hợi' => ['Tỵ','Thìn'],//
	];
	
	$kq = false;
	$luan = $c1.", ".$c2.' Không tuyệt, không mộ';

	// if(in_array($c2, $tuyetMo[$c1])){
	// 	if(array_search($c2, $tuyetMo[$c1]) == 0){
			
	// 			$kq = true; // "2t1";
	// 			$luan =  $c1." <b>tuyệt</b> tại ".$c2;
			
	// 	}elseif(array_search($c2, $tuyetMo[$c1]) == 1){
	// 		$kq = true; //"2m1";
	// 		$luan = $c1." <b>mộ</b> tại ".$c2;
			
	// 	}
	// }

	if(in_array($c1, $tuyetMo[$c2])){
		if(array_search($c1, $tuyetMo[$c2]) == 0){
			$kq = true; // "1t2";
			$luan = $c2." <b>tuyệt</b> tại ".$c1;
		
		}elseif(array_search($c1, $tuyetMo[$c2]) == 1){
			$kq = true; //"1m2";
			$luan = $c2." <b>mộ</b> tại ".$c1;
		}
	}
	return [
		'ketQua' => $kq,
		'luan' => $luan,
	];
}

function conGiapThang($thang){
	$conGiap = [
		'Dần',
		'Mão',
		'Thìn',
		'Tỵ',
		'Ngọ',
		'Mùi',
		'Thân',
		'Dậu',
		'Tuất',
		'Hợi',
		'Tý',
		'Sửu',
	];
	$a = $thang -1;
	return $conGiap[$a];
}

function mauNguHanh($a){
	if($a == "Kim"){
		return "secondary";
	}elseif($a == "Mộc"){
		return "success";
	}elseif($a == "Thủy"){
		return "primary";
	}elseif($a == "Hỏa"){
		return "danger";
	}elseif($a == "Thổ"){
		return "dark";
	}
}

function tuanKhong($ngay){
	$tcdc = explode(' ',$ngay);
	$diaChi = [
		'Tý', 'Sửu', 'Dần', 'Mão', 'Thìn', 'Tỵ', 'Ngọ', 'Mùi', 'Thân', 'Dậu', 'Tuất', 'Hợi',
		'Tý', 'Sửu', 'Dần', 'Mão', 'Thìn', 'Tỵ', 'Ngọ', 'Mùi', 'Thân', 'Dậu', 'Tuất', 'Hợi'
	];
	$thienCan = [
		'Giáp', 'Ất', 'Bính', 'Đinh', 'Mậu', 'Kỷ', 'Canh', 'Tân', 'Nhâm', 'Quý'
	];
	$demTC =0;
	for($i = array_search($tcdc[0],$thienCan); $i < 10; $i++){
		$demTC++;
	}
	$diachiPos = array_search($tcdc[1], $diaChi);
	$kv1 = $demTC + $diachiPos ;
	$kv2 = $demTC + $diachiPos + 1;
	
	return [
		'khongVong' => [
			$diaChi[$kv1], $diaChi[$kv2]
		]
	];
}

function lucThu($ngay){
	$tc = explode(' ',$ngay);
	$lucThu = [
		"Thanh Long", "Chu Tước", "Câu Trần", "Đằng Xà", "Bạch Hổ", "Huyền Vũ",
		"Thanh Long", "Chu Tước", "Câu Trần", "Đằng Xà", "Bạch Hổ", "Huyền Vũ",
	];
	$pos = 0;
	if($tc[0] == 'Giáp' || $tc[0] == 'Ất'){
		$pos = array_search('Thanh Long', $lucThu);
	}elseif($tc[0] == 'Bính' || $tc[0] == 'Đinh'){
		$pos = array_search('Chu Tước', $lucThu);
	}elseif($tc[0] == 'Mậu' ){
		$pos = array_search('Câu Trần', $lucThu);
	}elseif($tc[0] == 'Kỷ' ){
		$pos = array_search('Đằng Xà', $lucThu);
	}elseif($tc[0] == 'Canh' || $tc[0] == 'Tân'){
		$pos = array_search('Bạch Hổ', $lucThu);
	}elseif($tc[0] == 'Nhâm' || $tc[0] == 'Quý'){
		$pos = array_search('Huyền Vũ', $lucThu);
	}
	$a = [];
	for($i = $pos; $i < $pos+6; $i++){
		array_push($a, $lucThu[$i]);
	}
	return [
		'lucThu' => $a
	];
}
function nguHanhTheoDiaChi($dc){
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
	return $diaChiNguHanh[$dc];
}

function vongTruongSinh($nguHanh){
	$vts = [
		'Trường Sinh', 'Mộc Dục', 'Quan Đới', 'Lâm Quan', 'Đế Vượng', 'Suy', 'Bệnh', 'Tử', 'Mộ', 'Tuyệt', 'Thai', 'Dưỡng',
		'Trường Sinh', 'Mộc Dục', 'Quan Đới', 'Lâm Quan', 'Đế Vượng', 'Suy', 'Bệnh', 'Tử', 'Mộ', 'Tuyệt', 'Thai', 'Dưỡng', 
	];
	$tamHop = [
		'Thủy' => ['Thân','Tý','Thìn'], // thủy cục
		'Hỏa' => ['Dần','Ngọ','Tuất'], //Hỏa cục
		'Mộc' => ['Hợi', 'Mão', 'Mùi'], // Mộc cục
		'Kim' => ['Tỵ', 'Dậu','Sửu'], // kim cục
		'Thổ' => ['Thân','Tý','Thìn'],// Thổ dùng Thủy cục
	];
	$diaChi1 = [
		'Tý'=> 0, 'Sửu'=> 1, 'Dần'=> 2, 'Mão'=> 3, 'Thìn'=> 4, 'Tỵ'=> 5, 'Ngọ'=> 6, 'Mùi'=> 7, 'Thân'=> 8, 'Dậu'=> 9, 'Tuất'=> 10, 'Hợi'=> 11
	];
	
	$diaChi = [
		'Tý', 'Sửu', 'Dần', 'Mão', 'Thìn', 'Tỵ', 'Ngọ', 'Mùi', 'Thân', 'Dậu', 'Tuất', 'Hợi',
		'Tý', 'Sửu', 'Dần', 'Mão', 'Thìn', 'Tỵ', 'Ngọ', 'Mùi', 'Thân', 'Dậu', 'Tuất', 'Hợi'
	];
	$pos = $diaChi1[$tamHop[$nguHanh][0]];
	$a = [];
	$dem = 0;
	for($i = $pos; $i < $pos +12; $i++){
		$a[$diaChi[$i]] = $vts[$dem];
		$dem++;
	}

	return $a;
}



function gieoQueMaiHoa ($n, $time){
	$diaChi = ['Tý', 'Sửu', 'Dần', 'Mão', 'Thìn', 'Tỵ', 'Ngọ', 'Mùi', 'Thân', 'Dậu', 'Tuất', 'Hợi'];
	$nam = explode(' ',$n);

	$soNam = array_search($nam[1],$diaChi) + 1;

	$gio = [
		'0' => 'Tý',
		'1' => 'Sửu',
		'2' => 'Sửu',
		'3' => 'Dần',
		'4' => 'Dần',
		'5' => 'Mão',
		'6' => 'Mão',
		'7' => 'Thìn',
		'8' => 'Thìn',
		'9' => 'Tỵ',
		'10' => 'Tỵ',
		'11' => 'Ngọ',
		'12' => 'Ngọ',
		'13' => 'Mùi',
		'14' => 'Mùi',
		'15' => 'Thân',
		'16' => 'Thân',
		'17' => 'Dậu',
		'18' => 'Dậu',
		'19' => 'Tuất',
		'20' => 'Tuất',
		'21' => 'Hợi',
		'22' => 'Hợi',
		'23' => 'Tý',
	];
	$soGio = array_search($gio[$time[3]],$diaChi) + 1;

	$queThuong = ($soNam + $time[0] + $time[1]) % 8;
	if($queThuong == 0){
		$queThuong = 8;
	}
	$queHa = ($soNam + $time[0] + $time[1] + $soGio) % 8;
	if($queHa == 0){
		$queHa = 8;
	}
	$haoDong = ($soNam + $time[0] + $time[1] + $soGio) % 6;
	if($haoDong == 0){
		$haoDong = 6;
	}
	return [
		'thuong' => $queThuong,
		'ha' => $queHa,
		'dong' => [$haoDong],
	];
}


function gieoQueMaiHoaBongDa ($n, $time,$doi1){
	$diaChi = ['Tý', 'Sửu', 'Dần', 'Mão', 'Thìn', 'Tỵ', 'Ngọ', 'Mùi', 'Thân', 'Dậu', 'Tuất', 'Hợi'];
	$nam = explode(' ',$n);
	$d = str_split($doi1,1);
	$d1 = count($d);
	// $d2 = count($doi2);

	$soNam = array_search($nam[1],$diaChi) + 1;

	$gio = [
		'0' => 'Tý',
		'1' => 'Sửu',
		'2' => 'Sửu',
		'3' => 'Dần',
		'4' => 'Dần',
		'5' => 'Mão',
		'6' => 'Mão',
		'7' => 'Thìn',
		'8' => 'Thìn',
		'9' => 'Tỵ',
		'10' => 'Tỵ',
		'11' => 'Ngọ',
		'12' => 'Ngọ',
		'13' => 'Mùi',
		'14' => 'Mùi',
		'15' => 'Thân',
		'16' => 'Thân',
		'17' => 'Dậu',
		'18' => 'Dậu',
		'19' => 'Tuất',
		'20' => 'Tuất',
		'21' => 'Hợi',
		'22' => 'Hợi',
		'23' => 'Tý',
	];
	$soGio = array_search($gio[$time[3]],$diaChi) + 1;

	$queThuong = ($soNam + $time[0] + $time[1] + $d1) % 8;
	if($queThuong == 0){
		$queThuong = 8;
	}
	$queHa = ($soNam + $time[0] + $time[1] + $soGio + $d1) % 8;
	if($queHa == 0){
		$queHa = 8;
	}
	$haoDong = ($soNam + $time[0] + $time[1] + $soGio + $d1) % 6;
	if($haoDong == 0){
		$haoDong = 6;
	}
	return [
		'thuong' => $queThuong,
		'ha' => $queHa,
		'dong' => [$haoDong],
	];
}

function vuongTuong($a, $b){
	$nguHanh = ['Kim', 'Thủy', 'Mộc', 'Hỏa', 'Thổ','Kim', 'Thủy', 'Mộc', 'Hỏa', 'Thổ'];

	$nguHanh1 = ['Kim'=> 0, 'Thủy'=> 1, 'Mộc'=>2, 'Hỏa'=>3, 'Thổ'=>4];

	$pa = $nguHanh1[$a];
	$dem = 0;
	$diem = 0;
	for($i = $pa; $i < $pa+5; $i++){
		if($nguHanh[$i] == $b){
			break;
		}
		$dem++;

	}
	$kq = '';
	if($dem == 1){
		$kq = 'Tướng';
		$diem = 3;
	}elseif($dem == 2){
		$kq = 'Tử';
		$diem = 0;
	}elseif($dem == 3){
		$kq = 'Tù';
		$diem = 1;
	}elseif($dem == 4){
		$kq = 'Hưu';
		$diem = 2;
	}elseif($dem == 0){
		$kq = 'Vượng';
		$diem = 4;
	}

	return [
		'ketQua' =>$dem,
		'luan' =>$kq,
		'code'=>$dem,
		'diem' => $diem
	];

}


function sosanhNhatNguyet($a, $b, $allDiaChi){
	$kq = 0;
	$luan = '';
	if($a != $b){
		$tuyetMo = tuyetMo($a, $b);
            if($tuyetMo['ketQua']){
                  $luan =  $tuyetMo['luan'];
			$kq = 1;
            }else{
                  $tamHop = tamHop($a, $b, $allDiaChi);
                  if($tamHop['ketQua']){
                        $luan = $tamHop['luan'];
				$kq = 2;
                  }else{
                        $nhiHop = nhiHop($a, $b);
				if($nhiHop['ketQua']){
					$luan = $nhiHop['luan'];
					$kq = 3;
				}else{
					$nhiXung = nhiXung($a, $b);
					if($nhiXung['ketQua']){
						$luan = $nhiXung['luan'];
						$kq = 4;
					}else{
						$c = vuongTuong(nguHanhTheoDiaChi($a), nguHanhTheoDiaChi($b));
						$luan = $c['luan']; 
						if($c['ketQua'] == 1 || $c['ketQua'] == 0){
							$kq = 5;
						}
					}
				}
                  }
            }
	}else{
		$luan = 'Vượng';
		$kq = 6;
	}
	return [
		'ketQua' => $kq,
		'luan' => $luan
	];
}

function sosanhHao($a, $b, $allDiaChi){
	$kq = 0;
	$luan = '';
	$tuyetMo = tuyetMo($a, $b);
            if($tuyetMo['ketQua']){
                  $luan = $tuyetMo['luan'];
			$kq = 1;
            }else{
                  $tamHop = tamHop($a, $b, $allDiaChi);
                  if($tamHop['ketQua']){
                        $luan = $tamHop['luan'];
				$kq = 2;
                  }else{
                        $nhiHop = nhiHop($a, $b);
				if($nhiHop['ketQua']){
					$luan = $nhiHop['luan'];
					$kq = 3;
				}else{
					$nhiXung = nhiXung($a, $b);
					if($nhiXung['ketQua']){
						$luan = $nhiXung['luan'];
						$kq = 4;
					}else{
						$d = nguHanhTheoDiaChi($a);
						$e = nguHanhTheoDiaChi($b);
						$nhsk = nguHanhSinhKhac($d, $e);
						if($nhsk['ketQua']){
							$luan = $nhsk['luan'];
							if($nhsk['code'] == 1){
								$kq = 5;
							}
						}
					}
				}
                  }
            }
	return [
		'ketQua' => $kq,
		'luan' =>$luan
	];
}

function sosanhHaoBien($a, $b){
	$kq = 0;
	$luan = '';
	$tuyetMo = tuyetMo($a, $b);
            if($tuyetMo['ketQua']){
                  $luan = $tuyetMo['luan'];
			$kq = 1;
            }else{
                        $nhiHop = nhiHop($a, $b);
				if($nhiHop['ketQua']){
					$luan = $nhiHop['luan'];
					$kq = 3;
				}else{
					$nhiXung = nhiXung($a, $b);
					if($nhiXung['ketQua']){
						$luan = $nhiXung['luan'];
						$kq = 4;
					}else{
						$d = nguHanhTheoDiaChi($a);
						$e = nguHanhTheoDiaChi($b);
						$nhsk = nguHanhSinhKhac($d, $e);
						if($nhsk['ketQua']){
							$luan = $nhsk['luan'];
							if($nhsk['code'] == 1){
								$kq = 5;
							}
						}
					}
				}
                  }
            
	return [
		'ketQua' => $kq,
		'luan' =>$luan
	];
}

function luanLucThanLucThu($than, $thu){
	$thuVien = [
		'Thanh Long' => [
			'Huynh Đệ' => 'Là đồng bào huynh đệ tỷ muội , là chính nghĩa bằng hữu , hoặc chính trực của huynh đệ tỷ muội . Đồng bạn bằng hữu , hoặc là chủ cố chấp đã thấy , đại biểu có văn thư bên trên. Pháp luật thượng của phân tranh . Hoặc khế ước thượng của bất hoà , thanh long vậy chủ văn thư loại tin tức này .',
			'Tử Tôn' => 'Là thân sinh tử nữ , là dòng chính vãn bối , là tửu sắc vui đùa , giải trí , là sáng tác , biểu thị , tuyên truyền vật liệu , là rộng báo cho biết , loa phóng thanh , là vui vẻ , là ngôn ngữ biểu đạt , là tài văn chương các loại thuộc về nghệ thuật , phương diện kỹ thuật của sáng tác .',
			'Thê Tài' => 'Là chánh đạo của tài , là tửu sắc vui mừng của tài; nam chiêm cưới là kết tóc vợ , nếu như có thanh long lâm tài sinh hợp hào Thế , có thanh long nhi nữ hoặc tốt cách ăn mặc nhi nữ người chăm sóc . Như chiêm vận trình liền có phúc lộc của tài , phúc khí vân vân; suy đoán tài vận thật là tiền lương , dựa vào kinh doanh bình thường đoạt được của tài .',
			'Quan Quỷ' => 'Đại biểu pháp luật . Chủ chính nghĩa quản thúc , pháp luật , Quan cấp , giấy chứng nhận ( tốt nghiệp danh dự ) đại biểu trị an điều lệ , pháp luật pháp quy , điều lệ điều . Nữ nhân suy đoán cưới là trượng phu , đại biểu cảnh xét , quan toà , công an , công kiểm pháp bọn người viên , cũng đại biểu tửu sắc; suy đoán gia đình Quan quỷ lâm thanh long , đại biểu thần vị , tiên vị loại này tượng; thanh long lâm kim hào Quan quỷ , đại biểu phật đường , phật giáo; thanh long lâm quỷ , đại biểu tổ tiên nhãn hiệu vị . Như suy đoán gia đình tại hào hai giống như này không ngừng , như hào hai lâm Đằng xà liền thị địa tiên một loại .',
			'Phụ Mẫu' => 'Đại biểu văn thư giấy chứng nhận , pháp luật điều , trị an điều lệ ( đây chính là tin tức định vị ) hợp đồng , khế ước , hóa đơn , chứng từ , trương mục , kinh văn ( long chủ mộc , chủ từ thiện tín ngưỡng ) , đại biểu cha mẹ ruột ( chủ chính của ) , đại biểu quốc hữu xí nghiệp chỉ vị , đại biểu trường học vân vân.',
			'Khái Quát' => 'Thanh long đại biểu đông phương , thuộc mộc , đại biểu đại mộc , đại biểu đại thụ , thẳng đấy, chính trực đấy, chủ chính , đồ mảnh mà thông suốt của tính . Như trụ tử , cột điện , thô mà thẳng chi vật . Đại biểu tỵ , sông lớn , dòng sông ( trên trời long chủ mưa , dưới mặt đất long chủ sông , biển ) . Thanh long cũng chủ vui mừng sự tình , chủ tửu sắc tâm ý . Mặt khác thanh long thuộc giáp mộc , giáp mộc chủ thiên tài tính chất , thiên tài chủ nữ nhân , hưởng thụ . Suy đoán công việc , nhân tính , chức nghiệp lúc, thanh long lâm thế dụng , chủ người này có tham gia công chức , quốc gia xí nghiệp cơ quan công việc , sở tòng sự tình công việc tương đối hợp pháp , vậy có tửu điếm , phòng khiêu vũ , trang trí , trang trí , thanh long vượng yêu nhau cách ăn mặc , chủ chánh nghĩa , ngay thẳng , quang minh lỗi lạc , những đặc tính này . Như hưu tù là nhân quyết giữ ý mình , cứng nhắc .',
		],
		'Chu Tước' => [
			'Huynh Đệ' => 'Phát động có khẩu thiệt tranh chấp , phát động có phân tranh , chủ cãi lộn , biện luận , diễn thuyết , chủ đa thị phi tranh đấu .',
			'Tử Tôn' => 'Đại biểu âm nhạc , ca khúc , vui đùa nơi chốn , như phòng ca múa , quán bar , giải trí tràng các loại công việc phương diện , là phát thanh viên , xướng ngôn viên , hướng dẫn du lịch , sao ca nhạc , diễn viên hài , thuyết thư đấy, hát hí khúc của , coi như mệnh của các loại, ăn lương loại chức nghiệp , vẫn đại biểu sủng vật . Chó , heo , chim , cũng chủ niệm phật , tụng kinh , tuyên truyền , tiếng kêu , tiếng la , tiếng còi vân vân. Hào Tử tôn bản thân cũng đại biểu bàn bạc ý nghĩa , hào Tử tôn vẫn đại biểu kỹ nghệ , kỹ thuật .',
			'Thê Tài' => 'Đại biểu gửi tiền , tiền gửi ngân hàng , chi phiếu ( có văn tự của tài ) , công việc nói chuyện đấy, dựa vào miệng kiếm tiền của doanh sinh; nam suy đoán cưới , rất có thể đối phương có tiểu hài tử , hoặc chủ nữ nhân phương tốt nói , tốt ca hát , miệng vô già cản , năng lực ta thiện biện .',
			'Quan Quỷ' => 'Liền chủ quan không phải khẩu thiệt , nếu suy đoán tai họa , như lửa Quan lâm chu tước , chủ hỏa tai họa . Thủy Quan lâm chu tước , chủ thủy tai , như suy đoán địa khu hoả hoạn , thủy tai không nhất định là đối hào Thế uy hiếp , thủy tai tất nhiên khu tính .
			Suy đoán phong thuỷ , chu tước lâm quan khắc thế dụng , là hỏa hình sát , là hỏa tai họa , hoặc là là thanh sát , làm quan không phải .',
			'Phụ Mẫu' => 'Đại biểu thư , điện báo , điện thoại , hệ thống tin nhắn , đại biểu đơn kiện , lời khai , đĩa nhạc , băng nhạc , đĩa cd , băng ghi âm , lục tượng đái , ngôn ngữ học tập cơ . Suy đoán công việc , là giáo sư , diễn thuyết gia , văn nhân mặc khách , diễn nghệ giới , thu âm sư , thông tin , giao thông , văn hóa sự nghiệp , gởi thư công việc , hoặc dựa vào miệng , văn hóa , văn tự loại của ngành nghề .',
			'Khái Quát' => 'Chu tước chủ khẩu thiệt quan phi , là nam phương , ngũ hành thuộc hỏa , chủ tiếng vang , chủ văn thư , chủ văn minh , chủ tín hơi thở . Cũng đại biểu nghĩa rộng của chim , đại biểu tin tức , thông tin sự vật , năng lực phát ra âm thanh loại sự vật , gửi tiền qua bưu điện . Như tiếng ca , điện thoại , nói chuyện , diễn thuyết , dựa vào miệng , dựa vào thanh âm biểu đạt của sự vật . Như suy đoán công việc đại biểu phiên dịch , lão sư , luật sư , truyền giáo sĩ , dự đoán sư vân vân. Chu tước phần kết ấn , chủ khẩu thiệt , thế lâm chu tước vượng tướng , biểu thị người này tính cách tượng hỏa nhất tốt vội vàng , nhiệt tình đa lễ , là nhân thích nói , khẩu tài tốt, giỏi về biểu đạt , dễ nói buồn cười , chu tước hưu tù chủ nhân vội vàng xao động , tốt mắng chửi người , yêu cãi lộn . Kỳ chức nghiệp thích hợp vu lão sư , tuyên truyền , chào hàng , loa phóng thanh vân vân dựa vào miệng , văn hóa phương diện này sự nghiệp công việc .',
		],
		'Câu Trần' => [
			'Huynh Đệ' => 'Câu trần là bằng hữu , đồng sự , người quen biết cũ , là đối tác , đồng bọn , cũng chủ kéo bè kết phái , đội . Suy đoán kiện cáo , câu trần lâm hào Huynh đệ động có đoàn đội gây án của tượng; suy đoán cầu tài , Huynh lâm câu trần phát động , nói rõ bởi vì đồng sự bằng hữu hoặc người quen gây nên phá tài . Hoặc bởi vì người quen biết cũ gây nên phá tài .',
			'Tử Tôn' => 'Chiêm công việc là dựa vào kỹ thuật , tay nghề kiếm tiền ( tử tôn là tài nguyên , câu trần chủ kỹ nghệ ) . Dựa vào lôi kéo , tuyên truyền ( hào Tử tôn đại biểu tuyên truyền ) mà đắc tài . Câu trần lâm hào Tử tôn chịu khắc . Hoặc hào khác lâm câu trần khắc thế , đô chủ có bệnh hoặc lao ngục tai ương . Còn là dắt tới lĩnh đi theo người đi sủng vật . Như suy đoán bệnh . Hào Tử tôn lâm câu trần chịu khắc hoặc hào khác lâm câu trần khắc thế , chủ bệnh mãn tính hoặc bệnh truyền nhiễm , đây là chỉ suy đoán tử nữ bệnh lúc, .',
			'Thê Tài' => 'Nam chiêm cưới chủ nữ nhân mới có chân đứng hai thuyền của tượng: nữ nhân chiêm cưới vì tình địch , là nam phương của tình nhân cũ: chiêm cầu tài là thổ tài , là bất động sản của tài , là kỹ nghệ có được của tài; suy đoán vận khí thế hào hưu tù , Thê tài lâm câu trần vượng động khắc thế , chủ chịu nữ nhân của hại , hoặc chịu chính mình quen thuộc nữ nhân dính líu mà chuốc họa , nếu sinh các ngươi liền phải phương diện này của nữ nhân của trợ giúp .',
			'Quan Quỷ' => 'Như suy đoán buôn bán , là quen thuộc hộ khách . Nữ nhân chiêm cưới , chủ nam mới có chân đứng hai thuyền của tượng , chủ nó nam hữu cùng cái khác nữ nhân có cấu kết nhân tình của tượng . Nam suy đoán cưới vì tình địch , chủ nữ nhân phương của tình nhân cũ: chiêm kiện cáo là rắc rối , kiện cáo không dứt , không có đầu mối ( chủ chạp ); chiêm nhân tính cách , cũng chủ chạp , đại biểu sửu; chiêm u buồn chủ buồn rầu thời gian dài; chiêm bệnh , chủ ôn dịch , chủ bệnh mãn tính , chủ bệnh truyền nhiễm , chủ sưng , khối u; suy đoán nghề nghiệp là bất động sản công việc , bất động sản của Quan , cũng có thể là sở câu lưu , trại tạm giam , ngục giam phương diện này của chức nghiệp Quan vị .',
			'Phụ Mẫu' => 'Cùng xin chủ trì trệ , thời gian rất lâu làm không được , chủ nhận cách; chiêm xuất hành , chủ khổ cực , có liên lụy ( bởi vì cha hào là hành lý của nguyên nhân ) , có dừng lại; chiêm sinh con chủ sanh khó ( câu trần lâm hào Phụ khắc tử tôn . Lại câu trần chủ chạp sinh không ra tới. ) lấy phát động đoán; chiêm thủ tục là bất động sản , hợp đồng , khế ước , văn thư .',
			'Khái Quát' => 'Phương vị thay mặt trong ngoài , thuộc thổ . Câu trần chủ ruộng đất lao dịch , câu lưu thẩm tra của tượng , câu trần đại biểu dính líu , có nhiều người tham dự của tượng , câu trần vẫn chủ chạp , suy đoán bệnh chủ bệnh mãn tính . Vẫn chủ văn chương , khế ước . Câu trần vẫn chủ thổ kiến công trình ( nếu câu trần lâm thổ , kim hào càng chủ thổ xây ) , câu trần còn có một loại tin tức chủ cũ , chủ già đấy, suy ra là người quen , chủ chuyện xưa: câu trần chủ thời gian lâu , tại suy đoán phong thuỷ cắn câu trần chủ ở giữa giải đất , vẫn chủ ngoặt biến góc quanh; suy đoán tính cách chức nghiệp phương diện , câu trần chủ kỹ thuật chuyên nghiệp , chủ đồng bạn hợp tác; chiêm tính cách câu trần vượng tướng chủ nhân thành thực , phác thực , trung hậu , câu trần hưu tù chủ chủ xử sự làm người chết vịn khô khan , thiếu khôn khéo , tự mình sức ràng buộc mạnh, câu trần có trói giúp tâm ý , cho nên sinh tự mình trói buộc .',
		],
		'Đằng Xà' => [
			'Huynh Đệ' => 'Chiêm kiện cáo khắc thế , dụng , chủ có lao ngục tai ương; suy đoán hùn vốn buôn bán , phòng đối phương cố ý xảo thiết lập cái bẫy hại chính mình.',
			'Tử Tôn' => 'Chiếm hữu không nữ nhân lúc, là đã định trước có vậy nữ nhân , như chiêm cho nữ nhân cát hung , như đối mặt Đằng xà chịu khắc , một mặt có bệnh quấn thân , một phương diện khác cũng chủ vậy nữ nhân có lao ngục tai ương ( bởi vì hợp chất hữu cơ tỵ có câu lưu , buộc chặc của tượng ) . Tử tôn cầm địa lâm hợp chất hữu cơ tỵ , chủ cái này nhân tâm cơ nhiều, khoe khoang khoác lác không được thực ( tử tôn đại biểu nói , Đằng xà chủ nhẹ , hợp lại liền có cái này loại tượng ) , một phương diện khác cũng có thể nói thủ đoạn cao minh , xử sự khôn khéo , khéo léo , thích hợp tại ngoại giao tiếp đãi công việc .',
			'Thê Tài' => 'Nam chiêm cưới là trong số mệnh vợ ( không đổi Ly tế ); buôn bán là nên được của tài ( đã định trước ) , là xảo thủ , là dựa vào thủ đoạn , cơ trí có được của tài; suy đoán bệnh ( suy đoán thê bệnh ) , chủ có nhẹ bệnh; như suy đoán kiện cáo , thê có lao ngục tai ương; suy đoán vận khí , như Thê tài khắc thế , liền có chịu nữ nhân của hại , bị nữ nhân trêu cợt hoặc bởi vì tiền công tài phương diện có giả tạo , khiến hào Thế chịu hại , lừa gạt . Như Thê tài trì Thế lâm Đằng xà , liền có cái này phương không ngừng tin tức .',
			'Quan Quỷ' => 'Chiêm kiện cáo là hung tai họa , nếu phát động khắc hào Thế , dụng thần . Chủ có lao ngục tai ương . Suy đoán vận khí , nếu hào Quan phát động khắc thế , nói rõ có tiểu nhân hoặc nam nhân thiết lập cái bẫy , đùa nghịch thủ đoạn hãm hại . Đằng xà trì Thế , chủ nhân thủ đoạn cao , khéo léo; giải mộng , chủ có ác mộng , khiến cho người kỳ quái dị , sợ bóng sợ gió chi mộng; chiêm gia trạch , chủ có quái dị sự tình phát sinh ( lâm quan hào ) có yêu , tiên , quỷ quái , hoặc có thanh âm dị thường động tĩnh ( hào Quan tại hai , ba, bốn hào nhân chủ gia trong môn ); chiêm bệnh , là giả bệnh , bệnh lạ , y viện khám bệnh không ngừng không ra quái lạ bệnh , vẫn có thần kinh phương hai của chứng bệnh . Nữ nhân chiêm tế , hào Quan quỷ lâm Đằng xà , chủ trong số mệnh đã định trước của trượng phu ( bởi vì có buộc chặc tâm ý ) .',
			'Phụ Mẫu' => 'Khắc thế là chịu văn thư , khế ước trói buộc , chịu hợp đồng sở khiên chế; suy đoán phụ mẫu , chủ phụ mẫu có bệnh lạ , quái sự hoặc thần kinh không bình thường , có nhẹ bệnh , suy nghĩ quá nặng , đa nghi; suy đoán hợp đồng , nếu hào Phụ lâm Đằng xà khắc hào Thế , cũng chủ chỗ ký hợp đồng , ở bên trong cho thượng đối phương xảo thiết lập cái bẫy hại chính mình hay là vô hiệu hợp đồng , bằng chứng , là giả chứng giả kiện vân vân ( chính là không được thực , nội dung có nhẹ ): suy đoán bình an , Đằng xà lâm hào Phụ phát động khắc hào Thế hoặc khắc dụng thần , chủ có xe họa tai ương ( Đằng xà là đường, hào Phụ là xe của nguyên nhân ) .',
			'Khái Quát' => 'Phương vị trung ương kỷ thổ tính chất , Đằng xà chủ sợ bóng sợ gió quái dị sự tình , cũng chủ lao ngục tai ương . Đằng xà đại biểu sự vật: tỵ , mãng xà , thần , quỷ , tiên , yểu , quái sự , chuyện lạ ( khó mà lý giải thích sự tình ) , đại biểu vừa nhỏ vừa dài chi vật , có quăn xoắn hình chi vật , như dây thừng , tuyến , ống mềm , năng lực quấn quanh chi vật: đại biểu mưa nhỏ , tiểu hà . Tại phong thủy học bên trên đại biểu đường ( là đường nhỏ , vòng vo kỳ khúc đường nhỏ ) , xà chủ buộc chặc vờn quanh , quấy nhiễu , quấn quanh , có mang còng tay của tượng , chiêm tính cách Đằng xà vượng tướng chủ là nhân khéo léo , có thủ đoạn , hưu tù chủ nhân tính tình cổ quái , dối trá , giả tạo , tâm cơ nhiều, khoe khoang khoác lác không được thực .',
		],
		'Bạch Hổ' => [
			'Huynh Đệ' => 'Chiêm ngang hàng có hung tai họa , bệnh tổn thương quấn thân , tai nạn đổ máu , tranh đoạt tranh đấu sự tình . Như huynh hào lâm bạch hổ , cướp tiền là cướp đại tài ( liền có cầm đao cướp bóc của tượng ) , đây là suy đoán tài vận hoặc vận khí lúc, liền có cái này loại tượng . Huynh lâm bạch hổ phát động , chủ có tai nạn đổ máu , đánh nhau thấy máu .',
			'Tử Tôn' => 'Chủ tử nữ nhân tiểu bối có bệnh thương vong hiện tượng , ông chủ nhỏ đứa bé nghịch ngợm không thể hợp quản . Ông chủ nhỏ đứa bé nhìn khoẻ mạnh kháu khỉnh . Như bị khắc có lao ngục , tai nạn đổ máu ( tức Quan quỷ trì Thế bị bạch hổ động khắc chủ lao ngục huyết quang ) . Như bạch hổ lâm tử tôn phát tài , chủ dựa vào tuyên truyền , oanh động đắc tài , tuyên truyền diện nóng nảy . Bạch hổ phát động sinh thế dụng liền có phương diện tốt tin tức , khắc thế dụng liền không tốt, có xấu phương diện tin tức .
			Suy đoán tử tôn như vượng tướng chịu vốn liền chủ phương diện tốt , xuất nhân tài . Nếu hào Tử tôn thể tù chịu khắc hoặc gặp không , liền chủ tử vong , hung tai họa tai vạ bất ngờ .',
			'Thê Tài' => 'Chiêm bình an là có tiền , nếu có bệnh ( tài vì tiền , bạch hổ chủ nhiều ) , nam chiêm cưới , chủ nữ nhân mới có bệnh , như vượng tướng lúc chủ nữ nhân phương thân thể đầy đặn , trắng nõn; bạch hổ lâm tài sinh thế , chủ bộc phát hoặc là tiền của phi nghĩa , được tang sự , tai hoạ của tài ( nhà có tang sự có người đuổi lễ; còn có hoa phạm vi khách điếm , đoán nghĩa địa phong thuỷ chờ đến đến tiền , đều là loại tang sự của tài . Thanh long chủ việc vui của tài , vui đùa của tài , hình kết hôn bằng nhau ) . Bạch hổ lâm tài vẫn chủ được tính nguy hiểm làm việc của tài ( làm đặc kỹ động tác , bắt được lưu manh , chống lũ cứu tế vân vân ) .',
			'Quan Quỷ' => 'Suy đoán vận khí phát động khắc thế , chủ có tai nạn đổ máu , lao ngục tai ương , nghiêm trọng nhân có tử vong tai ương; suy đoán phong thuỷ , hào hai lâm bạch hổ giá trị hào Quan , vượng làm vui thời gian sử dụng . Chủ gia bên trong có nắm đại quyền sanh sát nhân ( công kiểm pháp , quân đội ) , hưu tù chủ gia bên trong có nổ tung chết , hung người chết . Bạch hổ lâm bất luận hào khắc hào Thế cũng là như thế .',
			'Phụ Mẫu' => 'Chủ bị thương , suy đoán trưởng bối chủ trưởng bối có bệnh tổn thương tai ương ( nếu hào Thế lâm quan lâm tự hổ , chủ trắng tay bị hao tổn ); suy đoán gia đình , chủ có tang sự , đồ tang , phơi hào hai cũng khả năng có tự sự tình , như tự hổ lâm kim hào , lại lâm hào Phụ mẫu ( phụ khắc tử tôn ) , có thể có thể vì giết cẩu ( cũng khả năng là ngoại khoa phẫu thuật đại phu ) .',
			'Khái Quát' => 'Bạch hổ là phương tây phương , thuộc kim , vượng tướng chủ tính cách mãnh liệt , dũng cảm , oanh oanh liệt liệt , khí thế hùng vĩ , bạch hổ hưu tù trì Thế chủ nhân tính cách trầm ổn , lòng dạ sâu , giỏi về tâm kế , là nhân nghiêm túc có sát khí . Bạch hổ chủ hung tai họa tai vạ bất ngờ , chủ bệnh tổn thương tai ương , lao ngục tai ương , tai nạn đổ máu , chủ phong ba hoặc là thế tới hung mãnh thế . Chiêm chức nghiệp có khả năng là y sinh , luật sư , đồ tể . Tự hổ vẫn đại biểu cứng rắn chi vật , kim loại vật , tảng đá , là mãnh thú , hung khí . Bạch hổ chủ đồ tang , tang sự . Suy đoán nhân thể , bạch hổ lâm thế dụng , chủ nhân người mập ( vượng tướng lúc ) , diện ác , trắng nõn . Là nhân làm việc có sức sống sừng , không được khôn khéo , gấp gáp . ',
		],
		'Huyền Vũ' => [
			'Huynh Đệ' => 'Chủ lừa gạt , lừa gạt , che đậy , trộm cướp; suy đoán tài , Huynh hào lâm huyền vũ , tiền tiêu tại ai vị sự tình; suy đoán huynh đệ bằng hữu , chủ huynh đệ bằng hữu có khó khăn khó nói , huynh đệ bằng hữu khả năng làm đạo tặc , bị khắc khả năng bị trộm hoặc bởi vì đánh bạc thua tiền vân vân.',
			'Tử Tôn' => 'Đại biểu tìm vui làm mừng ( âm u của nơi hẻo lánh ) , có không chính đáng của tính hành vi . Như huyền vũ sinh thế , đại biểu tâm tình thư sướng , được tiểu bối thầm đưa tiền tài , như huyền vũ phút cuối cùng tôn sinh hào Thế , có lẽ sẽ có tìm vui làm mừng sự tình .
			Như suy đoán tiểu bối , có thể nhỏ đứa bé mất đi , lạc đường của tượng , như chỗ suy đoán tiểu bối tuổi tác lớn một ít , khả năng có hành động trái luật , có hành động ăn trộm , có ám muội , có không thể cho ai biết của bí mật , như bị khắc , khả năng bị câu lưu .
			Tử tôn lâm huyền vũ khắc thế , khả năng có người ở bối nói chính mình nói xấu ( hào Tử tôn đại biểu nói ) , đặc biệt sinh thế nói rõ sau lưng nói tốt , tử tôn đại biểu hành động , vận động , cũng khả năng ngầm hành động .',
			'Thê Tài' => 'Cái này tài là không thể công khai của tài , không phải chánh đạo của tài , ám muội của tài , cờ bạc của tài , hắc đạo của tài , tham ô nhận hối lộ của tài , buôn lậu buôn lậu thuốc phiện của tài , trốn thuế vân vân phi pháp của tài .
			Như suy đoán cưới chủ thê hoặc đối tượng phong lưu ( ứng lâm huyền vũ ) , có yêu đương vụng trộm sự tình . Nếu hào Thế lâm huyền vũ , chính mình cũng là có tư ẩn sự tình . Nếu suy đoán cưới , tài , Quan , ứng lâm huyền vũ có mờ ám sự tình , lâm câu trần thuộc chân đứng hai thuyền: suy đoán cầu tài , như tài lâm huyền vũ sinh hào Thế , nói rõ được phương diện này của tài , nếu khắc hào Thế , nói rõ bởi vì những phương diện này gặp nạn , nếu thế lâm những phương diện này đấy, nói rõ là làm phương diện này của nghề .    ( nói rõ ngươi tài làm trái pháp tính , lai lịch không rõ ràng ) .',
			'Quan Quỷ' => 'Làm đạo tặc , như khắc hào Thế làm chăn trộm của tượng . Thế lâm quan quỷ lâm huyền vũ , mình là đầu trộm đuôi cướp ( đầu trộm đuôi cướp thực tế liền là kẻ trộm ) , hoặc là là hắc đạo nhân , buôn lậu buôn lậu thuốc phiện , phạm pháp nhân . Nữ nhân suy đoán cưới chủ phu bất chính , phong lưu; suy đoán phong thuỷ chủ chịu thủy hại , dễ có bệnh lây qua đường sinh dục , bệnh thận .',
			'Phụ Mẫu' => 'Suy đoán văn thư huyền vũ lâm phụ khắc thế dụng , chủ văn thư là giả , không hề thực của tượng hoặc giấy chứng nhận giả: thì kiện cáo , phụ mẫu lâm huyền vũ , chủ chứng cứ là giả , có làm ngụy chứng của tượng; như suy đoán mua xe vân vân sự tình , chủ xe thủ tục , lai lịch vân vân có làm giả , hoặc giấu diếm sự tình thực hiện tượng ( hoặc xe có bệnh , đổi mới của láo xưng là tách mới , cũng khả năng là trộm đến của xe ): suy đoán trưởng bối , chủ trưởng bối có khó khăn khó nói , nhận được một một ít không thể công khai sự tình quấy nhiễu .',
			'Khái Quát' => 'Huyền vũ đại biểu bắc phương , thuộc thủy , chủ yêu che giấu không rõ ràng , việc ngầm , đạo tặc , không thể quang minh chánh đại đi làm sự tình; làm trái pháp tính , chủ vụng trộm , trong lòng , chủ ẩn hình của sự vật , không đổi bị phát giác của sự vật . Chiêm tính cách huyền vũ vượng tướng máy chủ trí , khôn khéo , hưu tù chủ chủ nhân lỗ mãng ( suy đoán nhân tính tình lúc ) , nói chuyện hoa nhi không được thực , làm việc không có giữ chữ tín , minh nhất vỏ ngầm một bộ , âm hiểm , xảo trá .',
		],
	];
	return $thuVien[$thu][$than];
}

function luanLucThuDiaChi($thu, $diaChi){
	$thuVien = [
		'Thanh Long' => [
			'Tý'=> 'Tý thuộc Thủy, biến sinh Thanh long là chiếc thuyền, là được vui mừng cưỡi thuyền, ứng điềm may mắn về tiền bạc, vui vẻ đi xa du lịch, việc mình chủ động mà sinh ra việc vui mừng khác, gặp điều may mắn ở nơi khác đưa đến. Có vui mừng vì vợ có thai nghén, hoặc là điềm trong nhà có đàn bà chửa. Nữ nhân được thọ ơn cấp
			trên.',
			'Sửu'=> 'Sửu thuộc âm Thổ, có chứa can Quý âm Thủy, là đất có lẫn nước, tức bùn, có tượng Rồng sa lầy, quanh co đất bùn, việc mình mưu tính không đúng theo kế hoạch, không được toại ý. Không nên mưu đồ những việc to lớn vĩ đại hay những việc quan trọng.',
			'Dần'=> 'Dần là ngôi vị, bản gia của sao Thanh long, tượng rồng gặp rồng, điềm được mời thỉnh, được nhiều người cầu thân, cầu cạnh với mình, cũng là điềm vui mừng về con cháu hay việc sinh đẻ của con cháu, gặp điều phúc đức. Cũng là Rồng cưỡi mây, sự việc dự tính đã lâu nay ước nguyện được thành, rất vui mừng, mưu sự vừa ý. Rồng cưỡi mây là lúc người quân tử hành động một cách vừa đúng ý đồ. Gặp vận tốt.',
			'Mão'=> 'Mão thuộc âm mộc, Thanh long thuộc Dương mộc, đồng một loại mộc mà có đủ Âm Dương nên là môi trường rất thích hợp và thân cận, quẻ ứng đông người muốn giao hảo, muốn cầu thân thích với mình. Mão là tượng con sông nước, Thanh long lâm Mão có tượng Rồng giỡn nước, điềm được trùng trùng tài lợi, điềm thời vận
			hưng khởi nên mưu sự tiến tới theo nguyện vọng hay công việc của mình. Mão ở chính Đông là cung Chấn, mà Chấn là lôi, sấm cho nên gọi là Rồng đuổi theo sấm, ứng điềm thời vận hưng khởi, nên mưu sự và tiến theo nguyện vọng của mình hay việc mà mình đang làm. Cũng là tượng Rồng giỡn trái châu, cho mình mưu cầu được toại ý.',
			'Thìn'=> 'Thìn là Mộ của Thủy và Thổ, Thanh long lâm Thìn có tượng Rồng nằm tu, chưa biến hóa được, là điềm tiền tài gặp bất trắc, gặp trở ngại, làm chậm trễ, điềm bất ngờ gặp sự ưu lo, buồn phiền.',
			'Tỵ'=> 'Tị là giờ mặt trời đang thượng tiến gần tới đỉnh, là nơi lửa viêm thịnh vượng, làm mây chạy mưa tuôn, Rồng đến càng thêm huy động trời làm mưa, ứng điềm khởi tiến, mưu sự có lợi, rất hợp với sự cầu yết kiến, trình diện, thăm hỏi. Tượng Rồng trên trời như người quân tử đi xa thực thi công việc, người quân tử sắp hành động.',
			'Ngọ'=> 'Ngọ là nơi khí Dương cùng tột và bắt đầu sinh Âm, tượng Rồng nhắm mắt, ứng điềm suy vi khó hành động như ý muốn, điềm hao tổn tiền bạc, lo buồn việc quan, điềm hung, sự hại. Vợ đang chuyển bụng sinh con là điều đáng lo ngại lắm. Ngọ thuộc hỏa cho nên nói là thân Rồng bị đốt hoặc gọi là Rồng bị thương ở đuôi, ứng sự hại.',
			'Mùi'=> 'Mùi là Mộ của Mộc, Rồng nhập mộ, rồng gãy sừng, điềm chưa tới vận, cần yên tĩnh, giữ việc cũ, không nên hành động bất cứ điều gì. Nếu hoạt động điều chi khác tất gặp sự hung hại chẳng sai.',
			'Thân'=> 'Thanh long bị Thân kim khắc gọi là Rồng mài sừng, hoặc cũng gọi là Rồng tróc vảy, vậy nên yên tĩnh, nếu di động đi xa ắt gặp nguy hại. Thanh long lâm Thân Dậu có ý là Rồng gãy chân, gặp chuyện kiện tụng.',
			'Dậu'=> 'cũng như lâm Thân, cũng gọi là Rồng nằm lộ, nằm trên đất cạn khô, phải kiềm chế mình trong mọi việc mới yên, kiên quyết thủ tĩnh, động sự là hung hại đến ngay.',
			'Tuất'=> 'Tuất đất La võng, điềm bị tiểu nhân tranh chấp tiền bạc. Thanh long mộc khắc Tuất thổ là điềm đi đường nhưng ra vào mệt mỏi, có sự hung hại bất mãn.',
			'Hợi'=> 'Hợi Thủy là gốc nguồn sinh mộc Thanh long, rồng lội sông, điềm được đi thuyền, được lợi lộc, vui mừng, cũng là điềm vợ thai nghén hay trong nhà có đàn bà chửa. Cũng là điềm mình đang thực thi một việc nào đó, lại gặp thêm điều vui mừng khác nữa',
		],
		'Bạch Hổ' => [
			'Tý'=> 'Hổ thuộc kim gặp Tý thủy tất bị hao tổn chìm khắc, Hổ sa xuống nước, bị chậm chạp trì trễ, là điềm tin tức, thư từ không lưu thông, không đến, sự chờ đợi trông mong vô ích. Bị xui rủi thất thế, xe cộ đi lại mệt mỏi vô ích.',
			'Sửu'=> 'Tượng Hổ ẩn nấp nơi đồng ruộng để bắt hại trâu bò, điềm có âm mưu rình rập sát hại, bị tổn hại liên tiếp, bị người mưu hại, bị sa lầy vào rắc rối, bị vu vạ, đeo nợ vào thân.',
			'Dần'=> 'Hổ lâm hổ địa, gọi là quẻ mặc áo giáp, cầm quyền tha giết. Hổ lên núi, điềm thêm uy quyền, có lợi cho khoa giáp thi cử. Gặp may mắn, được đắc thời, đắc ý, gặp vận tốt, mạnh bạo thô lỗ, lấn át chế ngự kẻ khác sinh khẩu thiệt.',
			'Mão'=> 'Mão Chấn, tượng xe cộ, hổ ngồi xe, đi giải quyết công việc, bị mệt nhọc vì xe cộ đi lại. Hổ đến tìm người, kẻ mạnh bạo xộc hỏi tận nơi, có việc lo lắng, điềm bị ly cách tang thương. Tiểu nhân, nô tỳ bị hình phạt, nếu không gặp hung hại thì phải đi xa hoặc có người ở xa đến nhà mình.',
			'Thìn'=> 'Thìn là Thiên la, gặp Hổ là hung, tất sinh ra sự hại lớn như bị tra khảo, đánh đập, giết chết, bị áp đặt, bị kiềm chế, bị vô hiệu hóa. Việc gì rồi cuối cùng cũng rất xấu, rất hung, hành động bị họa lập tức.',
			'Tỵ'=> 'Tỵ Hỏa khắc Bạch Hổ kim, tượng Hổ bị đốt, Hổ bị sa bẫy, điềm bị mất thần, thất thế. Là hào phản họa thành phúc, thoát khỏi hung họa, xong nợ, nhẹ người. Vì có tiến thoái, nhập theo dòng, xuôi theo trào lưu nên mất tính hung dữ.',
			'Ngọ'=> 'Cũng như lâm Tỵ, gọi là Hổ bị cụt đuôi, điều mà Hổ sợ nhất, bị vô hiệu hóa, mất uy thế, sinh bệnh tật lo buồn, bị tang chế hoặc đang lo việc tang. Vì gặp điều xấu mà giảm tính nóng ác, dù có nóng nảy hung bạo cũng vô ích.',
			'Mùi'=> 'Mùi thuộc Thổ là ruộng nương, tượng Hổ đi chơi ruộng làm hại trâu dê, kẻ hung bạo đi cầu tài lợi, ứng điềm người bị thương tổn. Mùi cũng có tượng giếng ví như Hổ nằm hang, điềm sự việc còn nằm yên, chưa tiến triển, việc chưa đạt kết quả. Lại cũng là tượng hổ lên núi, được thêm quyền hành, việc đang chậm hóa nhanh. Có thể được tài lộc nhỏ.',
			'Thân'=> 'Có việc đi lại, thư từ, tin tức vui mừng, có thể đứng một nơi mà đợi sự vui may đưa đến. Cũng là điềm tin tức được lưu thông, không bị gián đoạn, có thư từ, tin tức đến, tạo ra cơ hội bất ngờ. Cũng ứng đang có sự bất hòa ngầm, có mâu thuẫn, chưa lộ ra.',
			'Dậu'=> 'Hổ chặn cửa đón đường, cậy thế làm càn, có tranh cãi kiện cáo. Hổ nắm quyền sinh sát, có uy phong, quyền thế, hổ đắc thời, tha hồ múa may, thể hiện.',
			'Tuất'=> 'Tuất địa võng lưới trời, gọi là Hổ sa xuống hang sâu, điềm hại hóa ra phúc, điềm thoát khỏi họa gông cùm, có lo lắng e ngại mà rồi thoát được, trong cái xấu có sự vừa ý, tuy không thật thỏa mãn.',
			'Hợi'=> 'Tượng Hổ bị chìm suối, điềm tin tức bị chậm trễ, không thể đi đến nơi đến chốn, sự trông vọng chỉ là điều phí công. Việc có đầu không đuôi, vô kết quả',
		],
		'Câu Trần' => [
			'Tý'=> 'Tý là nơi hãm hiểm tối tăm, có sự vướng mắc lôi thôi trong chuyện tiền bạc, tâm không yên, hoặc bị lăng nhục, xấu hổ. Có việc giấu diếm, lo có kẻ âm mưu gây tai họa. Lại là điềm đến cửa quan thưa kiện kéo dài, ra vào chẳng yên.',
			'Sửu'=> 'Sửu là công đường, Câu trần đến Sửu thường sinh điều hung hại, bị khiển trách, bị lăng nhục, bị dọa nạt. Hành động bị vướng mắc trì trệ, không thông suốt. Sửu quý nhân, cậy thế cậy thần làm càn bậy nhưng không toại ý. Sửu có ký can Quý thủy cùng với Câu trần tương khắc, tất ứng điềm hung, tự chuốc lấy họa.',
			'Dần'=> 'Câu trần bị Dần mộc khắc, tất gặp sự xử tội nguy thân, ứng điềm tù ngục hoặc phải chịu cho kẻ khác chế ngự, bó buộc, khống chế. Cũng là điềm có việc quan, đến nhà quan chức. Nếu là quan chức nhỏ thì bị tai họa liên đới. Chỉ có việc dâng đơn, hiến kế là tốt, cầu xin việc nơi quan thự thì hay.',
			'Mão'=> 'Mão có tượng Chấn, bị vướng mắc vào việc di chuyển, đổi thay, cũng là điềm dời đổi chỗ ở, nhà cửa không yên, trẻ nhỏ đau yếu, gặp việc quan, việc bận rộn quấn vào thân.',
			'Thìn'=> 'Thìn là ngôi của Câu trần, gọi là Câu trần giao hội, ứng điềm bị liên miên tai họa nặng. Có việc trì trễ lâu dài mà thành xấu, việc tù tụng liên đới, sự oan ức của mình khó mà giãi bầy được.',
			'Tỵ'=> 'Tỵ là lò lửa đúc ấn, Câu trận là vị tướng quân, nay gặp nhau ứng điềm quan nhân thụ ấn lệnh, vui mừng quan chức, được thưởng tặng, thêm tước vị, hưởng bổng lộc lâu dài.',
			'Ngọ'=> 'Câu trần đến Ngọ tham được sinh dưỡng mà ở lâu nơi sinh, vì tham lợi lộc mà phải che dấu để được lâu dài, vì sự bắt buộc mà phải chấp nhận kéo dài dù bất ưng. Có điều phản bội trái mắt, bất hòa hay việc ở đâu đưa đến mà mình bị liên lụy. Trăm sự đều bị kéo dài thời gian rất lâu.',
			'Mùi'=> 'Mùi là mùi vị, chủ về ăn uống, rượu tiệc có tượng như cửa hàng ăn uống, quán xá, nhà hàng. Nên gọi là Câu trần vào quán, điềm được ăn uống, điềm được lợi trong vụ nhà đất ruộng vườn. Hoặc có tổn thương bệnh tật mà phải theo đuổi chữa trị lâu dài. Việc nhà cửa kéo dài lôi thôi.',
			'Thân'=> 'Thân là chỗ trường sinh của thổ, ứng điềm có sự thay đổi, dời đi nhưng vẫn tốt lành, hoặc lẽ ra phải thay đổi nhưng được giữ lại lâu thêm. Câu trần thừa thần tác Lục hợp với Thân, cầu tiền tài được lợi. Thân thuộc dương kim nên cũng gọi là Câu trần đeo gươm, cầm lệnh sinh sát, điềm được oai dũng, hành sự ắt có kết quả tốt. Lại cũng là điềm mọi sự hay bị chậm trễ.',
			'Dậu'=> 'Cung Dậu là cửa hình trách, ứng điềm bị tra hình, xét hỏi, khiển trách. Có mâu thuẫn bất hòa, sự việc rất khó có thể tiến lên. Cũng gọi là quẻ chứa mầm bệnh ở chân.',
			'Tuất'=> 'Tuất là chốn lao ngục tối tăm, gọi là Câu trận bị nhập ngục, ứng điềm tù tội mà chẳng thể phân trần, thanh minh được. Cũng là điềm lui tới kiện thưa.',
			'Hợi'=> 'Câu trận khắc Hợi thủy, nhưng Hợi là nguồn gốc sinh ra mộc khắc lại Câu trận thổ, ấy là Câu trận bị phản khắc ứng điềm phản phúc không thôi, sự việc luôn bị bất trắc không ngừng, chẳng lường trước được. Lại cũng là điềm dời quan đổi chức, xấu.',
		],
		'Đằng Xà' => [
			'Tý'=> 'Xà lâm Tý gọi là rắn sa xuống nước, tuy vốn là điềm hung hại cùng sự bất thành, nhưng cứ lòng dạ ngay thẳng thì do sự chân thật mà sẽ thoát khỏi nạn. Lại cũng là điềm gặp kinh sợ nghi nan, nằm mộng thấy ma quỷ, việc xấu xa, lòng dạ bồn chồn không yên.',
			'Sửu'=> 'Gọi là rắn vào hang, có việc trốn tránh, lánh mặt, việc chia lìa, lo ngại tự nhiên tiêu tan, trong họa mà có phúc, họa phúc phân đôi.',
			'Dần'=> 'Xà thuộc Hỏa được sinh tại Dần, và Dần là ngôi của Thanh long. Khi Xà lâm Dần thì gọi là rắn nẩy mọc sừng nên đã biến hóa thành rồng, là lúc thời vận đang hưng khởi, nên cầu tiến thân danh, nên dụng sự, tiến tới việc mình đang dự tính. Cũng gọi là Rắn hóa Thằn lằn, điềm thoái hóa, lớn hóa nhỏ, sang hóa hèn, chẳng nên dục vọng động tiến thân danh. Luận quẻ thấy Xà lâm Dần thì phải tùy theo thời vận mình đang hưng thì mới nên động sự, còn khi đang suy vi thì phải giữ thân thủ cựu.',
			'Mão'=> 'Mão tượng Chấn, có việc lo lắng kinh sợ vu vơ, là điềm gia đạo bất hòa, gặp sự náo loạn gây gổ ồn ào trong nhà cửa, người trong gia đình gặp tai họa, điềm xảy ra vụ quan tụng sầu bi, đáng lo ngại, hay vụ máu lửa.',
			'Thìn'=> 'Thìn là ổ của Rồng, rắn đội lốt rồng, tiểu nhân trá hình, bề ngoài nhân nghĩa bên trong tà độc xảo trá, có hành vi phản trắc nhỏ nhen nhưng luôn rêu rao giả dối. Thi cử, khoa giáp tốt, có điềm đỗ đạt cao – Long khoa.',
			'Tỵ'=> 'Tị là cung vị của Phi xà, nhà của Rắn, rắn vào hang ổ, không có sự hại, nhưng sự việc chẳng xuất đầu lộ diện, mình cứ nên tiến theo nguyện vọng của mình, việc xuôi theo tốn thuận, việc âm thầm một mình.',
			'Ngọ'=> 'Ngọ là cung giữa trời, tượng Rắn lướt trên không trung để vượt lên, được tự do bay nhảy, tiến lên theo nguyện vọng của mình, cầu tài quan đều được thuận lợi. Xà lâm Tị Ngọ cũng hay ứng điều lo sợ hão huyền, lo sợ vu vơ.',
			'Mùi'=> 'Mùi là đất bụi khô nóng, gặp sự u tối, điềm bị khẩu thiệt quan tụng, phòng việc mờ ám che giấu đang tới, rất cẩn thận đường bộ, từng bước đi, lời ăn tiếng nói.',
			'Thân'=> ' Xà thuộc Hỏa khắc Thân Kim, ấy là ngoại chiến vốn đã ứng điềm hung, nay Đằng xà (Tức Tị) với Thân là Tam hình, cộng thêm sự hại. Tị đối với Thân vừa là Tam hình, vừa là Lục hợp, lại tương khắc. Do vậy, Xà lâm Thân gọi là hình hợp khắc chiến, đó là hợp nhau để cạnh tranh mà làm hại, gây hại cho nhau. Thân thuộc Kim là loại gươm đao, là quẻ rắn ngậm gươm làm hại người, động sự bất cứ điều gì cũng bị tai nạn hay thất bại.',
			'Dậu'=> 'Xà khắc Dậu nên cũng ứng điềm hung, nhưng nhờ có Đức hợp nên gặp họa có lẫn điều phúc. Động sự việc hay tiến dụng cũng có điều may, nhưng phải phòng quan tụng. Dậu có tượng răng, điềm Xà mọc răng đồng nghĩa với rắn cắn, điềm bị khẩu thiệt, điềm quái dị. Có cãi vã bất hòa, mưu sự thất bại, gãy đổ bởi lời hứa suông. Xà cư Dậu là gặp kẻ khác đang ganh ghét mình.',
			'Tuất'=> 'Xà thuộc Hỏa, mộ tại Tuất, là tượng rắn bò vào gò mộ để ngủ, để lột da, điềm thoát khỏi sự nguy, thoát khỏi tai họa, lo buồn tự nhiên tiêu tan. Có việc lẩn tránh, che dấu tông tích, ẩn thân, thay tên đổi họ.',
			'Hợi'=> 'Xà thuộc Hỏa, tuyệt tại Hợi, là lúc tuyệt ý nghĩ hại người vì rắn nhắm mắt, có việc cũng lơ đi, không có tai vạ. Lửa Xà gặp Hợi thủy thì không hoành hành, không làm ngang ngược được. Có điềm tôi tớ gái trốn đi hoặc điềm hao tài, vì Hợi là cung vị của sao Huyền vũ chuyên ứng vụ thất thoát, hao mất và trốn tránh.',
		],
		'Chu Tước' => [
			'Tý'=> 'Tý thủy khắc Chu tước Hỏa nên chim tước bị thương, bị gãy cánh sa xuống nước, điềm bị tai nạn. Lại cũng là điềm có ấn tín của quan chức, vì Chu tước Hỏa thì Tý thủy tác Quan quỷ. Chủ việc không thành.',
			'Sửu'=> 'Can Quý thủy ký tại Sửu khắc Hỏa, vì vậy chim tước bị bể đầu, hay chim tước nhắm mắt, ám chỉ sự sai lầm, điềm bất lợi, không nên hành động việc gì mà chỉ nên thủ cựu. Chu tước ngôi vị tại Ngọ hỏa, mà Ngọ với Sửu tác Lục hại, nên ứng điềm bị thiệt hại. Có tranh chấp, kiện tụng đến nhà đất, điền sản, vườn tược.',
			'Dần'=> 'Dần là chỗ trường sinh của Hỏa, ứng điềm chim tước làm tổ, có việc khởi đầu của ấn tín, văn thư, giấy tờ. Sẽ được tin tức, văn thư từ xa đến nhưng bị chậm. Cũng là điềm văn thư bị im ẩn, bị ỉm đi, bị bỏ mặc.',
			'Mão'=> 'Mão mộc sinh hỏa, có cơ hội hoạt động, thể hiện bản thân, được dịp lên cơn nóng nảy, sinh cãi vã, bất hòa. Cũng là văn tự bị quên lãng, chìm khuất.',
			'Thìn'=> 'Thìn là Thiên la (lưới trời) nên chim tước bị sa lưới, gặp khó khăn trở ngại lớn, điềm bị ngục tụng, tranh kiện, văn tự bị thất lạc hay bị sai sót, nhầm lẫn. Lại cũng là điềm có tin đến.',
			'Tỵ'=> 'Tị là nơi lửa đang cháy sáng, chim tước đang bay cao, việc thi cử, văn thư có kết quả tốt, điềm tin nơi xa đang đem đến sắp tới nơi.',
			'Ngọ'=> 'Ngọ là chính ngôi của Chu tước, cũng là cung chính giữa trục, nên gọi Ngọ là Chính ty, Quan thự (nơi làm việc), Chu tước đến Ngọ là chim ngậm thẻ lệnh, điềm hung, ám chỉ vào vụ xử án tội nhân, có thể bị tù ngục. Lại cũng là điềm sắp xảy ra việc quái lạ.',
			'Mùi'=> 'Mùi là mộ của Mộc, mà Mộc sinh Chu tước Hỏa, nên Mùi là mồ mả của cha mẹChu tước. Với ý này ứng điềmChu tước khóc mộ, điềm bi ai sầu thảm. Mùi cũng là mùi vị, nên chuyên chủ về ngũ cốc vật thực, được ăn uống, rượu chè, rất thuận với việc cầu tài.',
			'Thân'=> 'Chu tước Hỏa khắc Thân kim, tượng chim mài mỏ, điềm gặp sự kinh sợ, việc kỳ quái đưa đến. Có loan truyền tin tức, giao dịch văn thư, có tin đưa đến tận nơi. Lại cũng là điềm truyền phao tin giả dối, nghe thì phải suy nghĩ rất cẩn thận kẻo lầm.',
			'Dậu'=> ' Tước khắc Dậu, gặp sự sầu bi, buồn phiền, khẩu thiệt, tật bệnh, quan họa. Là điềm quan nhân bị giáng cấp, điềm mất uy tín trong quan hệ, có sự phao truyền tin giả dối, dựng chuyện bịa đặt, nói xấu.',
			'Tuất'=> 'Tước thuộc Hỏa mộ tại Tuất, điềm bị nguyền rủa, cãi vã, chửi bới. Hoặc có nói trời, nói đất, chửi rủa trời phật. Cũng là chim tước không đủ lông, thiếu khả năng hành sự, công việc bị chê bai, kết quả kém.',
			'Hợi'=> 'Chu tước Hỏa thì tuyệt tại Hợi, chim tước cùng đường, tuyệt lộ. Nên giữ yên thân phận, không nên hành động, khởi tiến, dụng mưu, hiến kế, tìm kiếm, hoạt động đều vô ích. Lại cũng là Chim tước bị sa xuống sông, điềm hao tổn tiền bạc.',
		],
		'Huyền Vũ' => [
			'Tý'=> 'Tượng đạo tặc qua sông biển, có việc quan trọng phải đi lại gian nan, khó khăn vất vả. Việc mờ ám, việc rượu chè quà cáp, việc mò mẫm đêm tối ướt át. Điềm lui tới chẳng yên, lòng muốn đi rình người, phục bắt kẻ gian.',
			'Sửu'=> 'Sửu là đất quý nhân, có người đến cầu cạnh điều gì đó, nhưng phải đề phòng họ giả dối, không thật, xảo trá. Lại cũng là điềm bị mất trộm, có việc chậm chạp gây nghi ngờ hiểu lầm.',
			'Dần'=> 'Là đạo tặc vào rừng, khó mà tìm kiếm nó được, đi tìm kẻ tiêu cực tội phạm nhưng không gặp. Cũng là điềm gặp sự cầu hỏi, tra vấn. Huyền vũ Bản gia tại Hợi, nhị hợp với Dần lại tương sinh nên nói là được hài hòa trong mọi việc, chẳng có hại.',
			'Mão'=> 'Mão là cái cửa, đạo tặc đến cửa là để dòm ngó vào nhà, phòng bị trộm cắp, cũng là điềm trong nhà có đạo tặc, kẻ mờ ám vào nhà. Có lo sợ, chấn động đề phòng kẻ trộm, mất xe cộ…',
			'Thìn'=> 'Thìn khắc Huyền vũ, là quẻ đạo tặc bị lạc đường mất lối mà tự nó bị hại, tự gây lầm lẫn rắc rối. Thìn là nơi tù ngục, tự gây ra sự ràng buộc. Cũng là ngẫu nhiên gặp việc, dùng vị thế, khả năng làm việc mờ ám.',
			'Tỵ'=> 'Có việc cân nhắc xem xét, chẳng hạn nghĩ xem sẽ đòi tiền, làm tiền thế nào. Có sự nhìn lại kiểm tra các việc, gọi là đạo tặc ngoái lại, tuy thấy điềm kinh hãi, nhưng không có sự hại. Có điềm được tiến tới thắng đạt, được tiến cử, thu được lợi bất chính.',
			'Ngọ'=> 'Ngọ là lúc mặt trời chiếu sáng nhất, bọn đạo tặc rất sợ bị bại lộ, bởi thế nên nói là đạo tặc bị cùng đường không nên đuổi theo mà có hại. Có việc gian trá cơ hội tiêu cực công khai trắng trợn. Cũng gọi là đạo tặc mất gươm, chẳng có sự hại. Cũng là điềm chuyển đổi nơi làm việc, chuyển chức, thiên quan.',
			'Mùi'=> 'Làm việc âm thầm, bị tổn hại ngầm. Lại cũng là điềm không biết giữ luật lệ, sa đà rượu chè tiệc tùng, bị hại vì rượu chè, lễ lạt gặp bất lợi. Quan nhân thì được yết kiến bề trên, được thêm chức tước…',
			'Thân'=> 'Việc che giấu bại lộ, bị bộc lộ chân tướng, bị cùng đường, cố đấm ăn xôi, làm bừa. Tượng đạo tặc bị gẫy chân, không làm gì được. Có việc chờ đợi, theo đuôi người hành sự, đau chân, mỏi gối.',
			'Dậu'=> 'Dậu thuộc kim, đạo tặc cầm kiếm, tính hung bạo cương quyết, sẵn sàng làm bậy, không ngại va chạm đụng độ, có đổ vỡ thiệt hại, có xích mích mâu thuẫn, quyết liệt dứt khoát không dây dưa.',
			'Tuất'=> 'Tuất cũng như Thìn chủ về tù ngục, là đạo tặc lâm tù, việc mờ ám riêng tư bị thất thế, không như ý. Huyền vũ lâm Tuất, vị tướng quân ra trận, cầm ấn lệnh chỉ huy, sai khiến người. Có điềm mất bạn bè đối tác, sứt mẻ quan hệ.',
			'Hợi'=> 'Hợi là bản gia của Huyền vũ, nên nói đạo tặc về nhà, tượng ẩn tàng kín đáo, có thoái thác lẩn tránh, khó tìm gặp người. Cũng là điềm quan chức bị tổn hại.',
		],
	];
	return $thuVien[$thu][$diaChi];
}

function luanPhucThan($than){
	$thuVien =[
		'Huynh Đệ' => 'Chủ cửa ngầm, cửa sổ ngầm, anh chị em bất hòa, không có vách tường.',
		'Tử Tôn' => 'Biểu thị tài nguyên không nhiều, không có con cái, đường ở sau lưng, ám đạo, con cái ra ngoài.',
		'Thê Tài' => 'Là tài vận không tốt, ám tài, vợ trốn đi, không có vợ, không có bếp, không có nhà kho.',
		'Quan Quỷ' => 'Biểu thị sự nghiệp bất lợi, chồng ra ngoài, chồng không ở cùng, có giấu tượng thần phật, nguy cơ tứ phía.',
		'Phụ Mẫu' => 'Là tầng hầm, văn thư không đến, không có chứng nhận đất đai, nhà cửa, phòng ở chỗ trũng, địa thế thấp, tìm không thấy mồ mả, phần mộ bị mất.',
	];
	return $thuVien[$than];
}

function luanLucThanBien($thanGoc, $thanBien){
	$thuVien = [
		'Huynh Đệ' => [
			'Huynh Đệ' => 'Môn hộ quá nhiều. Hóa tiến thần, tài vận kém. Hóa thoái thần, tài vận chuyển biến tốt đẹp, anh em bất hòa.

			Huynh đệ hóa tiến thần: Môn hộ trùng điệp, vách tường sâm nghiêm, mở cửa, tài vận không tốt. Hóa thoái thần: đóng cửa, vách tường sụp đổ, vách tường thấp.',
			'Tử Tôn' => 'Không có văn tài, con cái rách nát.',
			'Thê Tài' => 'Tiền tài bất nghĩa, hợp tác được lợi, nhờ vả bằng hữu phát tài.',
			'Quan Quỷ' => 'Bất lợi cho anh em, anh em tổn thương, tay chân thụ thương.',
			'Phụ Mẫu' => 'Tài vận không tốt, nhà cửa không tốt cho tài vận, anh em ở chung, thuê được nhà.',
		],
		'Tử Tôn' => [
			'Huynh Đệ' => 'Đời sau bình yên, tài vận phong phú, con cái có tiền đồ.',
			'Tử Tôn' => 'Hóa tiến thần, đời sau bình yên, muôn đời vĩnh hưởng, tài nguyên tốt, con cháu đầy đàn. Hóa thoái thần, đời sau suy sụp, tài vận kém.

			Tử tôn hóa tiến thần: Con cháu đông đúc, đời sau thịnh vượng, tài nguyên tươi tốt, đường xá xa xôi, đường xá thông suốt. Hóa thoái thần: đời sau không tốt, con cái thưa thớt, tài vận xuống dốc, con đường chật hẹp, ngõ cụt.',
			'Thê Tài' => 'Con cái đời sau tài phú vĩnh hưởng, đời sau mập ra.',
			'Quan Quỷ' => 'Con cái có tai họa, bất lợi cho đời sau, nhân khẩu suy yếu.',
			'Phụ Mẫu' => 'Sảy thai, con cái có hại, đoạn tuyệt tài lộ.',
		],
		'Thê Tài' => [
			'Huynh Đệ' => 'Rủi ro, tài vận suy sụp, vợ xảy ra chuyện.',
			'Tử Tôn' => 'Tài nguyên phong phú, cơm no áo ấm.',
			'Thê Tài' => 'Hóa tiến thần, tài vận hanh thông, càng ngày càng giàu có. Hóa thoái thần tài vận kém, vợ rời đi.

			Thê tài hóa tiến thần: Tài nguyên cuồn cuộn, cỏ cây rậm rạp, tài vận tốt, nữ nhân duyên tốt. Hóa thoái thần: tài vận suy sụp, nữ nhân rời xa, cỏ cây khô héo',
			'Quan Quỷ' => 'Vợ ngoại tình, vợ tử biệt, vợ nhiễm bệnh, vì tài sắc mà mang họa.',
			'Phụ Mẫu' => 'Hủy cũ đóng mới, mua được nhà cửa đất đai, nhờ phụ nữ mà được nhà cửa đất đai',
		],
		'Quan Quỷ' => [
			'Huynh Đệ' => 'Tay bị tổn thương, tai hoạ không ngừng.',
			'Tử Tôn' => 'Bất lợi cho công việc, vị trí, tiêu trừ ưu sầu, đời sau không tốt.',
			'Thê Tài' => 'Tài Quan cùng đến, thăng chức.',
			'Quan Quỷ' => 'Hóa tiến thần, tai hoạ liên tục, quan vận tốt, sửa chữa nhà cửa. Hóa thoái thần, tai hoạ biến mất, vận làm quan xấu.

			Quan quỷ hóa tiến thần: Thăng tiến, sự nghiệp phát triển, tai hoạ trùng điệp, bệnh tật thêm nặng, liên tục không ngừng sửa chữa và chế tạo. Hóa thoái thần: vận làm quan xấu, sự nghiệp kinh tế đình trệ, tai họa giảm bớt.',
			'Phụ Mẫu' => 'Nhờ công việc, vị trí mà có nhà cửa, sửa nhà cửa.',
		],
		'Phụ Mẫu' => [
			'Huynh Đệ' => 'Cửa phòng tương liên, có tường vây, nhà cửa đất đai phá tài, anh chị em tranh đoạt đất đai tài sản.',
			'Tử Tôn' => 'Đường đi thông thoáng, nhà cửa có phúc khí, sinh con, bất lợi cho đời sau.',
			'Thê Tài' => 'Nhà ở tốt cho tài vận, ruộng, nhà cửa, đất đai bị hao tổn, phá dỡ nhà cửa. Thanh Long chủ tiến Tài. Chu Tước chủ quan ti miệng lưỡi. Câu Trần chủ phá hủy. Đằng Xà chủ bất an. Bạch Hổ là đường đi xâm chiếm. Huyền Vũ chủ khí ẩm ảnh hưởng.',
			'Quan Quỷ' => 'Biểu thị có được nhà cửa. Lâm Thanh Long trang trí nhà cửa. Lâm Câu trần tu kiến cải tạo. Lâm Chu Tước là sửa đổi khế ước bản vẽ. Lâm Đằng Xà là phòng ở bất an. Lâm Bạch Hổ là đường thông suốt. Lâm Huyền Vũ lân cận có ao hồ, có đạo tặc.',
			'Phụ Mẫu' => 'Cần nhìn vào tiến thoái, lại cần căn cứ hào vị cùng lục thần lấy tượng. Phụ mẫu hóa tiến thần, trường kỳ ở lại, mở rộng kiến trúc, gia tăng công trình kiến trúc, mở rộng thổ địa, đại địa kéo dài. Hóa thoái thần là chuyển ra ngoài, nhà cửa rách nát, không ở lại, thổ địa biến hẹp, mặt đất sụp đổ.

			Phụ mẫu hóa tiến thần: Chủ mặt đất dần dần cao lên, đất đai rộng lớn, lầu các trùng trùng, núi non trùng điệp, kiến trúc san sát, tầng tầng lớp lớp, xây thêm nhà, ở lâu dài, phòng ốc san sát nối liền, lên dốc. Hóa thoái thần: chủ dần trũng, sườn núi, ở lại không lâu, khí thế yếu bớt.',
		],
	];
	return $thuVien[$thanGoc][$thanBien];
}

function haoVi($hao){
	$thuVien = [
		'
		-Trẻ con, con cháu, đời sau, vãn bối.
		-Nền nhà, mặt đất, giếng nước, cống rãnh, cống thoát nước, hàng xóm.
		-Chân, gan bàn chân.
		-Ngón chân, xương chân.
		-Nông thôn.
		-Viên chức, thuộc hạ, binh sĩ, quần chúng, bách tính.',	

		'
		-Vợ chồng, thai nhi.
		-Nhà, phòng ở, sân, nhà bếp.
		-Chân, đầu gối, bụng, bắp chân.
		-Ruột, gan mật, ruột thừa, tuỵ, tử cung, bộ phận sinh dục, thận, hậu môn, bàng quang.
		-Chợ búa, hẻm nhỏ, cộng đồng, đường đi.
		-Khoa trưởng, người phụ trách phòng, đại đội trưởng, ban trưởng.',			

		'
		-Anh chị em, cô chú bác.
		-Phòng ngủ, cửa, giường, bàn thờ Phật.
		-Đùi, bụng, eo, rốn.
		-Dạ dày, gan mật, thận, bàng quang, tuỵ, hậu môn, tâm tạng.
		-Hương trấn, tiểu trấn.
		-Trưởng phòng, đoàn trưởng, doanh trưởng.',		

		'
		-Mẹ.
		-Cửa chính, cửa sổ, nhà vệ sinh.
		-Ngực, vú, hai sườn, nách, lưng.
		-Tỳ vị, tim, lồng ngực, phổi, khí quản, tuyến vú.
		-Vùng ngoại thành, huyện thành.
		-Sở trưởng, bộ trưởng, thủ tướng, quản lí chi nhánh.',				

		'
		-Bố, gia trưởng.
		-Con đường, thang lầu, thông đạo.
		-Ngực, yết hầu, cổ, mặt, ngũ quan, bả vai, lưng.
		-Lá lách, tim, yết hầu, tuyến giáp trạng, thực quản, phổi.
		-Tỉnh lị, thủ đô, trung tâm thành phố, thành thị, địa khu.
		-Lãnh đạo, cấp trên, chủ quản, tổng thống, tỉnh trưởng, Hoàng đế, thị trưởng, tư lệnh viên, quân trưởng.',		

		'
		-Trưởng bối, tổ tông, tổ phụ, tổ mẫu.
		-Nóc nhà, tường vây, vách tường, thần vị, hàng xóm, tổ mộ phần, thủy khẩu.
		-Tóc, đầu, mặt mũi, cánh tay, bả vai.
		-Óc, sọ, đầu óc.
		-Biên cảnh, nơi khác, nước ngoài, vừa xa, phương xa, cấp tỉnh.
		-người về hưu, nhân viên hậu cần, nhân viên ngoài biên chế, người không được trọng dụng.',							
	];
	return $thuVien[$hao];
}

function luanLucThuGapNhau($thu1, $thu2){
	$thuVien = [
		'Thanh Long' => [
			"Chu Tước" =>'Nói chuyện tao nhã, văn kiện quan trọng, tuyên truyền quảng cáo, thiệp mời dự tiệc, dùng từ lễ độ, say rượu chửi bậy, chỉ gà mắng chó, nói móc người khác, châm biếm người khác, lời ngon tiếng ngọt, từ ngữ mỹ miều, lời nói dễ nghe, vì tiền của mắc kiện tụng, thư tình, lời tâm tình, tiệc rượu, nịnh bợ, tin tức quan trọng, tiếng ồn trong phòng ăn, tranh đoạt tình nhân, lời nói thấm thía, khuyên người hành thiện, hôn môi, đồ trang điểm được tuyên truyền, lời lẽ chí lý, đau nhức phát viêm, sách đóng bìa cứng, đến nhà tán gẫu,…',
			"Câu Trần" => 'Tòa án cấp cao, thượng cấp ngành công an, nhà cao tầng, khu dân cư cao cấp, khách sạn sang trọng, ruộng cao sản, cây trồng cao sản, ung thư thực quản, u xơ tử cung, nhân viên công vụ, kiến trúc đẹp, núi cao tú lệ, vùng đất trù phú, làng giàu có và đông đúc, đất đai màu mỡ, khu phong cảnh tự nhiên, sinh khó, vô cớ sưng đau, bề ngoài thâm trầm, buôn bán bất động sản, ung thư dạ dày, ăn chậm, nhà hàng, cục tài chính, thẩm mỹ viện, tiệm may, khoa phụ sản, câu lạc bộ,…', 
			"Đằng Xà" => 'Ngụy quân tử, không ăn no, không có lễ độ, bần cùng, diêm dúa lòe loẹt, áo quần lố lăng, da mặt dày, váy, tóc quăn, uốn tóc, họ hàng xa, tham của, mù quáng vì tiền, sinh non, bị kẻ dâm đãng theo dõi, lăn lộn vì đau, khiêm tốn quá mức, sức ăn ít, bởi vì khuôn mặt đẹp mà động tâm, bởi vì tiền tài mà kiện tụng, bởi vì tình dục mà gặp phiền phức,…', 
			"Bạch Hổ" => 'Khẩu Phật tâm xà, nham hiểm xảo quyệt, tình địch, vụ án giết người hiếp dâm, cướp đoạt, trúng độc tử vong, bệnh vì ăn uống, sinh con xuất huyết nhiều, sau khi uống rượu đánh nhau, sau khi uống rượu lái xe, gãy xương đau nhức, đường quốc lộ cao cấp, bảo đao, bảo kiếm, đạn đạo, vũ khí kiểu mới, kiên cường bất khuất, anh hùng khí khái, cao không với tới, gặp tai nạn khi đi thăm người thân, người chết vì tiền chim chết vì mồi, kẻ hai mặt, coi cái chết nhẹ tựa lông hồng, ngoài mềm trong cứng,…', 
			"Huyền Vũ" => 'Bằng mặt không bằng lòng, trộm cắp tiền của, thông dâm, buôn bán phụ nữ, lừa tiền, hối lộ, đầu cơ trục lợi, cơm không sạch sẽ, vật bẩn thỉu, giao dịch chợ đen, buôn lậu, tiền đánh bạc, dâm loạn bất kham, nội y nội khố, con riêng, giả nhân giả nghĩa, lừa đảo cao cấp, kẻ trộm chính nghĩa, quỹ đen, kiếm tiền bất minh, phá tài, quỷ kế đa đoan,…',
		],
		'Chu Tước' => [
			"Thanh Long" =>'Nói chuyện có lễ độ, tình tự, thư tình, phát viêm dẫn tới đau nhức, vừa nói vừa ăn, lời nói văn minh, tranh giành tiền của, những ý nghĩa khác có thể tham khảo Thanh Long gặp Chu Tước.', 
			"Câu Trần" => 'Đơn kiện, cáo trạng, công hàm, thư thông báo của cơ quan, văn kiện của cơ quan, giấy tờ nhà đất, quy định về nhà ở, nơi có tiếng ồn, ban tuyên giáo, do viêm dẫn tới ung thư, viêm dẫn tới phù thũng, phòng karaoke, nhà sách, thư viện, cục viễn thông, hợp đồng ruộng đất, kiện tụng vì bất động sản, lương thực bị côn trùng cắn, lời nói ngập ngừng, nói năng sơ suất dẫn tới bị liên lụy, văn tự ngục[1], quảng cáo công cộng,…', 
			"Đằng Xà" => 'Nói dối, nói trống rỗng, tin tức bất ngờ, giật mình khi nghe tin, nói chuyện quanh co, quan ti khẩu thiệt, dùng tự sát để dọa, công kích cá nhân, nói xấu người khác, nịnh bợ, chậm chạp không tỏ thái độ, nắm đầu đề câu chuyện, tiểu nhân quấy rối, tham ăn, thực phẩm hiếm có, không thích nói chuyện, ít nói, giọng nói lạ, kiến giải độc đáo, ma trơi, kỳ đàm quái luận[2], thư tống tiền, thao thao bất tuyệt, thực phẩm có mùi lạ, lời nói đáng sợ, thiên thư,…', 
			"Bạch Hổ" => ' Biến đổi bệnh lý do phát viêm, nhiễm trùng máu, ăn cơm nhiễm bệnh, tranh cãi dẫn tới đánh nhau, nói quá thẳng, nói hống hách, chửi thề, tuyên truyền giao thông, thư thông báo bệnh tình nguy kịch, vừa nói vừa khóc, lời nói xúc động rơi lệ, lời nói đắc tội, chết cháy, sự cố y khoa dẫn đến kiện tụng, đánh nhau dẫn tới kiện tụng, thần chú giết người, thần chú ác độc, huyết thư, điều lệ giao thông, trường cảnh sát, giáo dục pháp luật, tri thức y học, điều khoản pháp luật, chiến tranh ngôn luận, hiểu biết trên đường, nhanh miệng,…', 
			"Huyền Vũ" => 'Nghe trộm, nói thầm, lời nói hạ lưu, lời nói bẩn thỉu, lời đường mật, nói dối gạt người, không nói nên lời, lở loét phát viêm, mất tin tức, cơ mật, âm thanh không rõ ràng, ám ngữ, thần chú ác độc, bí mật phóng hỏa, đốt phá, công kích sau lưng, nói xấu người khác, sách đồi trụy, trộm cướp vào tù, ám hiệu, bàn bạc lén lút, trường tư thục, ý kiến cá nhân, mật báo, ban đỏ,…',
		],
		'Câu Trần' => [
			"Thanh Long" =>'Sưng đau do ung thư, công quỹ ăn uống, phát tài nhờ bất động sản, đặc sản địa phương, trang trí nội thất tinh tế, công trình kiến trúc đẹp, thăm tù, nguy nga lộng lẫy, cung vàng điện ngọc, ung thư thực quản, u xơ tử cung, gan nhiễm mỡ có cồn, nhà máy rượu, quán rượu, quán cơm, cửa hàng quần áo, rượu lâu năm, thức ăn thừa, đồ cổ, ăn chậm, quần áo cũ, sinh khó, bạn cũ,… Có thể tham khảo Thanh Long gặp Câu Trần.', 
			"Chu Tước" =>'Nhà bị cháy, phù thũng nên không thể nói chuyện hoặc tiểu tiện, sách kiến trúc, bản vẽ kiến trúc, lệnh bắt giữ, thông báo của chính phủ, lời nói trung thực, khế ước bất động sản, kiến thức cũ, giáo dục cũ, giấy chứng nhận đất đai, giấy chứng nhận bất động sản, kiến thức nông nghiệp, nói chậm, lời lẽ tầm thường, nhắc lại chuyện xưa,… Có thể tham khảo Chu Tước gặp Câu Trần.',
			"Đằng Xà" => 'Hung trạch, quái trạch, nhà ma, ảo ảnh, tai họa lao ngục, kiến trúc đặc biệt, hoang dã, cây dây leo, tranh chấp bất động sản, cảnh sát gây phiền hà, ăn hiếp người hiền lành, cây nông nghiệp giảm sản lượng, hoa cỏ tàn lụi, không một bóng người, nội thất sơ sài, không bớt sưng, đất đai chật hẹp, địa phương nhỏ, địa phương hẻo lánh, vết sẹo,…', 
			"Bạch Hổ" => 'Đánh nhau vì nhà cửa, cây trồng bị sâu bệnh, ung thư tử vong, cục máu đông, máu cô đặc, tắc động mạch, ung thư máu, sưng phù do gãy  xương, ung thư xương, phẫu thuật cắt bỏ khối u, sườn núi đất, khối đất, đường đất, đường núi, nông cụ, nhà tù, nhà xác, nhà thuốc, bệnh viện, bộ vũ trang, cơ quan công an, đồn cảnh sát, phòng phá thai, khoa chỉnh hình,…', 
			"Huyền Vũ" => ' Vào phòng ăn trộm, nốt ruồi, kỹ viện, hang ổ kẻ trộm, nơi ẩm thấp, kiến trúc thấp bé, cống ngầm, nước tưới ruộng, nhà ma, giả mạo công an, phòng giam, phòng tối, bãi rác, nhà thiếu ánh sáng,…',
		],
		'Bạch Hổ' => [
			"Thanh Long" =>'Chất dê da hổ, đường quốc lộ cao cấp, thêm Dịch Mã là đường cao tốc, bảo kiếm, tiền trợ cấp thương tật, tiền tuất, cửa hàng ven đường, ngành vận tải, tiền của trên đường, bán máu kiếm tiền, sát thủ chuyên nghiệp, lưu sản, đau bụng kinh, kiên cường bất khuất, tướng lĩnh cao cấp,… Có thể tham khảo Thanh Long gặp Bạch Hổ.', 
			"Chu Tước" =>'Tin dữ, thư báo tử, tin xấu, lời nói thô bỉ, chửi thề, nói năng lỗ mãng, rên rĩ vì bệnh tật, nhiễm trùng máu, quảng cáo bên đường, tuyên truyền bên đường, giấy phép lái xe, sách y học, đơn thuốc, phiếu chẩn đoán, lá thư ngắn, chuyển phát nhanh, thư khiêu chiến, di thư, di ngôn, tiếng khóc,… Có thể tham khảo Chu Tước gặp Bạch Hổ.',
			"Câu Trần" => 'Sân đấm bốc, vũ đài, trường đua xe, nhà thi đấu, cơ quan chấp pháp, trại lính, ung thư máu, phòng phát thuốc, tiệm thuốc, phòng khám bệnh, cục đường bộ, thuốc viên, cây cầu, mỡ trong máu cao,… Có thể tham khảo Câu Trần gặp Bạch Hổ.', 
			"Đằng Xà" => 'Thiếu máu, cung máu không đủ, cơ thể cường tráng, ít khi bị bệnh, đánh nhau vào tù, xương cốt biến dạng, đường đi quanh co, đường vòng, rẽ ngoặt, đường hẹp, đường nhỏ, sinh khó, sợi thép, cây kim, cốt thép, cáp thép, xe cáp, dược liệu quý báu,… Có thể tham khảo Đằng Xà gặp Bạch Hổ.', 
			"Huyền Vũ" => 'Mương nước, sông ngòi, phá phách cướp bóc, cướp giật, giết người cướp của, trộm cướp giữa đường, tiểu tiện lề đường, đường đêm, bệnh sinh dục, buôn lậu dược phẩm, buôn lậu vũ khí, vận chuyển trái phép, sinh mủ, đường thuỷ,…',
		],
		'Đằng Xà' => [
			"Thanh Long" =>'Giả dối, nhà giàu mới nổi, tiền của bất ngờ, mộng phát tài, trong mộng cưới vợ, mù quáng vì tiền, áo quần lố lăng,… Có thể tham khảo Thanh Long gặp Đằng Xà.', 
			"Chu Tước" =>'Trầm tĩnh ít nói, nói không hợp ý nhau, tin tức đặc biệt, tin tức giật gân, nói mớ, nói nhảm, tiếng kêu sợ hãi, đám cháy do sấm sét, vô cớ hỏa hoạn, lời nói chói tai, luận điệu kỳ quái,… Có thể tham khảo Chu Tước gặp Đằng Xà.',
			"Câu Trần" => 'Sợ đến nỗi đi không nổi, vết sẹo, ung thư ruột, nơi nguy hiểm như núi cao vực sâu,… Có thể tham khảo Câu Trần gặp Đằng Xà.', 
			"Bạch Hổ" => 'Bụng dạ hẹp hòi, quái chiêu, vũ khí quái dị, ung thư máu, thiếu máu, huyết áp thấp, mãn kinh, bị xe đâm ngã, bệnh nan y, treo cổ tự tử, bị dây thừng siết cổ chết, kinh hãi mà chết, mắc bệnh vì giấc mơ, thêm Dịch Mã là chứng mộng du,…', 
			"Huyền Vũ" => 'Tính tình quái gở, vụ án trộm cướp khác thường, âm hồn bất tán, phiền muộn, lừa gạt, nội thương, trong lòng sợ hãi, âm khí, kỳ dị, tà khí, âm u đáng sợ, quỷ kế đa đoan,…',
		],
		'Huyền Vũ' => [
			"Thanh Long" =>'Tang vật, mại dâm, lừa tiền, đánh bạc, bệnh phong thấp đau nhức, hối lộ, dâm loạn bất kham, cơm nguội, phục vụ cá thể, bữa tiệc riêng tư, gợi cảm,… Có thể tham khảo Thanh Long gặp Huyền Vũ.', 
			"Chu Tước" =>'Nói xấu sau lưng, nịnh người khác, ngại nói rõ, thấp khớp, chia của không đều dẫn tới chấp, siêu âm, phóng hỏa, mách lẻo, mật báo, mật hàm, thông báo tìm vật, thư cá nhân, hồ sơ cá nhân, ý kiến cá nhân, nói thầm, lời lẽ bẩn thỉu, vu khống,… Có thể tham khảo Chu Tước gặp Huyền Vũ.',
			"Câu Trần" => 'Nổi mề đay, phong hàn dẫn tới phù thũng, cục nước đá, tài sản riêng, điểm ẩn náu, nhà ma, phần mộ, cơ cấu phi pháp, nhà máy ngầm, nốt ruồi, mụn cóc sinh dục, hắc điếm, mưa đá, cây cầu,… Có thể tham khảo Câu Trần gặp Huyền Vũ.', 
			"Đằng Xà" => 'Trò lừa bịp, bắt cóc, nội tâm bất an, có tật giật mình, trộm cắp thường xuyên, kẻ cướp chuyên nghiệp, bị tên trộm bám đuôi, bị người khác theo dõi, tà khí,… Có thể tham khảo Đằng Xà gặp Huyền Vũ.', 
			"Bạch Hổ" => 'Nội chiến, bí mật đấu tranh, nội bộ mâu thuẫn, bệnh phong thấp, bệnh AIDS, nội thương, lặng lẽ rơi lệ, tranh đấu riêng tư, chiến tranh lạnh, ám sát, hành nghề y trái phép, thuốc thang, xuân dược, âm u đáng sợ,… Có thể tham khảo Bạch Hổ gặp Huyền Vũ.', 
		],
	];
	return $thuVien[$thu1][$thu2];
}

function queTuong($a){
	$thuVien = [
		'111111' => 'Càn tượng trưng cho trời và năng lực sáng tạo. Tất cả các vạch đều là vạch liền, tức vạch dương, ý nghĩa là tất cả các đơn quái liên kết để hợp thành trùng quái này, cả quẻ chủ lẫn quẻ hỗ, đều là Càn. Đó là tột đỉnh của dương lực. Càn là ánh sáng, sự mạnh mẽ, tích cực, đồng thời còn mang hàm ý sự hành động và sự bền gan, trì chí. Nói rộng ra, Càn đại diện cho vũ trụ đang biến dịch không ngừng. Do đó, Càn cũng hàm ý sự mô phỏng con đường của trời, con đường cần cù trong suốt cả ngày, và con đường của sự nỗ lực không ngừng lẫn sự chăm chỉ, siêng năng. Kinh Dịch tìm cách áp dụng các nguyên lý của trời đất vào công việc và hành xử đạo đức của con người. Càn thay cho con đường của trời, còn quẻ kế tiếp, Khôn, giải thích con đường của đất. Cả hai, trời và đất, đứng đầu trong Kinh Dịch. Càn tượng trưng cho sự sung thịnh của vạn vật, khỏe mạnh, tráng kiện và sum suê. Nhưng đang giữa sự cực dương thì âm tất sẽ nảy sinh. Do đó, lời khuyên là nên thật cẩn thận. Biết lưu ý sẽ tránh được điều bất ngờ và sự cố.', // Thiên Vi Càn
		'110111' => 'Lý tượng trưng cho việc bước sau đuôi con hổ nhưng không gặp bất kỳ nguy hiểm nào. Quẻ thượng là Càn và quẻ hạ là Đoài. Quẻ này thể hiện bức tranh một người đàn ông tráng kiện và khỏe mạnh Càn đang đi trước, có người phụ nữ yếu đuối, thanh nhã Đoài đang bước theo sau. Thật khó cho cô ấy để không bị rơi lại phía sau. Lý cũng có nghĩa là lễ độ hay lịch sự. Đơn quái Đoài với đức tính hiền lành và nhu mì, đang nhận được sức mạnh và sự tráng kiện của Càn. Vì lẽ đó, dù có sự nguy hiểm trong việc bước đi sau đuôi một con hổ, nhưng vẫn an toàn.',
		'101111' => 'Đồng nhân tượng trưng cho sự cùng một khuynh hướng, hòa hợp, đồng lòng, tình bằng hữu, và tình huynh đệ. Nó có nghĩa rằng người ta có thể vững kết đồng tâm với người khác – hợp tác và hòa hợp trong các nỗ lực. Cũng có nghĩa là bằng hữu, đồng chí, đồng nghiệp, đồng sự hay bạn đồng hành. Đơn quái trên là Càn, tức trời, trong khi đơn quái dưới là Ly, tức lửa. Cả hai đều có đặc tính là vận động đi lên. Các hào hai, ba và bốn từ dưới đếm lên tạo thành hỗ quái đơn là Tốn, tượng trưng cho gió. Nhờ có thêm gió thổi, lửa sẽ bốc cao mạnh mẽ, tiến sát đến trời ở trên cao và tỏa ra sự rực rỡ. Quẻ tiêu biểu cho các mối quan hệ với người khác, và tượng trưng cho việc sẽ thành công nhờ sự giúp đỡ hay hợp tác với người khác.',
		'100111' => 'Vô vọng nghĩa là thuận theo một cách tự nhiên, không mang chút cưỡng cầu hay bắt buộc nào. Càn, đơn quái trên, tượng trưng cho trời, còn đơn quái dưới, Chấn, tiêu biểu cho sấm. Càn cũng có ý chỉ tác động, lực đẩy. Vô vọng tiêu biểu cho sự vận động trong quỹ đạo theo con đường của trời, tức các qui luật của tự nhiên; do đó mà có bốn mùa rõ rệt và vạn vật tăng trưởng cũng như phát dục một cách tự nhiên. Trong đoán quẻ, Vô vọng có nghĩa rằng đây là lúc hãy dể mọi vật đi theo chiều hướng tự nhiên của chúng – hãy buông bỏ. Đừng hành động tích cực, nhưng cũng không né tránh, lười nhác mà không làm những gì tất phải làm. vẫn phải hoàn thành các trách nhiệm.',
		'011111' => 'Cấu nghĩa là giao hữu, giao tiếp, kết cặp, gặp gỡ. Hào dưới cùng là hào âm, tức vạch đứt, nằm dưới năm vạch liền, tức các hào dương. Càn (Quẻ 1, Sáng tạo) được làm thành từ sáu vạch liền, tức sáu vạch dương. Bản chất cực độ của lực dương đang mang đến sự xuất hiện của lực âm. Như vậy, Quẻ 44 này là xuất phát từ Quẻ 1. Sự có mặt của một hào âm bên dưới năm hào dương có nghĩa rằng sự giao phối giữa hai lực đang bắt đầu. Tượng của quẻ này là một cô gái đang chào mời bản thân mình với các nam nhân, và gợi ý rằng không nên hành động chỉ vì bị ảnh hưởng. Lực âm đang tăng lên và lực dương đang giảm xuống. Hãy đề phòng những gặp gỡ bất ngờ, tai nạn hay điều rủi ro. Quẻ này gợi ý sự bắt đầu suy vi của vận may.',
		'010111' => 'Tụng có nghĩa là sự kiện tụng, tranh chấp, mang việc gì đó ra tòa, và cãi cọ. Đơn quái trên là Càn, tượng trưng cho sự cường tráng của dương, và hàm ý sự tiến bộ cũng như vận động đi lên. Đơn quái dưới là Khảm, tiêu biểu cho nước. Nước chảy từ cao xuống thấp. Do đó, hai đơn quái này đôi nghịch lẫn nhau. Thêm nữa, Càn cai quản hoặc chỉ dẫn cho người dưới thông qua quyền hạn trong khi Khảm, chông đối lại bên trên thông qua những phương tiện ranh ma, vòng vèo. Do đó, quẻ này có ý nói rằng mọi việc thật là phức tạp, đầy những tranh chấp, trở ngại và xung đột. Đây không phải là một quẻ cát.',
		'001111' => 'Độn có nghĩa là thoái bộ, rút lui, thoái ẩn hay bỏ trốn. Hai hào dưới cùng là các hào âm, còn bốn hào bên trẽn là các hào dương, có nghĩa rằng lực âm đang dần dần đi lên, trong khi lực dương đang dần dần nhường bước. Trong đoán quẻ, điều đó có nghĩa rằng cơ đồ, gia sản đang bắt đầu sa sút, suy vi, và sự thoái ẩn cũng như việc không tiến tới trước nữa sẽ mang đến tốt lành.',
		'000111' => 'Bĩ tượng trưng cho sự trở ngại hay bế tắc. Đây là quẻ đối của quẻ trên (quẻ Thái). Đơn quái trên là Càn, tức trời, và lực dương cường kiện của nó đang bị đẩy đi lên. Đơn quái dưới, Khôn, tức đất, và lực âm của nó đang bị đè hướng xuống dưới. Các lực của trời và đất, âm và dương, đang bị cách trở và ngăn chặn. Giữa hai lực chẳng có sự chuyển động giao hòa với nhau. Trong đoán quẻ, Bĩ tượng trưng cho sự gian nan, vất vả và cam go. Thêm nữa, bạn sẽ chẳng nhận được sự giúp đỡ nào của người khác. Trong quản lý, Bĩ có nghĩa là không có sự thống nhất hay đồng cảm giữa cấp trên và cấp dưới. Cảm nghĩ của cấp dưới đã không được cấp trên thấu hiểu, và các chính sách của cấp trên không nhận được sự ủng hộ của cấp dưới.',
		'111110' => 'Quải nghĩa là vụng về, trệch hướng, rã rời. Trong quẻ này, hào âm (vạch đứt) nằm trên cùng, bên dưới là năm hào dương (các vạch liền). Nó không thể giao hòa với dương dược và đang phải chờ bị thay thế hoặc nhường bước cho lực dương. Năm hào dương bên dưới, cộng với một hào âm lại không thể giao phối với nhau được nên tạo thành một tình cảnh thật lúng túng, khó xử. Từ cách nhìn này, lực dương đang sung thịnh. Chẳng bao lâu nó sẽ trở nên mạnh mẽ đến quá độ, đủ để gây ra các vấn nạn. Đó là tai họa theo sau sự càng lúc càng căng thẳng. Trong đoán quẻ, điều này có nghĩa rằng sự quá sức hăng hái, sốt sắng có thể gây nên những tình huống khó xử, và gợi ý một tình huống nguy hiểm mà chỉ có thể tránh được bằng sự quyết tâm bất biến.',
		'110110' => 'Đoài có nghĩa là vui vẻ hay hài lòng. Cả hai đơn quái trên và dưới đều là Đoài. Ớ mỗi đơn quái, hào âm đều đóng ở vị trị chủ đạo bên trên hai hào dương. Lực dương tiêu biểu cho sự vững chắc và cao quí, trong khi lực âm tượng trưng cho sự yếu mềm và thấp hèn. Bởi yếu mềm và thấp hèn lại được trọng vọng và đóng ở ngôi vị cao hơn sự cứng rắn và cao quí, nên dĩ nhiên dây chính là nguyên nhân dẫn đến hạnh phúc và vui vẻ. Đoài tượng trưng cho ao chuôm. Ao chuôm thì làm ẩm và mang màu mỡ đến cho vạn vật, khiến chúng thích thú và vui vẻ. Bởi cả hai đơn quái đều là Đoài, nên ý tưởng vui vẻ và sự làm tốt, làm giàu càng mang giá trị gấp đôi. Trong đoán quẻ, điều này có nghĩa rằng bạn đang gặp hồi may mắn đầy vui vẻ và thích thú.', // trạch vi đoài
		'101110' => 'Cách nghĩa là cách mạng, thay đổi, cải cách, canh tân. Đơn quái trên là Đoài, tượng trưng cho ao, chuôm; đơn quái dưới, Ly, tượng trưng cho lửa. Lửa đang cháy trong đầm. Nếu lửa cháy dữ dội, nước trong ao chuôm sẽ khô. Nếu nước mênh mông hơn, lửa sẽ tắt ngấm. Do đó tượng của quẻ này là sự cải cách hay thay đổi. Ly cũng tượng trưng cho mặt trời. Ớ đây quẻ đang tọa lạc ở hướng tây, hướng do Đoài đại diện. Do đó, quẻ có ý nghĩa là sự thay đổi từ ngày sang đêm. Thêm nữa, Ly tượng trưng cho mùa hè, còn Đoài tượng trưng cho mùa thu. Như vậy, quẻ này cũng hàm ý về sự thay đổi của mùa màng hay thời tiết. Cách là quá trình chuyển dịch từ cái cũ sang cái mới. Cuộc canh tân này cần tuân theo con đường thay đổi chính đáng. Trong đoán quẻ, điều đó có nghĩa rằng tất cả các vấn đề của bản thân lẫn các vấn đề thuộc môi trường của người đó đang đến thời kỳ thay đổi.',
		'100110' => 'Tùy có nghĩa là đi theo, vâng lời, đồng nhất, và tháp tùng. Quẻ hàm ý nhân nhượng theo ý kiến hay quan điểm của người khác, không cố chấp bám theo ý kiến riêng của mình. Quẻ cũng hàm ý sự vâng theo những thăng trầm của sô” phận và những biến dịch do thời gian mang đến. Đơn quái trên là Đoài, tiêu biểu cho các cô gái trẻ, trong khi đơn quái là Chấn dưới tượng trưng cho những nam nhân tráng kiện. Toàn quẻ ám chỉ người đàn ông tráng kiện đó đang cung phụng và chiều chuộng cô gái trẻ. Trong đoán quẻ, Tùy tượng trưng cho cái cương kiện đang phục tùng theo cái âm nhu, do đó giành được sự sẵn lòng phục tùng của mọi người và thành công trong công việc.',
		'011110' => 'Đại quá nghĩa là sự quá độ hay sức mạnh thái quá. Đơn quái trên là Đoài, tượng trưng cho ao chuôm hay đầm lầy, còn đơn quái dưới là Tốn, tiêu biểu cho cây cối. Cây bị ngập quá nhiều nước sẽ bị chết úng. Trong đoán quẻ, có nghĩa rằng những trách nhiệm và gánh nặng của bạn rất nặng nề. Sức mạnh không cân xứng với ý chí — một tình huống quá sức gieo neo.',
		'010110' => 'Khốn có nghĩa là khó khăn, nghịch cảnh, khổ đau, buồn bã, nghèo hèn và mệt mỏi. Đơn quái trên là Đoài tượng trưng cho ao, chuôm, còn đơn quái dưới là Khảm, tượng trưng cho nước. Nước bình thường sẽ tụ tập trong ao chuôm, nhưng trong quẻ này nước lại ở bên dưới ao chuôm, điều đó có nghĩa rằng nước đang chảy thoát ra ngoài, khiến ao chuôm bị khô cạn. Những thứ cần thiết đang không có ở chung quanh. Tình hình thật nguy hiểm. Trong đoán quẻ, điều này có nghĩa rằng đang ở giữa cảnh khó khăn và thiếu thốn. Tuy nhiên, có thể chờ đợi cho đến lúc hanh thông bằng cách lúc nào cũng giữ vững con đường chính trực, sự tự chủ và nhẫn nại.',
		'001110' => 'Hàm nghĩa là cảm nhận và phản ứng – ảnh hưởng hỗ tương. Vạn sự vạn vật trên đời này đều có những cảm xúc hỗ tương hoặc những xung động đồng cảm với nhau, phản ứng hỗ tương về mặt cảm xúc mà hiển hiện nhất chính là giữa nam và nữ. Đơn quái trên, Đoài, tượng trưng cho thiếu nữ, còn đơn quái dưới, Cấn, tượng trưng cho thanh thiếu niên. Người nam trẻ ở bên dưới người nữ trẻ — có sự tiếp xúc và phản ứng. Đoài cũng tiêu biểu cho niềm vui và hạnh phúc, trong khi cấn tượng trưng cho ngừng nghỉ và yên tĩnh. Do đó, toàn quẻ tượng trưng cho bình an và yên tịnh xuất phát từ sự hài lòng, kết quả của hạnh phúc hay vui vẻ. Trong đoán quẻ, điều này có nghĩa rằng mọi việc sẽ diễn ra đúng như hy vọng và sẽ có hạnh phúc. Tuy nhiên, phải tránh thái độ ngoan cố và bất chính, vì một tương tác như vậy sẽ gây ra ô uế.',
		'000110' => 'Tụy nghĩa là tập hợp, tụ tập hoặc nhóm lại với nhau. Đơn quái Khôn ở dưới tượng trưng cho số đông, cho sự vâng lời, phục tùng và đi theo. Đơn quái Đoài ở trên tiêu biểu cho hạnh phúc và hài lòng. Như vậy, tượng của toàn quẻ là số đông đó đang vui vẻ, hạnh phúc và thuận tòng. Hào thứ năm, đếm từ dưới lên, là hào thượng chủ và hào thứ tư là hào thượng quản. Cả hai đều là hào dương. Bốn hào âm đang vây xung quanh hai hào dương và vâng lời chúng. Trong đoán quẻ, điều này có nghĩa rằng tinh thần và tài vật lực của một người đang được tập hợp lại. Đây là quẻ rất cát tường.',
		'111101' => 'Đại hữu tiêu biểu cho sự dồi dào, phong phú, giàu sang, phú dật. Đơn quái trên là Ly, tượng trưng cho mặt trời. Đơn quái dưới là Càn, tức trời. Mặt trời nằm trên cao, tỏa ánh sáng xuống vạn vật. Quẻ Ly cũng tượng trưng cho mùa hè, lúc vạn vật đang sung thịnh. Quẻ dưới tượng trưng cho mùa thu, lúc vạn vật đã đạt đến mức viên mãn và thời gian thu hoạch đã đến, ám chỉ  sự dồi dào, phong phú và thịnh vượng. Trong đoán quẻ, điều này có nghĩa rằng bạn đang ở vào lúc cực kỳ may mắn. Nhưng sau khi đạt đến đỉnh thịnh thì sự suy tàn sẽ đến. Do đó, phải cẩn thận, khôn khéo, và biết dè chừng. Không nên kiêu mãn.',
		'110101' => 'Khuê tượng trưng cho sự bất hòa, chia rẽ, và kình chống nhau. Đơn quái Ly ở trên là lửa, đơn quái Đoài ở dưới là ao chuôm. Lửa thì cháy bốc lên và nước của ao chuôm thì chảy xuống dưới. Hai đơn quái này do đó đối lập và bất hòa nhau. Trong đoán quẻ, quẻ này mang ý nghĩa các ý kiến không đạt được sự đồng tình với nhau và không dễ gì hoàn thành được bất cứ điều gì.',
		'101101' => 'Vì đơn quái trên lẫn đơn quái dưới đều là Ly, nên quẻ này cũng được gọi là Ly. Lynghĩa là tươi sáng, rực rỡ, đẹp đẽ, tượng trưng cho mặt trời và lửa. Tượng của quẻ có ý nói một mặt trời vừa mọc yà một mặt trời khác lập tức hiện ra chiếu sáng khắp vạn vật, giúp mọi vật sinh sôi, nảy nở và sum sê, cũng như khiến cảnh sắc đẹp đẽ xuất hiện. Trong đoán quẻ, nó có nghĩa là mặt trời đang mọc lên cao, mọi việc sẽ diễn ra êm đẹp đôi với người thành thật và cương trực. Nhưng đối với kẻ ương bướng và những người thiếu thành thật, thiếu công chính, thất bại là điều chắc chắn.', // Hỏa vi ly
		'100101' => 'Phệ hạp có nghĩa là đôi môi khép trở lại với nhau sau khi cắn hay nhai cái gì đó. Các hào dương ở dưới cùng và trên cùng tượng trưng cho đôi môi. Các hào âm hai, ba và năm là răng. Hào bốn, hào dương, bị kẹp ở giữa giống như nó là vật gì đó đang bị nhai hay cắn. Sau khi vật đó đã được cắn xong, đôi môi khép vào nhau trở lại. Trong chiêm quái, quẻ hàm ý các trở ngại đang chắn trên đường, nhưng có thể đạt được mục tiêu nếu trở ngại đó được gỡ bỏ hay vượt qua – bị phá hủy giống như việc nhai nhỏ cái gì đó thành nhiều mảnh.',
		'011101' => 'Đỉnh có ý chỉ cái vạc hay đỉnh dùng trong tế lễ có hai tai quai và ba chân. Nếu nhìn vào hình thể của quẻ, chúng ta có thể thấy nó tương tự như một cái vạc ba chân. Hào âm dưới cùng là vạch đứt, tượng trưng cho chân vạc. Vạch đứt ở vị trí thứ năm tương tự như hai tai quai, còn vạch liền trên cùng thì tiêu biểu cho cái nắp. Đơn quái trên là Ly tượng trưng cho lửa. Đơn quái dưới là Tốn tượng trưng cho gỗ. Toàn thể quẻ có tượng là ngọn lửa củi đang nấu thức ăn. Ba chân của cái Đỉnh tiêu biểu cho môi trường, của cải và sự thông minh – cả ba đều đang trong tình trạng ngăn nắp, an toàn và vững chắc. Trong đoán quẻ, điều này có nghĩa là sự ổn định và hanh thông.',
		'010101' => 'Vị tế nghĩa là trước khi hoàn tất, chưa hoàn thành, và trước khi có kết quả, kết cục hay kết thúc. Đơn quái trên Ly tượng trưng cho lửa, trong khi đơn quái dưới Khảm tượng trưng cho nước. Lửa cháy bốc lên trên, còn nước chảy tràn xuống dưới. Nhưng ở đây lửa lại ở trên nước, nghĩa rằng cả nước lẫn lửa không thể hòa hợp với nhau hoặc tạo được lợi ích cho nhau. Do đó, chẳng có gì hoàn thành hay hoàn tất. Trong đoán quẻ, điều này có nghĩa rằng vận hội giờ đây đang không được tốt đẹp cho lắm, nhưng sẽ dần dần thay đổi để trở nên tốt đẹp hơn. từ từ, hãy hòa thuận cùng với mọi người, và vận may sẽ từ từ cải thiện. Sự khinh suất, liều lĩnh hay hấp tấp khi thực hiện các công việc sẽ dẫn đến thất bại. Những đầu tư hợp tác là cát tường.',
		'001101' => 'Lữ nghĩa là sự đi xa, cuộc hành trình hoặc người sống lang bạt. Đơn quái Ly ở trên tượng trưng cho lửa, trong khi đơn quái Cấn ở dưới tượng trưng cho núi. Cộng lại, toàn quẻ mô tả cảnh một ngọn lửa đang cháy giữa nơi hoang vu của một ngọn núi. Núi thì đứng yên và bất động. Nhưng lửa thì cháy lan từ nơi này sang nơi khác, liên tục di chuyển. Trong trường hợp này, núi tượng trưng cho chuyến đi, còn lửa tượng trưng cho người lữ khách, người đang di chuyển và không ở yên tại bất cứ nơi nào hết. Trong đoán quẻ, điều này giống như ai đó đang ngao du xa nhà khắp chốn. Trong tất cả các vấn đề, người này đang cảm thấy bơ vơ, lạc lỏng, cô độc và băn khoăn, lo lắng. Tượng là sự vất vả và lao động. Giống như một chuyến đi, vận hội thiếu sự ổn định. Trôi nổi, lang thang và bất ổn định trong cuộc sông, mọi việc đều đang diễn ra không đúng như mong đợi. cần phải thận trọng và tự chủ. Đừng vội vàng trong mọi việc hay hành động quá khinh suất. Hãy xử lý các vấn đề',
		'000101' => 'Tấn nghĩa là tiến bước, tấn tới, tiến bộ, đi lên. Đơn quái trên là Ly, tượng trưng cho mặt trời, và đơn quái dưới là Khôn, tượng trưng cho đất. Mặt trời ở trên mặt đất như vào buổi sáng, lúc mặt trời mọc, tỏa ánh nắng rực rỡ của nó lên khắp thế giới. Lúc mặt trời mọc cũng là lúc bắt đầu một ngày mới và hàm ý sự bắt đầu của vận động và hành động. Ly cũng có nghĩa là tươi sáng, còn Khôn hàm ý sự nhượng bộ, phục tùng, tuân theo hay vâng lời. Như vậy, bằng việc qui phục sự tươi nhuận, sự phát triển hay tiến bộ rõ ràng là đạt được. Trong chiêm quái, quẻ này có nghĩa rằng, giống như mặt trời mọc ở phương đông và vạn vật đang bắt đầu phát triển, vận hội của bạn đang mở ra, và tất cả sẽ diễn ra đúng như mong đợi.',
		'111100' => 'Đại tráng có nghĩa là lực dương đặc biệt đang mạnh mẽ, sung thịnh, hùng mạnh, cường tráng và oai nghiêm. Bôn hào dương dưới cùng đang đi lên, khiến hai hào âm trên cùng phải rút lui. Do đó, nó tượng trưng rằng người ta không thể ngăn chặn hay phong tỏa ảnh hưởng, sức mạnh và thanh thế được. Đơn quái trên là Chấn, tượng trưng cho sấm, còn đơn quái dưới là Càn, tượng trưng cho trời. Sấm trên trời đang rền vang với sức mạnh, uy vũ và oai nghiêm không gì sánh nỗi. Trong đoán quẻ, điều này có nghĩa rằng giàu sang và thịnh vượng đang ở ngay đây.Nhưng sự thái quá hay thái độ cứng nhắc hoặc ngoan cố trong bất kỳ công việc nào cũng đều sẽ mang đến bất hạnh. Phải biết cẩn thận',
		'110100' => 'Qui muội có nghĩa là cô gái nhỏ lập gia đình trước cả chị gái của mình. Ớ Trung Quốc thời xưa, điều này vi phạm qui ước của xã hội và bị xem là không chính đáng. Đơn quái trên, Chấn, tượng trưng cho người con trai trưởng, trong khi đơn quái dưới, Đoài, tượng trưng cho người con gái út, niềm vui, niềm thích thú. Sự hợp nhất của người con gái nhỏ tuổi và người đàn ông lớn tuổi mà dựa trên những thôi thúc của dam mê cũng bị xem là vi phạm đạo đức xã hội. Trong đoán quẻ, điều này tượng trưng cho sự vi phạm các qui ước hoặc đạo đức xã hội và những hành động dựa trên tình cảm. Vì vậy, vận rủi bất ngờ là điều khó tránh. Kết quả là người ta phải thật cẩn thận.',
		'101100' => 'Phong nghĩa là phong phú, dồi dào, đầy đủ và sung túc. Đơn quái trên Chấn tiêu biểu cho sự vận động trong khi đơn quái Ly ở dưới tiêu biểu cho sự rực rỡ và ánh sáng. Như vậy, quẻ mô tả một sự vận dộng trung thực và công khai. Trung thực và công khai trong mọi việc sẽ dẫn đến thành công và phát triển. Một khi thành công đã trở thành hiện thực, theo sau đó sẽ là sự sung túc và phong phú. Chấn cũng tượng trưng cho sự uy nghiêm, đường bệ, thanh danh và lòng can đảm, còn Ly thì tượng trưng sự khôn ngoan và trí thông minh. Cộng lại với nhau thì sự khôn ngoan và sự gây kinh sợ mang lại sự uy nghi, hùng vĩ không gì sánh bằng. Trong đoán quẻ, điều này có nghĩa rằng sự phát đạt, thịnh vượng cực độ đang trong tầm tay. Bởi mọi sự sau khi đã lên đến cực đỉnh thì sẽ suy, nên phải biết nghĩ đến đường hướng hành động để tránh sự đi xuống này.',
		'100100' => 'Chấn nghĩa là gây phản ứng, gợi hứng, gây náo động và dấy động. Đơn quái trên lẫn đơn quái dưới đều là Chấn. Trong quẻ này, hai hào dương, nằm dưới cuối tại mỗi đơn quái đang bị ngăn chặn, kiềm chế bởi các hào âm. Bị ngăn chặn, nên sự phẫn nộ của lực dương dấy sinh. Bằng sự quyết tâm, lực dương đang cố gắng chọc thũng sự áp chế của âm và khuếch trương. Đơn quái Chấn tượng trưng cho sấm. Bởi cả hai đơn quái đều là Chấn, nên tượng của quẻ là sấm đang ở khắp nơi, dấy sinh và chuyển động. Trong đoán quẻ, điều này có nghĩa rằng giờ đây đã đến lúc để dấy động, khắc phục các khó khăn, và hoàn thành các ước nguyện hay tham vọng.', // Lôi vi chấn
		'011100' => 'Hằng nghĩa là lâu bền và bất biến. Đơn quái trên là Chấn, tượng trưng cho con trai trưởng, trong khi đơn quái dưới là Tốn, tượng trưng cho con gái trưởng. Nam đang trong vị trí bên trên nữ, có nghĩa là hôn nhân, hòa hiệp. Đối với các đôi vợ chồng, có nghĩa rằng con đường hôn nhân đó bền chặt đến răng long đầu bạc. Nên duy trì tình trạng hiện tại và tránh các kế hoạch mới. Nhờ vậy, có thể đạt được vận may lâu dài và thoát khỏi ưu phiền.',
		'010100' => 'Giải nghĩa là tháo tung, phóng thích, xua tan, làm vơi bớt sự gian nan và khó khăn. Đơn quái trên Chấn tượng trứng cho sấm, còn đơn quái dưới Khảm tượng trưng cho mưa. Do đó, toàn quẻ có ý nói đến các cảm xúc bị dồn nén, chất chứa trong lòng đang bị mưa và sấm giũ sạch và xóa tan. Khảm tượng trưng cho mùa đông, còn Chấn tượng trưng cho mùa xuân. Cả hai cộng lại gợi ý cảnh đông tàn và xuân sang. Cái lạnh cắt da đang tan biến và mưa xuân bắt đầu rơi. Sự ấm áp đang lan tỏa khắp mặt đất và vạn vật vui tươi, được ban cho sức sống, được làm cho màu mỡ và phấn khởi. Trong đoán quẻ, nó có nghĩa rằng những gian khổ đang tan dần; sự vận động mới có thể bắt đầu.',
		'001100' => 'Tiểu quá có nghĩa là hơi quá độ, bất hòa hợp và rắc rối. Các hào thứ ba và thứ tư từ dưới đếm lên là các hào dương. Các hào còn lại là những hào âm. Lực dương không đóng ở ngôi vị làm chủ. Thêm nữa, nó đang bị bao vây bởi lực âm và không thể nào phát huy được trọn vẹn vai trò, vì vậy có hơi gặp khó khăn. Ầm tiêu biểu việc nhỏ và dương tiêu biểu cho việc lớn. Hào giữa, hào chủ tại mỗi đơn quái, là hào âm. Do đó, điều này có ý nói việc nhỏ không xong thì chẳng hy vọng gì hoàn thành được đại sự. Hình tượng của quẻ có dáng vẻ hai người đang ngồi đâu lưng vào nhau, do đó gợi ý sự bất hòa. Trong đoán quẻ, điều này ám chỉ rằng mọi việc sẽ không diễn ra suôn sẻ. Người ta cần giữ mình ở bên trong phạm vi, phận sự hay chuyên môn của mình, và đừng cố gắng bành trướng hay xông tới.',
		'000100' => 'Dự có nghĩa là trước hay sớm, và ẩn chứa những ý như sự báo trước, biết trước và sự chuẩn bị. Đơn quái trên là Chấn, tượng sấm chớp, còn đơn quái dưới là Khôn, tức đất. Sau cơn sấm chớp, mùa xuân hiện ra trên trái đất, mặt trời sẽ chiếu ánh nắng xuống vạn vật. Cây, cỏ và hoa sẽ được ban cho sức sống, và chúng sẽ đâm chồi, nảy lộc. Cảnh tượng thật hạnh phúc và vui vẻ. Đối với con người, đó cũng là lúc để chuẩn bị cho công việc mới, hành động mới.',
		'111011' => ' Tượng của quẻ này là thời tiết, lúc những đám mây dày đặc đã xuất hiện nhưng chưa có mưa. Quẻ thượng là Tốn, tượng trưng cho gió và mây. Quẻ hạ là Càn, tức bầu trời. Khi gió và mây ngự trị trên bầu trời, thời tiết thật oi ả, u ám, như thể trời sắp mưa nhưng chưa thật sự mưa. Nhìn một bầu trời như vậy người ta cảm thấy lo lắng, không an tâm. Do đó, quẻ này ám chỉ mọi việc sẽ không diễn ra trôi chảy hay êm đẹp. Đầy trở ngại. Mọi việc sẽ không diễn ra như mong đợi. Đừng bi quan, yếu đuối hay quá độ. Hãy kiên nhẫn và tiếp tục cố gắng, bởi vì sau khi mây tan sẽ có ánh sáng mặt trời và vận hội sẽ thay đổi.',
		'110011' => 'Trung phu nghĩa là ngay thẳng và thật thà. Đơn quái trên là Tốn tượng trưng cho gió, trong khi đơn quái dưới là Đoài, tượng trung cho ao hồ. Hình tượng là gió đang thổi ngang qua mặt hồ, khiến cho nước trong hồ xao động thành những con sóng. Do vậy, điều này cũng giống như người trên đang đối xử với thuộc cấp của mình bằng sự tin cậy và thành thật, khiến họ tiến bước trong sự hòa hợp, đồng thời sẵn lòng thực hiện phận sự của mình và tuân phục. Đoài cũng tượng trưng cho niềm vui và sự thích thú, trong khi Tốn tiêu biểu cho sự vâng lời và tuân phục. Do đó, toàn quẻ mô tả sự hạnh phúc và phục tùng một cách ngoan ngoãn, hoàn toàn không có sự giả dối và giả vờ, nhạy cảm và biết nghĩ cho nhau. Trong đoán quẻ, điều này có nghĩa rằng sự thành thật, ngay thẳng và tin tưởng khi tiến hành công việc sẽ có nghĩa là sự mở ra vận may và diễn tiến suôn sẻ.',
		'101011' => 'Gia nhân nghĩa là gia đình hay những người trong gia đình. Cũng có thể hiểu đó là sinh kế và tài sản của gia đình. Điều bất biến của xã hội và con người là người nam thì ra ngoài làm việc hoặc chiến đấu, còn phụ nữ thì quán xuyến việc nhà. Trong quẻ này, hào thứ năm (hào thứ hai tính từ trên xuống), là hào dương, chiếm vị trí trung tâm của đơn quái trên. Hào thứ hai tính từ dưới lên là hào âm và cũng chiếm vị trí chính giữa của đơn quái dưới. Bởi cả hai đều đắc vị (ở đúng vị trí của mình), nên quẻ có nghĩa là sự bền chặt, vững chãi của gia đình – người chồng thì làm việc bên ngoài, còn người VỢ ở trong nhà quán xuyến việc gia đình. Đơn quái trên Tốn tiêu biểu cho người con gái trưởng, trong khi đơn quái dưới là Ly tượng trưng cho người con gái thứ. Người lớn tuổi hơn đi trước người nhỏ tuổi, duy trì chuỗi trình tự thích hợp giữa người nhiều tuổi hơn và người nhỏ tuổi hơn. Trong đoán quẻ, quẻ này có nghĩa là gia đình đang đi trên con đường thích hợp và thịnh vượng.',
		'100011' => 'ích có nghĩa là tăng, thêm, được lợi. Đơn quái Tốn ở trên tượng trưng cho gió, trong khi đơn quái Chấn ở dưới tượng trưng cho sấm. sấm do lực dương sinh ra, trong khi lực âm làm chuyển động gió. Cả hai đều rất quan trọng và giúp cho vạn vật sinh sôi, nảy nở, phát triển, do đó quẻ mang ý nghĩa sự tăng thêm. Ý tưởng cơ bản của quẻ là sự tăng trường của mọi vật, đồng thời hàm ý cái tốt chung là ưu tiên, chứ không phải những quan tâm cá nhân. Giống như trong quẻ với gió chuyển dộng ở bên trên và sấm động ở bên dưới, vạn vật có thể hành động tích cực và hanh thông. Trong đoán quẻ, điều này có nghĩa rằng với sự hăng hái hoàn toàn, bạn có thể mở ra con đường, do đó gặt hái được cái gì đó hữu lợi.',
		'011011' => 'Cả hai đơn quái trên và dưới đều là Tốn, tượng trưng cho gió. Nơi nào gió cũng đến được, mang đến ý nghĩa cho quẻ này là sự đến và đi. về mặt hình tượng, hào âm (vạch đứt) ở mỗi đơn quái đang chìm bên dưới hai hào dương (vạch liền). Lực âm đang thoái bộ hoặc rút xuống dưới một cách tiêu cực; nhưng trong trường hợp này, tuy các hào âm đã chìm xuống bên dưới, nhưng nó lại chẳng có nơi nào để rút lui. Như vậy, quẻ này cũng có nghĩa là sự vâng lời và tuân phục. Trong đoán quẻ, điều này có nghĩa rằng người ta không thể hành động với tư cách người xướng xuất, lãnh đạo hay chỉ đạo được. Thay vào đó, người ta phải tiến bước như thể nương theo gió, tuân theo sự lãnh đạo của người khác, để cho tình huống tự phát triển một cách tự nhiên. Bằng cách này, người ta có thể đạt được lợi thế. Vận hội đang chuyển động giống như cơn gió. Bất ổn định và quanh co. Trong đối nhân hay xử thế, phải có thái độ khiêm cung, tùng phục và nhanh chóng thích ứng theo hoàn cảnh đổi thay. Nếu làm được điều này, khi đó bạn có thể gặt hái được đôi chút phần thưởng. Có thể gặp những rủi ro sau đây: trộm cướp, sự bất lợi do chần chừ và thiếu dứt khoát, sự tổn thất hay thất bại do xung đột hay hành vi manh động.',// Phong vi Tốn
		'010011' => 'Hoán có nghĩa là tan rã, giải tán, tan tác. Đơn quái trên là Tốn, tượng trưng cho gió, đơn quái dưới là Khảm, tượng trưng cho nước. Khi gió thổi, nước bị tan tác. Khảm cũng tiêu biểu cho mùa đông và băng tuyết, trong khi Tốn tượng trưng cho mùa xuân và gió. Như vậy, quẻ mô tả cảnh những cơn gió mùa xuân đang thổi tan cái lạnh cắt da và làm tan băng tuyết của mùa đông. Trong đoán quẻ, điều này có nghĩa rằng vận rủi, khó khăn và gian khổ đang bắt đầu tan biến – sự bắt đầu của bành trướng và phát triển. Vận hội bắt đầu thay đổi và các gian nan đang tan dần nhưng cũng đừng quá dễ dãi, buông lỏng. Thất bại sẽ đến từ sự thiếu thận trọng, bất cẩn và quá phóng túng. Vận may to lớn đối với nghề nghiệp hay kinh doanh liên quan đến thuyền bè, công việc vận chuyển hoặc kinh doanh vận tải. Những điều sau đây có thể xảy ra: một chuyến đi xa nhà, nhận được sự giúp dỡ của ai đó, hoặc sự thất bại do thiếu ý chí hay không kiên định.',
		'001011' => 'Tiệm nghĩa là tiến tới hay tiến bộ theo trình tự, dần dần. Đơn quái trên là Tốn tượng trưng cho cây cối, trong khi đơn quái dưới là Cấn tượng trưng cho núi. Xét chung, tượng của quẻ là hình ảnh của cây cối đang mọc trên một ngọn núi. Cây phát triển một cách chậm chạp và dần dần, do đó quẻ có ý muôn nói đến sự tăng tiến dần dần. Trong đoán quẻ, nó có nghĩa rằng mọi sự đang dần dần mở rộng. Trong Kinh Dịch, loài chim nước bay từ chỗ có nước đến đất liền, đến cây, rồi đến núi. Điều đó cũng tương tự như việc các cô gái theo chồng về những nơi xa lạ. Sự chuyển động trong cả hai trường hợp này đều mang lại thịnh vượng và hạnh phúc.',
		'000011' => 'Quán nghĩa là quan sát, suy xét, trầm tư suy nghĩ, ngẫm nghĩ và tự kiểm thảo. Đơn quái trên là Tốn (gió) và đơn quái dưới là Khôn (đất). Toàn quẻ tượng trưng cho cơn gió lớn đang thổi trên mặt đất. Do đó, đây là thời điểm cho sự vận động – lúc lắc và run rẩy – và cho sự tiến tới cẩn thận. Trong chiêm quái, quẻ gợi ý nên giữ gìn tình trạng hiện tại một cách bình tĩnh và khách quan. Có thể đạt được biến chuyển thông qua suy ngẫm, quán xét và tự kiểm thảo.',
		'111010' => 'Nhu có nghĩa là chờ đợi. Hạ quái (quẻ dưới) là Càn, tượng trưng cho sự khang kiện, tích cực và năng nổ. Thượng quái (quẻ trên) là Khảm, tiêu biểu cho sự nguy hiểm, do đó gây cản trở cho sự hoạt động, hoạt bát, sôi nổi và hành sự của Càn. Quẻ Nhu hàm ý người ta cần tránh sự nguy hiểm gây ra bởi tinh thần cấp tiến cực đoan và thái độ quá chăm chăm tiến về phía trước, bằng cách chờ đợi nhẫn nại bằng lòng tự trọng và kỷ luật tự giác cho đến khi thời cơ may mắn hơn, tốt đẹp hơn xảy đến trước khi tiến bước về phía trước. Ý nghĩa chung là hãy chờ đợi hoặc chờ đến thời của mình.',
		'110010' => 'Tiết nghĩa là điều khiển, hạn chế và câu thúc. Đơn quái Khảm ồ trên tượng trưng cho nước, còn đơn quái dưới là Đoài, tượng trưng cho ao hồ. Tượng của quẻ là một cái chuôm đang đón nhận nước. Khi nhận quá nhiều nước, chuôm sẽ bị ngập đầy nước; nếu nhận quá ít nước, chuôm sẽ bị khô cạn. Như vậy, khi đón nhận nước, chuôm cần phải có sự kiểm soát và quản lý. Tượng của quẻ giống như một cây tre. Theo thứ tự từ dưới lên, các hào một và hai là các hào dương (vạch liền), các hào ba và bốn là các hào âm (vạch đứt), hào năm là dương, và hào sáu là âm. Sự luân phiên này tương tự như những lóng cách đều trên thân tre, như vậy càng làm rõ ý tưởng đồng bộ hóa và điều khiển. Trong đoán quẻ, điều này có nghĩa rằng người ta phải thực hiện bổn phận của mình, phải biết tự chủ và hài lòng với địa vị hiện tại. Hãy tránh sự tham lam và thèm muốn. Không tôn trọng lệ luật, sự bừa bãi và thiếu kiềm chế nhất thiết sẽ dẫn đến gian khổ, khó khăn hay nghèo đói.',
		'101010' => 'Ký tế nghĩa là mọi sự đang hoàn tất hay đã hoàn tất — sau khi hoàn tất, hoàn thành. Lực dương tượng trưng cho số lẻ, và lực âm tượng trưng cho số chẵn. Các hào thay phiên nhau trong toàn quẻ, một dương (vạch liền) rồi một âm (vạch đứt). Mỗi hào đều ở đúng vị trí của mình, và hai lực đang nối tiếp qua lại với nhau. Đơn quái trên là Khảm tượng trưng cho người con trai thứ, trong khi đơn quái dưới là Ly tượng trưng cho người con gái thứ. Nam và nữ đều õ trong chỗ thích hợp của mình, nói lên sự liên kết phù hợp. Trong đoán quẻ, điều này có nghĩa rằng giờ đây đã đến lúc thành công và tiếng tăm. Nhưng thời gian này sẽ không kéo dài lâu và người ta phải thận trọng đề phòng vận may suy tàn.',
		'100010' => 'Truân tượng trưng cho sự bắt đầu của vạn sự vạn vật. Cũng giông như những mầm chồi non yếu ớt và không thể chống chọi được với mưa rào và gió mạnh. Tình huống mới bắt đầu đầy gian khổ, khó khăn và trở ngại. Hãy cô” gắng chịu đựng những khó khăn hiện tại, nỗ lực trong thầm lặng. Tự nhiên những khó khăn sẽ tan biến và thời cơ thuận lợi sẽ đến.',
		'011010' => 'Tỉnh nghĩa là cái giếng chứa nước. Đơn quái Khảm ở trên tượng trutig cho nước, trong khi đơn quái Tốn ồ dưới tượng trưng cho gỗ. Nó cũng có nghĩa là sự đi vào hay đến và sự đi. Lấy toàn quẻ mà xét thì tượng của quẻ này là một cái thùng gỗ đang múc nước ra khỏi giếng. Các nền văn hóa thị tộc cổ xưa đều xây dựng quanh một dòng nước chảy hay cái giếng. Giếng cho phép con người lấy nước mà không làm hao kiệt nguồn cung cấp. Nhưng con người phải sử dụng những biện pháp hiệu quả dể hưởng được ân phước mà giếng mang lại và có nguồn để giải cơn khát của mình. Trong đoán quẻ, điều này có nghĩa rằng người ta phải có những hành vi thiện lành để tạo lợi ích cho người khác. Cùng lúc đó, người ta cũng cần phải giữ gìn sự an bình và yên tịnh giống như giếng.',
		'010010' => 'Cả đơn quái trên lẫn đơn quái dưới đều là Khảm; do đó, quẻ này cũng được gọi là Khảm. Khảm nghĩa là khó khăn và nguy hiểm, đồng thời cũng tượng trưng cho nước. Nước ở trên lẫn ở dưới, điều đó muốn nói lên rằng không thể nào dò được độ nông sâu của nước. Mênh mông và chảy mãi không ngừng, hòa vào nhau rồi lại chảy đi — hình ảnh này nói lên sự nguy hiểm trùng trùng. Bị chết đuôi là điều có thể xảy ra. Trong đoán quẻ, Khảm hàm ý vận hội của bạn đang cực kỳ xấu, như thể đang bị lôi vào cảnh rôl bù, tiến hay lui cũng đều gặp nguy hiểm.',// Thủy vi khảm
		'001010' => 'Kiển tượng trưng cho sự khó khăn trong hành động và sự ngăn cản, ức chế. Nó cũng có nghĩa là hết sức gian nan, khốn khó, rắc rối, truân chuyên. Đơn quái Khảm ồ trên tượng trưng cho sự nguy hiểm, trong khi đơn quái cấn ở dưới tượng trưng cho sự ngừng chuyển động. Toàn quẻ do đó có nghĩa là sự bị đình lại trong nguy hiểm, chẳng có lối thoát. Khảm cũng tượng trưng cho nước và Cấn tượng trưng cho núi, có ý nói lên rằng đường đi đã bị bí lối với một bên là mặt nước hiểm nghèo, còn một bên là núi cao sừng sững. Trong đoán quẻ, điều này có nghĩa rằng đang gặp phải tình trạng lưỡng nan, tiến không được mà lui cũng không xong. Trong trường hợp này, muôn vượt qua được thời điểm gian nan này phải nên cẩn thận.',
		'000010' => 'Tỷ tượng trưng cho sự gần gũi, thân thiết. Hào thứ năm đếm từ dưới lên, hào chủ, là hào dương. Hào dương này khẳng định mình trước tất cả các hào âm (vạch đứt) khác. Thượng quái Khảm tượng trưng cho nước và hạ quái Khôn tượng trưng cho đất. Khi nước chảy tràn khắp mặt đất, nó thấm vào trong đất và trở thành một với bùn đất, đồng thời cồn trộn lẫn và liên kết với nhau. Đó là dấu hiệu cát tường của việc trời yêu thương và nuôi dưỡng con người, khi trên và dưới hòa hợp, thân thiết và giúp đỡ cho nhau. Trong đoán quẻ, điều này có nghĩa là việc tiếp xúc với người khác sẽ diễn ra tốt đẹp và mọi việc sẽ được thực hiện suôn sẻ.',
		'111001' => 'Đại súc nghĩa là tích chứa, tiết kiệm hay cất trữ. Nó cũng có nghĩa là sự tràn đầy, phong phú hay dồi dào. Quẻ cũng hàm ý sự ngưng nghỉ và chờ đợi cho đến khi đầy đủ trước khi chính thức hành động. Đơn quái trên, Cấn, mang ý nghĩa bất động, đứng yên hay nghỉ ngơi. Đơn quái dưới, Càn, hàm chỉ sức mạnh và sự tiến về phía',
		'110001' => 'Tổn nghĩa là hy sinh, giảm bớt, buông, làm yếu, thu nhỏ và thua, mất. Các hào ba, bốn và năm tính từ dưới lên là các hào âm. Các hào âm nằm ở giữa các hào dương và có một hào chiếm ngôi vị thứ năm, ngôi vị chủ đạo, khiến cho lực dương phải suy yếu. Quẻ hỗ được tạo thành từ quẻ này là Phục (Quẻ 24, có nghĩa là trở về), với trong đó lực dương đang bắt đầu đi lên. Nó đã trở về sau khi đã bị lực âm che khuất. Trong quẻ Tổn, lực quay trở về này có ý muốn nói lên rằng tuy sự hy sinh là một loại tổn thất, nhưng sẽ giành được lợi ích hay tốt đẹp nào đó một khi phục hồi. Trong đoán quẻ, điều này có nghĩa rằng tuy hiện thời đang có sự tổn thất hay thiệt hại, nhưng chẳng bao lâu tình hình sẽ được cân bằng trở lại và hanh thông.',
		'101001' => 'Bí nghĩa là trang trí, trang sức, những màu sắc đẹp, diện mạo hay phong thái đẹp, lịch sự, những đồ trang sức, trang hoàng và trang điểm. Tượng của đơn quái Cấn ỗ trên là ngọn núi. Tượng của đơn quái Ly ở dưới là mặt trời. Do đó, quẻ này tượng trưng cảnh mặt trời đang khuất sau rặng núi phía tây. Toàn bộ là một cảnh tượng hết sức thi vị và đầy hoan hỉ của lúc mặt trời lặn. Trong đoán quẻ, Bí có nghĩa là lúc tàn phai của thời kỳ tươi đẹp. Cái đẹp ở bề ngoài sẽ nhanh chóng tàn phai. Khi mặt trời khuất sau ngọn núi, sức mạnh của các tia nắng bị hạn chế, hàm ý những gì người ta thấy và biết chỉ là thiển cận, ở trưức mắt – chẳng có sự nhìn xa trông rộng hay suy nghĩ sâu xa. Do đó, những sơ suất trong hoạch định và các lầm lẫn trong phán đoán sẽ trở nên phổ biến. Phải đặc biệt cẩn thận để tránh bị đánh lừa.',
		'100001' => 'Di có nghĩa là đôi má và cũng có nghĩa là sự nuôi dưỡng. Nuôi dưỡng đến dưới hình thức sự bổ dưỡng của thức ăn, sự hấp thu kiến thức và học hỏi, sự phát triển của tư tưởng, và sự vun bồi. Các hào nằm dưới cùng và trên cùng là những hào dương, giống như môi trên và môi dưới. Bốn hào âm ở giữa tượng trưng cho răng. Thức ăn tốt sẽ nuôi dưỡng cho cơ thể, nhưng thức ăn thiếu bổ dưỡng hay hư thối sẽ làm hại cơ thể. Tương tự như vậy đối với học vấn và tư tưởng, những gì được thu nhận phải chính đáng. Trong đoán quẻ, nó có nghĩa rằng nếu người ta thận trọng và ý tứ trong ngôn từ, biết điều độ trong ăn uống, biết vun bồi bản thân, và đối xử với người khác cũng như xử lý công việc theo con đường chính đáng, khi đó vận may sẽ mở rộng. Bằng không, thất bại sẽ đến.',
		'011001' => 'Cổ tượng trưng cho thức ăn nằm trên đĩa, đã bị hư thối, và trở thành nơi sinh sống của dòi bọ. Quẻ ám chỉ sự hỗn độn, thối rữa, mục nát, hoang tưởng, phế thải và hỏng hóc. Đơn quái trên cấn tiêu biểu những ngọn núi, trong khi đơn quái dưới Tốn tượng trưng cho gió. Gió đang nằm bên dưới núi – bị ngăn chặn bởi núi, gió không thể lưu chuyển được. Nếu không khí không thể lưu thông và di chuyển, mọi vật sẽ bắt đầu thối rữa và làm mồi cho sâu. Trong đoán quẻ, điều này có nghĩa rằng tình hình chung quanh cực kỳ rối loạn và phức tạp. Phải dụng công để dọn dẹp ngăn nắp hay duy trì trật tự – bằng không bạn sẽ gặp thất bại. Việc dọn sạch sự thôi rữa có thể dẫn đến thành công trong việc thay đổi vận hạn của mình.',
		'010001' => 'Mông tượng trưng cho tuổi trẻ thiếu kinh nghiệm với những cách nhìn chưa thấu suốt, và trí khôn hoặc hiểu biết hãy còn non kém. Tuy nhiên, những thanh niên này thu thập được sự nhạy bén, trí khôn và kiến thức thông qua sự chỉ bảo và dẫn dắt. Khi khảo sát hình tượng của quẻ này, chúng ta sẽ thấy rằng phần nửa trên, đơn quái Cấn tượng trưng cho những ngọn núi, còn nửa dưới, dơn quái Khảm, tiêu biểu cho nước. Nước trở thành sương hay giá khi bốc hơi, bao phủ hoặc che lấp mất núi, làm cho người ta không thể phân biệt được diện mạo hay hình dáng đích thực của núi. Do đó, Mông hàm ý sự dốt nát, ngu muội, vô tâm, mơ hồ, và thậm chí vô ý thức. Vạn vật đều đang ở trong một bức màn sương mù dày đặc, đầy dẫy sự dò dẫm và kém phát triển. Bạn phải hết sức nỗ lực và biết lắng nghe cũng như tuân theo sự chỉ dạy, dẫn dắt của người khôn ngoan, thông thái và đạo đức. Nếu được như vậy, tất cả sẽ dần dần chuyển biến tốt đẹp hơn.',
		'001001' => 'Cấn có nghĩa là sự bất động, nghỉ ngơi, đình chỉ, dừng lại và im lặng. Các đơn quái trên và dưới đều là Cấn, tượng trưng cho các ngọn núi. Tượng của quẻ là các ngọn núi đang đứng yên và bất động. Trong đoán quẻ, điều này có nghĩa rằng, giống như các ngọn núi, người ta cần phải yên lặng và bất động, chờ đến lúc có thời cơ thích hợp.', // Sơn vi cấn
		'000001' => 'Bác có nghĩa là đốn hạ, tách chẻ, tước, bào mòn hay róc, lột. Nếu nhìn vào quẻ, chúng ta sẽ thấy các hào âm đang chi phối sự đi lên, với chỉ còn lại có một hào dương. Có vẻ như lực dương đang lung lay và sắp đổ. Đơn quái trên, Cấn, tượng trưng cho các ngọn núi, còn đơn quái dưới, Khôn, tượng trưng cho đất. Ngọn núi cao sừng sững. Không thể nào chống đỡ nỗi sự xâm thực của gió và mưa, đang dần dần tiêu mòn và sụp đổ, rồi trở thành bình địa (đất bằng). Trong đoán quẻ, Bàc mang ý nghĩa là vận may của bạn đang đến hồi sa sút nhất. Hành động duy nhất là nhẫn nại chịu đựng và chờ đến lúc thích hợp hơn.',
		'111000' => 'Thái tượng trưng cho sự bình an và hòa hợp. Đơn quái trên là Khôn tượng trưng cho đất, còn đơn quái dưới tượng trưng cho trời. Lực âm của Khôn thì thấm xuống còn lực dương của Càn thì đi lên. Điều này có nghĩa rằng các lực của trời và đất, âm và dương đang quân bình, xứng hợp và hòa hợp – thống nhất với nhau. Kết quả là vạn vật phát triển và sinh sôi nảy nở sung thịnh. Trong đoán quẻ, Thái là quẻ cát tường, nói lên sự bình an và vận may.',
		'110000' => 'Lâm có nghĩa là mở rộng, gia tăng, tiến bộ. Hai hào dưới cùng của quẻ này là những hào dương và có nghĩa rằng lực dương đang tăng trưởng, bành trướng, mở rộng, trong khi lực âm đang từ từ thoái lui hay nhường bước. Quẻ này cũng hàm ý sự giúp đỡ hay tin tưởng vào kỳ vọng của nhau. Trong đoán quẻ, điều này có nghĩa rằng nếu xử lý mọi việc với thái độ nhường nhịn và hợp tác, cư xử với người khác phù hợp với qui tắc đạo đức đúng đắn, bạn sẽ hưởng được rất nhiều vận may.',
		'101000' => 'Minh di có nghĩa là sự tắt ngấm của ánh sáng hay vẻ rực rỡ. Đơn quái trên 1 aKhôn tức đất, còn đơn quái dưới là Ly tức mặt trời. Mặt trời đã lặn xuống đất, tậo nên bóng tối. Ly cũng tượng trưng cho lửa. Lửa từ xa đang tỏa ánh sáng của nó ra xa và rộng. Nhưng, trong trường hợp này, ý nghĩa ngược lại. Lửa đang ở dưới đất và do đó gợi ý sự chìm vào bóng tối. Trong chiêm quái, quẻ có nghĩa rằng, giống như đêm tối, tương lai thật mù mờ, do đó phải nên hết sức cẩn thận cho đến khi bầu trời sáng tỏ vào buổi sáng. Hãy chờ đợi nhẫn nại cho đến khi ầnh sáng trở lại trước khi hành động hay tiến bước.',
		'100000' => 'Phục nghĩa là quay về chỗ gốc, chỗ ban đầu và bắt đầu một chu kỳ mới. Lực dương, tiêu biểu qua vạch liền dưới cùng, đang di chuyển đi lên từ đáy. Như vậy, lực dương đang bắt đầu vận động và vạn vật đang nhận được sức sống từ lực này, đồng thời dần dần thu được sức mạnh. Trong đoán quẻ, Phục hàm ý mọi việc đang chuyển biến tốt đẹp hơn – như thể mùa xuân sắp đến. Mọi sự sẽ trở nên dần dần sáng sủa hơn.',
		'011000' => 'Thăng nghĩa là tăng, lên cao, tiến tới. Đơn quái trên là Khôn, tượng trưng cho đất, trong khi đơn quái dưới, Tốn, tượng trưng cho cây cối. Thế nên quẻ này trông giống như những hạt giống của cây xanh đang nảy mầm, sẵn sàng phá đất để chui lên, từ từ mọc thành cây cao. Cây mọc chậm, cho nên sự vận động đi lên của quẻ này cũng diễn ra từ từ và đều đều giống như bước lên thang, chứ không phải một sự nhảy vọt nhanh chóng lên trên. Khi hạt tăng trưởng, nó hấp thu các yếu tố từ môi trường của mình – các chất dinh dưỡng từ đất rồi mưa và ánh nắng. Nó thụ động. Tương tự, bạn phải mềm mỏng và chờ đợi cơ hội tốt. Hãy cần cù và chăm chĩ, và khả năng cũng như tài năng của bạn sẽ được công nhận. Trong đoán quẻ, điều này có nghĩa rằng đây chính là thời điểm để tài năng và năng lực nội tại của bạn phát triển đúng cách.',
		'010000' => 'Sư tượng trưng cho đạo quân binh và đám đông, và được gắn liền với ý tưởng chiến tranh hay đấu tranh. Vạch thứ hai tính từ dưới lên là vạch liền, tức hào dương, tiêu biểu cho vị đại tướng đang chỉ huy hay dẫn dắt năm hào âm. Thượng quái là Khôn, đất; hạ quái là Khảm, tượng trưng cho nước. Khi nước nằm trên đất, nó gây ẩm ướt và làm phong phú cho vạn vật, nhưng ở quẻ này vị trí thích hợp đó đã bị đảo lộn. Đất nằm trên nước. Cả hai không thể song hành hòa hợp với nhau được. Trong đoán quẻ, quẻ này có nghĩa là sự đấu tranh, tranh cãi, bất hòa, khó khăn, rắc rối và hỗn loạn. Cách duy nhất để đạt được bước ngoặt mỹ mãn là nghiêm túc tiếp tục đi theo Cồn đường chân chính và đúng đắn.',
		'001000' => 'Khiêm nghĩa là nhún nhường và khiêm tốn. Đơn quái trên là Khôn, tượng đất. Đơn quái dưới là Cấn, tượng núi. Dãy núi cao khom mình và trú ngụ bên dưới dồng bằng mênh mông, tiêu biểu cho đức hạnh khiêm tốn và nhún nhường. Khiếm cũng có nghĩa là tặng phần dư dả của mình cho người thiếu thốn. Ý tưởng chính là chuyển đất tơi của một ngọn núi cao đến lấp chỗ trũng thấp. Trong đoán quẻ, nó có nghĩa rằng vận may và sự thịnh đạt sẽ đến nếu biết giữ gìn sự khiêm tốn và chân thật trong hành động.',
		'000000' => 'Quẻ Khôn tượng trưng cho đất và đại diện cho ý tưởng sản sinh, dịu hiền, phục tùng và vâng lời. Quẻ tượng trưng cho bóng tối và thuộc về người mẹ. Khôn là đối lập của Càn (quẻ nói trên); sáu hào đều âm, tức các vạch đứt. Lực dương tượng trưng cho sự cho, tính cách hay khuynh hướng mạnh mẽ hoặc cứng rắn, chuyển động tích cực hay sự tiến bộ, trong khi lực âm tượng trưng cho sự nhận, phục tùng, tiêu cực và thụ động. Do đó, khi gieo được quẻ này, bạn cũng nên biết mềm mỏng giống như con lừa hay ngựa cái, thực hiện bổn phận hay hoàn thành vai trò của mình, và lắng nghe cũng như đi theo lời khuyên của các bậc trên trước của mình. Bằng cách này, thông qua kiên định, các triển vọng của bạn sẽ mở ra trong tương lai gần. Đừng hấp tấp, vội vàng, cũng đừng khinh suất, liều lĩnh và đừng hành động một cách quyết liệt, triệt để hay cẩu thả. Hãy thực hiện bển phận của bạn một cách thận trọng và có chăm chú. Hãy nghe theo những lời khuyên của người có khả năng và người khôn ngoan, và bạn sẽ được hưởng lợi.',//địa vi khôn
	];
	return $thuVien[$a];
}

function locThan($can, $dc){
	$thuVien = [
		'Giáp' =>  'Dần',
		'Mậu' =>   'Tị',
		'Ất' =>  'Mão',
		'Kỷ' =>  'Ngọ',
		'Bính' =>  'Tị',
		'Đinh' =>  'Ngọ',
		'Nhâm' => 'Hợi',
		'Quý' => 'Tý',
		'Canh' =>  'Thân',
		'Tân' =>  'Dậu',
	];
	$kq = false;
	if($thuVien[$can] == $dc) $kq = true;
	return $kq;
	
}

function quyNhan($can, $dc){
	$thuVien = [
		'Giáp' => ['Sửu', 'Mùi'],
		'Mậu' =>  ['Sửu', 'Mùi'],
		'Ất' => ['Tý', 'Thân'],
		'Kỷ' => ['Tý', 'Thân'],
		'Bính' => ['Hợi', 'Dậu'],
		'Đinh' => ['Hợi', 'Dậu'],
		'Nhâm' => ['Mão', 'Tị'],
		'Quý' => ['Mão', 'Tị'],
		'Canh' => ['Ngọ', 'Dần'],
		'Tân' => ['Ngọ', 'Dần'],
	];
	$kd = false;
	if(in_array($dc,$thuVien[$can])) $kd = true;

	return $kd;
}
function duongNhan($can, $dc){
	$thuVien = [
		'Giáp' =>  'Mão',
		'Mậu' =>   'Ngọ',
		'Ất' =>  'Dần',
		'Kỷ' =>  'Tị',
		'Bính' =>  'Ngọ',
		'Đinh' =>  'Tị',
		'Nhâm' => 'Tý',
		'Quý' => 'Hợi',
		'Canh' =>  'Dậu',
		'Tân' =>  'Thân',
	];
	$kq = false;
	if($thuVien[$can] == $dc) $kq = true;
	return $kq;
	
}
function vanXuong($can, $dc){
	$thuVien = [
		'Giáp' =>  'Tị',
		'Mậu' =>   'Thân',
		'Ất' =>  'Ngọ',
		'Kỷ' =>  'Dậu',
		'Bính' =>  'Thân',
		'Đinh' =>  'Dậu',
		'Nhâm' => 'Dần',
		'Quý' => 'Mão',
		'Canh' =>  'Hợi',
		'Tân' =>  'Tý',
	];
	$kq = false;
	if($thuVien[$can] == $dc) $kq = true;
	return $kq;
	
}

function dichMa($dcNgay, $dcHao){
	$thuVien = [
		'Tý' => 'Dần',
		'Sửu' => 'Hợi',
		'Dần' => 'Thân',
		'Mão' => 'Tỵ',
		'Thìn' => 'Dần',
		'Tỵ' => 'Hợi',
		'Ngọ' => 'Thân',
		'Mùi' => 'Tỵ',
		'Thân' => 'Dần',
		'Dậu' => 'Hợi',
		'Tuất' => 'Thân',
		'Hợi' => 'Tỵ',
	];
	$kq = false;
	if($thuVien[$dcNgay] == $dcHao) $kq = true;
	return $kq;
}
function daoHoa($dcNgay, $dcHao){
	$thuVien = [
		'Tý' => 'Dậu',
		'Sửu' => 'Ngọ',
		'Dần' => 'Mão',
		'Mão' => 'Tý',
		'Thìn' => 'Dậu',
		'Tỵ' => 'Ngọ',
		'Ngọ' => 'Mão',
		'Mùi' => 'Tý',
		'Thân' => 'Dậu',
		'Dậu' => 'Ngọ',
		'Tuất' => 'Mão',
		'Hợi' => 'Tý',
	];
	$kq = false;
	if($thuVien[$dcNgay] == $dcHao) $kq = true;
	return $kq;
}

function tuongTinh($dcNgay, $dcHao){
	$thuVien = [
		'Tý' =>'Tý',
		'Sửu' =>'Dậu',
		'Dần' =>'Ngọ',
		'Mão' =>'Hợi',
		'Thìn' =>'Tý',
		'Tỵ' =>'Dậu',
		'Ngọ' =>'Ngọ',
		'Mùi' =>'Hợi',
		'Thân' =>'Tý',
		'Dậu' =>'Dậu',
		'Tuất' =>'Ngọ',
		'Hợi' =>'Hợi',
	];
	$kq = false;
	if($thuVien[$dcNgay] == $dcHao) $kq = true;
	return $kq;
}

function kiepSat($dcNgay, $dcHao){
	$thuVien = [
		'Tý' =>'Tị',
		'Sửu' =>'Dần',
		'Dần' =>'Hợi',
		'Mão' =>'Thân',

		'Thìn' =>'Tị',
		'Tỵ' =>'Dần',
		'Ngọ' =>'Hợi',
		'Mùi' =>'Thân',

		'Thân' =>'Tị',
		'Dậu' =>'Dần',
		'Tuất' =>'Hợi',
		'Hợi' =>'Thân',
	];
	$kq = false;
	if($thuVien[$dcNgay] == $dcHao) $kq = true;
	return $kq;
}

function hoaCai($dcNgay, $dcHao){
	$thuVien = [
		'Tý' =>'Thân',
		'Sửu' =>'Sửu',
		'Dần' =>'Tuất',
		'Mão' =>'Mùi',

		'Thìn' =>'Thân',
		'Tỵ' =>'Sửu',
		'Ngọ' =>'Tuất',
		'Mùi' =>'Mùi',

		'Thân' =>'Thân',
		'Dậu' =>'Sửu',
		'Tuất' =>'Tuất',
		'Hợi' =>'Mùi',
	];
	$kq = false;
	if($thuVien[$dcNgay] == $dcHao) $kq = true;
	return $kq;
}

function muuTinh($dcNgay, $dcHao){
	$thuVien = [
		'Tý' =>'Tuất',
		'Sửu' =>'Mùi',
		'Dần' =>'Thìn',
		'Mão' =>'Sửu',

		'Thìn' =>'Tuất',
		'Tỵ' =>'Mùi',
		'Ngọ' =>'Thìn',
		'Mùi' =>'Sửu',

		'Thân' =>'Tuất',
		'Dậu' =>'Mùi',
		'Tuất' =>'Thìn',
		'Hợi' =>'Sửu',
	];
	$kq = false;
	if($thuVien[$dcNgay] == $dcHao) $kq = true;
	return $kq;
}

function thienY($dcThang, $dcHao){
	$thuVien = [
		'Tý' ,
		'Sửu',
		'Dần',
		'Mão',

		'Thìn',
		'Tỵ',
		'Ngọ',
		'Mùi',

		'Thân',
		'Dậu',
		'Tuất',
		'Hợi',
	];
	$kq = false;
	for($i = 0; $i < 12; $i++){
		if($i == 0){
			if($thuVien[$i] == $dcThang && $thuVien[11] == $dcHao) $kq = true;
		}elseif($i > 0){
			if($thuVien[$i] == $dcThang && $thuVien[$i-1] == $dcHao) $kq = true;
		}
	}
	return $kq;
}
function thienHy($dcThang, $dcHao){
	$thuVien = [
		'Tý' => 'Mùi',
		'Sửu' => 'Mùi',
		'Dần' => 'Tuất',
		'Mão' => 'Tuất',

		'Thìn' => 'Tuất',
		'Tỵ' => 'Sửu',
		'Ngọ' => 'Sửu',
		'Mùi' => 'Sửu',

		'Thân' => 'Thìn',
		'Dậu' => 'Thìn',
		'Tuất' => 'Thìn',
		'Hợi' => 'Mùi',
	];
	$kq = false;
	if($thuVien[$dcThang] == $dcHao) $kq = true;
	return $kq;
}

function taiSat($dcNgay, $dcHao){
	$thuVien = [
		'Tý' =>'Ngọ',
		'Sửu' =>'Mão',
		'Dần' =>'Tý',
		'Mão' =>'Dậu',

		'Thìn' =>'Ngọ',
		'Tỵ' =>'Mão',
		'Ngọ' =>'Tý',
		'Mùi' =>'Dậu',

		'Thân' =>'Ngọ',
		'Dậu' =>'Mão',
		'Tuất' =>'Tý',
		'Hợi' =>'Dậu',
	];
	$kq = false;
	if($thuVien[$dcNgay] == $dcHao) $kq = true;
	return $kq;
}

function quaiThan($theDC){
	$thuVien = [
		'Tý'  => 0,
		'Sửu'  => 1,
		'Dần' => 2,
		'Mão'  => 3,

		'Thìn'  => 4,
		'Tỵ'  => 5,
		'Ngọ' => 0,
		'Mùi'  => 1,

		'Thân'  => 2,
		'Dậu'  => 3,
		'Tuất' => 4,
		'Hợi'  => 5,
	];
	return $thuVien[$theDC];
}

function thanQue($nghi, $the){
	$duong = ['Tý', 'Sửu', 'Dần', 'Mão', 'Thìn', 'Tỵ'];
	$am = ['Ngọ', 'Mùi', 'Thân', 'Dậu', 'Tuất', 'Hợi'];
	$than = '';
	for($i = 0; $i  <= $the; $i++){
		if($i == $the){
			if($nghi == 0){
				$than = $am[$i];
			}elseif($nghi == 1){
				$than = $duong[$i];
			}
		}
		
	}
	return $than;

}

