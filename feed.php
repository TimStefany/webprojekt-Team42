<!-- ToDo
    - Individuelle Reihenfolge und Anzahl der Spalten
    - Spaltenbreite festlegen
    - Nutzer Follows einfügen
    - Beiträge pro Spalte ausgeben
-->
<?php
//muss noch überprüft werden ob diese Anmeldeüberprüfung funktioniert
session_start();
include_once 'userdata.php';

if (isset ($_SESSION["signed-in"])) {


    ?>
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

        try {
            $db = new PDO($dsn, $dbuser, $dbpass, $option);
            $stmt = $db->prepare("SELECT `followed-topic-id` FROM `user_follow_topic` WHERE `following-user-id-topic`=:user");

            if ($stmt->execute(array(":user" => $user))) {
                while ($row = $stmt->fetch()) {
                    $followed_topics[] = $row["followed-topic-id"];
                    //fügt die topics jeder Zeile hinten an das Array an.
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
                for ($i = 0; $i < count($followed_topics); $i++) {
                    $stmt = $db->prepare("SELECT `topic-name` FROM `topics` WHERE `topic-id`=:topic");
                    if ($stmt->execute(array(":topic" => $followed_topics[$i]))) {
                        while ($row = $stmt->fetch()) {
                            $topic_name = $row["topic-name"];
                        }
                    }

                    echo '<div class="col-sm"><!--explore Spalte mit allen Beiträgen-->';
                    echo '<h3>' . $topic_name . '</h3>';
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