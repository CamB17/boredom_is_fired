<? function fm_mobile_menu_container()
{
    echo "<div class='fm_mobile_menu_container bg_dark bg_black' style='height:0;opacity:0;'>";
        // echo "<button id='mobile_menu_close'>Close Mobile Menu</button>";
        echo "<div id='mobile_menu_wrapper'>";
            echo "<div class='mobile_menu_attach_wrapper'>";
                fm_menu(
                    menu_id: 2,
                    html_id: "mobile_menu",
                    levels: 3,
                    mode: "mobile" 
                );
            echo "</div>";
        echo "</div>";
    echo "</div>";

}