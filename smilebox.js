//<!--sharebuttons clicking:-->
var full_src;
var full_size;
var thumb_src;
var thumb_size ;
var number_of_photos;
var photoswipe_is_open = false;
var default_options;
var gallery;
var items;
var pswpElement = document.querySelectorAll('.pswp')[0];
var current_img_index = 0;
var loader_src = "resources/loading.gif";
function share(kind) {
    var url ="";

    switch(kind) {
        case 'twitter':
            url = '../booth-SMS/twitter/one.php?index=' + (current_img_index).toString();
            break;
        case 'facebook':
            url = '../booth-SMS/facebook/one.php?index=' + (current_img_index).toString();
            break;
        case 'pinterest':

            url = '../booth-SMS/pinterest.php?'+'description=' + description+'&file='+full_src[current_img_index];
            break;
        case 'download':
            url = '../booth-SMS/download.php?'+'file='+full_src[current_img_index];
            break;

    }
    window.location.href = url;
}
//<!--taking care of gestures:-->


function start_me_up(_full_src,  _full_size,_thumb_src,_number_of_photos) {
    full_src = _full_src;
    full_size = _full_size;
    thumb_src = _thumb_src;

    number_of_photos = _number_of_photos;
    var pic_con = document.getElementById('gesture_containor');
    var pic = document.getElementById('pic');
    if(number_of_photos==1)
    {
        var arrows = document.getElementsByClassName('my_button');
        arrows[0].style.display = 'none';
        arrows[1].style.display = 'none';
        show_animation = false;
    }
    var mc = new Hammer.Manager(pic_con,{
        touchAction: 'pan-y',
        recognizers: [
            // RecognizerClass, [options], [recognizeWith, ...], [requireFailure, ...]
            [Hammer.Tap,{event: 'doubletap',taps: 2, interval: 500}],
            [Hammer.Tap,{event: 'tap',taps: 1}],
            [Hammer.Swipe],
            [Hammer.Pinch,{ threshold: 1.5 }]
        ]
    });
    //mc.set({ enable: true });


    items = [];
    for (k=0;k<number_of_photos;k++)
    {
        items[k] ={w: 100,h: 100,src:'resources/loading.gif'};
    }


// build items array


// define options (if needed)

    default_options = {
        pinchToClose: true,
        closeOnScroll: false,
        closeOnVerticalDrag: false,
        tapToClose: true,
        clickToCloseNonZoomable: false,
        escKey: true,
        barsSize: {top: 60, bottom: 'auto'},
        closeEl: true,
        zoomEl: false,
        shareEl: false,
        arrowEl: true,
        preloaderEl: true,
        loop: true,


        getImageURLForShare: function (shareButtonData) {
            // `shareButtonData` - object from shareButtons array
            //
            // `pswp` is the gallery instance object,
            // you should define it by yourself
            //
            var size = 'thumb';
            if (useLargeImages) {
                size = 'fullsize';
            }
            return (gallery.currItem.originalImage.src || '') + '&index=' + (gallery.currItem.index || '') + '&size=' + size;
        },

    };

    // Initializes and opens PhotoSwipe

    mc.on("doubletap", function (ev) {
        stop_animation();
        open_photoswipe();
    });
    mc.on("tap", function (ev) {
        stop_animation();
    });
    var pinchstart = false;
    mc.on("pinchstart", function (ev) {
        stop_animation();
        pinchstart =true;
    });
    mc.on("pinchstart", function (ev) {
        if(pinchstart)
        {
            stop_animation();
            pinchstart = false;
            open_photoswipe();
        }

    });
    mc.on("swipe",function(ev) {
        //alert('swiped!');
        stop_animation();
        if(ev.direction== Hammer.DIRECTION_LEFT)
        {
            next_pic();
        }
        else if (ev.direction== Hammer.DIRECTION_RIGHT)
        {
            prev_pic();
        }

    });
    for (i = 0; i < full_src.length; i++) {
        downloadingImage[i].loaded_src = loader_src;
        downloadingImage[i].index = i;
        downloadingImage[i].onload = function () {
            loaded_fullsize(this.index);
        };
        downloadingThumbImage[i].index = i;
        downloadingThumbImage[i].onload = function () {

            loaded_thumb(this.index);
        };
    }
    for (i = 0; i < thumb_src.length; i++) {
        downloadingThumbImage[i].src = thumb_src[i];

    }
    for (i = 0; i < full_src.length; i++) {
        downloadingImage[i].src = full_src[i];

    }
}
function next_pic()
{
    current_img_index = current_img_index +1;
    if(current_img_index == number_of_photos)
    {
        current_img_index = 0;
    }
    if(current_img_index == -1)
    {
        current_img_index = number_of_photos -1;
    }
    image.src = downloadingImage[current_img_index].loaded_src;
}
function prev_pic()
{
    current_img_index = current_img_index -1;
    if(current_img_index == number_of_photos)
    {
        current_img_index = 0;
    }
    if(current_img_index == -1)
    {
        current_img_index = number_of_photos -1;
    }
    image.src = downloadingImage[current_img_index].loaded_src;
}
function create_options()
{
    options = {
        pinchToClose: true,
        closeOnScroll: false,
        closeOnVerticalDrag: false,
        tapToClose: true,
        clickToCloseNonZoomable: false,
        escKey: true,
        barsSize: {top: 60, bottom: 'auto'},
        closeEl: true,
        zoomEl: false,
        shareEl: false,
        arrowEl: true,
        preloaderEl: true,
        index: parseInt( current_img_index , 10),
        getImageURLForShare: function (shareButtonData) {
            // `shareButtonData` - object from shareButtons array
            //
            // `pswp` is the gallery instance object,
            // you should define it by yourself
            //
            var size = 'thumb';
            if (useLargeImages) {
                size = 'fullsize';
            }
            return (gallery.currItem.originalImage.src || '') + '&index=' + (gallery.currItem.index || '') + '&size=' + size;
        },

    };
    return options;
}
function open_photoswipe() {
    var my_options = create_options();
    gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, my_options);
    gallery.listen('close', photoswipe_closed);
    gallery.listen('initialZoomInEnd', do_it);
    gallery.init();
    photoswipe_is_open = true;
    //update_photoswipe();

}
function do_it () {
    window.setTimeout(now, 200);
}
function now()
{
    gallery.goTo(current_img_index)
}
function something_loaded(){
    if(show_animation) {
        gestures_animation.style.display = 'block';
    }
}
function stop_animation() {
    show_animation = false;
    gestures_animation.style.display = 'none';
}
function loaded_fullsize(i){

    something_loaded()
    new_item = {};
    new_item.w = full_size[i][0];
    new_item.h = full_size[i][1];
    new_item.src = downloadingImage[i].src;
    items.splice(i,1,new_item);
    update_photoswipe();
    downloadingImage[i].loaded_src = downloadingImage[i].src;
    if(i==current_img_index)
    {
        image.src = downloadingImage[i].loaded_src;
    }
}
function loaded_thumb(i){
    if(downloadingImage[i].loaded_src==loader_src)
    {
        new_item = {};
        new_item.w = full_size[i][0];
        new_item.h = full_size[i][1];
        new_item.src = downloadingThumbImage[i].src;
        items.splice(i,1,new_item);
        update_photoswipe();
        downloadingImage[i].loaded_src = downloadingThumbImage[i].src;
        if(i==current_img_index)
        {
            image.src = downloadingThumbImage[i].src;
        }
    }
}
function photoswipe_closed()
{
    photoswipe_is_open = false;
    current_img_index = gallery.getCurrentIndex();
    image.src = downloadingImage[current_img_index].loaded_src;
    //window.alert("closed");
}
function update_photoswipe()
{
    if (photoswipe_is_open){
        // sets a flag that slides should be updated
        gallery.invalidateCurrItems();
        // updates the content of slides
        gallery.updateSize(true);
    }
}
function copy_items()
{
    var cloned_items = [];
    for (i = 0; i < items.length; i++) {
        cloned_items[i] = {};
        for (var key in items[i]) {
            cloned_items[i][key] =  items[i][key];
        }

    }
    return cloned_items;
}