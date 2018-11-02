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
            <div class="d-flex"><img
                        src=https://img.fotocommunity.com/bb-bilder-9e10eb1c-ede3-47da-a2c5-97692e7faf8c.jpg?width=45&height=45
                        class="img-circle profil-image-small">
                <a class="nav-link active dropdown-toggle" data-toggle="dropdown" href="#"> USERNAME LINK</a>
                <ul class="dropdown-menu navbar-dark bg-dark">
                    <li class="nav-link nav-item"><a href="#"> Abmelden</a></li>
                    <li class="nav-link"><a class="navbar-brand text-center" href="#">
                            <i class="fas fa-cog"></i>
                        </a></li>
                    </li>
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
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Plus - Microblog</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Find</button>
    </form>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">Feed</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="#">Profil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Entdecken</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Einstellungen
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Farbe ändern</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Edit Profile</a>
                </div>
            </li>
        </ul>
        <button type="button" class="btn btn-dark notification-btn">
            News <span class="badge badge-light">8</span>
        </button>
        <li class="nav-item active">
            <div class="d-flex"><img
                        src=https://img.fotocommunity.com/bb-bilder-9e10eb1c-ede3-47da-a2c5-97692e7faf8c.jpg?width=45&height=45
                        class="img-circle profil-image-small">
                <a class="nav-link active dropdown-toggle" data-toggle="dropdown" href="#"> USERNAME LINK</a>
                <ul class="dropdown-menu navbar-dark bg-dark dropdown-user-menu">
                    <li class="nav-link nav-item"><a href="#"> Abmelden</a></li>
                    <li class="nav-link"><a class="navbar-brand text-center" href="#">
                            <i class="fas fa-cog"></i>
                        </a></li>
                </ul>

            </div>
        </li>
    </div>
</nav>

<main class="container"><!--ein Responsive Container in dem der Content steckt-->
    <h1>Hier entsteht der geile Microblog von Team-42!</h1>
    <!--input Box-->
    <form action="#" method="post" class="test">
        <p><label style="color: white;">Blogeintrag:<br>
                <textarea name="post" cols="80" rows="3" placeholder="neuer Eintrag!"
                          maxlength="200"></textarea></label></p>
        <p><input type="submit" value="Posten"></p>
    </form>

</main>
<footer>

</footer>
</body>

</html>