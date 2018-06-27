<?php
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$description = substr($actual_link, stripos($actual_link, "description") + 12,stripos($actual_link, "file")-(stripos($actual_link, "description") + 12+1));
$file = substr($actual_link, stripos($actual_link, "file") + 5);
$time = microtime();
$timearray = explode(" ",microtime());
$sec = $timearray[1];
$god = tempnam("", $sec.".").'.jpg';
$fulltmpfname = explode("/",$god);
$tmpfname = 'temp/'.$fulltmpfname[2];
file_put_contents($tmpfname, file_get_contents($file));
$image_url = "http://$_SERVER[HTTP_HOST]/booth-SMS/".$tmpfname;
$url = 'http://www.pinterest.com/pin/create/button/?url='. ''.'&media=' .$image_url.'&description=' . $description ;
header("location: ".$url);
?>

