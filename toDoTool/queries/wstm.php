<?php

require 'db.php';

$sql = "Select orders.customerNumber, sum(quantityOrdered * priceEach) as totalPriceOrdered 
from orderdetails 
inner join orders on orders.orderNumber = orderdetails.orderNumber 
group by orders.customerNumber order by totalPriceOrdered desc";

foreach ($dbh->query($sql) as $row) {

    echo $row['customerNumber'] . "\t";
    echo $row['totalPriceOrdered'] . "\n";
}

?>