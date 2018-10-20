<?php  //kompletter part ursprünglich mal von Tim geschrieben.
	$check=0;
	if(isset($_POST["absenden"])): //Kommt vom Registrieren Button
		$name = htmlspecialchars($_POST["username"], ENT_QUOTES, "UTF-8");
		$passwort = htmlspecialchars($_POST["password"], ENT_QUOTES, "UTF-8");
		$passwort_wiederholen = htmlspecialchars($_POST["password-repeat"], ENT_QUOTES, "UTF-8");

		if (!empty($name)&!empty($passwort)&!empty($passwort_wiederholen)) {
			$dsn = "";        // Hier Datenbank anbinden
			$dbuser = "";
			$dbpass = "";
			$option = array('charset' => 'utf8');
			if ($passwort==$passwort_wiederholen){
				$db = new PDO($dsn, $dbuser, $dbpass, $option);
				$sql = "SELECT `benutzername` FROM `users` WHERE 1";
				$query = $db->prepare($sql);
				$query->execute();
				while ($row=$query->fetch()) {
					if ($row['benutzername'] == $name){
						//if schleife wird für die gesamte while Schleife ausgeführt: check=1 steht für name vergeben
						$check=1;
					}
				}
				if ($check==1){
					echo "<h3>Nutzername schon Vergeben, veruche es erneut mit einem anderen!<br/></h3>";
				} else {
					try {
						$query = $db->prepare(
							"INSERT INTO `users` (`id`, `benutzername`, `passwort`) VALUES (NULL, :name, :passwort);");
						$query->execute(array("name" => $name, "passwort" => $passwort));
						$db = null;
						echo "Sie wurden erfolgreich Registriert<br/>";
					} catch (PDOException $e) {
						echo "Error!: Bitten wenden Sie sich an den Administrator...<br/>";
						die();
					}
				}
			}else{
				echo "Die Passwörter stimmen nicht Überein!<br/>";
			}
		}
		else {
			echo "Error: Bitte alle Felder ausfüllen!<br/>";
		}
	endif;
	header('Location:index.php');
?>



