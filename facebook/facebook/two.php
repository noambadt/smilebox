<?php
session_name('Private');
session_start();
require_once(dirname(__FILE__). '/src/Facebook/autoload.php');

$fb = new Facebook\Facebook([
  'app_id' => '1238864772791919',
  'app_secret' => '58ea6e26c0e3478376509a2cfd9ea108',
  'default_graph_version' => 'v2.7',
]);
$fbApp = $fb->getApp();

$helper = $fb->getRedirectLoginHelper();
try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  echo "one";
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
if (isset($accessToken)) {
  // Logged in!
  $_SESSION['facebook_access_token'] = (string) $accessToken;

  // Now you can redirect to another page and use the
  // access token from $_SESSION['facebook_access_token']
  try {
  // Returns a `Facebook\FacebookResponse` object
      $response = $fb->get('/me?fields=name', $_SESSION['facebook_access_token']);
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
      echo 'Graph returned an error: ' . $e->getMessage();
      echo "two";
      exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }

    $user = $response->getGraphUser();
      $_SESSION['username'] = $user['name'];
      $_SESSION['state']= "share";
        $_SESSION['share_platform']= "facebook";

  echo '<script>window.location = "../land.php";</script>';
  exit();
}
echo '<script>window.location = "../land.php";</script>';
?>
<html lang="en">
