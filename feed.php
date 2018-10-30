<?php
//muss noch überprüft werden ob diese Anmeldeüberprüfung funktioniert
session_start();
if (isset ($_SESSION["signed-in"])) {
    ?>
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
            <!--input Box-->
            <form action="#" method="post" class="test">
                <p><label style="color: white;">Blogeintrag:<br>
                        <textarea name="post" cols="80" rows="3" placeholder="neuer Eintrag!" maxlength="200"></textarea></label></p>
                <p><input type="submit" value="Posten"></p>
            </form>
            <!--hier kommt noch der feed bitte mal drüber schauen ich bekomme ihn nicht eingepflegt ohne ein html error auszulösen
            vieles kann auch entfernt werden anfangs vllt nur anzeige des contentd biss es läuft-->
            <!--
            <table>
            <thead>
            <th>Datum</th>
            <th>Blogeintrag</th>
            <th>Optionen</th>
            </thead>
            <tbody>
            <?php/*

                $dsn    = "mysql:dbhost=mars.iuk.hdm-stuttgart.de;dbname=u-bk094";
                $dbuser = "bk094";
                $dbpass = "Pie7vier5i";
                $option = array( 'charset' => 'utf8' );

                try {
                $db    = new PDO( $dsn, $dbuser, $dbpass, $option );
                $sql   = "SELECT `content`,`date`,`id` FROM `posts` ORDER BY date DESC";
                $query = $db->prepare( $sql );
                $query->execute();
                $i = 0;

                while ( $zeile = $query->fetchObject() ) {
                    echo "<tr>";
                    echo "<td style='background - color: rgba(128, 128, 128, 0.4);padding: 10px;'>$zeile->date</td>";
                    echo "<td ID='trhintergrund'>$zeile->content</td> ";
                    echo "<td style='background - color: rgba(128, 128, 128, 0.4);padding: 10px;'><a style='color:white' href='edit . php ? id = " . $zeile->id . "'><i class=\"fas fa-edit\"></i></a></td>";
                    echo "</tr>";
                }*/
            ?>
            </tbody>
        </table>-->
        </main>
        <footer>

        </footer>
        </body>

        </html>
        <?php
}
else {
    echo '<h1>Sie sind nicht angemeldet</h1>';
    echo '<p>gehen sie hier zu unserer Startseite und melden sie sich an</p><br>';
    echo '<a href="index.php">Startseite</a>';
}