<?php

require_once('vendor/autoload.php');

use Carbon\Carbon;

use Illuminate\Database\Capsule\Manager as Capsule;

use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

$capsule = new Capsule;

$capsule->addConnection([
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'dich',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);

$capsule->setEventDispatcher(new Dispatcher(new Container));

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

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

function queChinh($quePH, $ha, $thuong){
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
      $a = $haoDong-1;
      $b = str_split($queChinh,1);
      $c = dong($b, $a);
      $d = implode('',$c);
      return [
		'dataName' => 'Quẻ Biến',
            'que' => $d,
            'tenQue' => $quePH[$d]
      ];
}

function giaDinh($que, $quePH, $nguHanh){
      $a = str_split($que,1);
	$b = implode('',$a);
      $c = str_split($b,3);
      if(isThuanArray($a) == true){
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
                              $hao = $i +1 ;
                              break;
                        }
                  }elseif($i == 5){
                        $a = dong($a,3);
                        if(isThuanArray($a)){
                              $hao =4;
                              break;
                        }
                        $a = dong($a,2);
                        $a = dong($a,1);
                        $a = dong($a,0);
                        if(isThuanArray($a)){
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

function nguHanhSinhKhac($nguHanhQue, $nguHanhHao){
      $a = '';
      if($nguHanhQue == $nguHanhHao) $a = 'Trùng';
      $nguHanh = [
            'Kim' => ['Sinh' => 'Thủy','Khắc' => 'Mộc', 'Được Sinh' => 'Thổ', 'Bị Khắc' => "Hỏa"],
            'Thủy' => ['Sinh' => 'Mộc','Khắc' => 'Hỏa', 'Được Sinh' => 'Kim', 'Bị Khắc' => "Thổ"],
            'Mộc' => ['Sinh' => 'Hỏa','Khắc' => 'Thổ', 'Được Sinh' => 'Thủy', 'Bị Khắc' => "Kim"],
            'Hỏa' => ['Sinh' => 'Thổ','Khắc' => 'Kim', 'Được Sinh' => 'Mộc', 'Bị Khắc' => "Thủy"],
            'Thổ' => ['Sinh' => 'Kim', 'Khắc' => 'Thủy', 'Được Sinh' => 'Hỏa', 'Bị Khắc' => "Mộc"],
      ];
      foreach($nguHanh[$nguHanhQue] as $c => $v){
            if($v == $nguHanhHao){
                  $a = $c;
            }
      }
      return $a;
}

function lucThan($nguHanhQue, $diaChiQue){
      $a = [];
      for($i = 0; $i < 6; $i++){
            $ss = nguHanhSinhKhac($nguHanhQue, $diaChiQue['nguHanh'][$i]);
            if($ss == 'Trùng'){
                  array_push($a,'Huynh Đệ');
            }elseif($ss == 'Sinh'){
                  array_push($a,'Tử Tôn');
            }elseif($ss == 'Khắc'){
                  array_push($a,'Thê Tài');
            }elseif($ss == 'Được Sinh'){
                  array_push($a,'Phụ Mẫu');
            }elseif($ss == 'Bị Khắc'){
                  array_push($a,'Quan Quỷ');
            }
      }
      return [
		'dataName' => 'Lục Thân của các Hào',
		'lucThan' => $a
	];
}

function LucThanSinhKhac($lt1, $lt2){
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
      return $a;
}

function tamHop($c1, $c2){
	$tamHop = [
		['Thân','Tý','Thìn'], // thủy cục
		['Dần','Ngọ','Tuất'], //Hỏa cục
		['Hợi', 'Mão', 'Mùi'], // Mộc cục
		['Tỵ', 'Dậu','Sửu'] // kim cục
		// trường sinh -- đế vượng -- mộ (xoay trong vòng trường sinh)
	];
	$kq = false;
	$luan = '';
	foreach($tamHop as $th){
		if(in_array($c1, $th)){
			if(in_array($c2, $th)){
				$kq = true;
				$luan = "$c1 và $c2 tam hợp";

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
	foreach($nhiHop as $nh){
		if(in_array($c1, $nh)){
			if(in_array($c2, $nh)){
				$kq = true;
				$luan = "$c1 và $c2 nhị hợp";
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
	foreach($nhiXung as $nx){
		if(in_array($c1, $nx)){
			if(in_array($c2, $nx)){
				$kq = true;
				$luan = "$c1 và $c2 xung nhau";
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

	if(in_array($c2, $tuyetMo[$c1])){
		if(array_search($c2, $tuyetMo[$c1]) == 0){
			
				$kq = true; // "2t1";
				$luan =  $c2." tuyệt tại ".$c1;
			
		}elseif(array_search($c2, $tuyetMo[$c1]) == 1){
			$kq = true; //"2m1";
			$luan = $c2." mộ tại ".$c1;
			
		}
	}

	if(in_array($c1, $tuyetMo[$c2])){
		if(array_search($c1, $tuyetMo[$c2]) == 0){
			$kq = true; // "1t2";
			$luan = $c1." tuyệt tại ".$c2;
		
		}elseif(array_search($c1, $tuyetMo[$c2]) == 1){
			$kq = true; //"1m2";
			$luan = $c1." mộ tại ".$c2;
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

function vongTruongSinh($nguHanh){
	$vts = [
		'Trường Sinh', 'Mộc Dục', 'Quan Đới', 'Lâm Quan', 'Đế Vượng', 'Suy', 'Bệnh', 'Tử', 'Mộ', 'Tuyệt', 'Thai', 'Dưỡng',
	];
	$tamHop = [
		'Thủy' => ['Thân','Tý','Thìn'], // thủy cục
		'Hỏa' => ['Dần','Ngọ','Tuất'], //Hỏa cục
		'Mộc' => ['Hợi', 'Mão', 'Mùi'], // Mộc cục
		'Kim' => ['Tỵ', 'Dậu','Sửu'], // kim cục
		'Thổ' => ['Thân','Tý','Thìn'],// Thổ dùng Thủy cục
	];
	
	$diaChi = [
		'Tý', 'Sửu', 'Dần', 'Mão', 'Thìn', 'Tỵ', 'Ngọ', 'Mùi', 'Thân', 'Dậu', 'Tuất', 'Hợi',
		'Tý', 'Sửu', 'Dần', 'Mão', 'Thìn', 'Tỵ', 'Ngọ', 'Mùi', 'Thân', 'Dậu', 'Tuất', 'Hợi'
	];
	$pos = array_search($tamHop[$nguHanh][0],$diaChi);
	$a = [];
	$dem = 0;
	for($i = $pos; $i < $pos +12; $i++){
		$a[$diaChi[$i]] = $vts[$dem];
		$dem++;
	}

	return $a;
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
		'dong' => $haoDong,

	];
}


