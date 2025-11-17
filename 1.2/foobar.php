<?php

function foobar($nb) 
{
    if ($nb % 3 == 0 && $nb % 5 == 0)
        return "foobar"; 
    else if ($nb % 3 == 0)
        return "foo";
    else if ($nb % 5 == 0)
        return "bar";
    else
        return $nb;
}

echo foobar(14);