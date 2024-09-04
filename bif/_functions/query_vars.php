<?
function bif_custom_query_vars( $vars ){
  $vars[] = "wp";
  return $vars;
}
add_filter( 'query_vars', 'bif_custom_query_vars');