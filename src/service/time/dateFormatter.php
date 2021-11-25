<?php
$format = "Y-m-d H:i:s";

function stringToDate($string) {
    global $format;
    return DateTime::createFromFormat($format, $string);
}
