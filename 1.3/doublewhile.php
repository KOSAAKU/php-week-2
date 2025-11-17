<?php
function pattern($n) 
{
    $i = 1;
    while ($i <= $n) 
    {
        $j = 1;
        while ($j <= $i) 
        {
            echo $i;
            $j++;
        }
        echo "<br>";
        $i++;
    }
}

pattern(6);
