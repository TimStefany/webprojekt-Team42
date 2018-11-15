<!--
WICHTIG!
Der Seite müssen immer die IDs für die Topic oder den Nutzer und der Type (1=Topic 2=User) übergeben werden!
-->
<?php
session_start();
include_once 'userdata.php';

if (isset ($_SESSION["signed-in"])) {
    //Überprüfen ob alle Wete die für die Seite notwending sind übergben wurden
    if (isset ($_GET["followed_id"]) & isset ($_GET["type"])) {
        //Id des Nutzers oder der Topic der gefolgt werden soll aus der URL in eine Variable schreiben
        $followed_id = $_GET["followed_id"];
        $type = $_GET["type"];

        //Eintrag für den Follow in die Datenbank schreiben
        //Es muss zwischen User und Topic unterschieden werden
        if ($type == '1'){
            //Nutzer will einer Topic folgen - Daten in 'user_follow_topic' schreiben
            try {
                $db = new PDO($dsn, $dbuser, $dbpass, $option);
                $stmt = $db->prepare("INSERT INTO `user_follow_topic`(`following_user_id_topic`, `followed_topic_id`) VALUES (:user,:topic)");
                $stmt->execute(array(":user"=>$_SESSION["user-id"],":topic"=>$followed_id));
            } catch (PDOException $e) {
                echo "Error!: Bitten wenden Sie sich an den Administrator...<br/>";
                die();
            }

        }
        if ($type == '2'){
            //Nutzer will einem anderen Nutzer folgen - Daten in 'user_follow_user' schreiben
            try {
                $db = new PDO($dsn, $dbuser, $dbpass, $option);
                $stmt = $db->prepare("INSERT INTO `user_follow_user`(`following_user_id_user`, `followed_user_id`) VALUES (:following , :followed)");
                $stmt->execute(array("following"=>$_SESSION["user-id"],":followed"=>$followed_id));
            } catch (PDOException $e) {
                echo "Error!: Bitten wenden Sie sich an den Administrator...<br/>";
                die();
            }
        }

    } else {
        echo '<p>ups da ist etwas schief gelaufen.<br>';
        echo '<a href="feed.php">Feed</a>';
    }


}