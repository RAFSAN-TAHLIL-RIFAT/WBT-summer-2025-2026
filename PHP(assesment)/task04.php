<?php
$num1 = 15;
$num2 = 25;
$num3 = 10;

if ($num1 >= $num2 && $num1 >= $num3) {
    echo "Largest: " . $num1;
} else if ($num2 >= $num1 && $num2 >= $num3) {
    echo "Largest: " . $num2;
} else {
    echo "Largest: " . $num3;
}
?>