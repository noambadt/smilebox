<?php
session_name('Private');
session_start();

$_SESSION['src_index'] = htmlspecialchars($_GET["index"]);
$_SESSION['display_image_size'] = "fullsize";

require_once ('codebird/src/codebird.php');
\Codebird\Codebird::setConsumerKey('t2Q7Ltog7OpRpLYAMYYzc6CyX', 'E0ATGdLg86S3S3qwZSfCWnKKObkpE2JnTHbcBGdeFeSL5CFnNd'); // static, see README

$cb = \Codebird\Codebird::getInstance();


  // get the request token
  $reply = $cb->oauth_requestToken([
    'oauth_callback' => 'http://www.smilebox.co.il/booth-SMS/twitter/two.php'
  ]);

  // store the token
  $cb->setToken($reply->oauth_token, $reply->oauth_token_secret);
  $_SESSION['oauth_token'] = $reply->oauth_token;
  $_SESSION['oauth_token_secret'] = $reply->oauth_token_secret;
  $_SESSION['oauth_verify'] = true;

  // redirect to auth website
  $auth_url = $cb->oauth_authorize();
  echo '<script>window.location = "'.$auth_url.'";</script>';

?>
you sholdnot read this