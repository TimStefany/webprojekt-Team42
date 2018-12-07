<?php
session_start();
if (isset ($_SESSION["signed-in"])) {
    header('Location:feed.php');
} else {
    ?>
    <!doctype html>
    <html class="no-js" lang="de">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Microblog Team-42</title>
        <meta name="description" content="">
        <?php
        include "outsourced-php-code/header.php";
        ?>
    </head>
    <body class="loginpage">
    <div class="background-login"></div>
    <nav>

    </nav>
    <main class="container"><!--ein Responsive Container in dem der Content steckt-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4 modal-header">
                    <form action="invisible-pages/login-check.php" method="post" class="form-container">
                        <h1>+Plus HdM</h1>
                        <span class="fontnorm">Benutzername:</span><br> <input class="form-control" name="username"
                                                                               type="text"
                                                                               placeholder="Benutzername eingeben!"
                                                                               required><br>
                        <span class="fontnorm">Passwort</span> <br> <input class="form-control" name="password"
                                                                           type="password"
                                                                           placeholder="Passwort eingeben!"
                                                                           required><br>
                        <p><input class="form-control btn btn-dark btn-block" name="absenden" type="submit"
                                  value="Login">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-success btn-block" data-toggle="modal"
                                    data-target="#exampleModal">
                                Registrieren
                            </button>
                        </p>
                    </form>
                </div>
            </div>
        </div>


        <!-- Modal für die Registrierung -->
        <div class="modal fade registerblock" id="exampleModal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content form-container">
                    <div class="modal-header">
                        <h1 class="modal-title" id="exampleModalLabel">Registrieren</h1>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="invisible-pages/register.php" method="post">
                        <div class="modal-body">
                            <label for="uname"><span class="fontnorm">Nutzername</span></label>
                            <input type="text" class="form-control" placeholder="Benutzername Eingeben" name="username"
                                   required>
                            <br>
                            <label for="psw"><span class="fontnorm">Passwort</span></label>
                            <input type="password" class="form-control" placeholder="Passwort Eingeben" name="password"
                                   required>
                            <br>
                            <label for="psw"><span class="fontnorm">Passwort wiederholen!</span></label>
                            <input type="password" class="form-control" placeholder="Passwort Wiederholen"
                                   name="password-repeat" required>
                        </div>
                        <!-- Registrieren abbrechen und ausführen Buttons -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Zurück</button>
                            <input type="submit" name="absenden" class="btn btn-success" value="Registrieren">
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </main>
    <footer>

    </footer>
    </body>

    </html>
<?php } ?>
