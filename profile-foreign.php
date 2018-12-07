<!-- ToDo
   - Stylen
-->
<?php
	session_start();
	include_once 'outsourced-php-code/userdata.php';
	include_once 'outsourced-php-code/necessary-variables.php';
	include_once 'outsourced-php-code/select-profile-funktion.php';

	//ausführen der Funktion, um alle Benutzerinformationen in eine Variable zu schreiben und die des besuchten Profils in eine andere
	$user_information     = get_profile_information( $_SESSION["user-id"] );
	$profile_information  = get_profile_information( $_GET["id"] );
	$profile_foreign_text = $_GET["id"];

	if ( isset ( $_SESSION["signed-in"] ) ) {

	//User id die über die URL übergeben wird in eine Variable schreiben
	$visited_user = $_GET["id"];

	//Falls der Nutzer auf seinen eigenen Nutzernamen geklickt hat wird er auf seine Profil Seite weitergeleitet
	if ( $visited_user == $_SESSION["user-id"] ) {
		header( 'Location:profile.php' );
		die();
	}

	//Datenbankabfrage um alle Nutzerinformationen zu sammeln

	$user_name = $profile_information[0];

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
                <a class="btn btn-dark mx-0 my-1 form-inline" href="invisible-pages/logout.php"
                   role="button">Ausloggen</a>
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
                <div style="max-height:<?php echo( $notification_dropdown * 59 ) ?>px;">

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
					if ( $user_information[2] !== "" ) {
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
                                    <input class="form-control" name="topic" id="tags">
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
    <div class="profile-header">
        <div class="profile-header-cols">
            <div class="row">
                <div class="col-lg-4 p-3">
					<?php
						if ( $profile_information[2] !== "" ) {
							?>
                            <img class="profile-picture"
                                 src="<?php echo $picture_path_server . $profile_information[2]; ?>" alt="Profilbild">
							<?php
						} else { //default Profilbild
							?>
                            <img class="profile-picture"
                                 src="<?php echo $picture_path_server . $default_avatar_path; ?>" alt="Profilbild">
							<?php
						} ?>
                </div>

                <div class="col-lg-8 p-5">
                    <div>
                        <h1 class="profile-topic-headline"><?php echo $profile_information[0]; ?></h1>
                    </div>
                    <hr>
					<?php
						$user = $_SESSION["user-id"];

						try {
							$db    = new PDO( $dsn, $dbuser, $dbpass, $option );
							$sql   = "SELECT profile_text FROM registered_users WHERE user_id = :user;";
							$query = $db->prepare( $sql );
							$query->execute( array( ":user" => $profile_foreign_text ) );

							$zeile = $query->fetch();
							//Hinzufügen einer Erklärung für den Profiltext falls keiner vorhanden ist
							if ( $zeile["profile_text"] == null ) {
								$zeile["profile_text"] = "Kein Profiltext vorhanden.";
							}
							echo "<span class='profile-headline'>Profiltext:</span>";
							echo "<div><p>" . $zeile["profile_text"] . "</p></div>";
							$db = null;
						} catch ( PDOException $e ) {
							echo "Error!: Bitte wenden Sie sich an den Administrator!?..." . $e;
							die();
						}
					?>
                    <hr>
					<?php
						try {
							$db   = new PDO( $dsn, $dbuser, $dbpass, $option );
							$stmt = $db->prepare( "SELECT `user_follow_id`, `type` FROM `user_follow_user` WHERE `following_user_id_user` = :user AND `followed_user_id` = :followed" );

							if ( $stmt->execute( array(
								":user"     => $_SESSION["user-id"],
								":followed" => $visited_user
							) ) ) {
								$row = $stmt->fetch();
								if ( $row == [] ) {
									echo '<div><a href="invisible-pages/follow.php?followed_id=' . $visited_user . '&type=2"><button type="button" class="btn btn-dark">
                                Folgen
                                </button></a></div>';
								} else {
									$follow_id = $row["user_follow_id"];
									echo '<div><a href="invisible-pages/unfollow.php?followed_id=' . $visited_user . '&type=2&follow_id=' . $follow_id . '"><button type="button" class="btn btn-dark">
                                Entfolgen
                                </button></a></div>';
								}
							} else {
								echo 'Datenbank Fehler';
								echo 'bitte wende dich an den Administrator';
							}


						} catch ( PDOException $e ) {
							echo "Error!: Bitten wenden Sie sich an den Administrator...<br/>";
							die();
						} ?>

                </div>
            </div>
        </div>
    </div>
    <hr>
	<?php
		/*#############################################################################################################
			Alle Beiträge des Nutzers anzeigen
		###############################################################################################################*/
		echo '<div class="profile-transparent-bg">';
		echo '<h2>Beiträge von ' . $user_name . ':</h2>';

		try {
			$db   = new PDO( $dsn, $dbuser, $dbpass, $option );
			$stmt = $db->prepare( "SELECT * FROM posts_registered_users_topics_pictures_view WHERE user_id = :user" );

			if ( $stmt->execute( array( ":user" => $visited_user ) ) ) {
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

		echo '</div>';
		}
		else {
			header( "location:index.php" );
		}
	?>

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