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
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03"
            aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">Plus - Microblog</a>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-light" type="submit"> Find</button>
        </form>
    </div>
        <ul class=" navbar-nav navbar-right collapse navbar-collapse" id="navbarTogglerDemo03">
<!--die Größe sollte 45 px 45 PX sein  Funktion damit sie nur 45px 45px sein können fehlt noch !-->
            <li class="nav-item active">
                <div class="d-flex"><img src=https://img.fotocommunity.com/bb-bilder-9e10eb1c-ede3-47da-a2c5-97692e7faf8c.jpg?width=45&height=45 class="img-circle profil-image-small">
                <a class="nav-link active dropdown-toggle" data-toggle="dropdown" href="#"> USERNAME LINK</a>
                    <ul class="dropdown-menu navbar-dark bg-dark">
                        <li class="nav-link nav-item"><a href="#"> Abmelden</a></li>
                        <li class="nav-link"> <a class="navbar-brand text-center" href="#">
                                <i class="fas fa-cog"></i>
                            </a></li></li>
                    </ul>

                </div>
            </li>
            <li>
                <button type="button" class="btn btn-light">
                    News <span class="badge badge-light">8</span>
                </button>
            </li>
        </ul>
    </div>
</nav>

<main class="container"><!--ein Responsive Container in dem der Content steckt-->
    <h1>Hier entsteht der geile Microblog von Team-42!</h1>
    <!--input Box-->
    <form action="#" method="post" class="test">
        <p><label style="color: white;">Blogeintrag:<br>
                <textarea name="post" cols="80" rows="3" placeholder="neuer Eintrag!" maxlength="200"></textarea></label></p>
        <p><input type="submit" value="Posten"></p>
    </form>

</main>
<footer>

</footer>
</body>

</html>