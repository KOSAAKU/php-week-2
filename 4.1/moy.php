<?php

function calcMoy(array $notes)
{
    $nb = count($notes);
    if ($nb === 0) {
        return 0; 
    }

    $somme = 0;
    foreach ($notes as $note) {
        $somme += $note; 
    }

    return $somme / $nb;
}

$eleves = [
    ["nom" => "Alice",  "notes" => [15, 14, 16]],
    ["nom" => "Bob",    "notes" => [12, 10, 11]],
    ["nom" => "Claire", "notes" => [18, 17, 16]],
];
foreach ($eleves as $eleve) 
{
    $moyenne = calcMoy($eleve["notes"]);
    echo "La moyenne de " . $eleve["nom"] . " est : " . $moyenne . "\n";
}
