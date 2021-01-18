<?php
session_start();
require("../controller/MoviesClasses.php");
$mc = new MoviesClasses();
$film = $mc->getFilm($_GET["id"]);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Maximovies</title>
    <link rel="icon" type="image/png" href="favlogo.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/main.css">
</head>
<div class="layeredit">

    <body style="background-image: url(<?php echo 'data:image/jpeg;base64,' . base64_encode($film->backgroundimg); ?>); background-repeat: no-repeat;  background-size: cover;">
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
                        <a class="nav-link" href="views/index.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="views/films.php">Films</a>
                    </li>
                    <?php
                    if (isset($_SESSION['username']) && $_SESSION['username'] == 'Maxim') {
                        echo '
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Meer
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="views/opslaanfilm.php">Film toevoegen</a>
                        <a class="dropdown-item" href="#"></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>';
                    } else {
                        echo "";
                    }
                    ?>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0" method="POST">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" name="txtSearch" aria-label="Search">
                    <button id="Zoek" class="btn btn-outline-success my-2 my-sm-0" type="submit" name="btnZoeken">Zoek</button>
                </form>
                <?php
                if (isset($_POST['btnZoeken'])) {
                    $search = $_POST['txtSearch'];
                    header("Location: views/films.php?search=$search");
                }
                ?>
            </div>
        </nav>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <main>

            <br />
            <br />
            <div class="container" style="margin-top: 20px;">
                <h1 class="text-center white"><span style="color: teal">EDIT </span> FILM</h1>
                <form class="white" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="txtNaam">Film naam:</label>
                        <input type="text" class="form-control" name="txtNaam" value="<?php echo $film->naam; ?>">
                    </div>
                    <div class="form-group">
                        <label for="txtPrijs">prijs:</label>
                        <input type="text" class="form-control" name="txtPrijs" value="<?php echo $film->prijs; ?>">
                    </div>
                    <div class="form-group">
                        <label for="txtDescription">Beschrijving:</label>
                        <textarea class="form-control" name="txtDescription" rows="3"><?php echo $film->beschrijving; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="txtTrailer">Trailer url:<br>
                            https://www.youtube.com/embed</label><br><input type="text" class="form-control" name="txtTrailer" value="<?php echo $film->trailer; ?>">
                    </div>
                    <div class="form-group">
                        <label for="cbGenre">Genre:</label>
                        <select class="form-control" name="cbGenre">
                            <?php
                            $mc->getGenreCB($film->genreId);
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="txtDuur">Duur:</label>
                        <input type="number" class="form-control" name="txtDuur" value="<?php echo $film->duur ?>">
                    </div>
                    <div class="form-group">
                        <label for="bestand">Afbeelding:</label><br>
                        <input class="opslaanbutton" type="file" name="bestand">
                        <?php $filmafb = $mc->IdFilm($_GET["id"]) ?>
                    </div>
                    <div class="form-group">
                        <label for="dpDate">ReleaseDatum:</label>
                        <input type="date" class="form-control" name="dpDate" value="<?php echo $film->releasedatum ?>">
                    </div>
                    <div class="form-group">
                        <label for="dpBiosDate">BioscoopDatum:</label>
                        <input type="date" class="form-control" name="dpBiosDate" value="<?php echo $film->bioscoopdatum ?>">
                    </div>
                    <div class="form-group">
                        <label for="bestand1">Achtergrond-afbeelding: </label><br>
                        <input class="opslaanbutton" type="file" name="bestand1">
                    </div>
                    <div class="form-group">
                        <label for="cbGenre">Talen:</label>
                        <select class="form-control" name="cbTaal">
                            <?php
                            $mc->getTaalCB($film->tid);
                            ?>
                        </select>
                    </div>
                    <input class="opslaanbutton" type="submit" value="Submit" name="btnSubmit">
                </form>
                <br />
            </div>
            <?php
            if (isset($_POST['btnSubmit'])) {
                $id = $_GET['id'];
                $naam = $_POST['txtNaam'];
                $prijs = $_POST['txtPrijs'];
                $beschrijving = $_POST['txtDescription'];
                $trailer = $_POST['txtTrailer'];
                $genreId = $_POST['cbGenre'];
                $duur = $_POST['txtDuur'];
                $afbeelding = $_FILES['bestand']['tmp_name'];
                $releasedatum = $_POST['dpDate'];
                $bioscoopdatum = $_POST['dpBiosDate'];
                $backgroundimg = $_FILES['bestand1']['tmp_name'];
                $tid = $_POST['cbTaal'];

                $mc->updateFilm($id, $naam, $prijs, $beschrijving, $trailer, $genreId, $duur, $afbeelding, $releasedatum, $bioscoopdatum, $backgroundimg, $tid);
            }
            ?>
            <main>
                <footer>
                    <div class="footerdiv">
                        <a class="navbar-brand h3color" style=" text-transform: uppercase;" href="index.php"><span style="color: teal;">Maxi</span>movies</a>
                        <a href="#" class="fa fa-facebook"></a>
                        <a href="#" class="fa fa-twitter"></a>
                        <a href="#" class="fa fa-instagram"></a>
                    </div>
                </footer>
    </body>
</div>

</html>