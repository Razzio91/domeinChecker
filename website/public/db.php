<?php
include "key.php";
try {

    $dbh = new PDO('mysql:host=localhost;dbname=domainCheckResults', $user, $password);

} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}?>
