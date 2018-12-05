<?php //kompletter part ursprünglich mal von Tim geschrieben.
/*Todo
    Funktioniert so weit. Wollten wir später vielleicht in die feed.php Seite Integrieren.
    - Passwörter Hashen und Salten
    - effektivität der if Schleife steigern: Abbruch sobald der Name gefunden wurde/ Nur nach diesem Namen in
        der Datenbank suchen
    - Überürüfung für den Startbutton funktioniert so nicht. Alternative finden.
    - Zeile 53 nochmal anschauen wegen der if Schleife
*/

session_start();
include '../outsourced-php-code/userdata.php';
include_once '../outsourced-php-code/necessary-variables.php';
$check = 0;

//if(isset($_POST["absenden"])) { //Kommt vom Registrieren Button
$name = htmlspecialchars($_POST["username"], ENT_QUOTES, "UTF-8");
$passwordraw = htmlspecialchars($_POST["password"], ENT_QUOTES, "UTF-8");
$password_repeat = htmlspecialchars($_POST["password-repeat"], ENT_QUOTES, "UTF-8");




if (!empty($name) & !empty($passwordraw) & !empty($password_repeat)) {

    if ($passwordraw == $password_repeat) {
        //Wenn das Passwort dem Passwort_repeat entspricht wird das PAsswort gehashed
	    $password = password_hash($passwordraw, PASSWORD_DEFAULT);

        $db = new PDO($dsn, $dbuser, $dbpass, $option);

        //sql Befehl zur Überprüfung ob der Nutzername bereits vergeben ist.
        //eventuell optimierung später: Nur nach Nutzernamen mit dem gleichen Anfangsbuchstabe suchen
        $sql = "SELECT `user_name` FROM `registered_users` WHERE 1=1";

        //sql Befehl ausführen
        $query = $db->prepare($sql);
        $query->execute();
        //jede Zeile der Tabelle wird für einen Schleifendurchlauf in die Variable $row geschrieben und anschließend überschrieben
        while ($row = $query->fetch()) {
            if ($row['user_name'] == $name) {
                //if Schleife wird für die gesamte while Schleife ausgeführt: check=1 steht für name vergeben
                $check = 1;
                //Optimierung für Vorgang: Sobalt der Name gefunden wird wird der Schleifendurchlauf beendet.
            }
        }
        if ($check == 1) {
            echo "<h3>Nutzername schon Vergeben, veruche es erneut mit einem anderen!<br/></h3>";
            echo "<a href='../index.php'>Zurück</a>";
            die();
        } else {
            try {
                $query = $db->prepare("INSERT INTO `registered_users` (`user_name`, `user_pass`) VALUES (:name, :pass);");
                $query->execute(array(":name" => $name, ":pass" => $password));
                echo "Sie wurden erfolgreich Registriert<br/>";

                //Follow für die explore Topic hinzufügen
                $sql = "SELECT `user_id` FROM `registered_users` WHERE `user_name`=:user";
                $query = $db->prepare($sql);
                $query->execute(array(":user"=>$name));
                if ($row = $query->fetch())
                $user_id=$row["user_id"];

                $query = $db->prepare("INSERT INTO `user_follow_topic` (`following_user_id_topic`,`followed_topic_id`,`priority`) VALUES (:user,:topic,:priority);");
                $query->execute(array(":user" => $user_id, ":topic" => 1, ":priority" => 1));


                //Zustand Angemeldet in die Session schreiben
                $_SESSION["signed-in"] = 1;

                //user-id in der Session speichern
                $stmt = $db->prepare("SELECT `user_id`, `user_name` FROM `registered_users` WHERE `user_name`=:name AND `user_pass`=:password");
                if ($stmt->execute(array(':name' => $name, ':password' => $password))) {
                    if ($row = $stmt->fetch()) {
                        $_SESSION["user-id"] = $row["user_id"];
                        $_SESSION["user-name"] = $row["user_name"];
                    };
                } else {
                    echo 'Datenbankfehler siehe Zeile 55';
                    die();
                }
                $db = null;
                header('Location:../feed.php');
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
			<a href='../index.php'>zurück</a>";
}
//}
?>



