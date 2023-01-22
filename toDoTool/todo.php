<?php
require 'db.php';

array_shift($argv);

$command = $argv[0];
$description = $argv[1] ?? null;
$deadline = $argv[2] ?? null;
$status = $argv[3] ?? null;


switch ($command) {
    case 'display':
        $sql = 'SELECT * FROM doIt WHERE status = "inProgress" ORDER BY deadline asc';
        foreach ($dbh->query($sql) as $row) {
            echo $row['id'] . "\t";
            echo $row['shortScription'] . "\t";
            echo $row['deadline'] . "\t";
            echo $row['status'] . "\n";

        }
        break;
    case 'add-item':

        $sql = $dbh->prepare("INSERT INTO doIt(shortScription, deadline, status)values(?,?,?)");

        if ($status) {
            $sql->execute(array($description, $deadline, $status));
        } else {
            $sql->execute(array($description, $deadline, 'inProgress'));
        }


        echo "Record saved To toDoList" . "\n";
        break;

    case
    'update-item':
        $input_id = $argv[1] ?? null;
        $sqlDbId = $dbh->prepare('SELECT id FROM doIt');
        $sqlDbId->execute();
        $idFromDb = $sqlDbId->fetchAll();

        if (array_key_exists($input_id, $idFromDb)) {
            if ($status) {
                $sql = $dbh->query("UPDATE doIt SET deadline='$deadline', status='$status' WHERE id = '$input_id'");
            } else {
                $sql = $dbh->query("UPDATE doIt SET deadline='$deadline' WHERE id = '$input_id'");
            }

            $sql->execute();
            echo "Deadline of record updated" . "\n";
        } else {
            echo "No records found" . "\n";
        }
        break;
    case 'remove':
        $id = $argv[1] ?? null;
        $sql = $dbh->query("DELETE FROM doIt WHERE id = '$id'");
        $sql->execute();
        echo "Item removed" . "\n";
        break;

    default:
        echo "Use one of the following commands: |display|add-item|update-item|remove|" . "\n";
}

?>
