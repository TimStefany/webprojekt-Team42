<?php
	session_start();
	if ( isset ( $_SESSION["signed-in"] )) {
		$post = htmlspecialchars( $_POST["post"], ENT_QUOTES, "UTF-8" );
		$topic = htmlspecialchars( $_POST["topic"], ENT_QUOTES, "UTF-8" );
		$user_id =  $_SESSION["user-id"];


		if ( !empty($post)) {
			include_once 'userdata.php';
			try {
				$db    = new PDO( $dsn, $dbuser, $dbpass, $option );
				$query = $db->prepare(
					"INSERT INTO `posts` (`user_id`,`topic_id`,`content`,`picture_id`) VALUES (:user, :topic, :post, :picture );" );
				$query->execute( array( ":user" => $user_id, ":topic" => $topic, ":post" => $post, ":picture" => $picture, ) );
				$db = null;
			} catch ( PDOException $e ) {
				echo "Error!: Bitten wenden Sie sich an den Administrator...";
				die();
			}
			header( 'Location: profile.php' );
		} else {
			echo "Error: Bitte alle Felder ausfüllen!<br/>";
		}
	} else {
		echo '<h1>Sie sind nicht angemeldet</h1>';
		echo '<p>gehen sie hier zu unserer Startseite und melden sie sich an</p><br>';
		echo '<a href="index.php">Startseite</a>';
	}
?>
<?php
