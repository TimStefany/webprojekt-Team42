<?php
session_start();
include_once 'outsourced-php-code/userdata.php';
include_once 'outsourced-php-code/necessary-variables.php';
include_once 'outsourced-php-code/select-profile-funktion.php';

//ausführen der Funktion, um alle Benutzerinformationen in eine Variable zu schreiben
$user_information = get_profile_information( $_SESSION["user-id"] );

//pushhelp
if ( isset ( $_SESSION["signed-in"] ) ) {


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

<main class="container container-profile"><!--ein Responsive Container in dem der Content steckt-->
    <div class="profile-header">
    <div class="profile-header-cols">
    <div class="row">
    <div class="col-lg-4 p-3">
        <?php
        //##### Ausgabe des Profilbildes - Standard Bildes #############################################################
        if ($user_information[2] !== "") {
            ?>
            <div class="profile-picture">
                <img class="profile-picture" src="<?php echo $picture_path_server . $user_information[2]; ?>" alt="Profilbild">
            </div>
            <?php
        } else { //default Profilbild
            ?>
            <img class="profile-picture" src="<?php echo $picture_path_server . $default_avatar_path; ?>" alt="Profilbild">
            <?php
        }
        //##############################################################################################################
        ?>
    </div>
    <div class="col-lg-8 p-5">
    <div>
        <?php
        echo '<h1 class="profile-topic-headline">' . $_SESSION["user-name"] . '</h1>';
        ?>
    </div>
    <?php
    $user = $_SESSION["user-id"];

    try {
        $db    = new PDO( $dsn, $dbuser, $dbpass, $option );
        $sql   = "SELECT profile_text FROM registered_users WHERE user_id = :user;";
        $query = $db->prepare( $sql );
        $query->execute( array( ":user" => $user ) );

        $zeile = $query->fetch();
        //Hinzufügen einer Erklärung für den Profiltext falls keiner vorhanden ist
        if ( $zeile["profile_text"] == null ) {
            $zeile["profile_text"] = "Klicke auf Profiltext bearbeiten um deine Beschreibung hinzuzufügen.";
        }
        echo "<span class='profile-headline'>Profiltext:</span>";
        echo "<div><p>".$zeile["profile_text"]."</p></div>";
        ?>
        <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModal">
            Profiltext bearbeiten
        </button>
        <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#profile_picture">
            Bild ändern
        </button>
        <form style="display: inline;" action="invisible-pages/profile-picture-delete.php">
            <button class="btn btn-dark" type="submit" value="Submit">Profilbild löschen</button>
        </form>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog vh15" role="document">
                <div class="modal-content boxshadow bg-white">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Profiltext Bearbeiten:</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action='invisible-pages/update-profile-text.php' method='post'>
                        <div class="modal-body">
                            <p><label class="formular-label-color">Blogeintrag:<br>
                                    <textarea class="form-control" name="post" cols="80" rows="3"
                                              maxlength="200"><?php echo $zeile["profile_text"]; ?></textarea></label>
                            </p>
                            <p>
                        </div>
                        <!-- Aktuell schließen beide Buttons das Modal und keiner führt die Registrierung aus -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Zurück</button>
                            <input type="submit" name="absenden" class="btn btn-primary" value="Update">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade vh15" id="profile_picture" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog vh15" role="document">
                <div class="modal-content boxshadow bg-white">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Profiltext Bearbeiten:</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action='invisible-pages/image-database-upload-profile.php' method='post'
                          enctype="multipart/form-data">
                        <div class="modal-body">
                            <input class="verschiebung" type="file" name="files" accept="image/*"
                                   onchange="loadFile(event)">
                            <img id="output" class="image-preview"/>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zurück</button>
                                <input type="submit" name="upload-profile-picture" class="btn btn-primary"
                                       value="Update">
                            </div>
                    </form>
                </div>
            </div>
        </div>

        </div>
        </div>
        </div>
        </div>
        <!--input Box für Posts-->
        <!--------------------------------------------------------------------------------------------------------------------------------------------->
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
                                        <label class="formular-label-color" for="tags">Topic: </label>
                                        <input class ="form-control" name="topic" id="tags">
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <input class="verschiebung" type="file" name="files" accept="image/*"
                                           onchange="loadFile(event)">
                                    <img id="output1" class="image-preview"/>
                                    <button type="submit" name="upload-post-profile" class="btn btn-sm btn-primary">
                                        Posten
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <hr>
        <div class="profile-transparent-bg">
            <h2>Deine Beiträge:</h2>
            <?php
            /*#############################################################################################################
                Alle Beiträge des Nutzers anzeigen
            ###############################################################################################################*/
            try {
                $db   = new PDO( $dsn, $dbuser, $dbpass, $option );
                $stmt = $db->prepare( "SELECT * FROM posts_registered_users_topics_pictures_view WHERE user_id = :user" );

                if ( $stmt->execute( array( ":user" => $_SESSION["user-id"] ) ) ) {
                    while ( $row = $stmt->fetch() ) {
                        echo '<div class="profile-container-row">';
                        echo '<div class="profile-container-row-cell">';
                        if ( $row["topic_name"] !== null ) {
                            echo '/ <a class="topic-link" href="topic-profile.php?id=' . $row["topic_id"] . '"> +' . $row["topic_name"] . '</a>';
                            echo '<hr class="my-1">';
                        }
                        echo '<p>' . $row["content"] . '</p>';
                        if ( $row["picture_id"] != null ) {
                            echo '<img src="' . $picture_path_server . $row["picture_path"] . '">';
                        }
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo 'Datenbank Fehler';
                    echo 'bitte wende dich an den Administrator';
                }

            } catch ( PDOException $e ) {
                echo "Error!: Bitten wenden Sie sich an den Administrator...<br/>";
                die();
            }

            ?>


        </main>
        <footer>

        </footer>

        <!--Hier stehen die J Query codes welche dann ausgeführt werden wenn das Dokument geladen ist-->
        <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="dist/js/main.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <!-------------------------------Pic Upload------------------------------------------------------------------------>
        <script>
            var loadFile = function (event) {
                var output = document.getElementById('output');
                output.src = URL.createObjectURL(event.target.files[0]);
                var output1 = document.getElementById('output1');
                output1.src = URL.createObjectURL(event.target.files[0]);
            };
        </script>
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
        </body>

        </html>
        <?php
        $db = null;
    } catch ( PDOException $e ) {
        echo "Error!: Bitte wenden Sie sich an den Administrator!?..." . $e;
        die();
    }
    ?>
    <?php
} else {
    header("location:index.php");
}

?>