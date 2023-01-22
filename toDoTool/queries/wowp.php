<?php
require 'db.php';


$sql = "SELECT customers.customerNumber, orderdetails.productCode, orderdetails.quantityOrdered AS amountOfOrders FROM customers 
INNER JOIN orders ON customers.customerNumber = orders.customerNumber 
INNER JOIN orderdetails ON orders.orderNumber = orderdetails.orderNumber ORDER BY customers.customerNumber";

foreach ($dbh->query($sql) as $row) {
    echo $row['customerNumber'] . "\t";
    echo $row['productCode'] . "\t";
    echo $row['amountOfOrders'] . "\n";
}

?>