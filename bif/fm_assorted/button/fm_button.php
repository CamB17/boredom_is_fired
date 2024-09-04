<?
function fm_button(
    $text = null, 
    $style = "primary", 
    $new_tab = false, 
    $link_type = "url", // "url" or "wordpress"
    $url = null,
    $wordpress_content = null, // post id
    $css_classes = null,
    $aria_label = null
) {
    
    if ( !$text ) return;
    
    $url = $link_type == "wordpress" ? get_the_permalink($wordpress_content) : $url;
    $target_string = $new_tab ? "target='_blank'" : "";
    $aria_label = $aria_label ? "aria-label='$aria_label'" : null;
    
    echo "<a href='$url' class='fm_button $style $css_classes' $target_string $aria_label>";
        echo $text;
        
        //printing in page to take advantage of currentColor
        if ( $style == "text" ) 
        {
            ?>
            <svg width="7px" height="11px" viewBox="0 0 7 11" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <title>Path</title>
                <g id="Symbols" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g id="Global/Buttons/Primary/Text-Link/Dark" transform="translate(-83.000000, -5.000000)" stroke="currentColor" stroke-width="2">
                        <polyline id="Path" transform="translate(84.118813, 10.118813) rotate(45.000000) translate(-84.118813, -10.118813) " points="81 7.23762605 87.237626 7 87 13.237626"></polyline>
                    </g>
                </g>
            </svg>
            <?
        }
    echo "</a>";
}