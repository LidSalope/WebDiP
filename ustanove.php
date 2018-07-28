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
$sql = "SELECT * FROM `Ustanove`";
$rezultat = $veza->selectDB($sql);

$upit = "SELECT Nesreca.*, Ustanove.idUstanove, Ustanove.naziv_ustanove 
        FROM Nesreca LEFT JOIN Ustanove ON Ustanove.idUstanove=Nesreca.Ustanove_idUstanove 
        ORDER BY Nesreca.datum_prijave LIMIT 0, 30 ";
$rez = $veza->selectDB($upit);


$odabir = "";
if(!isset($_POST["prikaz_nesreca_po_ustanovi"])){
        $odabrano = 1;
        $test = "SELECT Nesreca.*, Ustanove.idUstanove, Ustanove.naziv_ustanove 
        FROM Nesreca JOIN Ustanove ON Ustanove.idUstanove=Nesreca.Ustanove_idUstanove 
        WHERE Ustanove.idUstanove=\"$odabrano\"\n"
            . "ORDER BY Nesreca.datum_prijave";
        $ret = $veza->selectDB($test);

}

if(isset($_POST["prikaz_nesreca_po_ustanovi"])){
        $odabir = $_POST['opcije'];
        $odabrano = $odabir;
        $test = "SELECT Nesreca.*, Ustanove.idUstanove, Ustanove.naziv_ustanove 
        FROM Nesreca JOIN Ustanove ON Ustanove.idUstanove=Nesreca.Ustanove_idUstanove 
        WHERE Ustanove.idUstanove=\"$odabrano\"\n"
            . "ORDER BY Nesreca.datum_prijave";
        $ret = $veza->selectDB($test);

}

$veza->zatvoriDB();
?> 



<!DOCTYPE html>
<html>
    <head>
        <title>Ustanove</title>
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
                <div id="prijava_datum">
                    <div>
                        <?php if (!isset($_SESSION["korisnik"])) { ?>
                            <a href="prijavaRegistracija.php?mod=prijava" title="Prijava">Prijava</a>
                        <?php } ?>
                        <?php if (isset($_SESSION["korisnik"])) { ?>
                            <a href="index.php?odjava=da" id="odjava">Odjava</a>
                        <?php } ?>
                    </div>
                    <div>
                        <p><?php echo date("Y/m/d") ?></p>
                    </div>
                </div>
            </div>
        </header>
        <nav>
            <ul>
                <li><a href="index.php">Početna stranica</a></li>
                <li><a href="nesrece.php">Nesreće</a></li>
                <li><a href="ustanove.php" class="aktivna_stranica">Ustanove</a></li>
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
            <h2>Ustanove</h2>
            <div class="gl_sadrzaj_ustanove">
                <table id="ustanove" class="display">
                    <thead>
                    <th>Naziv ustanove</th>
                    <th>Država</th>
                    <th>Grad</th>
                    <th>Ulica</th>
                    <th>Broj</th>
                    </thead>
                    <tbody>
                        <?php while ($red = mysqli_fetch_array($rezultat)) : ?>
                            <tr>
                                <td><?php echo $red['naziv_ustanove']; ?></td>
                                <td><?php echo $red['drzava']; ?></td>
                                <td><?php echo $red['grad']; ?></td>
                                <td><?php echo $red['ulica']; ?></td>
                                <td><?php echo $red['broj']; ?></td>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
                <form name="lista_ustanova_2" id="lista_ustanova_2" method="POST" action="<?php $_SERVER["PHP_SELF"] ?>">
                    <label>Izaberi ustanovu za pregled najnovijih nesreća!</label>
                    <select name="opcije">
                        <?php while ($red = mysqli_fetch_array($rez)) : ?>
                            <option value="<?php echo $red['idUstanove']; ?>"><?php echo $red['naziv_ustanove']; ?></option>
                        <?php endwhile ?>
                    </select>

                    <input type="submit" name="prikaz_nesreca_po_ustanovi" id="prikaz_nesreca_po_ustanovi"  value="Prikaži najnoviju nesreću!">
                    <table>
                        <thead>
                        <th>Ulica</th>
                        <th>Broj</th>
                        <th>Datum objave</th>
                        <th>Opis</th>
                        </thead>
                        <tbody>
                            <?php for ($i=0;$i<3;$i++) {$red = mysqli_fetch_array($ret) ?>
                                <tr>
                                    <td><?php echo $red['ulica']; ?></td>
                                    <td><?php echo $red['broj']; ?></td>
                                    <td><?php echo $red['datum_prijave']; ?></td>
                                    <td><?php echo $red['opis_nesrece']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </form>
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