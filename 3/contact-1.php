<?php
error_reporting(-1);

function add_contact($name)
{
    $file = fopen("contact.txt", "a+");
    if (!$file)
    {
        echo "Erreur";
        return false;
    }
    fwrite($file, $name . "\n");
    fclose($file);

    return true;
}

add_contact("Alice Dupont");
add_contact("John Doe");
add_contact("Jean Martin");

echo "ajouté !";