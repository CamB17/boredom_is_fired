<? function fm_search_form() {
    echo "<div class='fm_search_form'>";
        echo "<form role='search' method='get' action='/'>";
            echo "<input type='text' placeholder='Enter Search...' name='s' id='s'>";
            echo "<label for='s' style='display:none;'>Search</label>";
            echo "<button id='search_toggle' tabindex='0'>";
                icon_search();
                echo "Search";
            echo "</button>";
        echo "</form>";
    echo " </div>";
}