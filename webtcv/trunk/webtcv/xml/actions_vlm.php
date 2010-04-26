<?php
include("config.scripts.php");
include("fonctions.php");
session_start();

$pseudo = str_replace(" ", "%20",$_SESSION['pseudo']);
$pseudo_curl = $_SESSION['pseudo'];
$password = $_SESSION['password'];
$IDU = $_SESSION['IDU'];

$event = $_GET['event'];

// MAJ WP
if($event=="monwp") {
$nextwplat = format_query($_GET['targetlat']);
$nextwplon = format_query($_GET['targetlon']);
$targetandhdg = format_query($_GET['targetandhdg']); // def -1
$andhdg = format_query($_GET['andhdg']); // def off
$url_vlm = "http://".$serveur_vlm.".virtual-loup-de-mer.org/myboat.php?type=savemywp&pseudo=".$pseudo."&password=".$password."&targetlat=".$nextwplat."&targetlong=".$nextwplon."&targetandhdg=".$targetandhdg."&andhdg=".$andhdg;
}
// MAJ PREFERENCES CARTE
if($event=="prefsmap") {
$idraces = format_query($_GET['idraces']);
$lat = format_query($_GET['lat']);
$long = format_query($_GET['long']);
$latwp = format_query($_GET['latwp']);
$longwp = format_query($_GET['longwp']);
$x='980';
$y='1000';
$maptype='simple';
$maparea = format_query($_GET['maparea']);
$drawortho='yes';
$maille = format_query($_GET['maille']);
$proj='mercator';
$seacolor='ffffff';
$tracks='on';
$age = format_query($_GET['age']);
$estime = format_query($_GET['estime']);
$list = format_query($_GET['list']);
$boat = format_query($_GET['boat']);
$text='left';
$save='on';
$drawwind='0';

$mapcenter='myboat';
$drawtextwp='on';
$maplayers='merged';
$maptype='bothcompass';
$tracks='on';
$proj='mercator';
$text='right';

$url_vlm = "http://".$serveur_vlm.".virtual-loup-de-mer.org/map.img.php?maplayers=".$maplayers."&idraces=".$idraces."&boat=".$boat."&save=".$save."&maptype=".$maptype."&list=".$list."&mapcenter=".$mapcenter."&drawtextwp=".$drawtextwp."&maille=".$maille."&estime=".$estime."&age=".$age."&maparea=".$maparea."&x=".$x."&y=".$y."&lat=".$lat."&long=".$long."&latwp=".$latwp."&longwp=".$longwp."&tracks=".$tracks."&proj=".$proj."&text=".$text;
}

//EDITION DU CAP PIM=1
if($event=="pim1") {
$nw_cap = format_query($_GET['boatheading']);
$url_vlm = "http://".$serveur_vlm.".virtual-loup-de-mer.org/update_angle.php?expertcookie=yes&lang=fr&idusers=".$IDU."&pilotmode=autopilot&boatheading=".$nw_cap;
}
//EDITION DE L'ANGLE PIM=2
if($event=="pim2") {
$nv_angle = format_query($_GET['pilotparameter']);
$url_vlm = "http://".$serveur_vlm.".virtual-loup-de-mer.org/update_angle.php?expertcookie=&pilotparameter=".$nv_angle."&idusers=".$IDU."&lang=fr&pilotmode=windangle";
//$url_vlm = "http://tcv.virtual-loup-de-mer.org/update_angle.php?expertcookie=yes&lang=fr&idusers=".$IDU."&pilotmode=windangle&pilotparameter=".$nv_angle;
}

//PASSAGE EN PILOTE ORTHO PIM=3
if($event=="pim3") {
$url_vlm = "http://".$serveur_vlm.".virtual-loup-de-mer.org/update_angle.php?expertcookie=yes&lang=fr&idusers=$IDU&pilotmode=orthodromic";
}
//PASSAGE BEST VMG PIM=4
if($event=="pim4") {
$url_vlm = "http://".$serveur_vlm.".virtual-loup-de-mer.org/update_angle.php?expertcookie=yes&lang=fr&idusers=$IDU&pilotmode=bestvmg";
}
//PASSAGE VBVMG PIM=5
if($event=="pim5") {
$url_vlm = "http://".$serveur_vlm.".virtual-loup-de-mer.org/update_angle.php?expertcookie=yes&lang=fr&idusers=$IDU&pilotmode=vbvmg";
}

define('LOGIN', $pseudo_curl);
define('PASSWORD', $password);
define('LANG', 'fr');
define('TYPE', 'login');

define('AUTHENTIFICATION', 'http://'.$serveur_vlm.'.virtual-loup-de-mer.org/myboat.php');
define('URLVLM', $url_vlm);

// DECOMMENTER POUR DEBUGAGE => RESULTATS DANS FICHIER DE TRACE
//include("debug.php");


$sid = '';

//AUTHENTIFICATION

$ch = curl_init(AUTHENTIFICATION);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS,
    array(
        'pseudo' => LOGIN,
        'password' => PASSWORD,
		'lang' => LANG,
		'type' => TYPE
    )
);
curl_setopt($ch, CURLOPT_COOKIEJAR, realpath('cookie-'.$IDU.'.txt'));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$ret = curl_exec($ch);
if ($ret === FALSE) {
    die(curl_error());
}
curl_close($ch);

if (!$fp = @fopen('cookie-'.$IDU.'.txt','rb')) 
	{
	echo "Echec de l'ouverture du fichier";
	exit;
	}
	else 
	{
		while(!feof($fp)) 
			{
		
			$Ligne = fgets($fp,255);
				if (preg_match('/(PHPSESSID'.chr(9).'[0-9a-z,-]{32,40})/i', $Ligne, $m)) 
				{
				$sid = '&' . $m[1];
				$sid = str_replace(chr(9),"=",$sid);
				//echo "SID=".$sid."<br>";
				}
			}
		fclose($fp); // On ferme le fichier
	}

// ENVOI DE LA REQUETE GET
$ch = curl_init(URLVLM);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_COOKIEFILE, realpath('cookie-'.$IDU.'.txt'));
$ret = curl_exec($ch);
if ($ret === FALSE) {
    die(curl_error());
}
curl_close($ch);
echo $ret;

//echo "<reponse>$ret</reponse>";

//echo $sid."<br>";
?>
