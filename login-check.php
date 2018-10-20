<?php
	include 'header.php';

?>
<body>
<?php
	session_start();
	$name     = htmlspecialchars( $_POST["username"], ENT_QUOTES, "UTF-8" );
	$passwort = htmlspecialchars( $_POST["password"], ENT_QUOTES, "UTF-8" );

	$_SESSION['name'] = $name;

	$dsn    = ""; //Datenbankverbindung angeben.
	$dbuser = "";
	$dbpass = "";
	$option = array( 'charset' => 'utf8' );

	$db    = new PDO( $dsn, $dbuser, $dbpass, $option );
	$query = $db->prepare( "SELECT `id` FROM `users` WHERE `benutzername`=:name" );
	$query->execute( array( "name" => $name ) );
	$zeile = $query->fetchObject();
	//echo $zeile->id;

	$db    = new PDO( $dsn, $dbuser, $dbpass, $option );
	$query = $db->prepare( "SELECT `id` FROM `users` WHERE (`passwort`=:passwort)AND (`benutzername`=:Hallo)" );
	$query->execute( array( "passwort" => $passwort, "Hallo" => $name ) );
	$zeile2 = $query->fetchObject();
	//echo $zeile2->id;

	if ( $zeile == false && $zeile2 == false ) {
		echo "Sie haben eine falsches Passwort oder einen falschen Benutzernamen<br/>eingegeben. Bitte versuchen sie es erneut!<br/>";
		echo '<a href="login.php"><h3>Zurück zum Login</h3></a>';
		session_destroy();
	} else if ( $zeile == $zeile2 ) {
		header( 'Location: formlular.php' );
	} else {
		echo "Sie haben eine falsches Passwort oder einen falschen Benutzernamen<br/>eingegeben. Bitte versuchen sie es erneut!<br/>";
		echo '<a href="index.php"><h3>Zurück zum Login</h3></a>';
	}
?>

</body>
</html>


