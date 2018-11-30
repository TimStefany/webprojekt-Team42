<?php
session_start();
include_once '../outsourced-php-code/userdata.php';

try {
    $db = new PDO($dsn, $dbuser, $dbpass, $option);
    $stmt = $db->prepare("SELECT * FROM `notifications` WHERE `notified_user` = :user");

    if ($stmt->execute(array(":user"=> $_SESSION["user-id"]))){
        while ($row = $stmt->fetch()){
            echo '<li>'.$row ["notification_id"].'</li>';
        }
    } else {
        echo 'Datenbank Fehler';
        echo 'bitte wende dich an den Administrator';
    }
} catch (PDOException $e) {
    echo "Error!: Bitten wenden Sie sich an den Administrator...<br/>";
    die();
}