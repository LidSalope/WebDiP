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
$sql = "SELECT * FROM `Uzbuna` ORDER BY `grad`";    
$rezultat = $veza->selectDB($sql);     
$red = mysqli_fetch_array($rezultat);

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
        <title>Uzbune</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/lidsalope.css" rel="stylesheet" type="text/css">
        <link href="css/lidsalope_mobitel.css" rel="stylesheet" type="text/css" media="screen and (max-width:450px)">
        <link href="css/lidsalope_tablet.css" rel="stylesheet" type="text/css" media="screen and (min-width:450px) and (max-width:800px)">
        <link rel="stylesheet" type="text/css" href="css/lidsalope_pc.css" media="screen and (min-width:800px) and (max-width:1000px)">
        <link rel="stylesheet" type="text/css" href="css/lidsalope_tv.css" media="screen and (min-width:1000px)">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
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
                <div >
                    <div id="prijava_datum" >
                        <?php if (!isset($_SESSION["korisnik"])) { ?>
                            <a href="prijavaRegistracija.php?mod=prijava" title="Prijava">Prijava</a>
                        <?php } ?>
                        <?php if (isset($_SESSION["korisnik"])) { ?>
                            <a href="index.php?odjava=da" id="odjava">Odjava</a>
                        <?php } ?>
                    </div>
                    <div id="mod_kreir_uzbun">
                        <a href="kreiraj_uzbunu.php"> Kreiraj uzbunu </a>
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
                <?php if(!isset($_SESSION["korisnik"])){?>
                <li><a href="prijavaRegistracija.php?mod=registracija">Registracija</a></li>
                <?php }?>
                <?php if(isset($_SESSION["tip"])){?>
                <li><a href="oglasi.php">Oglasi</a></li>
                <?php }?>
            </ul>            
        </nav>
        <section>
            <h2>Uzbune</h2>
            <div class="oglasi">
                <div id="oglas9">
                    <img src="<?php echo $polje_slika[7]['slika_relput'] ?>" width="330" height="300" alt="Kupite oglas po cijeni 200kn!">
                </div>
            </div>
            <div class="gl_sadrzaj">
                <table border="solid" id="uzbune" class="display">
                    <thead>
                    <th>Datum uzbune</th>
                    <th>Država</th>
                    <th>Grad</th>
                    <th>Opis uzbune</th>
                    </thead>
                    <tbody>
                        <?php while ($red = mysqli_fetch_array($rezultat)) : ?>
                            <tr>
                                <td class="datum_uzbune"><?php echo $red['datum_uzbune']; ?></td>
                                <td><?php echo $red['drzava']; ?></td>
                                <td><?php echo $red['grad']; ?></td>
                                <td><?php echo $red['opis_uzbune']; ?></td>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            </div>
            <div class="oglasi">
                
            </div>
        </section> 
        <footer>

        </footer>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="js/kolacic.js"></script>
        <script type="text/javascript" src="js/datatables_moje.js"></script>
        <script type="text/javascript" src="js/lidsalope.js"></script>

    </body>
</html>