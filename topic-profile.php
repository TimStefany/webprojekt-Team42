<!-- ToDo
    - Stylen
    - URL bearbeiten?
-->
<?php
session_start();
include_once 'outsourced-php-code/userdata.php';
include_once 'outsourced-php-code/necessary-variables.php';
include_once 'outsourced-php-code/select-profile-funktion.php';

//ausführen der Funktion, um alle Benutzerinformationen in eine Variable zu schreiben
$user_information = get_profile_information($_SESSION["user-id"]);

if (isset ($_SESSION["signed-in"])) {

//Topic id die über die URL übergeben wird in eine Variable schreiben
$visited_topic = $_GET["id"];

//Datenbankabfrage um alle Nutzerinformationen zu sammeln
try {
    $db = new PDO($dsn, $dbuser, $dbpass, $option);
    $stmt = $db->prepare("SELECT topic_name FROM topics WHERE topic_id = :topic");
    $stmt->execute(array(":topic" => $visited_topic));
    while ($row = $stmt->fetch()) {
        $topic_name = $row ["topic_name"];
    }
} catch (PDOException $e) {
    echo "Error!: Bitten wenden Sie sich an den Administrator...<br/>";
    die();
}
?>
<!doctype html>

<html class="no-js" lang="de">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Microblog Team-42</title>
    <meta name="description" content="">
    <?php
    include 'outsourced-php-code/header.php';
    ?>
</head>

<body>
<div class="background-login"></div>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">+Plus</a>

    <!-------------------------------------------------------------------------------------------------------------->
    <!---------------Hamburger Button / Toggle Button--------------------------------------------------------------->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse mt-2" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <form class="form-inline my-lg-0 " action="find.php" method="get">
                <input class="form-control mr-lg-2 " type="search" placeholder="Search" aria-label="Search"
                       name="search">
                <button class="btn btn-outline-light my-2 my-lg-0" type="submit">Find</button>
            </form>
            <!--------Posten Modal Button--------------------------------------------------------------------------->
            <li class="nav-item">
                <button type="button" class="btn btn-secondary mx-0 my-1 form-inline" data-toggle="modal"
                        data-target="#postModal">
                    Posten
                </button>
            </li>
            <!----------------------------------------------------------------------------------------------------->
            <li class="nav-item">
                <a class="btn btn-dark mx-0 my-1 form-inline" href="feed.php" role="button">Feed</a>
            </li>
            <li class="nav-item">
                <a class="btn btn-dark mx-0 my-1 form-inline" href="invisible-pages/logout.php" role="button">Ausloggen</a>
            </li>
        </ul>
    </div>
    <!-------------------------------------------------------------------------------------------------------------->
    <!----------------------Profil Bild und Name und Notification--------------------------------------------------->
    <div class="d-flex nav-bar-profile-picture">
        <!---------------------Notification Bell-------------------------------------------------------------------->
        <div class="dropdown" style="list-style-type:none; margin-left:10px; margin-right:10px;top:12px;">
            <a href="#" data-toggle="dropdown"><span
                        class="label label-pill label-danger count" style="border-radius:10px;"></span> <span <i
                        class="fas fa-bell"></i> </a>
            <div id="reloaded" class="dropdown-menu notification-menu bg-dark">
                <!--Wird über Java Script alle 2 Sekunden aus der Datei 'notification-request.php' geladen-->
            </div>
        </div>
        <!---------------------------------------------------------------------------------------------------------->
        <!----------------------Benachrichtigungs Counter----------------------------------------------------------->
        <div class="count-container" id="reloaded-count">
            <!--Wird über Java Script alle 2 Sekunden aus der Datei 'notification-count.php' geladen-->
        </div>
        <!---------------------------------------------------------------------------------------------------------->
        <!----------------------Profil Bild und Name---------------------------------------------------------------->
        <img
                src="<?php
                if ($user_information[2] !== "") {
                    echo $picture_path_server . $user_information[2];
                } else { //default Profilbild
                    echo $picture_path_server . $default_avatar_path;
                } ?>"
                class="img-circle profil-image-small">
        <a href="profile.php"
           class="nav-item active nav-link username"><?php echo $_SESSION["user-name"]; ?></a>
    </div>
    <!-------------------------------------------------------------------------------------------------------------->
</nav>
<main class="container margin-top-19">
    <div class="profile-header p-4">
        <div>
            <?php
            echo '<h1 class="profile-topic-headline">' . $topic_name . '</h1>';
            /*#############################################################################################################
                Follow Button bzw Unfollow Button ausgeben
            ###############################################################################################################*/
            try {
                $db = new PDO($dsn, $dbuser, $dbpass, $option);
                $stmt = $db->prepare("SELECT `topic_follow_id`, `type` FROM `user_follow_topic` WHERE `following_user_id_topic` = :user AND `followed_topic_id` = :topic");

                if ($stmt->execute(array(":user" => $_SESSION["user-id"], ":topic" => $visited_topic))) {
                    $row = $stmt->fetch();
                    if ($row == []) {
                        echo '<a href="invisible-pages/follow.php?followed_id=' . $visited_topic . '&type=1"><button type="button" class="btn btn-dark">
               Folgen
            </button></a>';
                    } else {
                        $follow_id = $row["topic_follow_id"];
                        echo '<a href="invisible-pages/unfollow.php?followed_id=' . $visited_topic . '&type=1&follow_id=' . $follow_id . '"><button type="button" class="btn btn-dark">
               Entfolgen
            </button></a>';
                    }

                } else {
                    echo 'Datenbank Fehler';
                    echo 'bitte wende dich an den Administrator';
                }


            } catch (PDOException $e) {
                echo "Error!: Bitten wenden Sie sich an den Administrator...<br/>";
                die();
            }

            /*#############################################################################################################
                Alle Beiträge der Topic anzeigen
            ###############################################################################################################*/
            echo '</div>';
            echo '</div>';
            echo '<hr>';
            echo '<div class="profile-transparent-bg">';
            echo '<h2>Beiträge in ' . $topic_name . ':</h2>';

            try {
                $db = new PDO($dsn, $dbuser, $dbpass, $option);
                $stmt = $db->prepare("SELECT * FROM posts_registered_users_topics_pictures_view WHERE topic_id = :topic");

                if ($stmt->execute(array(":topic" => $visited_topic))) {
                    while ($row = $stmt->fetch()) {

                        //Informationen über den Autor in einer Variable abspeichern
                        $author_information = get_profile_information($row["user_id"]);

                        echo '<div class="profile-container-row">';
                        echo '<div class="profile-container-row-cell">';

                        //Ausgabe des Profilbildes
                        if ($author_information[2] !== "") {
                            echo '<img src="' . $picture_path_server . $author_information[2] . '" class="feed-scroll-row-container-cell-profilepicture" >';
                        } else { //default Profilbild
                            echo '<img src="' . $picture_path_server . $default_avatar_path . '" class="feed-scroll-row-container-cell-profilepicture" >';
                        }

                        //Name des Autors als Link ausgeben
                        echo '<a class="topic-link" href="profile-foreign.php?id=' . $row["user_id"] . '" class="autor"> +' . $row["user_name"] . '</a>';
                        echo '<hr class="my-1">';

                        //Inhalt des Posts wird ausgegeben
                        echo '<p>' . $row["content"] . '</p>';
                        if ($row["picture_id"] != null) {
                            echo '<img src="' . $picture_path_server . $row["picture_path"] . '">';

                        }
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo 'Datenbank Fehler';
                    echo 'bitte wende dich an den Administrator';
                }

            } catch (PDOException $e) {
                echo "Error!: Bitten wenden Sie sich an den Administrator...<br/>";
                die();
            } ?>

            <?php
            } else {
                header("location:index.php");
            }

            ?>
</main>
<footer>
</footer>
</body>
</html>
