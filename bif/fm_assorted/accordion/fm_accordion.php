<? function fm_accordion(
    $rows = null
) {
    if ( !ga($rows) ) return;
    
    echo "<div class='fm_accordion'>";
        foreach ( $rows as $row ) {
            $title = $row['title'] ?? null;
            $content = $row['content'] ?? null;
            
            echo "<div class='accordion'>";
            
                echo "<button class='accordion__intro'>";
                    echo "<h3>$title</h3>";
                    ?>
                    <svg width="7px" height="11px" viewBox="0 0 7 11" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <title>Arrow</title>
                        <g id="Symbols" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g id="Global/Buttons/Primary/Text-Link/Dark" transform="translate(-83.000000, -5.000000)" stroke="currentColor" stroke-width="2">
                                <polyline id="Path" transform="translate(84.118813, 10.118813) rotate(45.000000) translate(-84.118813, -10.118813) " points="81 7.23762605 87.237626 7 87 13.237626"></polyline>
                            </g>
                        </g>
                    </svg>
                    
                    <?
                echo "</button>";
                echo "<div class='accordion__content'>";
                    echo $content;
                echo "</div>";
            echo "</div>";
                
        }
    echo "</div>";
	
}
?>
