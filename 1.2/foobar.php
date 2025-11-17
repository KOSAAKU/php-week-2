<?php
function foobar($nb = 1) 
{
    if($nb > 100) return;

    if ($nb % 3 == 0 && $nb % 5 == 0)
        echo "foobar<br>";
    else if ($nb % 3 == 0)
        echo "foo<br>";
    else if ($nb % 5 == 0)
        echo "bar<br>";
    else
        echo $nb . "<br>";

    foobar($nb + 1);
}

foobar();
?>
