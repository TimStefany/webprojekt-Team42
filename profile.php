<?php
include 'header.php';

?>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#"> Mein Profil <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"> Mein Feed</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="#"> Explore Motherfucker</a>

            </li>

        </ul>

        <a class="navbar-brand" href="#">
            <i class="fas fa-plus-circle"> Einstellung</i>

        </a>

        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
</nav>

<main class="container"><!--ein Responsive Container in dem der Content steckt-->
    <h1>Hier entsteht der geile Microblog von Team-42!</h1>

</main>
<footer>

</footer>
</body>

</html>