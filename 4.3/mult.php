<?php
function multTable()
{
    $lignes = file('table.txt');
    $entete = explode(' ', trim($lignes[0]));

    $i = 1;
    while ($i < count($lignes)) 
    {
        $valeurs = explode(' ', trim($lignes[$i]));
        $numLigne = $valeurs[0];

        $j = 1;
        while ($j < count($valeurs)) 
        {
            $numCol = $entete[$j];
            $valeur1 = $valeurs[$j];
            $valeur2 = $numLigne * $numCol;

            if ($valeur1 != $valeur2) {
                echo $numLigne . 'x' . $numCol . ', ';
            }

            $j++;
        }
        $i++;
    }
}
multTable();
echo 'Fin';
?>