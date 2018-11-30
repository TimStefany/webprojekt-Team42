<!-- ToDo
    - Stylen
    - URL bearbeiten?
-->
<?php
	session_start();
	include_once 'outsourced-php-code/userdata.php';
	include_once 'outsourced-php-code/necessary-variables.php';
	include_once 'outsourced-php-code/select-profile-funktion.php';

	//ausführen der Funktion, um alle Benutzerinformationen in eine Variable zu schreiben
	$user_information = get_profile_information( $_SESSION["user-id"] );

	if ( isset ( $_SESSION["signed-in"] ) ) {

	//Topic id die über die URL übergeben wird in eine Variable schreiben
	$visited_topic = $_GET["id"];

	//Datenbankabfrage um alle Nutzerinformationen zu sammeln
	try {
		$db   = new PDO( $dsn, $dbuser, $dbpass, $option );
		$stmt = $db->prepare( "SELECT topic_name FROM topics WHERE topic_id = :topic" );
		$stmt->execute( array( ":topic" => $visited_topic ) );
		while ( $row = $stmt->fetch() ) {
			$topic_name = $row ["topic_name"];
		}
	} catch ( PDOException $e ) {
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
<main class="container container-topic">
    <div class="profile-header p-4">
    <div>
	    <?php
		    echo '<h1 class="profile-topic-headline">'.$topic_name.'</h1>';
		/*#############################################################################################################
			Follow Button bzw Unfollow Button ausgeben
		###############################################################################################################*/
		try {
			$db   = new PDO( $dsn, $dbuser, $dbpass, $option );
			$stmt = $db->prepare( "SELECT `topic_follow_id`, `type` FROM `user_follow_topic` WHERE `following_user_id_topic` = :user AND `followed_topic_id` = :topic" );

			if ( $stmt->execute( array( ":user" => $_SESSION["user-id"], ":topic" => $visited_topic ) ) ) {
				$row = $stmt->fetch();
				if ( $row == [] ) {
					echo '<a href="invisible-pages/follow.php?followed_id=' . $visited_topic . '&type=1"><button type="button" class="btn btn-primary">
               Folgen
            </button></a>';
				} else {
					$follow_id = $row["topic_follow_id"];
					echo '<a href="invisible-pages/unfollow.php?followed_id=' . $visited_topic . '&type=1&follow_id=' . $follow_id . '"><button type="button" class="btn btn-primary">
               Entfolgen
            </button></a>';
				}

			} else {
				echo 'Datenbank Fehler';
				echo 'bitte wende dich an den Administrator';
			}


		} catch ( PDOException $e ) {
			echo "Error!: Bitten wenden Sie sich an den Administrator...<br/>";
			die();
		}

		/*#############################################################################################################
			Alle Beiträge der Topic anzeigen
		###############################################################################################################*/
		echo '</div>';
		echo '</div>';
		echo '<div>';
		echo '<h2>Beiträge in ' . $topic_name . ':</h2>';

		try {
			$db   = new PDO( $dsn, $dbuser, $dbpass, $option );
			$stmt = $db->prepare( "SELECT * FROM posts_registered_users_topics_pictures_view WHERE topic_id = :topic" );

			if ( $stmt->execute( array( ":topic" => $visited_topic ) ) ) {
				while ( $row = $stmt->fetch() ) {
					echo '<div class="profile-container-row">';
					echo '<div class="profile-container-row-cell">';
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
		}?>

<?php
		echo '</div>';
		} else {
		echo '<h1>Sie sind nicht angemeldet</h1>';
		echo '<p>gehen sie hier zu unserer Startseite und melden sie sich an</p><br>';
		echo '<a href="index.php">Startseite</a>';
	}
	?>
</main>
<footer>
</footer>
</body>
</html>
