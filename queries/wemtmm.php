<?php

require 'db.php';

$sql = "Select employeeNumber, sum(payments.amount) as totalPriceSold 
        from employees 
        inner join customers on employees.employeeNumber = customers.salesRepEmployeeNumber 
        inner join payments on customers.customerNumber = payments.customerNumber 
        group by employeeNumber order by max(amount) desc";

foreach ($dbh->query($sql) as $row) {

    echo $row['employeeNumber'] . "\t";
    echo $row['totalPriceSold'] . "\n";
}

?>