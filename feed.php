<!-- ToDo
    - Spaltenbreite festlegen
    - Bilder richtig einfügen in den Spalten (SQL abfrage für den Pfad + <img>)
    - Nutzerprofil des Autors in den Link einfügen
-->
<?php
session_start();
include_once 'userdata.php';

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
        include 'header.php';
        ?>
    </head>
    <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Plus - Microblog</a>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Find</button>
        </form>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="feed.php">Feed</a>
                </li>
            </ul>
        </div>
        <a href="#">
            <button type="button" class="btn btn-light">
                News <span class="badge badge-light">8</span>
            </button>
        </a>
        <div class="d-flex"><img
                    src=https://img.fotocommunity.com/bb-bilder-9e10eb1c-ede3-47da-a2c5-97692e7faf8c.jpg?width=45&height=45
                    class="img-circle profil-image-small">
            <a href="profile.php" class="nav-item active nav-link username">USERNAME </a>
            <a class="nav-link dropdown-toggle username" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
            </a>
            <div class="dropdown-menu dropdown-user-menu bg-primary bg-dark" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Farbe ändern</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Edit Profile</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php">Ausloggen</a>
            </div>
        </div>
    </nav>
    <main class="container"><!--ein Responsive Container in dem der Content steckt-->
        <?php
        //Auslesen der Themen und Nutzer denen ein Nutzer folgt
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
                while ($row = $stmt->fetch()) {
                    $followed_id[] = $row ["followed_id"];
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
        } catch (PDOException $e) {
            echo "Error!: Bitten wenden Sie sich an den Administrator...<br/>";
            die();
        }
        ?>

        <div class="container">
            <div class="row">
                <?php

                for ($i = 0; $i < count($followed_name); $i++) {
                    //eine neue Spalte mit der Überschrift des Themas oder des Users wird aufgemacht
                    echo '<div class="col-sm">';
                    echo '<h3>' . $followed_name[$i] . '</h3>';

                    //Abfrage aller Beiträge für die Spalte - muss nach gefolgten Nutzern und gefolgten Topics getrennt werden.
                    if ($followed_type[$i]==1){     // Es geht um eine Topic
                        //explore Topic soll alle Beiträge anzeigen und muss deshalb extra behandelt werden
                        if ($followed_id[$i]!=='1'){
                            //alle Topics abgesehen von der Explore Topic werden so abgearbeitet (explore hat id=1)
                            $db = new PDO($dsn, $dbuser, $dbpass, $option);
                            $stmt = $db->prepare("SELECT user_name, content, picture_id FROM posts_registered_users_view WHERE topic_id = :topic");
                            if ($stmt->execute(array(":topic" => $followed_id[$i]))){
                                while ($row = $stmt->fetch()){
                                    echo '<p>'.$row["content"].'</p>'; //gibt den Content in einem P Tag aus
                                    echo '<a href="#">Autor: '.$row["user_name"].'</a>'; //gibt den Nutzernamen des Autors als Link aus

                                    //Wenn dem Beitrag ein Bild hinzugefügt wurde dann wird diese Schleife ausgeführt
                                    if ($row["picture_id"]!==NULL){
                                        echo 'hier steht der Pfad zum Bild';
                                    }
                                }
                            }
                        }
                        else {      //Andere Auswahl für die Explore Spalte
                            $db = new PDO($dsn, $dbuser, $dbpass, $option);
                            $stmt = $db->prepare("SELECT user_name, content, picture_id FROM posts_registered_users_view WHERE 1 = 1");
                            if ($stmt->execute()){
                                while ($row = $stmt->fetch()){
                                    echo '<p>'.$row["content"].'</p>'; //gibt den Content in einem P Tag aus
                                    echo '<a href="#">Autor: '.$row["user_name"].'</a>'; //gibt den Nutzernamen des Autors als Link aus

                                    if ($row["picture_id"]!==NULL){     // wird ausgeführt wenn ein Bild hinterlegt wurde
                                        echo 'hier steht der Pfad zum Bild';
                                    }
                                }
                            }
                        }

                    }

                    if ($followed_type[$i]==2){     // Es geht um einen User
                        $db = new PDO($dsn, $dbuser, $dbpass, $option);
                        $stmt = $db->prepare("SELECT user_name, content, picture_id FROM posts_registered_users_view WHERE user_id = :user");
                        if ($stmt->execute(array(":user" => $followed_id[$i]))){
                            while ($row = $stmt->fetch()){
                                echo '<p>'.$row["content"].'</p>'; //gibt den Content in einem P Tag aus
                                echo '<a href="#">Autor: '.$row["user_name"].'</a>'; //gibt den Nutzernamen des Autors als Link aus

                                if ($row["picture_id"]!==NULL){
                                    echo 'hier steht der Pfad zum Bild';
                                }
                            }
                        }
                    }
                    echo '</div>';
                }
                ?>

            </div>
        </div>
    </main>
    <footer>

    </footer>
    </body>

    </html>
    <?php
} else {
    echo '<h1>Sie sind nicht angemeldet</h1>';
    echo '<p>gehen sie hier zu unserer Startseite und melden sie sich an</p><br>';
    echo '<a href="index.php">Startseite</a>';
}