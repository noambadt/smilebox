 <!-- load jQuery 1.12.4 -->

    <script src="image-picker/image-picker.js" type="text/javascript"></script>

    <style>
    #share_photo {
    display: block;
    margin: auto;
    width: 100%;
    height: auto;
    }
    #share_logo {
    float: right;
    display: block;
    margin: auto;
    width: 10%;
    height: auto;
    }
  #description{
  -webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
	border: 5px solid #cccccc;

	width: 100%;
  }

</style>



<div class="container">
  <!-- Trigger the modal with a button -->
  <script>
      jQuery_1_12_4(window).load(function(){
        jQuery_1_12_4('#myModal').modal('show');
    });
</script>
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <form role="form" action="<?php echo $_SESSION['share_platform'];?>/three.php" method="post">
        <div class="modal-header">
            <div class="row_div" id="share_logo">
                <a class="btn btn-<?php if($_SESSION['share_platform']=="facebook"){echo "primary";} else if ($_SESSION['share_platform']=="twitter"){echo "info";}?> btn-block responsive-width" onclick="">
                    <i class="fa fa-<?php echo $_SESSION['share_platform']?>"></i></a>
            </div>


          <h4 class="modal-title">Hi <?php echo $_SESSION['username'];?> ! </h4>

        </div>
        <div class="modal-body" id="my_modal_body" >

            <img id='share_photo' src="<?php echo $_SESSION[ $_SESSION['display_image_size']][$_SESSION['src_index']]; ?>" alt="photo number <?php echo $_SESSION['src_index']; ?>" />

            <label for="other">Description:</label><br>
            <textarea type="text" name="description" id="description" ><?php echo $_SESSION['title']; ?></textarea>
            <div id="pick_text">click on the photos you wish to add to your post</div>
            <div style="margin: auto;text-align: center;width:100%">
            <select name="extra_photos[]" multiple="multiple" id="picker" class="image-picker">
            <?php
                for ($i = 0; $i < $_SESSION['number_of_photos']; $i++) {
                    if ($i  != $_SESSION['src_index'])
                    {
                        echo ('<option id="'.strval($i).'" class="thumb" data-img-src="'. $_SESSION['thumb'][$i].'" value="'.strval($i).'" >img'. strval($i) .'</option>');
                    }
                }
            ?>
            </select>
            </div>
            <button type="button" id="pick_button" onclick="show_selector()">upload more photos</button>
            <div>you will be directed to your post/tweet in after you press "post"</div>
        </div>
        <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <input type="submit" class="btn btn-default" value="Post!">
        </div>
        </form>
      </div>

    </div>
  </div>

</div>

<script>
var picker = document.getElementById('picker');
picker.style.visibility = 'hidden';
var picker = document.getElementById('pick_text');
picker.style.visibility = 'hidden';

function show_selector() {
    var picker = document.getElementById('picker');
    picker.style.visibility = 'visible';
    var picker = document.getElementById('pick_text');
    picker.style.visibility = 'visible';
    var picker = document.getElementById('pick_button');
    picker.style.visibility = 'hidden';
    jQuery_1_6_4("select").imagepicker({
        hide_select: true
    });
    var total_width = jQuery_1_6_4("#my_modal_body").width();
    var how_many_extra_photos =  <?php echo ($_SESSION['number_of_photos'])-1;?>;
    if (how_many_extra_photos>0){
        var width_of_img = (Math.round(0.9*total_width/how_many_extra_photos)).toString()+"px"
        jQuery_1_6_4( ".thumbnails li" ).css("width", width_of_img );
    }
}
</script>

