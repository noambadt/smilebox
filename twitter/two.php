<?php
session_name('Private');
session_start();

if (isset($_GET['oauth_verifier']) && isset($_SESSION['oauth_verify'])) {
    require_once ('codebird/src/codebird.php');
    \Codebird\Codebird::setConsumerKey('t2Q7Ltog7OpRpLYAMYYzc6CyX', 'E0ATGdLg86S3S3qwZSfCWnKKObkpE2JnTHbcBGdeFeSL5CFnNd'); // static, see README

    $cb = \Codebird\Codebird::getInstance();

  // verify the token
  $cb->setToken($_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
  unset($_SESSION['oauth_verify']);

  // get the access token
  $reply = $cb->oauth_accessToken([
    'oauth_verifier' => $_GET['oauth_verifier']
  ]);

  // store the token (which is different from the request token!)
  $_SESSION['oauth_token'] = $reply->oauth_token;
  $_SESSION['oauth_token_secret'] = $reply->oauth_token_secret;
  $_SESSION['username'] = $reply->screen_name;
    $_SESSION['state'] = "share";
  $_SESSION['share_platform'] = "twitter";

  // send to the choosing photos dialog

  echo '<script>window.location = "../land.php";</script>';
}
?>