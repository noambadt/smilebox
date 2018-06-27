<?php
session_name('Private');
session_start();


ini_set('display_errors', 1);


if (!isset($_SESSION['state'])) {
    $_SESSION['state'] = "idle";
}
if(!empty($_GET)){
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $datafileurl = substr($actual_link, strpos($actual_link, "=") + 1);
        file_put_contents("tmpdata.php", file_get_contents($datafileurl));
    require "tmpdata.php";
    unlink ('tmpdata.php');
    $_SESSION['fullsize'] =  $fullsize;
    $_SESSION['thumb'] = $thumb;
    $_SESSION['title'] = $event_title;
    $_SESSION['number_of_photos'] = count($fullsize);
    $_SESSION['full_width'] = $full_width;
    $_SESSION['full_height'] =$full_height;
    $_SESSION['bottombanner'] =$bottombanner;
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script
            src="https://code.jquery.com/jquery-1.12.4.min.js"
            integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
            crossorigin="anonymous"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        var jQuery_1_12_4 = $.noConflict(true);
    </script>

    <link rel="stylesheet" type="text/css" href="image-picker/image-picker.css">
    <!-- load jQuery 1.6.4 -->
    <script
            src="https://code.jquery.com/jquery-1.6.4.min.js"
            integrity="sha256-lR1rrjnrFy9XqIvWhvepIc8GD9IfWWSPDSC2qPmPxaU="
            crossorigin="anonymous"></script>
    <script type="text/javascript">
        var jQuery_1_6_4 = $.noConflict(true);
    </script>
    <title>Share Your Pictures!</title>
    <style type="text/css">
        /* Some custom styles to beautify this example */
         #pic {
             margin: auto;
             width: auto;
             max-height: 100%;

         }
        #gestures_hint {
            margin: auto;
            max-width: 60vmin;
            max-height: 40vmin;
            height: auto;
            position: absolute;
            top: 80%;
            left: 50%;
            transform: translate(-50%,-50%);
        }
        .rows_div
        {
            padding: 15px;
            font-size: 18px;
            margin-bottom: 10px;
            max-width: 100%;
        }
        .row_div
        {
            padding: 1%;
            font-size: 18px;
            margin-bottom: 10px;
            max-width: 100%;
        }
        .my_button {
            background-color: Transparent;
            background-repeat:no-repeat;
            border: none;
            cursor:pointer;
            overflow: hidden;
            outline:none;
            position: absolute;
            top: 50%;
        }
        #gesture_containor{
            height: 70vh;
            position: relative;
        }
        #sharing_row{
            height: 10vh;
        }
        #bottom_banner_row{
            height: 30vh;
        }
        .glyphicon{
            font-size: 10vmin;
            color:lightgray;
            text-shadow: -2px 0 black, 0 2px black, 2px 0 black, 0 -2px black;
        }
        #leftarrow{
            left: 0%;
            transform: translate(0%,-50%);

        }
        #rightarrow{
            left: 100%;
            transform: translate(-100%,-50%);

        }

    </style>
</head>
<body style="background-color:white;">
    <?php
        if ($_SESSION['state']!="idle") {
            $_SESSION['state']="idle";
            require "share_modal.php";
        }
    ?>
    <div class="container">
        <!--place for title row if needed-->
        <div class="row" id="gesture_containor">
            <button type="button" class="my_button"  id="leftarrow" onclick="prev_pic()">
            <span class="glyphicon glyphicon-chevron-left"></span>
            </button>
            <button type="button" class="my_button"  id="rightarrow" onclick="next_pic()">
            <span class="glyphicon glyphicon-chevron-right"></span>
            </button>
                <img  id="pic" class="img-rounded img-responsive"  src="resources/loading.gif">
                <img  id="gestures_hint" style="display:none" class="img-rounded img-responsive"  src="resources/gestures.gif">
        </div>
        <div class="row">


        </div>

        <!--buttons row-->
        <div class="row" id="sharing_row">

                <div class="col-xs-3">
                    <div class="row_div">
                    <a class="btn btn-info btn-block responsive-width" onclick="share('twitter')">
                        <i class="fa fa-twitter fa-2x"></i></a>
                    </div>
                </div>
                <div class="col-xs-3" >
                    <div class="row_div">
                    <a class="btn btn-primary btn-block responsive-width" onclick="share('facebook')">
                        <i class="fa fa-facebook fa-2x"></i></a>
                    </div>
                </div>
                <div class="col-xs-3">
                    <div class="row_div">
                    <a class="btn btn-danger btn-block responsive-width" onclick="share('pinterest')">
                        <i class="fa fa-pinterest fa-2x"></i></a>
                    </div>

                </div>

                <div class="col-xs-3">
                    <div class="row_div">
                        <a href="path/to/file" download>
                            <a class="btn btn-success btn-block responsive-width"  onclick="share('download')">
                                <i class="fa fa-download     fa-2x"></i></a>
                        </a>

                    </div>
                </div>

        </div>
        <!--bottom banner row-->
        <div class="row" id="bottom_banner_row">
            <div class="row_div" >
                <img src="<?php echo $_SESSION['bottombanner']; ?>" class="img-rounded img-responsive">
            </div>
        </div>
    </div>

    <script src="hammer/hammer.js"></script>
    <link rel="stylesheet" href="photoswipe/photoswipe.css">
    <link rel="stylesheet" href="photoswipe/default-skin/default-skin.css">
    <script src="photoswipe/photoswipe.min.js"></script>
    <script src="photoswipe/photoswipe-ui-default.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!-- Root element of PhotoSwipe. Must have class pswp. -->
    <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

        <!-- Background of PhotoSwipe.
             It's a separate element as animating opacity is faster than rgba(). -->
        <div class="pswp__bg"></div>

        <!-- Slides wrapper with overflow:hidden. -->
        <div class="pswp__scroll-wrap">

            <!-- Container that holds slides.
                PhotoSwipe keeps only 3 of them in the DOM to save memory.
                Don't modify these 3 pswp__item elements, data is added later on. -->
            <div class="pswp__container">
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
            </div>

            <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
            <div class="pswp__ui pswp__ui--hidden">

                <div class="pswp__top-bar">

                    <!--  Controls are self-explanatory. Order can be changed. -->

                    <div class="pswp__counter"></div>

                    <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

                    <button class="pswp__button pswp__button--share" title="Share"></button>

                    <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

                    <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

                    <!-- Preloader demo http://codepen.io/dimsemenov/pen/yyBWoR -->
                    <!-- element will get class pswp__preloader--active when preloader is running -->
                    <div class="pswp__preloader">
                        <div class="pswp__preloader__icn">
                            <div class="pswp__preloader__cut">
                                <div class="pswp__preloader__donut"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                    <div class="pswp__share-tooltip"></div>
                </div>

                <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
                </button>

                <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
                </button>

                <div class="pswp__caption">
                    <div class="pswp__caption__center"></div>
                </div>

            </div>

        </div>

    </div>
</body>
<script src="smilebox.js"></script>

<script>
    // link to the debuginfgthingie: src="https://jsconsole.com/js/remote.js?noam"
    //<!--some variables regarding the page:-->
    var description = '<?php echo $_SESSION['title'];?>';
    //<!--asynchronous image loading:-->
    var image = document.getElementById('pic');
    var gestures_animation = document.getElementById('gestures_hint');
    var show_animation = true;
    var downloadingImage = [
        <?php
        $addme = "";
        for ($i = 0; $i < $_SESSION['number_of_photos']; $i++) {
            echo $addme . "new Image()";
            $addme = " , ";
        }
        ?>
    ];
    var downloadingThumbImage = [
        <?php
        $addme = "";
        for ($i = 0; $i < $_SESSION['number_of_photos']; $i++) {
            echo $addme . "new Image()";
            $addme = " , ";
        }
        ?>
    ];
    var full_src = [
        <?php

        $addme = "";
        for ($i = 0; $i < $_SESSION['number_of_photos']; $i++) {
            echo $addme . "'" .$_SESSION['fullsize'][$i] . "'";
            $addme = " , ";
        }
        ?>
    ];
 full_sizes = [
        <?php

        $addme = "";
        for ($i = 0; $i < $_SESSION['number_of_photos']; $i++) {
            echo $addme . "[" .$_SESSION['full_width'][$i] . ',' .$_SESSION['full_height'][$i] . "]";
            $addme = " , ";
        }
        ?>
    ];
    var thumb_src = [
        <?php
        $addme = "";
        for ($i = 0; $i < $_SESSION['number_of_photos']; $i++) {
            echo $addme ."'" .$_SESSION['thumb'][$i] . "'";
            $addme = " , ";
        }
        ?>
    ];

    start_me_up(
        full_src,
        full_sizes,
        thumb_src,
        <?php echo $_SESSION['number_of_photos']; ?>
    );
</script>
</html>