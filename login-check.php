<?php
/*Todo
    Funktioniert so weit. Wollten wir später vielleicht in die feed.php Seite Integrieren.
    - Passwörter Hashen und Salten
*/
session_start();
include_once 'userdata.php';

//übernehmen der Variablen aus dem Vormular der Startseite
if(isset($_POST["username"]) AND isset($_POST["password"])){
    $name     = htmlspecialchars( $_POST["username"], ENT_QUOTES, "UTF-8" );
    $password = htmlspecialchars( $_POST["password"], ENT_QUOTES, "UTF-8" );
}
//Abfangen falls keine Daten übergeben wurden
else {
    echo '<h1>Keine Daten übergeben</h1>';
    echo '<p>Du hast keine vollständigen Daten zur anmeldung übergeben. Probiers nochmal.</p><br>';
    echo '<a href="index.php">Startseite</a>';
    die();
}

//sql Statement überprüft Nutzernamen und Passwort auf einmal. Hat nur ein ergebnis wenn beide Daten stimmen.
$db    = new PDO( $dsn, $dbuser, $dbpass, $option );
$stmt = $db->prepare( "SELECT `user-id` FROM `registered_users` WHERE `user-name`=:name AND `user-pass`=:password");


if ($stmt->execute(array(':name'=>$name, ':password'=>$password))){
    if($row=$stmt->fetch()) {
        //Wenn das Statement ein Ergebnis liefert haben die Zugangsdaten gestimmt - Session Angemeldet wird gesetzt und ID gespeichert
        $_SESSION["signed-in"]=1;
        $_SESSION["user-id"]=$row["user-id"];
        header('Location: feed.php');
    }
    else {
        echo'<h1>Ungültige Zugangsdaten</h1>';
        echo'<p>Deine eingegebenen Daten sind leider falsch. Probiers nochmal</p><br>';
        echo'<a href="index.php">Startseite</a>';
    }
}
else {
    echo "Datenbank-Fehler:";
    echo $stmt->errorInfo()[2];
    echo $stmt->queryString;
    die();
}

