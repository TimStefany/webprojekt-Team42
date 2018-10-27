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
<nav>

</nav>
<main class="container"><!--ein Responsive Container in dem der Content steckt-->
    <h1>Hier entsteht der geile Microblog von Team-42!</h1>
    <div class="text-center"> <!--Klasse wird schon von bootstrap mitgegeben-->
        <h3 class='test'>Sie müssen sich zuerst einloggen!</h3>
        <!-- Login-->
        <div class='loginblock'>
            <form action="#" method="post">
                <span>Benutzername:</span><br> <input name="username" type="text"
                                                      placeholder="Benutzername eingeben!"><br>
                Passwort:<br> <input name="password" type="password" placeholder="Passwort eingeben!"><br>
                <p><input name="absenden" class="btn btn-primary" type="submit" value="Login">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        Registrieren
                    </button>
                </p>
            </form>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade registerblock" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registrieren</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action='register.php' method='post'>
                    <div class="modal-body">
                        <label for="uname"><b>Username</b></label>
                        <input type="text" placeholder="Benutzername Eingeben" name="username" required>
                        <br>
                        <label for="psw"><b>Password</b></label>
                        <input type="password" placeholder="Passwort Eingeben" name="password" required>
                        <br>
                        <label for="psw"><b>Repeat Password</b></label>
                        <input type="password" placeholder="Passwort Wiederholen" name="password-repeat" required>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button name='absenden' type="submit" class="btn btn-primary" data-dismiss="modal">
                            Registrieren
                        </button>

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
