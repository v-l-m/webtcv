<?php
// le session start doit etre dans le script appellant
$traces = "debug_".str_replace(" ","_",$event).".log";
$handle = fopen($traces,"a");

fwrite($handle,$event." \n");
fwrite($handle,"URL formée pour VLM : ".$url_vlm." \n");
if($event=="get_map") { fwrite($handle,"URL pour carte VLM : ".$url_map." \n"); }
fwrite($handle,"Identifiant de la session :  \n");
fwrite($handle,session_id()." \n");

// POST
$k="";
$v="";
fwrite($handle,"Variables POST : \n");
foreach ($_POST as $k => $v) {
   fwrite($handle,"$k => $v \n");
}

//GET
$k="";
$v="";
fwrite($handle,"Variables GET : \n");
foreach ($_GET as $k => $v) {
   fwrite($handle,"$k => $v \n");
}

//SESSION
$k="";
$v="";
fwrite($handle,"Variables de session : \n");
foreach ($_SESSION as $k => $v) {
   fwrite($handle,"$k => $v \n");
}

// SERVEUR
$k="";
$v="";
fwrite($handle,"Variables serveur : \n");
foreach ($_SERVER as $k => $v) {
   fwrite($handle,"$k => $v \n");
}
fclose($handle); 
?>
