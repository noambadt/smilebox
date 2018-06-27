<?php
session_name('Private');
session_start();

$file = substr($actual_link, strpos($_SESSION['test'], "&") + 6);
$god = tempnam("", "temp_image").'.jpg';
$fulltmpfname = explode("/",$god);
$tmpfname = $fulltmpfname[2];
file_put_contents('god.jpg', file_get_contents($file));
?>