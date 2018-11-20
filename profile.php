<?php
session_start();
include_once 'userdata.php';

if (isset ($_SESSION["signed-in"])) {


    ?>
    <!doctype html>

    <html class="no-js" lang="de">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Microblog Team-42</title>
        <meta name="description" content="">
        <?php
        include 'header.php';
        ?>

    </head>
    <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Plus - Microblog</a>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Find</button>
        </form>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="feed.php">Feed</a>
                </li>
            </ul>
        </div>
        <a href="#">
            <button type="button" class="btn btn-light">
                News <span class="badge badge-light">8</span>
            </button>
        </a>
        <div class="d-flex"><img
                    src=https://img.fotocommunity.com/bb-bilder-9e10eb1c-ede3-47da-a2c5-97692e7faf8c.jpg?width=45&height=45
                    class="img-circle profil-image-small">
            <a href="profile.php" class="nav-item active nav-link username">USERNAME </a>
            <a class="nav-link dropdown-toggle username" href="#" id="navbarDropdown" role="button"
               data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
            </a>
            <div class="dropdown-menu dropdown-user-menu bg-dark" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Farbe ändern</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Edit Profile</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php">Ausloggen</a>
            </div>
        </div>
    </nav>

    <main class="container"><!--ein Responsive Container in dem der Content steckt-->
        <h1>Hier entsteht der geile Microblog von Team-42!</h1>
        <!--input Box-->
        <form action="post.php" method="post" class="test">
            <p><label style="color: white;">Blogeintrag:<br>
                    <textarea name="post" cols="80" rows="3" placeholder="neuer Eintrag!"
                              maxlength="200"></textarea></label></p>

            <p><input type="submit" value="Posten"></p>
        </form>
        <div class="container">
            <!-- Standar Form -->
<!--            enctype muss rein weil es wichtig für die übergabe des IMGs ist-->
<!--            specifies how the form data should be encoded-->
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <div class="form-inline">
                    <div class="form-group">
                        <input type="file" name="files" accept="image/*" onchange="loadFile(event)" >
                        <img id="output"/>
                    </div>
                    <button type="submit" name="upload" class="btn btn-sm btn-primary">Upload files</button>
                </div>
            </form>
            <div class="jquery-script-clear"></div>
        </div>

    </main>
    <footer>

    </footer>

    <!--Hier stehen die J Query codes welche dann ausgeführt werden wenn das Dokument geladen ist-->
    <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="dist/js/dropzone.js"></script>
    <script type="text/javascript" src="dist/js/main.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        var loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>

    </html>
    <?php
} else {
    echo '<h1>Sie sind nicht angemeldet</h1>';
    echo '<p>gehen sie hier zu unserer Startseite und melden sie sich an</p><br>';
    echo '<a href="index.php">Startseite</a>';
}
?>