<!--
WICHTIG!
Der Seite müssen immer die IDs für die Topic oder den Nutzer und der Type (1=Topic 2=User) übergeben werden!
-->
<?php
session_start();
include_once '../outsourced-php-code/userdata.php';

if (isset ($_SESSION["signed-in"])) {
    //Überprüfen ob alle Wete die für die Seite notwending sind übergben wurden
    if (isset ($_GET["followed_id"]) & isset ($_GET["type"]) & isset($_GET["follow_id"])) {
        //Alle übergebenen Werte aus der URL in eine Variable schreiben
        $followed_id = $_GET["followed_id"];
        $type = $_GET["type"];
        $follow_id = $_GET["follow_id"];

        //Eintrag für den Follow aus der Datenbank löschen
        //Es muss zwischen User und Topic unterschieden werden
        if ($type == '1'){
            //Nutzer will einer Topic entfolgen - Daten aus 'user_follow_topic' entfernen
            try {
                $db = new PDO($dsn, $dbuser, $dbpass, $option);
                $stmt = $db->prepare("DELETE FROM `user_follow_topic` WHERE `topic_follow_id` = :id");
                $stmt->execute(array(":id"=>$follow_id));
                header('Location:../topic-profile.php?id='.$followed_id);
            } catch (PDOException $e) {
                echo "Error!: Bitten wenden Sie sich an den Administrator...<br/>";
                die();
            }

        }
        if ($type == '2'){
            //Nutzer will einem anderen Nutzer entfolgen - Daten aus 'user_follow_user' entfernen
            try {
                $db = new PDO($dsn, $dbuser, $dbpass, $option);
                $stmt = $db->prepare("DELETE FROM `user_follow_user` WHERE `user_follow_id` = :id");
                $stmt->execute(array(":id"=>$follow_id));
                header('Location:../profile-foreign.php?id='.$followed_id);
            } catch (PDOException $e) {
                echo "Error!: Bitten wenden Sie sich an den Administrator...<br/>";
                die();
            }
        }

    } else {
        echo '<p>ups da ist etwas schief gelaufen.<br>';
        echo '<a href="../feed.php">Feed</a>';
    }


}