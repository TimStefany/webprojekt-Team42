<!-- ToDo
    - Stylen
    - Beiträge der Topic ausgeben
    - URL bearbeiten?
-->
<?php
session_start();
include_once 'outsourced-php-code/userdata.php';

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
        <a class="nav-link dropdown-toggle username" href="#" id="navbarDropdown" role="button"
           data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">
        </a>
        <div class="dropdown-menu dropdown-user-menu bg-dark" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="#">Farbe ändern</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Edit Profile</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="invisible-pages/logout.php">Ausloggen</a>
        </div>
    </div>
</nav>
<div>
    <h2><?php echo $topic_name ?></h2>
</div>
    <?php
    echo '<a href="invisible-pages/follow.php?followed_id=' . $visited_topic . '&type=1">Folgen</a>';
} else {
    echo '<h1>Sie sind nicht angemeldet</h1>';
    echo '<p>gehen sie hier zu unserer Startseite und melden sie sich an</p><br>';
    echo '<a href="index.php">Startseite</a>';
}