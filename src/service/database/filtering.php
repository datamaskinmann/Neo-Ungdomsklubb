<?php
function filterResultByAttributeValue($result, $attribute, $value) {
    $ret = [];

    $index = 0;
    for($i = 0; $i < count($result); $i++) {
        if($result[$i][$attribute] != $value) continue;
        $ret[$index] = $result[$i];
        $index++;
    }
    return $ret;
}

function filterResultByAttributeUnique($result, $attribute) {
    $ret = [];

    for($i = 0; $i < count($result); $i++) {
        if(!in_array($result[$i][$attribute], $ret)) array_push($ret, $result[$i][$attribute]);
    }

    return $ret;
}
