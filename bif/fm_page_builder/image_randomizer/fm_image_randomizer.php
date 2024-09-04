<? function fm_image_randomizer(
    $images = null
)
{
    if ( !ga($images) ) return;
    
    $count = count($images);
    
    $rand = rand(0, $count - 1);
    
    $image = $images[$rand]['image'];
    
    $image_url = $image['url'] ?? null;
    $image_alt = $image['alt'] ?? null;
    
    echo $image_url ? "<img src='$image_url' alt='$image_alt'>" : null;
    
    
    return array(
        // "background_color" => "",
        // "id" => "",
        // "classes" => array(
        //     "",
        // )
    );
}