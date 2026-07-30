<?php

//task01

$Principal = 10;
$Rate = 0.12;
$Time = 3;
$Simple_Interest = ($Principal * $Rate * $Time)/100;
echo "Simple Interest = $Simple_Interest<br><br>";

//task02
$Number = 11;
for($i=2; $i<$Number; $i++){
    if($Number%$i==0){
        echo "The number is not Prime<br>";
        break;
    }
    else{
        echo "The number is Prime<br><br>";
    }
}


//task03
$Number = 5;
for($i=1; $i<=$Number; $i++){
    $factorial *=$i;
}
echo "Result is = $factorial<br><br>";


//task04
$numbers = [10, 20, 30, 40, 50];
$sum = 0;
$count = count($numbers);
for ($i = 0; $i < $count; $i++) {
    $sum += $numbers[$i];
}
$average = $sum/$count;

echo "Sum = $sum<br><br>";
echo "Average = $average<br><br>";



//task05
$rows = 4;
for ($i = 1; $i <= $rows; $i++) {
    for ($j = 1; $j <= $i; $j++) {
        echo "$i ";
    }
    echo "\n";
}


?>