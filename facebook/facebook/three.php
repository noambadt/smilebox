<?php
session_name('Private');
session_start();

$_SESSION['description'] = htmlspecialchars($_POST["description"]);
require_once(dirname(__FILE__). '/src/Facebook/autoload.php');
$extra_photos =  $_POST["extra_photos"];

$fb = new Facebook\Facebook([
  'app_id' => '1238864772791919',
  'app_secret' => '58ea6e26c0e3478376509a2cfd9ea108',
  'default_graph_version' => 'v2.7',
]);
$fbApp = $fb->getApp();
$urls = array($_SESSION[$_SESSION['display_image_size']][$_SESSION['src_index']]);
if(is_array ($extra_photos)) {
    foreach ($extra_photos as &$extra_photo) {
        array_push($urls, $_SESSION['fullsize'][intval($extra_photo)]);
    }
}
$filename = $_SESSION['fullsize'][0];
$pos = strpos($filename, '?');
if ($pos === false)
{
    $ext = 'jpg';
}
else
{
    $ext = substr($filename,$pos-3,3);
    $ext = strtolower($ext);
}

$link_for_main_photo ="";
/*
if(strcmp($ext,"gif") ==0) {
        $data = [
            'message' =>$_SESSION['description'],
            //'link' => $urls[0],
            'link' => "https://s3.amazonaws.com/smilebox-2017/2017.05.11+-+13-15-08+ne/0034/GIF%5C170511_133506.GIF",
        ];
        $graph_request = '/me/feed';
        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->post($graph_request, $data, $_SESSION['facebook_access_token']);
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        $graphNode = $response->getGraphNode();
        $photoid = $graphNode['id'];
        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->get($photoid . '?fields=permalink_url', $_SESSION['facebook_access_token']);
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        $graphNode = $response->getGraphNode();
        $url = $graphNode['permalink_url'];
    $link_for_main_photo = $url;
 }
*/
if(1==2)
{}
 else {
     foreach ($urls as &$src_url) {

         $data = [
             'message' => $_SESSION['description'],
             'url' => $src_url,
         ];
         $graph_request = '/me/photos';


         try {
             // Returns a `Facebook\FacebookResponse` object
             $response = $fb->post($graph_request, $data, $_SESSION['facebook_access_token']);
         } catch (Facebook\Exceptions\FacebookResponseException $e) {
             echo 'Graph returned an error: ' . $e->getMessage();
             exit;
         } catch (Facebook\Exceptions\FacebookSDKException $e) {
             echo 'Facebook SDK returned an error: ' . $e->getMessage();
             exit;
         }
         $graphNode = $response->getGraphNode();
         $photoid = $graphNode['id'];
         try {
             // Returns a `Facebook\FacebookResponse` object
             $response = $fb->get($photoid . '?fields=link', $_SESSION['facebook_access_token']);
         } catch (Facebook\Exceptions\FacebookResponseException $e) {
             echo 'Graph returned an error: ' . $e->getMessage();
             exit;
         } catch (Facebook\Exceptions\FacebookSDKException $e) {
             echo 'Facebook SDK returned an error: ' . $e->getMessage();
             exit;
         }

         $graphNode = $response->getGraphNode();
         $url = $graphNode['link'];
         if ($link_for_main_photo == "") {
             $link_for_main_photo = $url;
         }


     }
 }

?>
<html>
<body>
<?php
echo "//<script>window.location = '$link_for_main_photo'</script>";
?>
</body>
</html>
