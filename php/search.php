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

//var_dump($json);
//var_dump($session_id);

///getplayeridbyname[ResponseFormat]/{developerId}/{signature}/{session}/{timestamp}/{playerName}
$signature = md5("3099getplayeridbynameC8CDF14A003649E494CA47347175579B".$timestamp);
$jsonurl = "http://api.smitegame.com/smiteapi.svc/getplayeridbynamejson/3099/".$signature."/".$session_id."/".$timestamp."/".$playername;

$json = file_get_contents($jsonurl);
$json = json_decode($json,true);
$player_id = $json[0]['player_id'];

if (empty($json)){
  //  var_dump('true');

    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Content-type: application/json');
    echo (json_encode(false));
    die;
}

//var_dump($json);
//var_dump($player_id);

///getplayer[ResponseFormat]/{developerId}/{signature}/{session}/{timestamp}/{player}

$signature = md5("3099getplayerC8CDF14A003649E494CA47347175579B".$timestamp);
$jsonurl = "http://api.smitegame.com/smiteapi.svc/getplayerjson/3099/".$signature."/".$session_id."/".$timestamp."/".$player_id;

$json = file_get_contents($jsonurl);
//var_dump($json);


///getplayerachievements[ResponseFormat]/{developerId}/{signature}/{session}/{timestamp}/{playerId}

$signature = md5("3099getplayerachievementsC8CDF14A003649E494CA47347175579B".$timestamp);
$jsonurl = "http://api.smitegame.com/smiteapi.svc/getplayerachievementsjson/3099/".$signature."/".$session_id."/".$timestamp."/".$player_id;
$json_1 = file_get_contents($jsonurl);

$jsonmerge = json_encode(array_merge(json_decode($json, true),json_decode($json_1, true)));


///getmatchhistory[ResponseFormat]/{developerId}/{signature}/{session}/{timestamp}/{playerId}
$signature = md5("3099getmatchhistoryC8CDF14A003649E494CA47347175579B".$timestamp);
$jsonurl = "http://api.smitegame.com/smiteapi.svc/getmatchhistoryjson/3099/".$signature."/".$session_id."/".$timestamp."/".$player_id;
$json_2 = file_get_contents($jsonurl);

$jsonmerge = json_encode(array_merge(json_decode($json, true),json_decode($json_1, true)));


header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
echo ($jsonmerge);

?>
