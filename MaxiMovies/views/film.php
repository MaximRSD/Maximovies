<?php session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Maximovies</title>
    <script src="https://kit.fontawesome.com/cd5c74d312.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/png" href="favlogo.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/main.css">
</head>

<body>
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
                <li class="nav-item">
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
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" method="POST">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" name="txtSearch" aria-label="Search">
                <button id="Zoek" class="btn btn-outline-success my-2 my-sm-0" type="submit" name="btnZoeken">Zoek</button>
            </form>
            <?php
            if (isset($_POST['btnZoeken'])) {
                $search = $_POST['txtSearch'];
                header("Location: films.php?search=$search");
            }
            ?>
        </div>
    </nav>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <main>
        <br /><br /><br />

        <div class="filmecho">
            <?php
            require("../controller/MoviesClasses.php");
            $mc = new MoviesClasses();


            $film = $mc->getFilm($_GET["id"]);
            ?>

            <body style="background-image: url(<?php echo 'data:image/jpeg;base64,' . base64_encode($film->backgroundimg); ?>); background-repeat: no-repeat;  background-size: cover;">
                <div class="echofilminfo">
                    <div class="filmimg"><?php echo '<img src="data:image/jpeg;base64,' . base64_encode($film->afbeelding) . '" width="325px" heigth="auto" />'; ?></div>
                    <div class="filmbeschrijving">
                        <div class="bold"><?php echo $film->naam; ?></div>
                        <div><?php echo $film->duur . " min"; ?></div>
                        <div><?php echo "€ " . $film->prijs; ?></div>
                        <div><i class="fas fa-film"></i><?php echo " $film->name"; ?></div>
                        <br />
                        <div></br> <?php echo $film->beschrijving; ?></div>
                        <br /><br />
                        <div><?php echo "Releasedatum " . $film->releasedatum; ?></div>
                        <div><?php echo "Bioscoopdatum " . $film->bioscoopdatum; ?></div>
                        <?php
                        if (isset($_SESSION['username']) && $_SESSION['username'] == 'Maxim') {
                            echo '<a class="editbutton" href="editfilm.php?id=' . $film->Id . '">Edit</a>   <a class="editbutton" data-toggle="modal" data-target="#deletePopup">
                            Verwijderen
                        </a>';
                        } else {
                            echo '';
                        } ?>
                    </div>
                    <br />
                    <iframe class="trailerfilm" width="560" height="315" src="https://www.youtube.com/embed/<?php echo $film->trailer; ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="modal fade" id="deletePopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Verwijderen</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Weet je het zeker?<?php echo $film->naam ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <a href="deletefilm.php?id=<?php echo $film->Id ?>" class="btn btn-danger">Delete</a>
                            </div>
                        </div>
                    </div>
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
</head>