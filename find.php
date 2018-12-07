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

    <main class="margin-top-19">
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
        <div class="background-login"></div>
        <div class="container">
			<?php
				//##################################################################################################################
				//          Datenbankabfrage um alle Nutzer zu finden
				//##################################################################################################################
				echo '<h2 style="background-color: rgba(235, 236, 235, 0.5);">Nutzer</h2>';
				try {
					$stmt = $db->prepare("SELECT user_id, user_name, picture_path, profile_text FROM registered_users_pictures_view 
                                        WHERE user_name LIKE :search");
					$stmt->execute(array(":search" => $search));
					while ($row = $stmt->fetch()) {
						?>
                        <a class="find-container" href="profile-foreign.php?id=<?php echo $row["user_id"] ?>">
                            <div class="profile-header">
                                <div class="profile-header-cols">
                                    <div class="row">
                                        <div class="col-lg-4 p-3">
											<?php
												if ($row["picture_path"] !== null) {
													?>
                                                    <img class="profile-picture"
                                                         src="<?php echo $picture_path_server . $row["picture_path"]; ?>"
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
				echo '<h2 style="background-color: rgba(235, 236, 235, 0.5);">Topics</h2>';
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

		<?php
	} else {
		header("location:index.php");
	}

?>