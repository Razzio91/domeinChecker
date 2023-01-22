<?php

require 'db.php';

$sql = "Select offices.officeCode, offices.city, offices.country, sum(payments.amount) as totalPriceSold 
        from offices 
        inner join employees on offices.officeCode = employees.officeCode 
        inner join customers on employees.employeeNumber = customers.salesRepEmployeeNumber 
        inner join payments on customers.customerNumber = payments.customerNumber 
        group by offices.officeCode";

foreach ($dbh->query($sql) as $row) {

    echo $row['officeCode'] . "\t";
    echo $row['city'] . "\t";
    echo $row['country'] . "\t";
    echo $row['totalPriceSold'] . "\n";

}

?>