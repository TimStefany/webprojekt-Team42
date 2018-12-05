<?php
session_start();
include_once 'outsourced-php-code/userdata.php';
include_once 'outsourced-php-code/necessary-variables.php';
include_once 'outsourced-php-code/select-profile-funktion.php';

//ausführen der Funktion, um alle Benutzerinformationen in eine Variable zu schreiben
$user_information = get_profile_information($_SESSION["user-id"]);

if (isset ($_SESSION["signed-in"])) {

    //Suchbegriff aus der URL in die Variable schreiben
    $search = '%' . $_GET["search"] . '%';

    //Datenbankverbindung aufbauen
    $db = new PDO($dsn, $dbuser, $dbpass, $option);

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
    <a class="navbar-brand" href="#">Plus - Microblog</a>
    <!---------------Search Teil der Nav Bar------------------------------------------------------------------------->
    <form class="form-inline my-2 my-lg-0" action="find.php" method="get">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search">
        <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Find</button>
    </form>
    <!-------------------------------------------------------------------------------------------------------------->
    <!---------------Weis leider nich was das ist------------------------------------------------------------------->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="feed.php">Feed</a>
            </li>
            <!--------Posten Modal Button---------------------------------------------------------------------------
            <li class="nav-item">
                <button type="button" class="btn btn-success" data-toggle="modal"
                        data-target="#postModal">
                    Posten
                </button>
            </li>
            ----------------------------------------------------------------------------------------------------->
        </ul>
    </div>
    <!-------------------------------------------------------------------------------------------------------------->
    <!---------------------Notification Bell------------------------------------------------------------------------>
    <div>
        <li class="dropdown" style="list-style-type:none; margin-left:10px; margin-right:10px;">
            <a href="#" data-toggle="dropdown"><span
                        class="label label-pill label-danger count" style="border-radius:10px;"></span> <span <i
                        class="fas fa-bell"></i> </a>
            <ul id="reloaded" class="dropdown-menu">

            </ul>
        </li>
    </div>
    <!-------------------------------------------------------------------------------------------------------------->
    <!----------------------Profil Bild und Name und Dropdown------------------------------------------------------->
    <div class="d-flex nav-bar-profile-picture"><img
                src="<?php
                if ($user_information[2] !== "") {
                    echo $picture_path_server . $user_information[2];
                } else { //default Profilbild
                    echo $picture_path_server . $default_avatar_path;
                } ?>"
                class="img-circle profil-image-small">
        <a href="profile.php"
           class="nav-item active nav-link username"><?php echo $_SESSION["user-name"]; ?></a>
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
    <!-------------------------------------------------------------------------------------------------------------->
</nav>
<main>
    <div class="container">
        <?php
        //##################################################################################################################
        //          Datenbankabfrage um alle Nutzer zu finden
        //##################################################################################################################
        echo '<h2>Nutzer</h2>';
        try {
            $stmt = $db->prepare("SELECT user_id, user_name, picture_path, profile_text FROM registered_users_pictures_view 
                                        WHERE user_name LIKE :search");
            $stmt->execute(array(":search" => $search));
            while ($row = $stmt->fetch()) {
                ?>
                <a href="profile-foreign.php?id=<?php echo $row["user_id"] ?>">
                    <div class="profile-header">
                        <div class="profile-header-cols">
                            <div class="row">
                                <div class="col-lg-4 p-3">
                                    <?php
                                    if ($row["picture_path"] !== null) {
                                        ?>
                                        <img src="<?php echo $picture_path_server . $row["picture_path"]; ?>"
                                             width="300" height="auto" alt="Profilbild">
                                        <?php
                                    } else { //default Profilbild
                                        ?>
                                        <img src="<?php echo $picture_path_server . $default_avatar_path; ?>"
                                             width="300" height="auto" alt="Profilbild">
                                        <?php
                                    } ?>
                                </div>

                                <div class="col-lg-8 p-5">
                                    <div>
                                        <h1 class="profile-topic-headline"><?php echo $row["user_name"]; ?></h1>
                                    </div>
                                    <hr>
                                    <?php
                                    $user = $_SESSION["user-id"];

                                    //Hinzufügen eines Profiltextes falls keiner vorhanden ist
                                    if ($row["profile_text"] == NULL) {
                                        $row["profile_text"] = "Kein Profiltext vorhanden.";
                                    }
                                    echo "<span class='profile-headline'>Profiltext:</span>";
                                    echo "<div><p>" . $row["profile_text"] . "</p></div>";

                                    ?>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <hr>
                <?php
            }
        } catch (PDOException $e) {
            echo "Error!: Bitten wenden Sie sich an den Administrator...<br/>";
            die();
        }

        //##################################################################################################################
        //          Datenbankabfrage um alle Topics zu finden
        //##################################################################################################################
        echo '<h2>Topics</h2>';
        try {
            $stmt = $db->prepare("SELECT * FROM topics
                                        WHERE topic_name LIKE :search");
            $stmt->execute(array(":search" => $search));
            while ($row = $stmt->fetch()) {
                ?>
                <a href="topic-profile.php?id=<?php echo $row["topic_id"] ?>">
                    <div class="profile-header p-4">
                        <div>
                            <?php
                            echo '<h1 class="profile-topic-headline">' . $row["topic_name"] . '</h1>';
                            ?>
                        </div>
                    </div>
                </a>
                <hr>
                <?php
            }
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

    <?php
}