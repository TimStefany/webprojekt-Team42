<?php
session_start();
include_once '../outsourced-php-code/userdata.php';
//TEst
if (isset($_POST['upload-profile'])) {
    $file = $_FILES['files'];

    $filename = $_FILES['files']['name'];
    $filetmpname = $_FILES['files']['tmp_name'];
    $filesize = $_FILES['files']['size'];
    $fileerror = $_FILES['files']['error'];
    $filetype = $_FILES['files']['type'];

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


                // $_SESSION["imgdatabasename"] = $filenamenew;

                $filedestination = '/home/fs119/public_html/uploads/user_img/' . $filenamenew;
                move_uploaded_file($filetmpname, $filedestination);
                #nach dem upload kommt man wieder auf die folgende Seite

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

    $query = $db->prepare("INSERT INTO `pictures` (`picture_path`) VALUES (:imgpath);");
    $query->execute(array(":imgpath" => $filenamenew));

    $stmt = $db->prepare("SELECT `picture_id` FROM `pictures` WHERE `picture_path`=:imgpath");

    if ($stmt->execute(array(":imgpath" => $filenamenew))) {
        while ($row = $stmt->fetch()) {
            $picture_id = $row ["picture_id"];
            echo "$picture_id" ;
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

try{
    $db = new PDO($dsn, $dbuser, $dbpass, $option);

    $query1 = $db->prepare("UPDATE `registered_users` SET `picture_id`=:imgid WHERE `user_id` =:user");
    $query1->execute(array(":imgid" => $picture_id, ':user' => $user));
    var_dump($picture_id);
    //header('Location:profile.php');
}
catch (PDOException $e) {
    echo "Error!: Bitten wenden Sie sich an den Administrator...<br/>";
    die();
}
