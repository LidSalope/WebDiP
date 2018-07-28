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
$moderator = $_SESSION["tip"];
$sql = "SELECT * FROM Nesreca "
        . "inner join Ustanove_moderator on Nesreca.Ustanove_idUstanove=Ustanove_moderator.Ustanove_idUstanove "
        . "inner join Ustanove on Ustanove.idUstanove=Ustanove_moderator.Ustanove_idUstanove "
        . "inner join Korisnik on Korisnik.idKorisnik=Ustanove_moderator.Korisnik_idKorisnik "
        . "where Korisnik.Prava_idPrava=\"$moderator\" and Korisnik.korime=\"$korisnik\" "
        . "ORDER BY Nesreca.datum_prijave";
$rezultat = $veza->selectDB($sql);

$kod = "SELECT država, grad, COUNT(grad) "
        . "AS brojNesreca FROM Nesreca "
        . "GROUP BY grad "
        . "ORDER BY brojNesreca DESC";
$rez_broj = $veza->selectDB($kod);

$veza->zatvoriDB();
?> 



<!DOCTYPE html>
<html>
    <head>
        <title>Nesreće-moderator</title>
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
                    <div id="mod_nesr_natrag">
                        <a href="nesrece.php"> Natrag </a>
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
                    <li><a href="prijavaRegistracija.php?mod=registracija">Registracija</a></li>
                <?php } ?>
                <?php if (isset($_SESSION["tip"])) { ?>
                    <li><a href="oglasi.php">Oglasi</a></li>
                <?php } ?>
            </ul>          
        </nav>
        <section>  
            <div>
                <h2>Pristigle nesreće</h2>
                <table>
                    <thead>
                    <th>Datum prijave</th>
                    <th>Naziv ustanove</th> 
                    <th>ID nesrece</th>
                    <th>Opis nesreće</th>
                    </thead>
                    <tbody>
                        <?php while ($red = mysqli_fetch_array($rezultat)) : ?>
                            <tr>
                                <td><?php echo $red['datum_prijave']; ?></td>
                                <td><?php echo $red['naziv_ustanove']; ?></td>
                                <td><?php echo $red['idNesreća']; ?></td>
                                <td><?php echo $red['opis_nesrece']; ?></td>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            </div>
            <div>
                <h2>Broj prijavljenih nesreća po gradovima</h2>
                <table>
                    <thead>
                    <th>Država</th>
                    <th>Grad</th> 
                    <th>Broj nesreća</th>
                    </thead>
                    <tbody>
                        <?php while ($lista = mysqli_fetch_array($rez_broj)) : ?>
                            <tr>
                                <td><?php echo $lista['država']; ?></td>
                                <td><?php echo $lista['grad']; ?></td>
                                <td><?php echo $lista['brojNesreca']; ?></td>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            </div>


        </section> 
        <footer>

        </footer>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/kolacic.js"></script>

    </body>
</html>