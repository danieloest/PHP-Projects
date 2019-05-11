<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="zmart.css">
    <title>ZMart</title>
</head>
<body>
    <?php include 'header.php';?>
    <?php  
    // If there is nothing in the cart
    var_dump($_SESSION);
    if (empty($_SESSION)) {
        echo "<h2>You have not added anything to your cart.";
    }
    // If we have stuff in our cart
    else {
        
        echo "<table>
        <tr>
        <th>Item</th>
        <th>Quantity</th>
        <th>Price</th>
        </tr>";
        // foreach ($product as $_SESSION) {
        //     echo "<tr><td>" . $product->name . "</td><td>" . $product->quantity . "</td><td>" . $product->price . "</td></tr>";
        // }
        foreach($_SESSION AS $key => $value) {
            echo "Item: $key -> $value <br>";  
          }
        echo "</table>";
    }
    ?>
</body>
</html>