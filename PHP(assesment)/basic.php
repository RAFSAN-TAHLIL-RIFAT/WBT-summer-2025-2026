<?php

//task01

$length = 12;
$width  = 7;

$area      = $length * $width;
$perimeter = 2 * ($length + $width);

echo "1. Rectangle - Area & Perimeter<br>";
echo "Length = $length, Width = $width<br>";
echo "Area = $area<br>";
echo "Perimeter = $perimeter<br><br>";



// task02

$amount = 2500;
$vat    = $amount * (15 / 100);
$total  = $amount + $vat;

echo "2. VAT Calculation<br>";
echo "Amount = $amount<br>";
echo "VAT (15%) = $vat<br>";
echo "Total = $total<br><br>";



// task03

$number = 17;

echo "3. Odd or Even<br>";
if ($number % 2 == 0) {
    echo "$number is Even<br><br>";
} else {
    echo "$number is Odd<br><br>";
}



// task04

$num1 = 45;
$num2 = 82;
$num3 = 67;

echo "4. Largest of Three Numbers<br>";
echo "Numbers: $num1, $num2, $num3<br>";

if ($num1 >= $num2 && $num1 >= $num3) {
    $largest = $num1;
} elseif ($num2 >= $num1 && $num2 >= $num3) {
    $largest = $num2;
} else {
    $largest = $num3;
}
echo "Largest = $largest<br><br>";



// task05

echo "5. Odd Numbers between 10 and 100<br>";
for ($i = 10; $i <= 100; $i++) {
    if ($i % 2 != 0) {
        echo "$i ";
    }
}
echo "<br><br>";



// task06

$numbers = [23, 45, 12, 67, 34, 89, 2, 9, 56];
$search  = 67;
$found   = false;

echo "6. Search an Element in an Array<br>";
echo "Array: " . implode(", ", $numbers) . "<br>";
echo "Searching for: $search<br>";

for ($i = 0; $i < count($numbers); $i++) {
    if ($numbers[$i] == $search) {
        $found = true;
        echo "Element found at index $i.<br><br>";
        break;
    }
}
if (!$found) {
    echo "Element not found in the array.<br><br>";
}


// task07
echo "7. Shapes<br>";

// --- Star triangle ---
echo "Star Triangle:<br>";
for ($i = 1; $i <= 3; $i++) {
    for ($j = 1; $j <= $i; $j++) {
        echo "* ";
    }
    echo "<br>";
}
echo "<br>";

// --- Number triangle ---
echo "Number Triangle:<br>";
for ($i = 3; $i >= 1; $i--) {
    for ($j = 1; $j <= $i; $j++) {
        echo "$j ";
    }
    echo "<br>";
}
echo "<br>";

// --- Letter triangle ---
echo "Letter Triangle:<br>";
$letter = 'A';
for ($i = 1; $i <= 3; $i++) {
    for ($j = 1; $j <= $i; $j++) {
        echo "$letter ";
        $letter++;
    }
    echo "<br>";
}
?>
