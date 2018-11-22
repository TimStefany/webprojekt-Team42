<?php
session_start();
if (isset($_POST['upload'])) {
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

                $_SESSION["imgdatabasename"] = $filenamenew;

                $filedestination = '/home/fs119/public_html/uploads/user_img/' . $filenamenew;
                move_uploaded_file($filetmpname, $filedestination);
                #nach dem upload kommt man wieder auf die folgende Seite
                header("Location:image-database-upload-profile.php");

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
}
?>