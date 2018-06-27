<?php
session_name('Private');
session_start();
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$file_link = substr($actual_link, strpos($actual_link, "file=") + 5);
$pos = strpos($filename, '?AWS');
if ($pos === false)
{
    $ext = 'jpg';
}
else
{
    $ext = substr($filename,$pos-3,3);
    $ext = strtolower($ext);
}

ini_set ('allow_url_fopen',1);
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="smilebox_photo.'. $ext . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
    $head = array_change_key_case(get_headers($file_link, TRUE));
    $filesize = $head['content-length'];
header('Content-Length: ' . $filesize);
readfile($file_link);
ini_set ('allow_url_fopen',0);
exit;

?>
