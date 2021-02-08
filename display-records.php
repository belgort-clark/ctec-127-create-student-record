<?php
require "inc/db_connect.inc.php";
require "inc/header.inc.html";
?>

<div>
    <a href="create-record.php">Create New Record</a>
</div>

<?php

if (isset($_GET["action"])) {
    if ($_GET["action"] == "delete") {
        # now can delete a record
        $sql = "DELETE FROM STUDENT_V2 WHERE id=:id LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->execute(["id" => $_GET["id"]]);
        $result = $stmt->fetch();
        if ($stmt->rowCount() == 0) {
            echo "OH CRAP - I COULD NOT DELETE THAT RECORD FOR YOU";
        } else {
            echo "I deleted the record for you.";
        }
    } elseif ($_GET["action"] == "add") {
        echo "I have successfully added that new record for you";
    }
}

$sql = "SELECT * FROM student_v2";
$stmt = $db->prepare($sql);
$stmt->execute();
$records = $stmt->fetchAll();

if ($stmt->rowCount() != 0) {
    echo "<table class='table table-dark'>";
    echo "<tr><th>Actions</th><th>First Name</th><th>Last Name</th><th>Email</th><tr>";
    foreach ($records as $record) {
        echo "<tr><td><a href='display-records.php?action=delete&id=$record->id'>Delete</a></td><td>$record->first_name</td><td>$record->last_name</td><td>$record->email</td></tr>";
    }
    echo "</table>";
} else {
    echo "No data to show you";
}
?>


<? require "inc/footer.inc.html";