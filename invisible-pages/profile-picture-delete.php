<?php
	session_start();

	$id      = $_SESSION["user-id"];
	include_once "../outsourced-php-code/necessary-variables.php";

	try {
		include_once '../outsourced-php-code/userdata.php';
		$db    = new PDO( $dsn, $dbuser, $dbpass, $option );
		$query = $db->prepare(
			"UPDATE registered_users SET picture_id = :p_id WHERE user_id= :id" );
		$query->execute( array("p_id" => $default_avatar_id, "id" => $id) );
		$db = null;
		header( 'Location: ../profile.php' );
	} catch ( PDOException $e ) {
		echo "Error: Bitten wenden Sie sich an den Administrator!";
		die();
	}
