<? function fm_content_section(
    $columns = array(),
    $full_width_content = false,
    $center_columns_horizontally = false,
    $center_columns_vertically = false
) {
    
    if ( !ga($columns) ) return;
    
    $expanded = $full_width_content ? "expanded" : null;
    $center_columns_horizontally = $center_columns_horizontally ? "justify_center" : null;
    $center_columns_vertically = $center_columns_vertically ? "align_center" : null;

    echo "<div class='row $expanded $center_columns_horizontally $center_columns_vertically'>";
        foreach ( $columns as $column )
        {
            $layout = $column['acf_fc_layout'] ?? null;
            
            if ( $layout == "column" )
            {
                get_template_part( 
                    slug: '/fm_page_builder/content_section/column/column',
                    args: $column
                );
            }
        }
    echo "</div>";
        
    return array(
        // "background_color" => "",
        // "id" => "",
        "classes" => array(
            "wave_bottom",
            "wave_top"
        )
    );

}