<?php
require 'pomphp/baza.class.php';
require 'pomphp/sesija.class.php';

Sesija::kreirajSesiju();
if (isset($_SESSION["korisnik"])) {
    
} else {
    
}
if (isset($_GET["odjava"])) {
    Sesija::obrisiSesiju();
}

if (isset($_POST["kreiranje_uzbune"])) {
    $greske = "";
    foreach ($_POST as $k => $v) {
        if (empty($v)) {
            $greske .= "$k nije unesen. ";
        }
    }

    if (empty($greske)) {
        $veza = new Baza();
        $veza->spojiDB();

        $drzavaUzbuna = $_POST["drzava_uzbuna"];
        $gradUzbuna = $_POST["grad_uzbuna"];
        $opisUzbuna = $_POST["opis_uzbuna_uzbuna"];
        $datumUzbune = $_POST["datum_uzbune"];

        $sql = "INSERT INTO Uzbuna (drzava, grad, opis_uzbune, datum_uzbune)"
                . "VALUES ('$drzavaUzbuna', '$gradUzbuna', '$opisUzbuna', '$datumUzbune')";
        $veza->updateDB($sql);
        $veza->zatvoriDB();
    }
}
?> 



<!DOCTYPE html>
<html>
    <head>
        <title>Kreiraj uzbunu</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/lidsalope.css" rel="stylesheet" type="text/css">
        <link href="css/lidsalope_mobitel.css" rel="stylesheet" type="text/css" media="screen and (max-width:450px)">
        <link href="css/lidsalope_tablet.css" rel="stylesheet" type="text/css" media="screen and (min-width:450px) and (max-width:800px)">
        <link rel="stylesheet" type="text/css" href="css/lidsalope_pc.css" media="screen and (min-width:800px) and (max-width:1000px)">
        <link rel="stylesheet" type="text/css" href="css/lidsalope_tv.css" media="screen and (min-width:1000px)">
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
        <meta name="datum promjene" 
              content="">
        <meta name="autor" content="Lidija Salopek">
    </head>
    <body onload="pocetna()">
        <header>
            <div class="zaglavlje">
                <div id="broj">
                    <p>112</p>
                </div>
                <div id="glnaslov">
                    <h1>Hitna Služba 112</h1>
                </div>
                <div id="prijava_datum">
                    <div>
                        <?php if (!isset($_SESSION["korisnik"])) { ?>
                            <a href="prijavaRegistracija.php?mod=prijava" title="Prijava">Prijava</a>
                        <?php } ?>
                        <?php if (isset($_SESSION["korisnik"])) { ?>
                            <a href="index.php?odjava=da" id="odjava">Odjava</a>
                        <?php } ?>
                    </div>
                    <div id="mod_kreir_uzbun">
                        <a href="uzbune.php"> Natrag</a>
                    </div>
                </div>
            </div>
        </header>
        <nav>
            <ul>
                <li><a href="index.php">Početna stranica</a></li>
                <li><a href="nesrece.php">Nesreće</a></li>
                <li><a href="ustanove.php">Ustanove</a></li>
                <li><a href="uzbune.php" class="aktivna_stranica">Uzbune</a></li>
                <?php if (!isset($_SESSION["korisnik"])) { ?>
                    <li><a href="prijavaRegistracija.php?mod=registracija">Registracija</a></li>
                <?php } ?>
                <?php if (isset($_SESSION["tip"])) { ?>
                    <li><a href="oglasi.php">Oglasi</a></li>
                <?php } ?>
            </ul>            
        </nav>
        <section id="srednji_dio">
            <h2>Kreiraj uzbunu</h2>
            <div class="kr_uzbunu">
                <form method="POST" name="kreiraj_uzbunu" id="forma_kreiraj_uzbunu" action="<?php $_SERVER["PHP_SELF"] ?>">
                    <label for="drzava_uzbuna"> Država* </label>
                    <input type="text" id="drzava_uzbuna" name="drzava_uzbuna" size="20" maxlength="45" 
                           required="required" placeholder="Država" ><br>

                    <label for="grad_uzbuna">Grad* </label>
                    <input type="text" id="grad_uzbuna" name="grad_uzbuna" size="20" maxlength="45" 
                           required="required" placeholder="Grad" ><br>

                    <label for="opis_uzbuna_uzbuna">Opis uzbune* </label>
                    <textarea type="text" id="opis_uzbuna_uzbuna" name="opis_uzbuna_uzbuna" rows="10" cols="40" maxlength="100" 
                              placeholder="Opis uzbune" required="required" ></textarea><br>

                    <label for="datum_uzbune">Datum uzbune* </label>
                    <input type="date" id="datum_uzbune" name="datum_uzbune"   
                           placeholder="yy/mm/dd" required="required"><br>

                    <input type="submit" name="kreiranje_uzbune" id="kreiranje_uzbune"  value="Kreiraj uzbunu!" >
                </form>
            </div>
        </section> 
        <footer>

        </footer>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/kolacic.js"></script>

    </body>
</html>