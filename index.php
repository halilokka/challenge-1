$input = [
	[1,0,0,0,0,0,0],
	[0,1,0,1,1,1,1],
	[1,0,1,1,0,0,1],
	[0,0,1,0,1,0,0],
	[1,1,1,0,1,0,0],
	[1,0,1,1,0,0,1],
	[1,0,0,0,0,1,1],
];



$_duzen = duzen($input);
$_kontrol = kontrol($input, $_duzen["kontrol"], $_duzen["sinirlar"], $_duzen["cikti"]);
cikti($input, $_kontrol["cikti"]);exit;
print_r($_kontrol);exit;

function duzen($matriks){
	$xkey = count($matriks);
	$ykey = count($matriks[0]);
	$duzen = [];
	foreach ($matriks as $key => $val) {
		foreach ($val as $skey => $sval) {
			$duzen["cikti"][$key][$skey] = 0;
			if($sval==1){
				if($key==0){
					$duzen["sinirlar"][$key."-".$skey] = $sval;
					$duzen["cikti"][$key][$skey] = $sval;
				}
				if($key+1==$xkey){
					$duzen["sinirlar"][$key."-".$skey] = $sval;
					$duzen["cikti"][$key][$skey] = $sval;
				}
				if($skey==0){
					$duzen["sinirlar"][$key."-".$skey] = $sval;
					$duzen["cikti"][$key][$skey] = $sval;
				}
				if($skey+1==$ykey){
					$duzen["sinirlar"][$key."-".$skey] = $sval;
					$duzen["cikti"][$key][$skey] = $sval;
				}
				if(! isset($duzen["sinirlar"][$key."-".$skey])){
					$duzen["kontrol"][] = $key."-".$skey;
					$duzen["cikti"][$key][$skey] = $sval;
				}
			}
		}
	}
	return $duzen;
}

function kontrol($matriks, $kordinatlar, $sinirlar, $cikti){
	$xkey = count($matriks);
	$ykey = count($matriks[0]);
	$kontrol = [];
	$kontrol["cikti"] = $cikti;
	$kontrol["sinirlar"] = $sinirlar;
	$kontrol["sinir"] = false;
	
	foreach($kordinatlar as $key=>$val){
		$kordinat = explode('-', $val);
		$x = $kordinat[0];
		$y = $kordinat[1];

		$degisti = false;
		$kontrol["cikti"][$x][$y] = 0;
		if($x>0 AND isset($sinirlar[($x-1)."-".$y])){
			$kontrol["cikti"][$x][$y] = 1;
			$degisti = true;
		}
		if($x<$xkey AND isset($sinirlar[($x+1)."-".$y])){
			$kontrol["cikti"][$x][$y] = 1;
			$degisti = true;
		}
		if($y>0 AND isset($sinirlar[$x."-".($y-1)])){
			$kontrol["cikti"][$x][$y] = 1;
			$degisti = true;
		}
		if($y<$ykey AND isset($sinirlar[$x."-".($y+1)])){
			$kontrol["cikti"][$x][$y] = 1;
			$degisti = true;
		}
		if($degisti==true){
			if(! isset($kontrol["sinirlar"][$x."-".$y])){
				$kontrol["sinirlar"][$x."-".$y] = 1;
				$kontrol["sinir"] = true;
			}
		}
	}
	if($kontrol["sinir"]==true){
		return kontrol($matriks, $kordinatlar, $kontrol["sinirlar"], $kontrol["cikti"]);
	}
	return $kontrol;
}

function cikti($matriks, $matriksoutput=null){
	$ycount = count($matriks[0])-1;
	foreach ($matriks as $xkey => $xvalue) {
		foreach ($xvalue as $ykey => $yvalue) {
			echo $yvalue;
			if($ykey!=$ycount){
				echo " / ";
			}	
		}
		echo "</br>";
	}
	if($matriksoutput){
		echo '-----------<br><div>';
		$ycount2 = count($matriksoutput[0])-1;
		foreach ($matriksoutput as $xkey => $xvalue) {
			echo '<div style="width:100%; display:flex;">';
			foreach ($xvalue as $ykey => $yvalue) {
				if($matriks[$xkey][$ykey]!=$yvalue){
					echo '<div style="color:red;">'.$yvalue.'</div>';
				}else{
					echo '<div>'.$yvalue.'</div>';
				}
				if($ykey!=$ycount2){
					echo "<div>&nbsp;/&nbsp;</div>";
				}	
			}
			echo '</div>';
		}
		echo '</div>';
	}
}
