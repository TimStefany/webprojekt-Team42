<?php
	session_start();

	if ( ! empty( $name ) ) {
		include_once 'userdata.php';
		try {
			$db    = new PDO( $dsn, $dbuser, $dbpass, $option );
			$query = $db->prepare(
				"INSERT INTO `posts` (`post_id`,`user_id`,`topic_id`,`content`,`picture_id`) VALUES (NULL, :name);" );
			$query->execute( array( "name" => $name ) );
			$db = null;
		} catch ( PDOException $e ) {
			echo "Error!: Bitten wenden Sie sich an den Administrator...";
			die();
		}
		header( 'Location: profile.php' );
	} else {
		echo "Error: Bitte alle Felder ausfüllen!<br/>";
	}
?>


