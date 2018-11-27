<?php
	session_start();

	$id      = $_SESSION["user-id"];
	$text    = htmlspecialchars( $_POST["post"], ENT_QUOTES, "UTF-8" );

	if ( ! empty( $text )) {
		try {
			include_once '../outsourced-php-code/userdata.php';
			$db    = new PDO( $dsn, $dbuser, $dbpass, $option );
			$query = $db->prepare(
				"UPDATE registered_users SET profile_text = :text WHERE user_id= :id" );
			$query->execute( array("text" => $text, "id" => $id) );
			$db = null;
			header( 'Location: ../profile.php' );
		} catch ( PDOException $e ) {
			echo "Error: Bitten wenden Sie sich an den Administrator!";
			die();
		}
	} else {
		echo "Error: Bitte alle Felder ausfüllen!";
	}