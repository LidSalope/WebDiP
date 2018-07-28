<?php

if (isset($_POST["slanje_podataka"])) {
    $greske = "";
    $znakovi = array("!", "?", "#", "'");

    if ((empty($_POST["ime"])) || (empty($_POST["prez"])) || (empty($_POST["email"])) || (empty($_POST["korisme"]))) {
        $greske .= "Polje za ime, prezime, email, korisničko ime ne smije biti prazno!<br>";
    }
    if ((strlen($_POST["ime"]) > 1) || (strlen($_POST["prez"]) > 1) || (strlen($_POST["email"]) > 1) || (strlen($_POST["korisme"]) > 1)) {
        $imedz = strlen($_POST["ime"]);
        $ime = $_POST["ime"];
        $prezdz = strlen($_POST["prez"]);
        $prez = $_POST["prez"];
        $emaildz = strlen($_POST["email"]);
        $email = $_POST["email"];
        $korimedz = strlen($_POST["korisme"]);
        $korime = $_POST["korisme"];

        for ($i = 0; $i < $imedz; $i++) {
            for ($a = 0; $a < 4; $a++) {
                if ($ime[$i] === $znakovi[$a]) {
                    $ime[$i] = '';
                    $greske .= "Nedozovoljeni znak u polju ime!<br>";
                }
            }
        }
        for ($i = 0; $i < $prezdz; $i++) {
            for ($a = 0; $a < 4; $a++) {
                if ($prez[$i] === $znakovi[$a]) {
                    $prez[$i] = '';
                    $greske .= "Nedozovoljeni znak u polju prezime!<br>";
                }
            }
        }
        for ($i = 0; $i < $emaildz; $i++) {
            for ($a = 0; $a < 4; $a++) {
                if ($email[$i] === $znakovi[$a]) {
                    $email[$i] = '';
                    $greske .= "Nedozovoljeni znak u polju email!<br>";
                }
            }
        }
        for ($i = 0; $i < $korimedz; $i++) {
            for ($a = 0; $a < 4; $a++) {
                if ($korime[$i] === $znakovi[$a]) {
                    $korime[$i] = '';
                    $greske .= "Nedozovoljeni znak u polju korisničko ime!<br>";
                }
            }
        }
    }
    if ((strlen($_POST["lozinka1"]) < 5 ) || (strlen($_POST["korisme"]) < 6 )) {
        $greske .= "Lozinka mora imati barem 5 znakova, korisničko ime mora imati barem 6 znakova!<br>";
    }

    if ($_POST["lozinka1"] != $_POST["lozinka2"]) {
        $greske .= "Lozinke se ne poklapaju!<br>";
    }
    
    if (!preg_match("/^[a-zA-Z0-9]+\.*[a-zA-Z0-9]*@[[a-zA-Z0-9]*\.[[a-zA-Z0-9]{2,}$/",$email)) {
      $greske .= "Nevaljali format email-a!"; 
    }
}