<?php 



$headline = $args['headline'] ?? null;
$headline_level = $args['headline_level'] ?? null;
$headline_display_as = $args['headline_display_as'] ? "class='{$args['headline_display_as']}'" : null;


echo $headline ? "<$headline_level $headline_display_as>$headline</$headline_level>" : null;
