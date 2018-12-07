<?php
session_start();
include_once 'outsourced-php-code/userdata.php';
include_once 'outsourced-php-code/necessary-variables.php';
include_once 'outsourced-php-code/select-profile-funktion.php';

//ausführen der Funktion, um alle Benutzerinformationen in eine Variable zu schreiben
$user_information = get_profile_information($_SESSION["user-id"]);
$notification_dropdown = $_SESSION["notification-count"];

if (isset ($_SESSION["signed-in"])) {

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
    <!--####################################################################################################################
        Hier steht der NAV Bar
    ####################################################################################################################-->
    <div style="height:61px;"></div>
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="feed.php">+Plus</a>

        <!-------------------------------------------------------------------------------------------------------------->
        <!---------------Hamburger Button / Toggle Button--------------------------------------------------------------->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse abstand_mobil" id="navbarSupportedContent">
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
                <ul id="reloaded" class="dropdown-menu bg-dark">
                    <div style="max-height:<?php echo ($notification_dropdown * 59)  ?>px;">

                    </div>
                </ul>
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
    <!--################################################################################################################
        Hier beginnt der Inhalt der Seite
    #################################################################################################################-->
    <main>
        <!-----------input Box für Posts (Modal)----------------------------------------------------------------------->
        <div class="postform">
            <div class="modal fade " id="postModal" tabindex="-1" role="dialog"
                 aria-labelledby="postModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog vh15" role="document">
                    <div class="modal-content boxshadow bg-white">
                        <div class="modal-header">
                            <h1 class="modal-title" id="postModalLabel">Posten</h1>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="postform">
                            <form action="invisible-pages/post.php" method="post" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <p><label class="formular-label-color">Blogeintrag:<br>
                                            <textarea class="form-control" name="post" cols="80" rows="3"
                                                      placeholder="neuer Eintrag!"
                                                      maxlength="200" required></textarea></label></p>
                                    <p>
                                    <div class="ui-widget">
                                        <!--<textarea class="form-control" name="topic" id="tags" rows="1"></textarea>-->
                                        <label class="formular-label-color" for="tags">Topic: </label>
                                        <input class ="form-control" name="topic" id="tags">
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <input class="verschiebung" type="file" name="files" accept="image/*"
                                           onchange="loadFile(event)">
                                    <img id="output" class="image-preview"/>
                                    <button type="submit" name="upload-post-feed" class="btn btn-sm btn-primary">
                                        Posten
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <!--------------------------------------------------------------------------------------------------------->

            <?php
            /*###########################################################################################################
                Hier wird ausgelesen, welchen Nutzern und welcher Topic der Nutzer folgt
            ###########################################################################################################*/
            $user = $_SESSION["user-id"];
            $followed_topics = array();
            $i = 0;

            try {
                $db = new PDO($dsn, $dbuser, $dbpass, $option);
                $stmt = $db->prepare("SELECT topic_id AS followed_id, topic_name AS followed_name, priority, `type` FROM user_follow_topic_view WHERE following_user_id_topic = :user
                                            UNION ALL
                                            SELECT user_id AS followed_id, user_name AS followed_name, priority, `type` FROM user_follow_user_view Where following_user_id_user = :user
                                            ORDER BY priority ASC");
                //Das SQL Statement wählt die Nutzernamen und Topicnamen denen gefolgt wird und sortiert sie nach 'priority'


                if ($stmt->execute(array(":user" => $user))) {
                    $counter = 0; // wird benötigt um die anzahl der gefolgten Topics und User rauszufinden.
                    while ($row = $stmt->fetch()) {
                        $followed_id[] = $row ["followed_id"];
                        $followed_name[] = $row["followed_name"];
                        $followed_type[] = $row["type"];
                        //fügt die id von dem Nutzer oder der Topic der gefolgt wird, die topics oder Nutzernamen dem
                        // gefolgt wird und den type jeder Zeile hinten an das Array an.
                        $counter++;
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
            ?>

            <div class="feed-scroll" style="min-width:<?php echo ($counter * 432) + 42 ?>px;">
                <!--####################################################################################################################
                    Dieser Teil gibt die Spalten mit den Beiträgen aus
                    ####################################################################################################################-->
                <?php

                for ($i = 0; $i < count($followed_name); $i++) {

                    //eine neue Spalte mit der Überschrift des Themas oder des Users wird aufgemacht
                    if ($followed_type[$i] == 1) {     //Topics bekommen einen Link in der Überschrift auf die Topic Seite
                        echo '<div class="feed-scroll-row">';
                        echo '<a href="topic-profile.php?id=' . $followed_id[$i] . '" class= "h4" >+' . $followed_name[$i] . '</a><div class="feed-scroll-row-container">';
                    } else {
                        echo '<div class="feed-scroll-row">';
                        echo '<a href="profile-foreign.php?id=' . $followed_id[$i] . '" class= "h4" >+' . $followed_name[$i] . '</a><div class="feed-scroll-row-container">';
                    }

                    /*###########################################################################################################
                        Hier werden alle Topics ausgegeben - zuerst alle anderen Topics und danach die explore Topic
                    ###########################################################################################################*/

                    //Abfrage aller Beiträge für die Spalte - muss nach gefolgten Nutzern und gefolgten Topics getrennt werden.
                    if ($followed_type[$i] == 1) {     // Es geht um eine Topic

                        //explore Topic soll alle Beiträge anzeigen und muss deshalb extra behandelt werden
                        if ($followed_id[$i] !== '1') {
                            //alle Topics abgesehen von der Explore Topic werden so abgearbeitet (explore hat id=1)
                            $db = new PDO($dsn, $dbuser, $dbpass, $option);
                            $stmt = $db->prepare("SELECT user_id, user_name, content, picture_path, topic_name, topic_id FROM posts_registered_users_topics_pictures_view WHERE topic_id = :topic");
                            if ($stmt->execute(array(":topic" => $followed_id[$i]))) {
                                while ($row = $stmt->fetch()) {
                                    //Informationen über den Autor für das Prfilbild in eine Variable schreiben
                                    $author_information = get_profile_information($row["user_id"]);

                                    echo '<div class="feed-scroll-row-container-cell">';   //der Gesammte Post steckt in diesem DIV

                                    //Ausgabe des Profilbildes
                                    if ($author_information[2] !== "") {
                                        echo '<img src="' . $picture_path_server . $author_information[2] . '" class="feed-scroll-row-container-cell-profilepicture" >';
                                    } else { //default Profilbild
                                        echo '<img src="' . $picture_path_server . $default_avatar_path . '" class="feed-scroll-row-container-cell-profilepicture" >';
                                    }

                                    echo '<a href="profile-foreign.php?id=' . $row["user_id"] . '" class="autor"> +' . $row["user_name"] . '</a>';
                                    if ($row["topic_id"] !== null) {
                                        echo ' /';
                                        echo '<a class="topic-link" href="topic-profile.php?id=' . $row["topic_id"] . '"> +' . $row["topic_name"] . '</a>';
                                    }
                                    echo '<hr class="my-1">';
                                    echo '<p>' . $row["content"] . '</p>'; //gibt den Content in einem P Tag aus
                                    //gibt den Nutzernamen des Autors als Link aus

                                    //Wenn dem Beitrag ein Bild hinzugefügt wurde dann wird diese Schleife ausgeführt
                                    if ($row["picture_path"] !== null) {
                                        echo '<a href="' . $picture_path_server . $row["picture_path"] . '">';
                                        echo '<img  src="' . $picture_path_server . $row["picture_path"] . '">';
                                        echo '</a>';
                                    }

                                    echo '</div>';  //der Gesammte Post steckt in diesem DIV
                                }
                            }
                        } else {      //Andere Auswahl für die Explore Spalte
                            $db = new PDO($dsn, $dbuser, $dbpass, $option);
                            $stmt = $db->prepare("SELECT user_id, user_name, content, picture_path, topic_id, topic_name FROM posts_registered_users_topics_pictures_view WHERE 1 = 1");
                            if ($stmt->execute()) {
                                while ($row = $stmt->fetch()) {
                                    //Informationen über den Autor für das Prfilbild in eine Variable schreiben
                                    $author_information = get_profile_information($row["user_id"]);

                                    echo '<div class="feed-scroll-row-container-cell">';   //der Gesammte Post steckt in diesem DIV

                                    //Ausgabe des Profilbildes
                                    if ($author_information[2] !== "") {
                                        echo '<img src="' . $picture_path_server . $author_information[2] . '" class="feed-scroll-row-container-cell-profilepicture" >';
                                    } else { //default Profilbild
                                        echo '<img src="' . $picture_path_server . $default_avatar_path . '" class="feed-scroll-row-container-cell-profilepicture" >';
                                    }

                                    echo '<a href="profile-foreign.php?id=' . $row["user_id"] . '" class="autor"> +' . $row["user_name"] . '</a>';
                                    if ($row["topic_id"] != null) {
                                        echo ' /';
                                        echo '<a class="topic-link" href="topic-profile.php?id=' . $row["topic_id"] . '"> +' . $row["topic_name"] . '</a>';
                                    }
                                    echo '<hr class="my-1">';
                                    echo '<p>' . $row["content"] . '</p>'; //gibt den Content in einem P Tag aus
                                    //gibt den Nutzernamen des Autors als Link aus

                                    //gibt die Topic des Posts als Link aus
                                    if ($row["picture_path"] != null) {     // wird ausgeführt wenn ein Bild hinterlegt wurde
                                        echo '<a href="' . $picture_path_server . $row["picture_path"] . '">';
                                        echo '<img  src="' . $picture_path_server . $row["picture_path"] . '">';
                                        echo '</a>';
                                    }

                                    echo '</div>';   //der Gesammte Post steckt in diesem DIV
                                }
                            }
                        }

                    }

                    /*###########################################################################################################
                        Hier werden alle Nutzer denen gefolgt wird ausgegeben
                    ###########################################################################################################*/
                    if ($followed_type[$i] == 2) {     // Es geht um einen User
                        $db = new PDO($dsn, $dbuser, $dbpass, $option);
                        $stmt = $db->prepare("SELECT user_id, user_name, content, topic_id, topic_name, picture_path FROM posts_registered_users_topics_pictures_view WHERE user_id = :user");
                        if ($stmt->execute(array(":user" => $followed_id[$i]))) {
                            global $author_information;
                            $author_information = get_profile_information($followed_id[$i]);

                            while ($row = $stmt->fetch()) {
                                echo '<div class="feed-scroll-row-container-cell">';   //der Gesammte Post steckt in diesem DIV

                                //Ausgabe des Profilbildes
                                if ($author_information[2] !== "") {
                                    echo '<img src="' . $picture_path_server . $author_information[2] . '" class="feed-scroll-row-container-cell-profilepicture" >';
                                } else { //default Profilbild
                                    echo '<img src="' . $picture_path_server . $default_avatar_path . '" class="feed-scroll-row-container-cell-profilepicture" >';
                                }

                                echo '<a href="profile-foreign.php?id=' . $row["user_id"] . '" class="autor"> + Autor: ' . $row["user_name"] . '</a>';
                                if ($row["topic_id"]) {
                                    echo ' /';
                                    echo '<a href="topic-profile.php?id=' . $row["topic_id"] . '"> + Topic: ' . $row["topic_name"] . '</a>';
                                }
                                echo '<hr class="my-1">';
                                echo '<p>' . $row["content"] . '</p>'; //gibt den Content in einem P Tag aus
                                //gibt den Nutzernamen des Autors als Link aus

                                if ($row["picture_path"] !== null) {
                                    echo '<a href="' . $picture_path_server . $row["picture_path"] . '">';
                                    echo '<img  src="' . $picture_path_server . $row["picture_path"] . '">';
                                    echo '</a>';
                                }

                                echo '</div>';  //der Gesammte Post steckt in diesem DIV
                            }
                        }
                    }
                    echo '</div></div>';
                }
                ?>

            </div>

    </main>
    <footer>

    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="dist/js/main.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script> <!--Pic Upload-->
        var loadFile = function (event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>

    <!------Notification Text reload----------------------------------------------------------------------------------->
    <script>
        setInterval(function () {
            $.get('invisible-pages/notification-request.php', function (data) {
                $('#reloaded').html(data);
            });
        }, 2000);
    </script>
    <!----------------------------------------------------------------------------------------------------------------->
    <!------Notification Count reload---------------------------------------------------------------------------------->
    <script>
        setInterval(function () {
            $.get('invisible-pages/notification-count.php', function (data) {
                $('#reloaded-count').html(data);
            });
        }, 2000);
    </script>
    <!----------------------------------------------------------------------------------------------------------------->
    </body>

    </html>
    <?php
} else {
    header("location:index.php");
}
?>