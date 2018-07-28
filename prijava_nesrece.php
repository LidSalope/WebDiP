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

if (isset($_POST["slanje_prijave_nesrece"])) {
    $greske = "";
    foreach ($_POST as $k => $v) {
        if (empty($v)) {
            $greske .= "$k nije unesen. ";
        }
    }
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
        if ($userfile_error = "") {
            $veza = new Baza();
            $veza->spojiDB();

            $drzava = $_POST["drzava"];
            $grad = $_POST["grad"];
            $ulica = $_POST["ulica"];
            $broj = $_POST["kbroj"];
            $opis_nesrece = $_POST["opis_nesrece"];
            $datum_prijave = date("Y/m/d");
            $idUstanove = $_POST["lista_ustanova"];
            $slika_nesrece = $upfile;

            $sql = "INSERT INTO Nesreca (drzava, grad, ulica, broj, slika, opis_nesrece, datum_prijave, Ustanove_idUstanove) "
                    . "VALUES ('$drzava', '$grad', '$ulica', '$broj', '$slika_nesrece', '$opis_nesrece', '$datum_prijave', '$idUstanove')";
            $veza->updateDB($sql);
            header("Location:nesrece.php");
            $veza->zatvoriDB();
        }
    }
}
?> 



<!DOCTYPE html>
<html>
    <head>
        <title>Prijava nesreće</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/lidsalope.css" rel="stylesheet" type="text/css">
        <link href="css/lidsalope_mobitel.css" rel="stylesheet" type="text/css" media="screen and (max-width:450px)">
        <link href="css/lidsalope_tablet.css" rel="stylesheet" type="text/css" media="screen and (min-width:450px) and (max-width:800px)">
        <link rel="stylesheet" type="text/css" href="css/lidsalope_pc.css" media="screen and (min-width:800px) and (max-width:1000px)">
        <link rel="stylesheet" type="text/css" href="css/lidsalope_tv.css" media="screen and (min-width:1000px)">
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
        <meta name="datum promjene" 
              content=date()>
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
                    <div>
                        <p><?php echo date("Y/m/d") ?></p>
                    </div>
                </div>
            </div>
        </header>
        <nav>
            <ul>
                <li><a href="nesrece.php" class="aktivna_stranica">Povratak</a></li>
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
        <section>
            <h2>Prijava nesreće</h2>
            <div id="greske">
                <?php
                if (isset($greske))
                    echo $greske;
                ?>
            </div>
            <form method="POST" name="prijava_nesrece" id="prijava_nesrece" action="<?php $_SERVER["PHP_SELF"] ?>" ENCTYPE="multipart/form-data">
                <label for="ime"> Država:* </label>
                <input type="text" id="drzava" name="drzava" size="20" maxlength="30" 
                       required="required" placeholder="Država" ><br>

                <label for="grad">Grad:* </label>
                <input type="text" id="grad" name="grad" size="20" maxlength="50" 
                       required="required" placeholder="Grad" ><br>
                <label for="korisme">Ulica: </label>
                <input type="text" id="ulica" name="ulica" size="20" maxlength="20" 
                       placeholder="Ulica" ><br>

                <label for="kbroj">Kućni broj </label>
                <input type="number" id="kbroj" name="kbroj" size="20" maxlength="35"  
                       placeholder="Kućni broj:"><br>

                <label for="userfile">Slika nesreće: </label>
                <input type="hidden" name="MAX_FILE_SIZE" value="300000">
                <input type="file" id="userfile" name="userfile"><br>

                <label for="opis_nesrece">Opis nesreće:* </label>
                <textarea name="opis_nesrece" id="opis_nesrece" rows="20" cols="50" maxlength="500"
                          placeholder="Ukratko opiši nesreću."></textarea><br> 

                <label for="lista_ustanova">Odaberite ustanovu:</label>
                <select id="lista_ustanova">
                    <optgroup label="Varaždin">
                        <option value="1">Hitna pomoć Varaždin</option>
                        <option value="2">JVP Varaždin</option>
                        <option value="3">Policijska postaja Varaždin</option> 
                    </optgroup>
                    <optgroup label="Slavonski Brod">
                        <option value="4">Policijska postaja SB</option>
                        <option value="5">JVP Slavonski Brod</option>
                        <option value="6">Zavod za hitnu medicinu BPŽ</option>
                    </optgroup>
                    <optgroup label="Zagreb">
                        <option value="7">Hitna pomoć Zagreb</option>
                        <option value="8">Policijska uprava Zagreb</option>
                        <option value="9">Policijska postaja Novi Zagreb</option>
                        <option value="10">JVP grada Zagreba</option>
                    </optgroup>
                </select><br>
                <input type="submit" name="slanje_prijave_nesrece" id="slanje_prijave_nesrece"  value="Prijavi nesreću!" >
            </form>
        </section> 
        <footer>

        </footer>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/kolacic.js"></script>

    </body>
</html>