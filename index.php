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
                    <button onclick="document.getElementById('id01').style.display='block'" class="btn btn-primary">Registrieren</button>
                </p>
            </form>
        </div>
    </div>
    <!-- Registrieren-->
    <div id="id01" class="modal">

        <form class="modal-content animate" action="#" method='post'>
            <div>
                <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>

            </div>

            <div>
                <label for="uname"><b>Username</b></label>
                <input type="text" placeholder="Benutzername Eingeben" name="benutzername" required>

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Passwort Eingeben" name="passwort" required>

                <label for="psw"><b>Repeat Password</b></label>
                <input type="password" placeholder="Passwort Wiederholen" name="passwort_wiederholung" required>

                <button name='absenden' type="submit">Registrieren</button>
            </div>

            <div class="container" style="background-color:#f1f1f1">
                <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">
                    Cancel
                </button>

            </div>
        </form>
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
