<?php
include("fonctions.php");
session_start();

$pseudo = str_replace(" ", "%20",$_SESSION['pseudo']);
$pseudo_curl = $_SESSION['pseudo'];
$password = $_SESSION['password'];
$IDU = $_SESSION['IDU'];

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
$text='left';

$url_vlm = "http://www.virtual-loup-de-mer.org/map.img.php?maplayers=".$maplayers."&idraces=".$idraces."&boat=".$boat."&save=".$save."&maptype=".$maptype."&list=".$list."&mapcenter=".$mapcenter."&drawtextwp=".$drawtextwp."&maille=".$maille."&estime=".$estime."&age=".$age."&maparea=".$maparea."&x=".$x."&y=".$y."&lat=".$lat."&long=".$long."&latwp=".$latwp."&longwp=".$longwp."&tracks=".$tracks."&proj=".$proj."&text=".$text;
$url_map = "http://www.virtual-loup-de-mer.org/mercator.img.php?save=".$save."&drawortho=".$drawortho."&drawwind=".$drawwind."&lat=".$lat."&long=".$long."&x=".$x."&y=".$y."&maparea=".$maparea."&maille=".$maille."&idraces=".$idraces."&drawtextwp=".$drawtextwp."&proj=".$proj."&seacolor=".$seacolor."&tracks=".$tracks."&age=".$age."&estime=".$estime."&list=".$list."&boat=".$boat."&text=".$text;
define('LOGIN', $pseudo_curl);
define('PASSWORD', $password);
define('LANG', 'fr');
define('TYPE', 'login');

define('AUTHENTIFICATION', 'http://www.virtual-loup-de-mer.org/myboat.php');
define('URLVLM', $url_vlm);
define('URLMAP', $url_map);

// DECOMMENTER POUR DEBUGAGE => RESULTATS DANS FICHIER DE TRACE
$event="get_map";
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
$ret="";

// ENVOI DE LA REQUETE GET POUR SAUVER LES PREFERENCES
$ch = curl_init(URLVLM);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_COOKIEFILE, realpath('cookie-'.$IDU.'.txt'));
$ret = curl_exec($ch);
if ($ret === FALSE) {
    die(curl_error());
}
curl_close($ch);
$ret="";
/*
// NOUVEAU GET POUR RECUPERER LA CARTE
$ch = curl_init(URLMAP);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_COOKIEFILE, realpath('cookie-'.$IDU.'.txt'));
$ret = curl_exec($ch);
if ($ret === FALSE) {
    die(curl_error());
}
curl_close($ch);

header("Content-type: image/png"); 
echo $ret;
*/
?>
