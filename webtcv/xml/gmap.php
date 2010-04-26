<?php
include("config.scripts.php");
include("../../geocalc-php-1.2/GeoCalc.class.php");
$oGC = new GeoCalc();
include("fonctions_vlm.php");

if (!$fp = @fopen("http://".$serveur_vlm.".virtual-loup-de-mer.org/getinfo.php?pseudo=$pseudo&password=$password&idu=$bateau","rb")) 
	{
	$msg = "Echec de l'ouverture du fichier";
	//exit;
	}
	else {
		while(!feof($fp)) {
		// On récupère une ligne
			$Ligne = fgets($fp,255);
			$tab = explode("=",$Ligne);
			// echo "Label = ".$tab[0]." valeur = ".$tab[1]."<br>";
			$datas[$tab[0]]=$tab[1];
			$tab = "";
		}
		fclose($fp); // On ferme le fichier
	}
$lat = $datas["LAT"]/1000;
$lon = $datas["LON"]/1000;
$wplat = $datas["WPLAT"];
$wplon = $datas["WPLON"];
$nextvac = $datas["NUP"];
	
if($_GET['zoom'])
{ $zoom = $_GET['zoom']; } else { $zoom = 8; }
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset="iso-8859-1">
<meta http-equiv="refresh" content="<?php echo $nextvac+2; ?>">
<link rel="stylesheet" type="text/css" href="vlm.css" />
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAok_IBFtVMWx0xZX21zbpJRQMI8aBYvnUh4A1aH4V8c-4mNhOzxRN6Ev5QoDS02IpbpY4DsfPaT4QmQ" type="text/javascript"></script>
<script type="text/javascript">
    function initialize() {
      if (GBrowserIsCompatible()) {
	  
        var map = new GMap2(document.getElementById("map_canvas"), {draggableCursor: 'crosshair', draggingCursor: 'pointer'});
        map.setCenter(new GLatLng(<?php echo $lat; ?>,<?php echo $lon; ?>),<?php echo $zoom; ?>);
		var customUI = map.getDefaultUI();
        // Remove MapType.G_HYBRID_MAP
        customUI.maptypes.hybrid = true;
        map.setUI(customUI);
		
		//geodesic true pour les tracages en orthodromie
        var polyOptions = {geodesic:true};
		<?php
		//trace du bateau
		
		if (!$fp = @fopen("http://".$serveur_vlm.".virtual-loup-de-mer.org/gmap/index.php?type=ajax&riq=trj&idusers=$bateau&idraces=$course","rb")) 
			{
			$msg = "Echec de l'ouverture du fichier";
			//exit;
			}
			else {
				while(!feof($fp)) {
				// On récupère une ligne
					$Ligne = fgets($fp,255);
					$Ligne = str_replace("'#FF0000', 3","'#FF0000', 1",$Ligne);
					echo $Ligne;
				}
				fclose($fp); // On ferme le fichier
			}
		
		?>
		

		
	//geodesic true pour les tracages en orthodromie
    var polyOptions = {geodesic:true};
	
	// Marqueur du bateau
	var latlng = new GLatLng(<?php echo $lat; ?>,<?php echo $lon; ?>);
	var bateau = new GMarker(latlng);
	map.addOverlay(bateau);

	//WP visé
	var pointmwpv = new GLatLng(<?php echo trim($wplat); ?>,<?php echo trim($wplon); ?>);
	var MonIconwpv = new GIcon();
	MonIconwpv.iconSize=new GSize(32,32);
	MonIconwpv.iconAnchor=new GPoint(16,16);
	MonIconwpv.infoWindowAnchor = new GPoint(16,16);
	MonIconwpv.image="gmap/placemark_circle_highlight.png";
	var mwpv = new GMarker(pointmwpv,MonIconwpv);
	map.addOverlay(mwpv);
	var textewpv = "<?php echo $textewpv; ?>";
	GEvent.addListener(mwpv, "click", function() {
			mwpv.openInfoWindowHtml(textewpv);
			});
	
<?php
/*
	var latlng = new GLatLng(<?php echo $wplat; ?>,<?php echo $wplon; ?>);
	var wpv = new GMarker(latlng);
	map.addOverlay(wpv);
*/
?>
	//ligne entre les deux
        var polyline = new GPolyline([
	new GLatLng(<?php echo $lat; ?>, <?php echo $lon; ?>),
	new GLatLng(<?php echo $wplat; ?>, <?php echo $wplon; ?>),
        ], "#cccccc", 0.5, 0.5, polyOptions);
        map.addOverlay(polyline);


    </script>
</head>
<body onload="initialize()" onunload="GUnload()">
	<div id="message"></div>
<div id="map_canvas" style="width: 1000px; height: 800px"></div>
</body>
</html>    
