<!-- ToDo
    - Profilbild des Nutzers einfügen
    - Stylen
    - Beiträge des Nutzers ausgeben
    - URL bearbeiten?
    - Aktuellen Nutzer auf die profile.php Seite umleiten
-->
<?php
	session_start();
	include_once 'outsourced-php-code/userdata.php';
	include_once 'outsourced-php-code/necessary-variables.php';

	if ( isset ( $_SESSION["signed-in"] ) ) {

	//User id die über die URL übergeben wird in eine Variable schreiben
	$visited_user = $_GET["id"];

	//Falls der Nutzer auf seinen eigenen Nutzernamen geklickt hat wird er auf seine Profil Seite weitergeleitet
	if ( $visited_user == $_SESSION["user-id"] ) {
		header( 'Location:profile.php' );
		die();
	}

	//Datenbankabfrage um alle Nutzerinformationen zu sammeln
	try {
		$db   = new PDO( $dsn, $dbuser, $dbpass, $option );
		$stmt = $db->prepare( "SELECT user_name, picture_id FROM registered_users WHERE user_id = :user" );
		$stmt->execute( array( ":user" => $visited_user ) );
		while ( $row = $stmt->fetch() ) {
			$user_name = $row ["user_name"];
			$picture   = $row ["picture_id"];
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
    <div class="d-flex"><img
                src=https://img.fotocommunity.com/bb-bilder-9e10eb1c-ede3-47da-a2c5-97692e7faf8c.jpg?width=45&height=45
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
</main class="container container-profile">
<div>
    <h2><?php echo $user_name ?></h2>
</div>
<?php
	/*#############################################################################################################
	   Follow Button bzw Unfollow Button ausgeben
   ###############################################################################################################*/
	try {
		$db   = new PDO( $dsn, $dbuser, $dbpass, $option );
		$stmt = $db->prepare( "SELECT `user_follow_id`, `type` FROM `user_follow_user` WHERE `following_user_id_user` = :user AND `followed_user_id` = :followed" );

		if ( $stmt->execute( array( ":user" => $_SESSION["user-id"], ":followed" => $visited_user ) ) ) {
			$row = $stmt->fetch();
			if ( $row == [] ) {
				echo '<a href="invisible-pages/follow.php?followed_id=' . $visited_user . '&type=2">Folgen</a>';
			} else {
				$follow_id = $row["user_follow_id"];
				echo '<a href="invisible-pages/unfollow.php?followed_id=' . $visited_user . '&type=2&follow_id=' . $follow_id . '">Entfolgen</a>';
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
		Alle Beiträge des Nutzers anzeigen
	###############################################################################################################*/
	echo '<div>';
	echo '<h2>Beiträge von ' . $user_name . ':</h2>';

	try {
		$db   = new PDO( $dsn, $dbuser, $dbpass, $option );
		$stmt = $db->prepare( "SELECT * FROM posts_registered_users_topics_pictures_view WHERE user_id = :user" );

		if ( $stmt->execute( array( ":user" => $visited_user ) ) ) {
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
	}

	echo '</div>';
	}
	else {
		echo '<h1>Sie sind nicht angemeldet</h1>';
		echo '<p>gehen sie hier zu unserer Startseite und melden sie sich an</p><br>';
		echo '<a href="index.php">Startseite</a>';
	} ?>
</main>
<footer>

</footer>
</body>
</html>