<?php
session_start();
include_once '../outsourced-php-code/userdata.php';

try {
    $db = new PDO($dsn, $dbuser, $dbpass, $option);
    $stmt = $db->prepare("SELECT * FROM `notifications_posts_view` WHERE `notified_user` = :user");

    if ($stmt->execute(array(":user"=> $_SESSION["user-id"]))){
        while ($row = $stmt->fetch()){
            echo '<li>';
            echo '<p>';
            echo 'Neuer Beitrag von '.$row["user_name"];
            if ($row["topic_name"] !== null){
                echo ' in '.$row["topic_name"];
            }
            echo '</p>';
            echo '</li>';
        }
    } else {
        echo 'Datenbank Fehler';
        echo 'bitte wende dich an den Administrator';
    }
} catch (PDOException $e) {
    echo "Error!: Bitten wenden Sie sich an den Administrator...<br/>";
    die();
}