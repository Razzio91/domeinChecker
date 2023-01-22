<?php
try {
    $user = 'phpmyadmin';
    $dbh = new PDO('mysql:host=localhost;dbname=toDo', $user);
//    foreach($dbh->query('SELECT * from doIt') as $row) {
//        print 'connection succesfull';
//    }
//    $dbh = null;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}?>