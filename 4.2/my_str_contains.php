<?php

function my_str_contains($str, $search)
{
    $len_str = strlen($str);
    $len_search = strlen($search);

    if ($len_search == 0)
        return true;
    if ($len_search > $len_str)
        return false;
    $i = 0;
    while ($i <= $len_str - $len_search)
    {
        $j = 0;
        while ($j < $len_search && $str[$i + $j] == $search[$j])
        {
            $j++;
        }
        if ($j == $len_search)
            return true;
        $i++;
    }
    return false;
}

echo my_str_contains("Hello World!", "Wor");