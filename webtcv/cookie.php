<?php
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Document sans titre</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?php
echo $_COOKIE['pseudo']."<br>";
echo $_COOKIE['password']."<br>";

echo $_SESSION['pseudo']."<br>";
echo $_SESSION['password']."<br>";
?>
</body>
</html>
