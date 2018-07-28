<?php
require 'pomphp/baza.class.php';
require 'pomphp/sesija.class.php';
include_once 'pomphp/provjeraDostupnosti.php';
include_once 'pomphp/validacija.php';

Sesija::kreirajSesiju();
if (isset($_SESSION["korisnik"])) {
    
}

if (isset($_GET["odjava"])) {
    Sesija::obrisiSesiju();
}

if (isset($_POST["salji"])) {
    $greska = "";
    foreach ($_POST as $key => $value) {
        if (empty($value)) {
            $greska .= "$key nije unesen. ";
        }
    }
    if (empty($greska)) {
        $veza = new Baza();
        $veza->spojiDB();

        $korime = $_POST["korime"];
        $lozinka = $_POST["lozinka"];
        //registracija
        $salt = sha1(time());
        $kriptirano = sha1($salt . "--" . $lozinka);
        //prijava
        if (sha1($salt . "--" . $lozinka) == $kriptirano)
            ;
        $sql = "SELECT * FROM `Korisnik` WHERE "
                . "`korime`='$korime' AND "
                . "`lozinka`='$lozinka'";
        $rezultat = $veza->selectDB($sql);
        $autenticiran = false;
        if ($rezultat != null)
            while ($red = mysqli_fetch_array($rezultat)) {
                $autenticiran = true;
                $tip = $red["Prava_idPrava"];
            }

        if ($autenticiran) {
            Sesija::kreirajKorisnika($korime, $tip);
            setcookie("korime", $korime, time() + 3600 * 24);
            setcookie("tip", $tip, time() + 3600 * 24);
            header("Location:index.php");
        } else {
            $greska .= "Neuspješna prijava!";
        }

        $veza->zatvoriDB();
    }
}

if (isset($_POST["slanje_podataka"])) {
    $greske = "";
    foreach ($_POST as $k => $v) {
        if (empty($v)) {
            $greske .= "$k nije unesen. ";
        }
    }

    if (empty($greske)) {
        $veza = new Baza();
        $veza->spojiDB();

        $ime = $_POST["ime"];
        $prezime = $_POST["prez"];
        $drzava = $_POST["drzava"];
        $grad = $_POST["grad"];
        $ulica = $_POST["ulica"];
        $broj = $_POST["kbroj"];
        $korime = $_POST["korisme"];
        $lozinka = $_POST["lozinka1"];
        $datum_registracije = date("Y/m/d");
        $email = $_POST["email"];

        $sql = "INSERT INTO Korisnik (ime, prezime, drzava, grad, ulica, broj, korime, lozinka, datum_registracije, email, Prava_idPrava, aktivan) "
                . "VALUES ('$ime','$prezime', '$drzava', '$grad', '$ulica', '$broj', '$korime', '$lozinka', '$datum_registracije', '$email', '1', '1')";
        $veza->updateDB($sql);
        header("Location:prijavaRegistracija.php?mod=prijava");
        $veza->zatvoriDB();
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Početna stranica</title>
        <meta charset = "utf-8">
        <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
        <link href = "css/lidsalope.css" rel = "stylesheet" type = "text/css">
        <link href="css/lidsalope_mobitel.css" rel="stylesheet" type="text/css" media="screen and (max-width:450px)">
        <link href="css/lidsalope_tablet.css" rel="stylesheet" type="text/css" media="screen and (min-width:450px) and (max-width:800px)">
        <link rel="stylesheet" type="text/css" href="css/lidsalope_pc.css" media="screen and (min-width:800px) and (max-width:1000px)">
        <link rel="stylesheet" type="text/css" href="css/lidsalope_tv.css" media="screen and (min-width:1000px)">
        <link rel = "stylesheet" href = "https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
        <meta name = "datum promjene"
              content = "">
        <meta name = "autor" content = "Lidija Salopek">
        <script src = 'https://www.google.com/recaptcha/api.js'></script>
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
                <li><a href="nesrece.php">Nesreće</a></li>
                <li><a href="ustanove.php">Ustanove</a></li>
                <li><a href="uzbune.php">Uzbune</a></li>
                <?php if (!isset($_SESSION["korisnik"])) { ?>
                    <li><a href="prijavaRegistracija.php?mod=registracija" class="aktivna_stranica">Registracija</a></li>
                <?php } ?>
                <?php if (isset($_SESSION["tip"])) { ?>
                    <li><a href="oglasi.php">Oglasi</a></li>
                <?php } ?>
            </ul>       
        </nav>

        <div class="forma">
            <section id="prijava">
                <div class="pir">
                    <a href="prijavaRegistracija.php?mod=prijava" title="Prijava">PRIJAVA</a>
                    <a href="prijavaRegistracija.php?mod=registracija" title="registracija">REGISTRACIJA</a><br>
                </div>
                <?php
                if (isset($_GET["mod"]) && $_GET["mod"] == "prijava") {
                    ?>
                <h2 class="naslov">Prijava</h2>
                    <form method="post" name="form1" id="form1" action="<?php $_SERVER["PHP_SELF"] . "?mod=prijava" ?>">
                        <div>
                            <label class="labela" for="korime">Korisničko ime: </label>
                            <input type="text" class="labela" id="korime" name="korime" size="15" maxlength="20" 
                                   value="<?php if (isset($_COOKIE["korime"])) echo $_COOKIE["korime"]; ?>" required="required" placeholder="Korisničko ime"><br>


                            <label for="lozinka">Lozinka: </label>
                            <input type="password" id="lozinka" name="lozinka" size="15" maxlength="15" required="required" placeholder="Lozinka"><br>

                            <input type="submit" name="salji" value=" Prijavi se ">
                        </div>
                    </form>
                <p> korime: milak 382222  prava:registrirani</p>
                <p> korime: grofdavor dok118 prava:moderator</p>
                <p> korime: lidsalope admin prava:admin</p>
                    <div id="greska">
                        <?php
                        if (isset($greska))
                            echo $greska;
                        ?>
                    </div>
                <?php } ?>
            </section>
            <section id="registracija">
                <div id="greske">
                    <?php
                    if (isset($greske))
                        echo $greske;
                    ?>
                </div>
                <?php
                if (isset($_GET["mod"]) && $_GET["mod"] == "registracija") {
                    ?>
                <h2 class="naslov">Registracija</h2>
                    <form method="POST" name="form2" id="form2" action="<?php $_SERVER["PHP_SELF"] . "?mod=registracija" ?>" enctype="multipart/form-data">
                        <label for="ime"> Ime:* </label>
                        <input type="text" id="ime" name="ime" size="20" maxlength="30" 
                               required="required" placeholder="Ime" onkeyup="return nz(event)"><br>

                        <label for="prez">Prezime:* </label>
                        <input type="text" id="prez" name="prez" size="20" maxlength="50" 
                               required="required" placeholder="Prezime" onkeyup="return nz(event)"><br>
                        <label for="korisme">Korisničko ime:* </label>
                        <input type="text" id="korisme" name="korisme" size="20" maxlength="20" 
                               required="required" placeholder="Korisničko ime" 
                               onblur="provjeriDostupnost()" onfocusout="broji(korisme)" onkeyup="return nz(event)"><br>
                        <span id="status"></span><br>

                        <label for="email">E-mail:* </label>
                        <input type="email" id="email" name="email" size="20" maxlength="35"  
                               required="required" placeholder="ime.prezime@posluzitelj.xxx" 
                               onblur="return provjera()"><br>

                        <label for="lozinka1">Lozinka:* </label>
                        <input type="password" id="lozinka1" name="lozinka1" size="20" maxlength="15"  
                               required="required" placeholder="Lozinka" onfocusout="brojiloz(lozinka1)" onkeydown="return provjera()"><br>

                        <label for="lozinka2">Ponovi pozinku:* </label>
                        <input type="password" id="lozinka2" name="lozinka2" size="20" maxlength="15"  
                               required="required" placeholder="Ponovi lozinku" onkeyup="return lozinke(event)"><br> 

                        <label for="drzava">Država:</label>
                        <input type="text" id="drzava" name="drzava" size="20" maxlength="35" 
                               placeholder="Država" onkeyup="return nz(event)"><br>

                        <label for="grad">Grad:</label>
                        <input type="text" id="grad" name="grad" size="20" maxlength="35" 
                               placeholder="Grad" onkeyup="return nz(event)"><br>

                        <label for="ulica">Ulica:</label>
                        <input type="text" id="ulica" name="ulica" size="20" maxlength="35"
                               placeholder="Ulica"><br>

                        <label for="kbroj">Kućni broj:</label>
                        <input type="number" id="kbroj" name="kbroj" size="20" maxlength="35"
                               placeholder="Kućni broj"><br>

                        <!--<div class="g-recaptcha" data-sitekey="6LcxrF0UAAAAABIQ6bULVXz-MmxOdAQIQH1zipRv"></div>-->
                        <input type="submit" name="slanje_podataka" id="slanje_podataka"  value="Registriraj se!" >
                    </form>
                <?php } ?>
            </section>
        </div>

        <footer>
        </footer>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/provjeraDostupnosti.js"></script>
        <script type="text/javascript" src="js/kolacic.js"></script>
        <script type="text/javascript" src="js/validacija.js"></script>
        <script type="text/javascript" src="js/validacija_jquery.js"></script>

    </body>
</html>