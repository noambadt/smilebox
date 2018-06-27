<?php
session_name('Private');
session_start();
$_SESSION['description'] = htmlspecialchars($_POST["description"]);
require_once ('codebird/src/codebird.php');
\Codebird\Codebird::setConsumerKey('t2Q7Ltog7OpRpLYAMYYzc6CyX', 'E0ATGdLg86S3S3qwZSfCWnKKObkpE2JnTHbcBGdeFeSL5CFnNd'); // static, see README
$cb = \Codebird\Codebird::getInstance();
// assign access token on each page load
$cb->setToken($_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

$extra_photos =  $_POST["extra_photos"];
$urls =  array($_SESSION[$_SESSION['display_image_size']][$_SESSION['src_index']]);
if(is_array ($extra_photos)){
    foreach ($extra_photos as &$extra_photo) {
        array_push($urls,$_SESSION['fullsize'][intval($extra_photo)]);
    }
}



$media_ids = array("test");

foreach ($urls as &$src_url) {
    $reply = $cb->media_upload(array(
      'media' => $src_url
    ));
    $temp[] = $reply->media_id_string;
    $media_ids_comma_separated = implode(',', $temp);
}


$reply = $cb->statuses_update([
  'status' => $_SESSION['description'],
  'media_ids' => $media_ids_comma_separated
]);
echo '<script>window.location = "' . $reply->entities->media[0]->expanded_url . '"</script>';

?>
