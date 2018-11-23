<?php
session_start();
//pushhelp
if (isset ($_SESSION["signed-in"])) {
    $post = htmlspecialchars($_POST["post"], ENT_QUOTES, "UTF-8");
    $topic = htmlspecialchars($_POST["topic"], ENT_QUOTES, "UTF-8");
    $user_id = $_SESSION["user-id"];
    include_once 'userdata.php';

    /*#############################################################################################################
        Ab hier wird getestet ob der Post ein Bild angehängt hat
        ###############################################################################################################*/

    if (isset($_POST['upload-post'])) {
        $file = $_FILES['files'];

        $filename = $_FILES['files']['name'];
        $filetmpname = $_FILES['files']['tmp_name'];
        $filesize = $_FILES['files']['size'];
        $fileerror = $_FILES['files']['error'];
        $filetype = $_FILES['files']['type'];

        var_dump($filename);
        echo "1";

        $fileext = explode('.', $filename);
        #everytime we make it lower case before checking it
        $fileactualext = strtolower(end($fileext));

        #hier lege ich fest welche filetypes hochgeladen werden können
        $allowed = array('jpg', 'jpeg', 'png');

        if (in_array($fileactualext, $allowed)) {
            #error Test
            if ($fileerror === 0) {
                if ($filesize < 2000000) {
                    #wenn es unter 2mb ist bekommt es einen unique namen (mit der jeweiligen endung) damit es nicht überschrieben wird
                    $filenamenew = uniqid('', true) . "." . $fileactualext;

                    var_dump($file);
                    // $_SESSION["imgdatabasename"] = $filenamenew;

                    $filedestination = '/home/fs119/public_html/uploads/post_img/' . $filenamenew;
                    move_uploaded_file($filetmpname, $filedestination);

                    try {
                        $db = new PDO($dsn, $dbuser, $dbpass, $option);

                        $user = $_SESSION["user-id"];

                        $query = $db->prepare("INSERT INTO `pictures` (`picture_path`) VALUES (:imgpath);");
                        $query->execute(array(":imgpath" => $filenamenew));

                        $stmt = $db->prepare("SELECT `picture_id` FROM `pictures` WHERE `picture_path`=:imgpath");
                        if ($stmt->execute(array(":imgpath" => $filenamenew))) {
                            while ($row = $stmt->fetch()) {
                                $picture_id = $row ["picture_id"];
                                //fügt die id von dem Nutzer oder der Topic der gefolgt wird, die topics oder Nutzernamen dem
                                // gefolgt wird und den type jeder Zeile hinten an das Array an.
                            }
                        } else {
                            echo 'Datenbank Fehler';
                            echo 'bitte wende dich an den Administrator';
                        }
                        $stmt = 0;
                    } catch (PDOException $e) {
                        echo "Error!: Bitten wenden Sie sich an den Administrator...<br/>";
                        die();
                    }
                    #hier fängt benny code an der jetzt die picture id in das post feld schickt nachdem die rausgezogen wurde

                } else {
                    echo "Du hast die maximale Dateigröße von 2 Mb überschritten";
                }
            } else {
                echo "Fehler beim uploaden der Datei";
            }
        } else {
            echo "Dieser Dateityp ist nicht erlaubt";
        }

        if (!move_uploaded_file($_FILES['files']['tmp_name'][0], '/uploads/' . $_FILES['files']['name'][0])) {
            echo "error";
        }
        echo "success";

        /*#############################################################################################################
        Dieser Abschnitt schreibt den Post mit Bild (id) in die Datenbank
        ###############################################################################################################*/
        try {

            $db1 = new PDO($dsn, $dbuser, $dbpass, $option);
            $query1 = $db1->prepare(
                "SELECT `topic_id` FROM `topics` WHERE `topic_name` = '" . $topic . "'");
            $query1->execute();
            $row1 = $query1->fetch();
            $row = $row1[0];

            $db2 = new PDO($dsn, $dbuser, $dbpass, $option);
            $query2 = $db2->prepare(
                "INSERT INTO `posts` (`user_id`,`topic_id`,`content`,`picture_id`) VALUES (:user, :topic, :post, :picture);");
            $query2->execute(array(
                ":user" => $user_id,
                ":topic" => $row,
                ":post" => $post,
                ":picture" => $picture_id,
            ));
            $db2 = null;
        } catch (PDOException $e) {
            echo "Error!: Bitten wenden Sie sich an den Administrator...";
            die();
        }

        /*#############################################################################################################
        Dieser Abschnitt schreibt den Post in die Datenbank wenn kein Bild mit geliefert wird
        ###############################################################################################################*/
    } else {

        try {
            $db1 = new PDO($dsn, $dbuser, $dbpass, $option);
            $query1 = $db1->prepare(
                "SELECT `topic_id` FROM `topics` WHERE `topic_name` = '" . $topic . "'");
            $query1->execute();
            $row1 = $query1->fetch();
            $row = $row1[0];

            $db2 = new PDO($dsn, $dbuser, $dbpass, $option);
            $query2 = $db2->prepare(
                "INSERT INTO `posts` (`user_id`,`topic_id`,`content`,`picture_id`) VALUES (:user, :topic, :post, :picture );");
            $query2->execute(array(
                ":user" => $user_id,
                ":topic" => $row,
                ":post" => $post,
                ":picture" => $picture,
            ));
            $db2 = null;
        } catch (PDOException $e) {
            echo "Error!: Bitten wenden Sie sich an den Administrator...";
            die();
        }
        header('Location: profile.php');

    }
} else {
    echo '<h1>Sie sind nicht angemeldet</h1>';
    echo '<p>gehen sie hier zu unserer Startseite und melden sie sich an</p><br>';
    echo '<a href="index.php">Startseite</a>';
}

