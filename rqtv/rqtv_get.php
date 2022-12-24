<?php

header("Content-Type: text/plain");
ini_set('max_execution_time', 0);

$id = hex2bin($_GET['id']);

$userid = "841851";
$user = "2022101023";
$password = "2310102022";
$k = "AndTVFS_rci9c867om2dhd0nasuimpvc8v";
$authorization = "MjAyMjEwMTAyMzoyMzEwMTAyMDIy";

session_start();
if(is_null($_SESSION['rqtv'.$id])){
	$api = "https://smovies.vomcenter.com:443/xbmc/tvgen.php?guide=1&fullepg=1&userid=".$userid."&user=".$user."&password=".$password."&k=".$k."&roku=1&vu=1";
	$json = json_decode(cURL($api , $authorization), true);
	for($i = 0; $i < count($json['Videos']); $i++){
		$url = str_replace(array('\/\/', ' ', '�', '+', '�', '!'), array('//', '_', 'n', 'plus', 'u', ''), $json['Videos'][$i]['Url']);
		$name = $json['Videos'][$i]['Title'];
		if($id == $name){
			$_SESSION['rqtv'.$id] = $url;
			}
		}
	}
$expire = explode("e=" , $_SESSION['rqtv'.$id] );
if (time() < $expire[1]){
	$path = explode("/" , $_SESSION['rqtv'.$id] );
	$session_path = str_replace(end($path) , "" , $_SESSION['rqtv'.$id] );
	$content = file_get_contents($_SESSION['rqtv'.$id]);
	echo str_replace("URI=\"" , "URI=\"".$session_path , str_replace(",".PHP_EOL , ",".PHP_EOL.$session_path , $content));
	}else{
		$api = "https://smovies.vomcenter.com/xbmc/tvgen.php?guide=1&fullepg=1&userid=".$userid."&user=".$user."&password=".$password."&k=".$k."&roku=1&vu=1";
		$json = json_decode(cURL($api , $authorization), true);
		for($i = 0; $i < count($json['Videos']); $i++){
			$url = str_replace(array('\/\/', ' ', '�', '+', '�', '!'), array('//', '_', 'n', 'plus', 'u', ''), $json['Videos'][$i]['Url']);
			$name = $json['Videos'][$i]['Title'];
			if($id == $name){
				$_SESSION['rqtv'.$id] = $url;
				$path = explode("/" , $_SESSION['rqtv'.$id] );
				$session_path = str_replace(end($path) , "" , $_SESSION['rqtv'.$id] );
				$content = file_get_contents($_SESSION['rqtv'.$id]);
				echo str_replace("URI=\"" , "URI=\"".$session_path , str_replace(",".PHP_EOL , ",".PHP_EOL.$session_path , $content));
				}
			}
		}
		
function cURL($url , $authorization){
    $ch = curl_init();
    $headers = array
    (
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
		
		