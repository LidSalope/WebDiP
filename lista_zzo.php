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

$veza = new Baza();
$veza->spojiDB();
$korisnik = $_SESSION["korisnik"];
$polje_slika = array();
$sql = "SELECT * FROM `Oglas` join `Korisnik` on `Oglas`.`Korisnik_idKorisnik`=`Korisnik`.`idKorisnik` where `Korisnik`.`korime` = \"$korisnik\" ";
$rezultat = $veza->selectDB($sql);
$polje_slika = array();

$veza->zatvoriDB();
?> 



<!DOCTYPE html>
<html>
    <head>
        <title>Lista zahtjeva za oglas</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/lidsalope.css" rel="stylesheet" type="text/css">
        <link href="css/lidsalope_mobitel.css" rel="stylesheet" type="text/css" media="screen and (max-width:550px)">
        <link href="css/lidsalope_tablet.css" rel="stylesheet" type="text/css" media="screen and (min-width:550px) and (max-width:800px)">
        <link rel="stylesheet" type="text/css" href="css/lidsalope_pc.css" media="screen and (min-width:800px) and (max-width:1000px)">
        <link rel="stylesheet" type="text/css" href="css/lidsalope_tv.css" media="screen and (min-width:1000px)">
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
        <meta name="datum promjene" 
              content="">
        <meta name="autor" content="Lidija Salopek">
        <script src='https://www.google.com/recaptcha/api.js'></script>
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
                <div >
                    <div id="prijava_datum">
                        <?php if (!isset($_SESSION["korisnik"])) { ?>
                            <a href="prijavaRegistracija.php?mod=prijava" title="Prijava">Prijava</a>
                        <?php } ?>
                        <?php if (isset($_SESSION["korisnik"])) { ?>
                            <a href="index.php?odjava=da" id="odjava">Odjava</a>
                        <?php } ?>
                    </div>
                    <div id="lista_zzo">
                        <a href="lista_zzo.php" class="aktivna_stranica">Vaši oglasi</a>
                    </div>
                </div>
            </div>
        </header>
        <nav>
            <ul>
                <li><a href="index.php">Početna stranica</a></li>
                <li><a href="nesrece.php">Nesreće</a></li>
                <li><a href="ustanove.php">Ustanove</a></li>
                <li><a href="uzbune.php">Uzbune</a></li>
                <?php if (!isset($_SESSION["korisnik"])) { ?>
                    <li><a href="prijavaRegistracija.php?mod=registracija">Registracija</a></li>
                <?php } ?>
                <?php if (isset($_SESSION["tip"])) { ?>
                    <li><a href="oglasi.php">Oglasi</a></li>
                <?php } ?>
            </ul>           
        </nav>
        <div  id="galerija_zzo">
            <?php while ($row = mysqli_fetch_array($rezultat)) :?>
            <div class="galerija">
                <img src="<?php echo $row['slika_relput'] ?>" width="300" height="200">
                <div class="opis">
                    <?php echo $row['Aktivan'] ?>
                </div>
            </div>
            <?php endwhile ?>
        </div> 
        <footer>

        </footer>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/kolacic.js"></script>

    </body>
</html>