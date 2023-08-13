<?php 

function sanitize_custom_floatval($value) {
    return floatval($value);
}
function remove_non_numeric($string) {
    $string = preg_replace('/[+\-\/\(\)\s]/', '', $string);
    $string = preg_replace('/[^0-9]/', '', $string);
    return $string;
}

?>

