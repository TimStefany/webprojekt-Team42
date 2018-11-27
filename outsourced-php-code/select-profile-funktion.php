<?php
function get_profile_information($user_id){
    include "userdata.php";

    try {
        $db   = new PDO($dsn, $dbuser, $dbpass, $option);
        $stmt = $db->prepare( "SELECT * FROM `registered_users_pictures_view` WHERE `user_id` = :user" );

        if ($stmt->execute(array(":user" => $user_id))) {
            while ( $row = $stmt->fetch() ) {
                $user_name = $row["user_name"];
                $picture_id = $row["picture_id"];
                $picture_path = strval($row["picture_path"]);
                $profile_text = $row["profile_text"];
            }
        } else {
            echo 'Datenbank Fehler';
            echo 'bitte wende dich an den Administrator';
        }

    } catch ( PDOException $e ) {
        echo "Error!: Bitten wenden Sie sich an den Administrator...<br/>";
        die();
    }
    $information = [$user_name, $picture_id, $picture_path, $profile_text];
    return $information;
}