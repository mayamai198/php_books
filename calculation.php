<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
$x = 9;
$y = 2;
$z = $x + $y;
echo $z;

echo "<br>";
$k = 5;
$z = $z - $k;
echo $z;

echo "<br>";
$cup_of_milk = 750;
$your_money = 1200;
$change = $your_money - $cup_of_milk;
echo "The remaining change is {$change}";
echo "<br>";
$mom_gift = 500;
$total_amount = $change + $mom_gift;
echo "The total amount will be {$total_amount}";
echo "<br>";
$no_of_books = 5;
$cost_price = 2.0;
$book_to_buy = 3;
$pay_price = $book_to_buy * $cost_price;
echo "It will be {$pay_price}";
echo "<br>";
$what_I_have = 10;
$cost_of_one = 2.50;
$total = $what_I_have / $cost_of_one;
echo "I can buy {$total} potatoes"; 
?>
    
</body>
</html>