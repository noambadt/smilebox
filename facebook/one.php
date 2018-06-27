<?php
session_name('Private');
session_start();


$_SESSION['src_index'] = htmlspecialchars($_GET["index"]);
$_SESSION['display_image_size'] = "fullsize";

require_once(dirname(__FILE__). '/src/Facebook/autoload.php');
$fb = new Facebook\Facebook([
  'app_id' => '1238864772791919',
  'app_secret' => '58ea6e26c0e3478376509a2cfd9ea108',
  'default_graph_version' => 'v2.7',
]);
$helper = $fb->getRedirectLoginHelper();
$permissions = ['publish_actions', 'user_photos'];
$loginUrl = $helper->getLoginUrl('http://www.smilebox.co.il/booth-SMS/facebook/two.php', $permissions);
header( "Location: $loginUrl" );
exit();
?>


