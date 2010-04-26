<?php
function format_query($var)
{
$var = str_replace("%2E",".",$var);
$var = str_replace("%2D",".",$var);
return $var;
}

// CALCUL DE DISTANCE ENTRE DEUX POINTS
function getRiemannDistance($lat_from, $long_from, $lat_to, $long_to)
{
 /*** distance unit ***/
 /*** miles ***/
   // $unit = 3963;
 /*** nautical miles ***/
    $unit = 3444; 
    /*** kilometers ***/
   // $unit = 6371;
 /*** 1 degree = 0.017453292519943 radius ***/
 $degreeRadius = deg2rad(1);
 
 /*** convert longitude and latitude to radians ***/
 $lat_from  *= $degreeRadius;
 $long_from *= $degreeRadius;
 $lat_to    *= $degreeRadius;
 $long_to   *= $degreeRadius;
 
 /*** apply the Great Circle Distance Formula ***/
 $dist = sin($lat_from) * sin($lat_to) + cos($lat_from)
 * cos($lat_to) * cos($long_from - $long_to);
 
 /*** radius of earth * arc cosine ***/
 return ($unit * acos($dist));
}

// PERMET D'AVOIR L'ANGLE TRIBORD AU BABORD
function calcul_angle_vent($cap, $dir_vent)
{
$angle = $cap-$dir_vent;
if($angle>180)
{ $angle=$angle-360; }
return $angle;
}

function calcul_direction_vent($cap, $angle_vent)
{
$direction = $cap+$angle_vent;
if($direction>360)
{ $direction=$direction-360; }
return $direction;
}

// UTILE POUR VLM-20
function angle_oppose($val) 
	{
	$val=$val + 180;
	if($val>360) { $val=$val - 360; }
	return $val;
	}

?>
