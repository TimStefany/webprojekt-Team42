<?php  //kompletter part ursprünglich mal von Tim geschrieben.
//Funktioniert so weit. Wollten wir später vielleicht in die feed.php Seite Integrieren.
session_start();
include 'userdata.php';
$check=0;

if(isset($_POST["absenden"])) { //Kommt vom Registrieren Button
    $name = htmlspecialchars($_POST["username"], ENT_QUOTES, "UTF-8");
    $passwort = htmlspecialchars($_POST["password"], ENT_QUOTES, "UTF-8");
    $passwort_wiederholen = htmlspecialchars($_POST["password-repeat"], ENT_QUOTES, "UTF-8");

    if (!empty($name) & !empty($passwort) & !empty($passwort_wiederholen)) {

        if ($passwort == $passwort_wiederholen) {
            $db = new PDO($dsn, $dbuser, $dbpass, $option);

            //sql Befehl zur Überprüfung ob der Nutzername bereits vergeben ist.
			//eventuell optimierung später: Nur nach Nutzernamen mit dem gleichen Anfangsbuchstabe suchen
            $sql = "SELECT `user-name` FROM `registered-users` WHERE 1=1";

			//sql Befehl ausführen
            $query = $db->prepare($sql);
            $query->execute();
            //jede Zeile der Tabelle wird für einen Schleifendurchlauf in die Variable $row geschrieben und anschließend überschrieben
            while ($row = $query->fetch()) {
                if ($row['user-name'] == $name) {
                    //if Schleife wird für die gesamte while Schleife ausgeführt: check=1 steht für name vergeben
                    $check = 1;
                    //Optimierung für Vorgang: Sobalt der Name gefunden wird wird der Schleifendurchlauf beendet.
                }
            }
            if ($check == 1) {
                echo "<h3>Nutzername schon Vergeben, veruche es erneut mit einem anderen!<br/></h3>";
                echo "<a href='index.php'>Zurück</a>";
            } else {
                try {
                    $query = $db->prepare(
                        "INSERT INTO `registered-users` (`user-name`, `user-pass`) VALUES (:name, :pass);");
                    $query->execute(array(":name" => $name, ":pass" => $passwort));
                    $db = null;
                    echo "Sie wurden erfolgreich Registriert<br/>";
                    //Zustand Angemeldet in die Session schreiben
                    $_SESSION["signed-in"] = 1;
                } catch (PDOException $e) {
                    echo "Error!: Bitten wenden Sie sich an den Administrator...<br/>";
                    die();
                }
            }
        } else {
            echo "Die Passwörter stimmen nicht Überein!<br/>";
        }
    } else {
        echo "Error: Bitte alle Felder ausfüllen!<br/>
			<a href='index.php'>zurück</a>";
    }
}
header('Location:feed.php');
?>



