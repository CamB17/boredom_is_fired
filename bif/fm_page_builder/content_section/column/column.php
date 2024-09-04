<?
$width = $args['width'] ?? null;
$half_width_on_mobile = $args['half_width_on_mobile'] ? "half_width_on_mobile" : null;
$column_content = $args['column_content'] ?? null;

echo "<div class='column_content column small-12 $width $half_width_on_mobile'>";

    if ( ga($column_content) )
    {
        foreach ( $column_content as $content )
        {
            $layout = $content['acf_fc_layout'] ?? null;
            if ( $layout )
            {
                $test = get_template_part(
                    slug: "/fm_page_builder/content_section/column/column_content/$layout",
                    args: $content
                );

            }
        }
    }
echo "</div>";

