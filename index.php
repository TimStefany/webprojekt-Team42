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
                <p><input name="absenden" class="btn btn-primary" type="submit" value="Login"></p>
            </form>
        </div>
    </div>

</main>
<footer>

</footer>

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
