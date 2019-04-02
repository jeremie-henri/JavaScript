<?php
/**
 * Created by PhpStorm.
 * User: h17004901
 * Date: 08/03/2019
 * Time: 14:45
 */

$timestamp = $_POST['timestamp'];
$playername = $_POST['playername'];

///createsession[ResponseFormat]/{developerId}/{signature}/{timestamp}
$signature = md5("3099createsessionC8CDF14A003649E494CA47347175579B".$timestamp);
$jsonurl = "http://api.smitegame.com/smiteapi.svc/createsessionjson/3099/".$signature."/".$timestamp;

$json = file_get_contents($jsonurl);
$json = json_decode($json,true);
$session_id = $json['session_id'];

///getplayeridbyname[ResponseFormat]/{developerId}/{signature}/{session}/{timestamp}/{playerName}
$signature = md5("3099getplayeridbynameC8CDF14A003649E494CA47347175579B".$timestamp);
$jsonurl = "http://api.smitegame.com/smiteapi.svc/getplayeridbynamejson/3099/".$signature."/".$session_id."/".$timestamp."/".$playername;

$json = file_get_contents($jsonurl);
$json = json_decode($json,true);
$player_id = $json[0]['player_id'];


///getmatchhistory[ResponseFormat]/{developerId}/{signature}/{session}/{timestamp}/{playerId}
$signature = md5("3099getmatchhistoryC8CDF14A003649E494CA47347175579B".$timestamp);
$jsonurl = "http://api.smitegame.com/smiteapi.svc/getmatchhistoryjson/3099/".$signature."/".$session_id."/".$timestamp."/".$player_id;
$json_2 = file_get_contents($jsonurl);

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
echo ($json_2);

?>
