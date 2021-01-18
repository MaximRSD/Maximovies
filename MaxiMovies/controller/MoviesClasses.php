<?php
class MoviesClasses
{
    public $conn;

    public function __construct()
    {
        $conn = new PDO("mysql:host=localhost;dbname=dbmaximovies;", "root", "");
        $this->conn = $conn;
    }
    public function getLanguage()
    {
        $query = "SELECT * FROM tbTalen";
        $stm = $this->conn->prepare($query);
        if ($stm->execute()) {
            $result =  $stm->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } else {
            print_r($stm->errorInfo());
        }
    }
    public function opslaanFilm($naam, $prijs, $beschrijving, $trailer, $genreId, $duur, $afbeelding, $releasedatum, $bioscoopdatum, $backgroundimg, $tid)
    {
        $query = "INSERT into tbfilms (naam, prijs, beschrijving, trailer, genreId, duur, afbeelding, releasedatum, bioscoopdatum, backgroundimg, tid)
         VALUE ('$naam', '$prijs', '$beschrijving', '$trailer', '$genreId', '$duur' , '$afbeelding', '$releasedatum', '$bioscoopdatum', '$backgroundimg', '$tid')";

        $stm = $this->conn->prepare($query);
        if ($stm->execute()) {
            echo ("<script>location.href = 'films.php';</script>");
        } else {
            print_r($stm->errorInfo());
        }
    }
    public function searchMovie($input, $tid)
    {
        $query = "SELECT id, afbeelding, naam, duur FROM tbfilms WHERE naam LIKE :input AND tid = $tid ORDER BY ID";
        $stm = $this->conn->prepare($query);
        $val = "%" . $input . "%";
        $stm->bindparam(":input", $val);
        if ($stm->execute()) {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach ($result as $film) {
                echo '<a href="film.php?id=' . $film->id . '"><div class="filmdiv"><img class="filmposter" src="data:image/jpeg;base64,' . base64_encode($film->afbeelding) . '" width="175px" heigth="auto" /><br/>' . $film->naam . '<br/><p>' . $film->duur . ' min</p></div></a>';
            }
        }
    }

    public function opslaanUser($username, $wachtwoord)
    {
        if ($_POST['wachtwoord'] === $_POST['wachtwoordRepeat']) {

            $hashpass = password_hash($wachtwoord, PASSWORD_DEFAULT);
            $query = "INSERT into tbusers (username, wachtwoord) VALUE ('$username', '$hashpass')";
            $stm = $this->conn->prepare($query);
            if ($stm->execute()) {
                echo ("<script>location.href = 'inlog.php';</script>");
            } else {
                print_r($stm->errorInfo());
            }
        } else {
            echo "Register failed";
        }
    }
    public function loginUser($username, $wachtwoord)
    {
        $query = "SELECT username, wachtwoord FROM tbusers WHERE username = :username LIMIT 1";
        $stm = $this->conn->prepare($query);
        $stm->bindparam(":username", $username);
        if ($stm->execute()) {
            $user = $stm->fetch(PDO::FETCH_OBJ);
            if ($user != null) {
                if (password_verify($wachtwoord, $user->wachtwoord)) {
                    $_SESSION["ingelod"] = true;
                    $_SESSION["username"] = $username;
                    $_SESSION["admin"] = $user->admin;
                    echo ("<script>location.href = 'index.php';</script>");
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            print_r($stm->errorInfo());
        }
    }
    public function deleteFilm($id)
    {
        $query = "DELETE FROM tbfilms WHERE id=:id";
        $stm = $this->conn->prepare($query);
        $stm->bindparam(":id", $id);
        if ($stm->execute()) {
            echo ("<script>location.href = 'films.php';</script>");
        } else {
            print_r($stm->errorInfo());
        }
    }
    public function updateFilm($id, $naam, $prijs, $beschrijving, $trailer, $genreId, $duur, $afbeelding, $releasedatum, $bioscoopdatum, $backgroundimg, $tid)
    {
        $query = "UPDATE tbfilms SET naam='$naam', prijs='$prijs', beschrijving='$beschrijving', trailer='$trailer', genreId='$genreId', duur='$duur', ";

        if ($afbeelding != "") {
            $query .= "afbeelding='" . addslashes(file_get_contents($afbeelding)) . "', ";
        }

        $query .= "releasedatum='$releasedatum', bioscoopdatum='$bioscoopdatum', ";

        if ($backgroundimg != "") {
            $query .= "backgroundimg='" . addslashes(file_get_contents($backgroundimg)) . "', ";
        }

        $query .= "tid='$tid' WHERE id= $id";

        $stm = $this->conn->prepare($query);

        // if ($afbeelding != "") {
        //     $stm->bindparam(file_get_contents($afbeelding));
        // }

        // if ($backgroundimg != "") {
        //     $stm->bindparam(file_get_contents($backgroundimg));
        // }

        if ($stm->execute()) {
            echo ("<script>location.href = 'films.php';</script>");
        } else {
            print_r($stm->errorInfo());
        }
    }
    public function laatsteFilm()
    {
        $conn = new PDO("mysql:host=localhost;dbname=dbmaximovies;", "root", "");

        $query = "SELECT * FROM tbfilms WHERE ID = (SELECT MAX(ID) FROM tbFilms)";

        $stm = $conn->prepare($query);
        if ($stm->execute()) {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach ($result as $finfo) {
                return $finfo;
            }
        }
    }
    public function laatstefilmInfo($id)
    {
        $conn = new PDO("mysql:host=localhost;dbname=dbmaximovies;", "root", "");
        $query = "SELECT id, afbeelding FROM tbFilms WHERE tid = $id ORDER BY ID  DESC LIMIT 0,10 ";
        $stm = $conn->prepare($query);
        if ($stm->execute()) {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach ($result as $afb) {
                echo '<a href="film.php?id=' . $afb->id . '"><img class="recentefilms mb-4" src="data:image/jpeg;base64,' . base64_encode($afb->afbeelding) . '" width="220px" heigth="auto" /></a>';
            }
        }
    }
    public function alleFilm($id)
    {
        $conn = new PDO("mysql:host=localhost;dbname=dbmaximovies;", "root", "");

        $query = "SELECT id, naam, duur, afbeelding FROM tbFilms WHERE tid = $id";

        $stm = $conn->prepare($query);
        if ($stm->execute()) {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach ($result as $film) {
                echo '<a href="film.php?id=' . $film->id . '"><div class="filmdiv"><img class="filmposter" src="data:image/jpeg;base64,' . base64_encode($film->afbeelding) . '" width="175px" heigth="auto" /><br/>' . $film->naam . '<br/><p>' . $film->duur . ' min</p></div></a>';
            }
        }
    }
    public function getFilm($id)
    {
        $conn = new PDO("mysql:host=localhost;dbname=dbmaximovies;", "root", "");

        $query = "SELECT * FROM tbfilms INNER JOIN tbgenre ON tbfilms.genreId=tbgenre.id WHERE tbfilms.id =:id";

        $stm = $conn->prepare($query);
        $stm->bindparam(":id", $id);
        if ($stm->execute()) {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach ($result as $film) {
                return $film;
            }
        }
    }
    public function getGenre()
    {
        $conn = new PDO("mysql:host=localhost;dbname=dbmaximovies;", "root", "");
        $query = "SELECT * FROM tbgenre";
        $stm = $conn->prepare($query);
        if ($stm->execute()) {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach ($result as $genreId) {
                echo "<option value='" . $genreId->id . "'>" . $genreId->name . "</option>";
            }
        }
    }
    public function getTaal()
    {
        $conn = new PDO("mysql:host=localhost;dbname=dbmaximovies;", "root", "");
        $query = "SELECT * FROM tbtalen";
        $stm = $conn->prepare($query);
        if ($stm->execute()) {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach ($result as $taalId) {
                echo "<option value='" . $taalId->id . "'>" . $taalId->taal . "</option>";
            }
        } else {
            print_r($stm->errorInfo());
        }
    }
    public function IdFilm($id)
    {
        $conn = new PDO("mysql:host=localhost;dbname=dbmaximovies;", "root", "");

        $query = "SELECT afbeelding FROM tbFilms WHERE tbfilms.id =:id";

        $stm = $conn->prepare($query);
        $stm->bindparam(":id", $id);
        if ($stm->execute()) {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach ($result as $film) {
                echo '<div class="filmdiv"><img class="filmposter" src="data:image/jpeg;base64,' . base64_encode($film->afbeelding) . '" width="175px" heigth="auto" /></div>';
            }
        }
    }
    public function getGenreCB($id)
    {
        $conn = new PDO("mysql:host=localhost;dbname=dbmaximovies;", "root", "");
        $query = "SELECT * FROM tbgenre";
        $stm = $conn->prepare($query);
        if ($stm->execute()) {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach ($result as $genreId) {
                if ($genreId->id != $id) {
                    echo "<option value='" . $genreId->id . "'>" . $genreId->name . "</option>";
                } else {
                    echo "<option selected='selected' value='" . $genreId->id . "'>" . $genreId->name . "</option>";
                }
            }
        }
    }
    public function getTaalCB($id)
    {
        $conn = new PDO("mysql:host=localhost;dbname=dbmaximovies;", "root", "");
        $query = "SELECT * FROM tbtalen";
        $stm = $conn->prepare($query);
        if ($stm->execute()) {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach ($result as $taalId) {
                if ($taalId->id != $id) {
                    echo "<option value='" . $taalId->id . "'>" . $taalId->taal . "</option>";
                } else {
                    echo "<option selected='selected' value='" . $taalId->id . "'>" . $taalId->taal . "</option>";
                }
            }
        } else {
            print_r($stm->errorInfo());
        }
    }
}
