<?php
session_start();
include_once 'userdata.php';
try {
    $db = new PDO($dsn, $dbuser, $dbpass, $option);

    $filenamenew = $_SESSION["imgdatabasename"];
    $user = $_SESSION["user-id"];

    $query = $db->prepare("INSERT INTO `pictures` (`picture_path`) VALUES (:imgpath);");
    $query->execute(array(":imgpath" => $filenamenew));

    $stmt = $db->prepare("SELECT `picture_id` FROM `pictures` WHERE `picture_path`=:imgpath");

    //Das SQL Statement wählt die Nutzernamen und Topicnamen denen gefolgt wird und sortiert sie nach 'priority'

    if ($stmt->execute(array(":imgpath" => $filenamenew))) {
        while ($row = $stmt->fetch()) {
            $picture_id = $row ["picture_id"];
            echo "$picture_id" ;
            //fügt die id von dem Nutzer oder der Topic der gefolgt wird, die topics oder Nutzernamen dem
            // gefolgt wird und den type jeder Zeile hinten an das Array an.
        }
    } else {
        echo 'Datenbank Fehler';
        echo 'bitte wende dich an den Administrator';
    }
    $stmt = 0;
} catch (PDOException $e) {
    echo "Error!: Bitten wenden Sie sich an den Administrator...<br/>";
    die();
}


$query1 = $db->prepare("UPDATE `registered_users` SET `picture_id`=:imgid WHERE `user_id` =:user");
$query1->execute(array(":imgid" => $picture_id, ':user' => $user));
