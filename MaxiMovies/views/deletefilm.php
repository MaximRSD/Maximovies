<?php
session_start();
require("../controller/MoviesClasses.php");
$mc = new MoviesClasses();
$mc->deleteFilm($_GET["id"]);
