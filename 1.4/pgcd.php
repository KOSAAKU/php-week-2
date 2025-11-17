<?php

function pgcd($nb1, $nb2)
{
    while ($nb2 != 0) 
    {
        $res = $nb1 % $nb2;
        $nb1 = $nb2;
        $nb2 = $res;
    }
    return $nb1;
}

$nbA = 24;
$nbB = 36;
echo "Le PGCD de " . $nbA . " et " . $nbB . " est : " . pgcd($nbA, $nbB);