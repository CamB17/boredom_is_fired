<? 
function fm_video_embed(
    $image_url,
    $image_alt,
    $embed_code
)
{

    $id = "video_embed_" . rand(100000,1000000);
    
    
    echo "<div class='fm_video_embed'>";
        echo "<img src='$image_url' alt='$image_alt'>";
        echo "<div class='play_icon_hold magnific_popup' href='#$id' tabindex='0'>";
            icon_play();
        echo "</div>";
    echo "</div>";
    echo "<div id='$id' class='white-popup mfp-hide'>";
        echo $embed_code;
    echo "</div>";
    

}