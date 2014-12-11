<?php

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function titleCase($str) {
    $words = explode(' ', $str);
    $nocaps = array("the","in","of","and");
    foreach ($words as $i => $w) {
        if (!in_array($w, $nocaps)) {
            $w = ucfirst($w);
        }
        $words[$i] = $w;
    }
    $str = implode(' ', $words);
    return ucfirst($str);
}

?>
