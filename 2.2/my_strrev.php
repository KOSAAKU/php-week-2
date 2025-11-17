<?php

function my_strrev($text)
{
    $rev = "";
    $len = strlen($text);
    $i = $len - 1;

    while ($i >= 0)
    {
        $rev .= $text[$i];
        $i--;
    }
    return $rev;
}

echo my_strrev("Hello World!");