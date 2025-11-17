<?php

function    calcMoy($tab)
{
    $somme = 0;
    $nb = count($tab);
    if ($nb == 0)
        return 0;
    $i = 0;
    while($i < $nb)
    {
        $somme = $somme + $tab[$i];
        $i++;
    }
    return $somme / $nb;
}

echo calcMoy([18, 19, 20]);