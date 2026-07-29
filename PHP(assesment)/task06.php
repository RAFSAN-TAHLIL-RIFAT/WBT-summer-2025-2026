<?php
$numbers = array(10, 20, 30, 40, 50);
$search = 30;

for ($i = 0; $i < count($numbers); $i++) {
    if ($numbers[$i] == $search)
    {
        echo "$search is found in the array.";
        break;
    }
    else 
    {
    echo "$search is not found.";
    }
}
?>