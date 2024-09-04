<?

$buttons = $args['buttons'] ?? null;

if ( ga($buttons) )
{
    echo "<p class='button_hold'>";
        foreach ( $buttons as $button ) {
            fm_button(...$button['button']);
        }
    echo "</p>";
}

