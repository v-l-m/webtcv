<?php
if($_POST['pseudo'])
{
	define('LOGIN', $_POST['pseudo']);
	define('PASSWORD', $_POST['password']);
	define('LANG', 'fr');
	define('TYPE', 'login');
	
	define('AUTHENTIFICATION', 'http://tcv.virtual-loup-de-mer.org/myboat.php');
	$sid = '';
	$userAgent = "IE 7 - Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30)";

$ch = curl_init(AUTHENTIFICATION);
@curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
	curl_setopt($ch, CURLOPT_POSTFIELDS,
		array(
			'pseudo' => LOGIN,
			'password' => PASSWORD,
			'lang' => LANG,
			'type' => TYPE
		)
	);
	curl_setopt($ch, CURLOPT_COOKIEJAR, realpath('cookie.txt'));
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$ret = curl_exec($ch);
	if ($ret === FALSE) {
		die(curl_error());
	}
	curl_close($ch);
	

	//echo "<br>".$ret."<br>";
	$ret = strip_tags($ret);
	$pos = strrpos(trim($ret), "Access restricted");
	if ($pos === false) { 
	setcookie("pseudo", $_POST['pseudo'], time()+2592000, "/" ,"caraibes.hd.free.fr/", 1);
	setcookie("password", $_POST['password'], time()+2592000, "/" ,"caraibes.hd.free.fr/", 1);
	session_start();
	$_SESSION['pseudo'] = $_POST['pseudo'] ;
	$_SESSION['password'] = $_POST['password'] ;
	$_SESSION['IDU'] = $_POST['IDU'] ;
	if($_POST['version'] == '0') { header("location: webtcv.php"); }
	if($_POST['version'] == '1') { header("location: http://caraibes.hd.free.fr:8080/lps-4.6.1/vlm/vlm_navigator.lzx?lzr=swf9"); }
	if($_POST['version'] == '2') { header("location: mobile_320x240/index.php"); }
	}
	else {echo "non connecté !";}
	
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Dev WebTCV</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="SHORTCUT ICON" type="image/png" href="http://www.virtual-loup-de-mer.org/images/site/favicon.png" />
<style type="text/css">
<!--
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
}
-->
</style></head>

<body>
<h3>Page de connexion a WebTCV</h3>
<p>Indiquez le compte valide d'un bateau en course sur VLM,<br>
  puis choisissez soit la version stable compil&eacute;e pour d&eacute;ploiement,<br> 
  soit la version non compil&eacute;e en cours de d&eacute;veloppement . </p>
<form name="form1" method="post" action="">
<table width="400" border="0">
  <tr>
    <td width="112"><div align="right"><strong>Pseudo : </strong></div></td>
    <td width="278"><input type="text" name="pseudo"></td>
  </tr>
  <tr>
    <td><div align="right"><strong>Mot de passe : </strong></div></td>
    <td><input type="password" name="password"></td>
  </tr>
  <tr>
    <td><div align="right"><strong>Numéro de bateau : </strong></div></td>
    <td><input type="IDU" name="IDU"></td>
  </tr>
  <tr>
    <td><div align="right"><strong>Version : </strong></div></td>
    <td><select name="version">
      <option value="0" selected>Compil&eacute;e stable (d&eacute;ploiement)</option>
      <option value="1">Non compil&eacute;e (d&eacute;veloppement)</option>
	  <option value="2">Mobile 320x240</option>
    </select></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
      <input type="submit" name="Submit" value="Envoyer">    </td>
  </tr>
</table>
</form>
<p>&nbsp;</p>
</body>
</html>
