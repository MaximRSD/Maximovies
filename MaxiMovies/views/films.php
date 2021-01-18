<?php
session_start();
if (isset($_GET['id'])) {
    $_SESSION['taal'] = $_GET['id'];
}
require("../controller/MoviesClasses.php");
$mc = new MoviesClasses();

?>
<!DOCTYPE html>
<html>

<head>
    <title>Maximovies - Films</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="favlogo.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/main.css">
</head>

<body style="background-color: #202020;">
    <?php
    if (isset($_SESSION['username'])) {
        echo '<div class="info-top">
                <a href="uitloggen.php" class="inlogclass d-inline">uitloggen</a><p class="d-inline">, ' . $_SESSION["username"] . '</p>
            </div>';
    } else {
        echo '<div class="info-top">
                <a href="inlog.php" class="inlogclass">inloggen</a>
            </div>';
    }
    ?>
    <nav id="stickynav" class="navbar navbar-expand-lg navbar-dark bg-dark">
        <img src="../pic/logow.png" alt="logo" href="index.php" class="logo">
        <a class="navbar-brand" style=" text-transform: uppercase;" href="index.php"><span style="color: teal;">Maxi</span>movies</a> <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="films.php">Films</a>
                </li>
                <?php
                if (isset($_SESSION['username']) && $_SESSION['username'] == 'Maxim') {
                    echo '
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Meer
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="opslaanfilm.php">Film toevoegen</a>
                        <a class="dropdown-item" href="#"></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>';
                } else {
                    echo "";
                }
                ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Talen
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php
                        $talen = $mc->getLanguage();
                        foreach ($talen as $taal) {
                        ?> <a class="dropdown-item" href="films.php?id=<?php echo $taal->id ?>"><?php echo $taal->taal; ?></a>
                        <?php } ?>
                    </div>
                </li>
                <li class="nav-item">
                <li class="nav-link">
                    <?php
                    switch ($_SESSION['taal']) {
                        case 1:
                            echo '<img src="../pic/united-kingdom.png" style="width:22.5px;">';
                            break;
                        case 2:
                            echo '<img src="../pic/netherlands.png" style="width:22.5px;">';
                            break;
                    }

                    // if ($_SESSION['taal'] == 1) {
                    //     echo '<img src="pic/united-kingdom.png" style="width:22.5px;">';
                    // } else if ($_SESSION['taal'] == 2) {
                    //     echo '<img src="pic/netherlands.png" style="width:22.5px;">';
                    // } else if ($_SESSION['taal'] == 1) {
                    //     echo '<img src="pic/united-kingdom.png" style="width:22.5px;">';
                    // } else if ($_SESSION['taal'] == 2) {
                    //     echo '<img src="pic/netherlands.png" style="width:22.5px;">';
                    // }
                    ?>
                </li>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" method="POST">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" name="txtSearch" aria-label="Search">
                <button id="Zoek" class="btn btn-outline-success my-2 my-sm-0" type="submit" name="btnZoeken">Zoek</button>
            </form>
            <?php
            if (isset($_POST['btnZoeken'])) {
                $search = $_POST['txtSearch'];
                header("Location: films.php?search=$searcht&id=$tid");
            }
            ?>
        </div>
    </nav>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <br /><br />
    <main>
        <div>
            <?php
            if (isset($_GET["search"]) && $_GET["tid"]) {
                $tid = $_GET["tid"];
                $search = $_GET["search"];
                $movie = $mc->searchMovie($search, $tid);
            } else {
                $film = $mc->alleFilm($_SESSION['taal']);
            }
            ?>
        </div>
    </main>

    <footer>
        <div class="footerdiv">
            <a class="navbar-brand h3color" style=" text-transform: uppercase;" href="index.php"><span style="color: teal;">Maxi</span>movies</a>
            <a href="#" class="fa fa-facebook"></a>
            <a href="#" class="fa fa-twitter"></a>
            <a href="#" class="fa fa-instagram"></a>
        </div>
    </footer>
</body>

</html>