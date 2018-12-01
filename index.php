<!-- ToDo
    - Buttons im Modal für die Registrierung funktionieren noch nicht
    - Felder für die Anmeldung erfordern noch keine Eingabe
    - Überprüfung ob der Nutzer schon angemeldet ist
-->
<!doctype html>
<html class="no-js" lang="de">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Microblog Team-42</title>
    <meta name="description" content="">
    <?php
    include 'outsourced-php-code/header.php';
    ?>
</head>
<body class="loginpage">
<nav>

</nav>
<main class="container"><!--ein Responsive Container in dem der Content steckt-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12"></div>
                <div class="col-md-4 col-sm-4 col-xs-12 modal-header">
                    <form action="invisible-pages/login-check.php" method="post" class="form-container">
                        <h1>Plus HdM Microblog</h1>
                        <b class="fontnorm">Benutzername:</b><br> <input class="form-control" name="username" type="text"
                                                              placeholder="Benutzername eingeben!"><br>
                        <b class="fontnorm">Passwort</b> <br> <input class="form-control" name="password" type="password" placeholder="Passwort eingeben!"><br>
                        <p><input class= "form-control btn btn-dark btn-block" name="absenden"  type="submit" value="Login">
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
        <div class="modal fade registerblock bg" id="exampleModal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title" id="exampleModalLabel">Registrieren</h1>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action='invisible-pages/register.php' method='post'>
                        <div class="modal-body">
                            <label for="uname"><b>Username</b></label>
                            <input type="text" class="form-control" placeholder="Benutzername Eingeben" name="username" required>
                            <br>
                            <label for="psw"><b>Password</b></label>
                            <input type="password" class="form-control" placeholder="Passwort Eingeben" name="password" required>
                            <br>
                            <label for="psw"><b>Repeat Password</b></label>
                            <input type="password" class="form-control" placeholder="Passwort Wiederholen" name="password-repeat" required>
                            <!-- Button nur vorübergehend bis die folgenden zwei funkitonstüchtig sind -->

                        </div>
                        <!-- Aktuell schließen beide Buttons das Modal und keiner führt die Registrierung aus -->
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
