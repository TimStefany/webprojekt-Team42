<?php
include_once 'userdata.php';
//Auslesen der Themen und Nutzer denen ein Nutzer folgt
$user            = $_SESSION["user-id"];
$followed_topics = array();
$i               = 0;

try {
    $db   = new PDO( $dsn, $dbuser, $dbpass, $option );
    $stmt = $db->prepare( "SELECT topic_id AS followed_id, topic_name AS followed_name, priority, `type` FROM user_follow_topic_view WHERE following_user_id_topic = :user
                                            UNION ALL
                                            SELECT user_id AS followed_id, user_name AS followed_name, priority, `type` FROM user_follow_user_view Where following_user_id_user = :user
                                            ORDER BY priority ASC" );
    //Das SQL Statement wählt die Nutzernamen und Topicnamen denen gefolgt wird und sortiert sie nach 'priority'

    if ( $stmt->execute( array( ":user" => $user ) ) ) {
        while ( $row = $stmt->fetch() ) {
            $followed_id[]   = $row ["followed_id"];
            $followed_name[] = $row["followed_name"];
            $followed_type[] = $row["type"];
            //fügt die id von dem Nutzer oder der Topic der gefolgt wird, die topics oder Nutzernamen dem
            // gefolgt wird und den type jeder Zeile hinten an das Array an.
        }
    } else {
        echo 'Datenbank Fehler';
        echo 'bitte wende dich an den Administrator';
    }
    $stmt = 0;
} catch ( PDOException $e ) {
    echo "Error!: Bitten wenden Sie sich an den Administrator...<br/>";
    die();
}