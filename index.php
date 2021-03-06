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

$sql = "SELECT * FROM `Oglas` ";
$rezultat = $veza->selectDB($sql);
$polje_slika = array();
while ($slika = mysqli_fetch_array($rezultat)) {
    $polje_slika[] = $slika;
}
$veza->zatvoriDB();
?> 
<!DOCTYPE html>
<html>
    <head>
        <title>Početna stranica</title>
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
        <script src='https://www.google.com/recaptcha/api.js'></script>
    </head>
    <body onload="pocetna()">
        <header>
            <div class="zaglavlje">
                <div id="broj">
                    <p>112</p>
                    <a href="dokumentacija.php" id="dokumentacija">Dokumentacija</a>
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
                            <div id="o_autoru">   
                            <a href="o_autoru.php">O autoru</a>
                            </div>
                    </div>

                </div>
            </div>
        </header>
        <nav>
            <ul>
                <li><a href="index.php" class="aktivna_stranica">Početna stranica</a></li>
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
        <section id="pocetna">
            <div class="oglasi">
                <div>
                    <img src="<?php echo $polje_slika[0]['slika_relput'] ?>" width="330" height="300" alt="Kupite oglas po cijeni 200kn!">
                </div>
                <div>
                    <img src="#" width="330" height="300" alt="Kupite oglas po cijeni 200kn!">
                </div>
            </div>
            <div class="gl_sadrzaj" id="pocetna_str">
                <p>Dobrodošli na stranicu Hitne službe 112!</p>
            </div>
            <div class="oglasi">
                <div id="oglas3"><img src="<?php echo $polje_slika[3]['slika_relput'] ?>" width="330" height="300" alt="Kupite oglas po cijeni 200kn!"></div>
                <div id="oglas4"><img src="<?php echo $polje_slika[4]['slika_relput'] ?>" width="330" height="300" alt="Kupite oglas po cijeni 200kn!"></div>
            </div>
        </section>
        <footer>
            
        </footer>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/kolacic.js"></script>

    </body>
</html>