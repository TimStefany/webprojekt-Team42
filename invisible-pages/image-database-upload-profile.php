<?php
session_start();
include_once '../outsourced-php-code/userdata.php';
include_once '../outsourced-php-code/necessary-variables.php';

if (isset($_POST['upload-profile-picture'])) {
    $file = $_FILES['files'];

    $filename = $_FILES['files']['name'];
    $filetmpname = $_FILES['files']['tmp_name'];
    $filesize = $_FILES['files']['size'];
    $fileerror = $_FILES['files']['error'];
    $filetype = $_FILES['files']['type'];

    /*#############################################################################################################
    $filetmpname ist hier das file das beim upload kurzeitig zwischen gespeichert wird als "temporär" solang bis es eben durch die function move_uploaded_file
    dann zu finalen Destination gebracht wird
    $filesize die Filesize wird hier angegeben um diese Später zu überprüfen, diese wird dann auf maximal 2 MB festgelegt um zu viel Speicher inanspruchnahme auf dem Server zu vermeiden
    $filetype beschreibt den Filetype damit dieser auf Bildtypen untersucht werden kann
		###############################################################################################################*/

    $fileext = explode('.', $filename);

    /*#############################################################################################################
    #Hier wird die File endung genommen um Sie dann im Folgeschritt "immer" klein zuschreiben, das wird gemacht damit es keine Probleme mit Dateien wie
    z.b Blabla.JPG gibt
    /*#############################################################################################################*/

    $fileactualext = strtolower(end($fileext));

    //hier lege ich fest welche filetypes hochgeladen werden können

    $allowed = array('jpg', 'jpeg', 'png');

    if (in_array($fileactualext, $allowed)) {
        #error Test
        if ($fileerror === 0) {
            if ($filesize < 20000000) {

                #wenn es unter 20mb ist bekommt es einen unique namen (mit der jeweiligen endung) damit es nicht überschrieben wird

                $filenamenew = uniqid('', true) . "." . $fileactualext;

                $filedestination = $picture_path_upload . 'profile_img/' . $filenamenew;

                //Hier wird das Bild hochgeladen von der ( temporären Position zur vordefinierten

                move_uploaded_file($filetmpname, $filedestination);

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
} else {
    echo 'hier fehlt was';
    die();
}

try {
    $db = new PDO($dsn, $dbuser, $dbpass, $option);

    $user = $_SESSION["user-id"];

    //hier wird das Bild in die Datenbank geschrieben und der Image Path wird in die Datenbank geschrieben

    $query = $db->prepare("INSERT INTO `pictures` (`picture_path`) VALUES (:imgpath);");
    $query->execute(array(":imgpath" => 'profile_img/' . $filenamenew));


    $stmt = $db->prepare("SELECT `picture_id` FROM `pictures` WHERE `picture_path`=:imgpath");

    if ($stmt->execute(array(":imgpath" => 'profile_img/' . $filenamenew))) {
        while ($row = $stmt->fetch()) {
            $picture_id = $row ["picture_id"];
            echo "$picture_id";
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

// im folgenden Schritt wird jetzt das Profilfoto in der Datenbank überschrieben "geupdated"

try {
    $db = new PDO($dsn, $dbuser, $dbpass, $option);

    $query1 = $db->prepare("UPDATE `registered_users` SET `picture_id`=:imgid WHERE `user_id` =:user");
    $query1->execute(array(":imgid" => $picture_id, ':user' => $user));
    var_dump($picture_id);
    header('Location:../profile.php');
} catch (PDOException $e) {
    echo "Error!: Bitten wenden Sie sich an den Administrator...<br/>";
    die();
}
