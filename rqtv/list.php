<?php

header("Content-Type: text/plain");
ini_set('max_execution_time', 0);
$server = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}";
$path_get = str_replace ('list.php' , 'rqtv_get.php' , $server);
$path_logo = str_replace ('list.php' , 'logo.png' , $server);

$userid = "841851";
$user = "2022101023";
$password = "2310102022";
$k = "AndTVFS_rci9c867om2dhd0nasuimpvc8v";
$authorization = "MjAyMjEwMTAyMzoyMzEwMTAyMDIy";

$api = "https://smovies.vomcenter.com/xbmc/tvgen.php?guide=1&fullepg=1&userid=".$userid."&user=".$user."&password=".$password."&k=".$k."&roku=1&vu=1";
$json = json_decode(cURL($api , $authorization), true);

echo "#EXTM3U".PHP_EOL;
	for($i = 0; $i < count($json['Videos']); $i++){
		$url_json = str_replace(array('\/\/', ' ', '�', '+', '�', '!'), array('//', '_', 'n', 'plus', 'u', ''), $json['Videos'][$i]['Url']);
		$path = explode ('?' , $url_json);
		$cat_search = array("01" , "02" , "03" , "04" , "05" , "06" , "07" , "08" , "09" , "00" , "10" , "11" );
		$grupo = str_replace($cat_search , NULL , $json['Videos'][$i]['categoria']);
		$path_name = explode(" " , $json['Videos'][$i]['Title']);
		$path_name_slash = explode("/ " , $json['Videos'][$i]['Title']);
		if($path_name_slash[1] == NULL){
			$path_name_slash[1] = "";
			}else{
				$path_name_slash[1] = "(".ucwords(strtolower($path_name_slash[1])).")";
				}
		$name_search = array("Lat: " , "Es: " , "Usa: " , "Col: " , "Uk: " , "Arg: " , "Ita: " , "Jap: " , "Chil: " , "Uru: " , "Kor: ");
		$name_replace = array("LATINO | " , "SPAIN | " , "USA | " , "COLOMBIA | " , "UK | " , "ARGENTINA | " , "ITALY | " , "JAPAN | " , "CHILE | " , "URUGUAY | " , "KOREA | ");
		$name = str_replace($name_search , $name_replace , str_replace("Hd" , "HD" , ucwords(strtolower(str_replace($path_name[0] , "" , $path_name_slash[0]))))).$path_name_slash[1];
		echo '#EXTINF:-1 group-title="'.strtoupper($grupo).'" tvg-logo="'.$path_logo.'",'.$name.PHP_EOL.$path_get.'?id='.bin2hex($json['Videos'][$i]['Title'])."&type=master.m3u8".PHP_EOL.PHP_EOL;
		}
		
		
function cURL($url , $authorization){
    $ch = curl_init();
    $headers = array
    (
    'Host: smovies.vomcenter.com',
    'Connection: Keep-Alive',
    'User-Agent: vodfull',
    'Authorization: Basic '.$authorization,
    'Accept-Encoding: gzip'
    );
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch,CURLOPT_ENCODING, '');
    $response=curl_exec($ch);
    curl_close($ch);
    return $response;
    }
		
		