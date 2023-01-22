<?php
require'db.php';

$sql = " select employees.employeeNumber, sum(quantityOrdered) as amountOfOrders from customers 
     inner join employees on customers.salesRepEmployeeNumber = employees.employeeNumber 
     inner join orders on customers.customerNumber = orders.customerNumber
     inner join orderdetails on orders.orderNumber = orderdetails.orderNumber 
     group by employeeNumber order by amountOfOrders desc";


if($sql->rowCount() > 0)
{
    $table = '
   <table border=1>
                    <tr>
                         <th>EmployeeNumber</th>
                         <th>AmountOfOrders</th>
                      

                    </tr>
  ';
    while($row = $sql->fetchAll())
    {
        $table .= '
    <tr>
                        <td>'.$row["employeeNumber"].'</td>
                         <td>'.$row["amountOfOrders"].'</td>
                     


                    </tr>
   ';
    }
    $table .= '</table>';
    echo $table;
}


foreach ($dbh->query($sql) as $row) {

    echo $row['employeeNumber'] . "\t";
    echo $row['amountOfOrders'] . "\n";
}

?>