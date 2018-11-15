<?php
	session_start();
	if ( isset ( $_SESSION["signed-in"] ) ) {
		$post    = htmlspecialchars( $_POST["post"], ENT_QUOTES, "UTF-8" );
		$topic   = htmlspecialchars( $_POST["topic"], ENT_QUOTES, "UTF-8" );
		$user_id = $_SESSION["user-id"];
var_dump($topic);

		include_once 'userdata.php';
		$db1    = new PDO( $dsn, $dbuser, $dbpass, $option );
		$query1 = $db1->prepare(
			"SELECT `topic_id` FROM `topics` WHERE `topic_name` = '".$topic."'" );
		$query1->execute();
		$row1 = $query1->fetch();
		$row = $row1[0];
var_dump($row);

		try {
			$db2    = new PDO( $dsn, $dbuser, $dbpass, $option );
			$query2= $db2->prepare(
				"INSERT INTO `posts` (`user_id`,`topic_id`,`content`,`picture_id`) VALUES (:user, :topic, :post, :picture );" );
			$query2->execute( array(
				":user"    => $user_id,
				":topic"   => $row,
				":post"    => $post,
				":picture" => $picture,
			) );
			$db2 = null;
		} catch ( PDOException $e ) {
			echo "Error!: Bitten wenden Sie sich an den Administrator...";
			die();
		}
		header( 'Location: profile.php' );


	} else {
		echo '<h1>Sie sind nicht angemeldet</h1>';
		echo '<p>gehen sie hier zu unserer Startseite und melden sie sich an</p><br>';
		echo '<a href="index.php">Startseite</a>';
	}
?>

