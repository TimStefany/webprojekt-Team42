<?php
	include 'header.php';

?>
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
                <span>Benutzername:</span><br> <input name="benutzername" type="text"
                                                      placeholder="Benutzername eingeben!"><br>
                Passwort:<br> <input name="passwort" type="password" placeholder="Passwort eingeben!"><br>
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


<script> // Popup Registierung
    // Get the modal
    var modal = document.getElementById('id01');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
<!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
<!--
<script>
    window.ga = function () {
        ga.q.push(arguments)
    };
    ga.q = [];
    ga.l = +new Date;
    ga('create', 'UA-XXXXX-Y', 'auto');
    ga('send', 'pageview')
</script>
<script src="https://www.google-analytics.com/analytics.js" async defer></script>-->
</body>

</html>
