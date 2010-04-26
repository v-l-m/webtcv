<?php
include("config.scripts.php");
include("GeoCalc.class.php");
include("fonctions.php");
session_start();
$pseudo = str_replace(" ", "%20",$_SESSION['pseudo']);
//echo $pseudo;
$password = $_SESSION['password'];
$IDU = $_SESSION['IDU'];
echo "<myXML>";
echo "<boat>";
if (!$fp = fopen("http://".$serveur_vlm.".virtual-loup-de-mer.org/getinfo.php?idu=".$IDU."&pseudo=".$pseudo."&password=".$password."","rb")) 
//if (!$fp = fopen("http://tcv.virtual-loup-de-mer.org/getinfo.php?idu=13912&pseudo=kernel%20panic%202&password=sweetie","rb")) 
	{
	echo "Echec de l'ouverture du fichier";
	exit;
	}
	else {
		while(!feof($fp)) {
		// On récupère une ligne
			$Ligne = fgets($fp,255);
			$tab = explode("=",$Ligne);
			if(!empty($tab[0]) && !empty($tab[1]))
			{ 
			$label = str_replace("@","_at_",$tab[0]);
			$valeur = strip_tags(trim($tab[1]));
			echo "<$label>$valeur</$label>"; 
			if($label == "HDG") { $HDG = $valeur; }
			if($label == "TWD") { $TWD = $valeur; }
			}
			$tab = "";
		}
		fclose($fp); // On ferme le fichier
	}
echo "<VTWA>".calcul_angle_vent($HDG, $TWD)."</VTWA>";
echo "<VTWD>".angle_oppose($TWD)."</VTWD>";
echo "<password>".$password."</password>";
echo "</boat>";
echo "</myXML>";
?>

