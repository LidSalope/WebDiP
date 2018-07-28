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
$sql = "SELECT * FROM `Nesreca`";
$rezultat = $veza->selectDB($sql);

$upit = "SELECT * FROM `Oglas` ";
$rez = $veza->selectDB($upit);
$polje_slika = array();
while ($slika = mysqli_fetch_array($rez)) {
    $polje_slika[] = $slika;
}

$veza->zatvoriDB();
?> 



<!DOCTYPE html>
<html>
    <head>
        <title>Nesreće</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/lidsalope.css" rel="stylesheet" type="text/css">
        <link href="css/lidsalope_mobitel.css" rel="stylesheet" type="text/css" media="screen and (max-width:450px)">
        <link href="css/lidsalope_tablet.css" rel="stylesheet" type="text/css" media="screen and (min-width:450px) and (max-width:800px)">
        <link rel="stylesheet" type="text/css" href="css/lidsalope_pc.css" media="screen and (min-width:800px) and (max-width:1000px)">
        <link rel="stylesheet" type="text/css" href="css/lidsalope_tv.css" media="screen and (min-width:1000px)">
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
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
                    <div class="datum">
                        <p><?php echo date("Y/m/d") ?></p>
                    </div>
                </div>
            </div>
        </header>
        <nav>
            <ul>
                <li><a href="index.php">Početna stranica</a></li>
                <li><a href="nesrece.php" class="aktivna_stranica">Nesreće</a></li>
                <li><a href="ustanove.php">Ustanove</a></li>
                <li><a href="uzbune.php">Uzbune</a></li>
                <?php if (!isset($_SESSION["korisnik"])) { ?>
                    <li><a href="prijavaRegistracija.php?mod=regist racija">Registracija</a></li>
                <?php } ?>
                <?php if (isset($_SESSION["tip"])) { ?>
                    <li><a href="oglasi.php">Oglasi</a></li>
                <?php } ?>
            </ul>          
        </nav>
        <section>
            <h2>Nesreće</h2>
            <div class="oglasi">
                <div id="oglas5">
                    <img src="<?php echo $polje_slika[5]['slika_relput'] ?>" width="330" height="300" alt="Kupite oglas po cijeni 200kn!">
                </div>
                <div id="oglas6">
                    <img src="<?php echo $polje_slika[6]['slika_relput'] ?>" width="330" height="300" alt="Kupite oglas po cijeni 200kn!">
                </div>
            </div>
        </div>
        <div class="gl_sadrzaj">
            <table id="nesrece" class="display">
                <thead>
                <th>Država</th>
                <th>Grad</th> 
                <th>Ulica</th>
                <th>Opis nesreće</th>
                <th>Datum prijave nesreće</th>
                </thead>
                <tbody>
                    <?php while ($red = mysqli_fetch_array($rezultat)) : ?>
                        <tr>
                            <td><?php echo $red['država']; ?></td>
                            <td><?php echo $red['grad']; ?></td>
                            <td><?php echo $red['ulica']; ?></td>
                            <td><?php echo $red['opis_nesrece']; ?></td>
                            <td><?php echo $red['datum_prijave']; ?></td>
                        </tr>
                    <?php endwhile ?>
                </tbody>
            </table>
        </div>
        <div id='nesrece_desno'>
            <div id="link_prijava_nesrece">
                <a href="prijava_nesrece.php"> Prijavite nesreću! </a>
            </div>
            <?php if (isset($_SESSION["tip"])) { ?>
                <div id='nesrece_moderator'>
                    <?php if ($_SESSION["tip"] == '3') { ?>
                        <a href="nesrece_moderator.php">Moderiranje</a>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </section> 
    <footer>

    </footer>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/kolacic.js"></script>
    <script type="text/javascript" src="js/datatables_moje.js"></script>

</body>
</html>