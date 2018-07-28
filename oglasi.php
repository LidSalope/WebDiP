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
$sql = "SELECT * FROM `Vrsta_oglasa` ORDER BY `cijena`";
$rezultat = $veza->selectDB($sql);
$veza->zatvoriDB();


if (isset($_POST["slanje_zahtjeva_za_oglas"])) {
    $greske = "";
    foreach ($_POST as $k => $v) {
        if (empty($v)) {
            $greske .= "$k nije unesen. ";
        }
    }
    var_dump($_FILES);
    $userfile = $_FILES['userfile']['tmp_name'];
    $userfile_name = $_FILES['userfile']['name'];
    $userfile_size = $_FILES['userfile']['size'];
    $userfile_type = $_FILES['userfile']['type'];
    $userfile_error = $_FILES['userfile']['error'];

    if (empty($greske)) {

        if ($userfile_error > 0) {
            echo 'Problem: ';
            switch ($userfile_error) {
                case 1: echo 'Veličina veća od ' . ini_get('upload_max_filesize');
                    break;
                case 2: echo 'Veličina veća od ' . $_POST["MAX_FILE_SIZE"] . 'B';
                    break;
                case 3: echo 'Datoteka djelomično prenesena';
                    break;
                case 4: echo 'Datoteka nije prenesena';
                    break;
            }
            exit;
        }

        $upfile = 'slike_baza/' . $userfile_name;

        if (is_uploaded_file($userfile)) {
            if (!move_uploaded_file($userfile, $upfile)) {
                $greske .= 'Problem: nije moguće prenijeti datoteku na odredište';
            }
        } else {
            $greske .= 'Problem: mogući napad prijenosom. Datoteka: ' . $userfile_name;
        }
        var_dump($upfile);
        if ($userfile_error = "") {
            $veza = new Baza();
            $veza->spojiDB();

            if (isset($_COOKIE["korime"])) {
                $korime = $_COOKIE["korime"];

                $upit = "SELECT idKorisnik FROM Korisnik WHERE korime=\"$korime\"";
                $rjesenje = $veza->selectDB($upit);
                $red = mysqli_fetch_array($rjesenje);
                $idKorisnik = $red["idKorisnik"];
                
                $vrstaOglas = $_POST["idoglas"];
                $nazivOglas = $_POST["naziv_oglasa"];
                $opisOglas = $_POST["opis_oglas"];
                $urlOglas = $_POST["url_oglas"];
                $slikaOglas = $upfile;
                $datum_zahtjeva = date("Y/m/d");
                $aktivan = '0';

                $sql = "INSERT INTO Oglas (naziv, opis, slika_relput, url, Korisnik_idKorisnik, Vrsta_oglasa_idVrsta_oglasa, aktivan, datum_zahtjeva ) "
                        . "VALUES ('$nazivOglas', '$opisOglas', '$slikaOglas', '$urlOglas', '$idKorisnik', '$vrstaOglas', '$aktivan', '$datum_zahtjeva' )";
                $veza->updateDB($sql);
                
                $veza->zatvoriDB();
                header("Location:nesrece.php");
            }
        }
    }
}
?> 



<!DOCTYPE html>
<html>
    <head>
        <title>Oglasi</title>
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
                        <a href="lista_zzo.php">Vaši oglasi</a>
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
                    <li><a href="oglasi.php" class="aktivna_stranica">Oglasi</a></li>
                <?php } ?>
            </ul>           
        </nav>
        <div class="oglas">  
            <div class="vrste_oglasa">
                <h2>Vrste Oglasa</h2>
                <table>
                    <thead>
                    <th>Cijena (u kn)</th>
                    <th>Trajanje prikazivanja</th>
                    <th>Brzina izmjene</th>
                    <th>ID oglasa</th>
                    </thead>
                    <tbody>
<?php while ($red = mysqli_fetch_array($rezultat)) : ?>
                            <tr>
                                <td><?php echo $red['cijena']; ?></td>                  
                                <td><?php echo $red['trajanje_prikazivanja']; ?></td>
                                <td><?php echo $red['brzina_izmjene']; ?></td>
                                <td><?php echo $red['idVrsta_oglasa']; ?></td>
                            </tr>
<?php endwhile ?>
                    </tbody>
                </table>
            </div>
            <div class="zzk_oglas">
                <h2>Pošalji zahtjev za kreiranjem oglasa</h2>
                <form method="POST" name="kreiraj_oglas" id="kreiraj_oglas" action="<?php $_SERVER["PHP_SELF"] ?>" ENCTYPE="multipart/form-data">
                    <label for="idoglas"> Vrsta oglasa* </label>
                    <input type="text" id="idoglas" name="idoglas" size="20" maxlength="30" 
                           required="required" placeholder="ID oglasa" ><br>

                    <label for="naziv_oglasa">Naziv* </label>
                    <input type="text" id="naziv_oglasa" name="naziv_oglasa" size="20" maxlength="50" 
                           required="required" placeholder="Naziv oglasa" ><br>
                    <label for="opis_oglas">Opis oglasa </label>
                    <textarea type="text" id="opis_oglas" name="opis_oglas" rows="20" cols="50" maxlength="500" 
                              placeholder="Opis oglasa" ></textarea><br>

                    <label for="url_oglas">URL(link webmjesta) oglasa </label>
                    <input type="text" id="url_oglas" name="url_oglas" size="20" maxlength="35"  
                           placeholder="www.link.domena"><br>

                    <label for="userfile">Slika oglasa: </label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="300000">
                    <input type="file" id="userfile" name="userfile"><br>

                    <input type="submit" name="slanje_zahtjeva_za_oglas" id="slanje_zahtjeva_za_oglas"  value="Pošalji zahtjev!" >
                </form>
            </div>
        </div> 
        <footer>

        </footer>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/kolacic.js"></script>

    </body>
</html>