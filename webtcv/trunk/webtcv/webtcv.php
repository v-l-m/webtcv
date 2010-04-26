<?php
session_start();
if(empty($_SESSION['pseudo']))
{ header("location: index.php"); }
?>
<!DOCTYPE html
  PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <link rel="SHORTCUT ICON" type="image/png" href="http://www.virtual-loup-de-mer.org/images/site/favicon.png" />
      <title>WebVLM Vb0.1</title>
<style type="text/css">
          html, body { margin: 0; padding: 0; height: 100%; }
          body { background-color: #000000; }
        </style></head>
   <body>
<div align="center" style="background-image: url('water010.jpg');  repeat;">
<object type="application/x-shockwave-flash" data="vlm_navigator.lzx.swf10.swf?lzproxied=false" width="1200" height="1000">
         <param name="movie" value="vlm_navigator.lzx.swf10.swf?lzproxied=false">
         <param name="quality" value="high">
         <param name="scale" value="noscale">
         <param name="salign" value="LT">
         <param name="menu" value="false">
</object>
</div>
</body>
</html>

