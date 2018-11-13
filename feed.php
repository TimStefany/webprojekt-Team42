<!-- ToDo
    - Spaltenbreite festlegen
    - Beiträge pro Spalte ausgeben
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
            $stmt = $db->prepare("SELECT topic_name AS followed_name, priority FROM user_follow_topic_view WHERE following_user_id_topic = :user
                                            UNION ALL
                                            SELECT user_name AS followed_name, priority FROM user_follow_user_view Where following_user_id_user = :user
                                            ORDER BY priority ASC");
            //Das SQL Statement wählt die Nutzernamen und Topicnamen denen gefolgt wird und sortiert sie nach 'priority'

            if ($stmt->execute(array(":user" => $user))) {
                while ($row = $stmt->fetch()) {
                    $followed[] = $row["followed_name"];
                    //fügt die topics oder Nutzernamen jeder Zeile hinten an das Array an.
                }
            } else {
                echo 'Fehler 123';
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
                for ($i = 0; $i < count($followed); $i++) {
                    echo '<div class="col-sm"><!--explore Spalte mit allen Beiträgen-->';
                    echo '<h3>' . $followed[$i] . '</h3>';
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