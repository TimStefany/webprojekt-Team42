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
    <nav>

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