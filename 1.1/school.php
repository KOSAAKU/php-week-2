<?php
function school($age) 
{
    if ($age <= 3)
        return "Crèche"; 
    else if ($age <= 6)
        return ("maternelle");
    else if ($age <= 11)
        return ("primaire");
    else if ($age <= 16)
        return ("college");
    else if ($age <= 18)
        return ("lycée");
    else
        return ("rien");
}

echo school(17);
