<?php
session_start();

include_once 'outsourced-php-code/userdata.php';
include_once 'outsourced-php-code/select-profile-funktion.php';
include_once 'outsourced-php-code/necessary-variables.php';

//ausführen der Funktion, um alle Benutzerinformationen in eine Variable zu schreiben
$user_information = get_profile_information($_SESSION["user-id"]);

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
    <div>
        <!-- Notification Bell -->
        <li class="dropdown" style="list-style-type:none; margin-left:10px; margin-right:10px;">
            <a href="#" data-toggle="dropdown"><span
                        class="label label-pill label-danger count" style="border-radius:10px;"></span> <span <i
                        class="fas fa-bell"></i> </a>
            <ul id="reloaded" class="dropdown-menu">

            </ul>
        </li>
    </div>
    <div class="d-flex nav-bar-profile-picture"><img
                src="<?php echo $picture_path_server . $user_information[2]; ?>"
                class="img-circle profil-image-small">
        <a href="profile.php" class="nav-item active nav-link username"><?php echo $_SESSION["user-name"]; ?></a>
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
<main>
    <div class="container">
    <?php
    echo '<div>';
    try {
        $db = new PDO($dsn, $dbuser, $dbpass, $option);
        $stmt = $db->prepare("SELECT * FROM posts_registered_users_topics_pictures_view WHERE post_id = :post");
        if ($stmt->execute(array(":post" => $_GET["post-id"]))) {
            while ($row = $stmt->fetch()) {
                $author_information = get_profile_information($row["user_id"]);

                //ab hier wird das Bild, der Name und eventuell die Topic ausgegeben
                echo '<div class="profile-container-row">';
                echo '<div class="profile-container-row-cell">';
                echo '<img src="'.$picture_path_server.$author_information[2].'" class="feed-scroll-row-container-cell-profilepicture" >';
                echo '<a href="profile-foreign.php?id=' . $row["user_id"] . '" class="autor"> +' . $row["user_name"] . '</a>';
                if ($row["topic_id"] !== null) {
                    echo ' /';
                    echo '<a class="topic-link" href="topic-profile.php?id=' . $row["topic_id"] . '"> +' . $row["topic_name"] . '</a>';
                }
                echo '<hr class="my-1">';

                //ab hier wird der Post ausgegeben
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
    }

    echo '</div>';
    /*##################################################################################################################
        Ab hier wird der Eintrag für den Post aus der notifications Datenbank gelöscht, da er bereits gesehen wurde
    ##################################################################################################################*/
    try {
        $db = new PDO($dsn, $dbuser, $dbpass, $option);
        $stmt = $db->prepare("DELETE FROM `notifications` WHERE `notification_id` = :id");

        $stmt->execute(array(":id"=>$_GET["follow-id"]));
    } catch (PDOException $e) {
        echo "Error!: Bitten wenden Sie sich an den Administrator...<br/>";
        die();
    }
    ?>
    </div>
</main>
<script>
    setInterval(function () {
        $.get('invisible-pages/notification-request.php', function (data) {
            $('#reloaded').html(data);
        });
    }, 2000);
</script>
</body>
