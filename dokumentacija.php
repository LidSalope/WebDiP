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
?> 
<!DOCTYPE html>
<html>
    <head>
        <title>Dokumentacija</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/lidsalope.css" rel="stylesheet" type="text/css">
        <link href="css/lidsalope_mobitel.css" rel="stylesheet" type="text/css" media="screen and (min-width:100px) and (max-width:450px)">
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
                <li><a href="index.php" class="aktivna_stranica">Natrag</a></li>
            </ul>       
        </nav>
        <div class="navigacija">
            <a href="dokumentacija.php#1">1.Opis projektnog zadatka</a><br>
            <a href="dokumentacija.php#2">2.Opis projektnog rješenja</a><br>
            <a href="dokumentacija.php#3">3.Navigacijski dijagram</a><br>
            <a href="dokumentacija.php#4">4.ERA model</a><br>
            <a href="dokumentacija.php#5">5.Popis skripti i datoteka</a><br>
            <a href="dokumentacija.php#6">6.popis vanjskih izvora</a><br>
        </div>

        <section id="dokumentacija_sekcija">            
            <div class="sadrzaj_dokumentacija">
                <div class="kutija">
                    <div class="naslov_kutije">
                        <h2 id="1">1. Opis projektnog zadatka</h2>
                    </div>
                    <div class="sadrzaj">
                        <p>
                            Bilo je potrebno izraditi projektni zadatak I - Hitna služba 112.
                            Sustav treba omogućiti prikaz nesreća, uzbuna i jedinica hitne službe (112). 
                            Bilo je potrebno imati četiri vrste korisnika koji bi imali zasebne mogućnosti rada na web mjestu.
                            Anonimni ili registrirani korisnik treba moći: vidjeti popis nesreća, ustanova, prijaviti nesreću, 
                            uzbune nad gradovima te aktivne oglase na stranici. 
                            Registrirani korisnik treba moći poslati zahtjev za blokiranjem aktivnih oglasa, pregledati vrste oglasa
                            i kreirati zahtjev za kreiranjem novog oglasa, vidi svoje zahtjeve za oglase i statistiku klikova na oglase.
                            Moderator treba moći vidjeti popis prijava nesreća, popis država i gradova, može kreirati uzbunu za neki grad.
                            Određuje vrste oglasa za pozicije za koje je zadužen, vidi popis zahtjeva za oglašavanjem za oglase na pozicijama za koje je zadužen.
                            Administrator kreira ustanove i dodjeljuje moderatore istima, definira pozicije prikaza oglasa, vidi statistiku
                            klikova svih oglasa i plaćenih oglasa, vidi listu top korisnika sa najviše plaćenih oglasa.
                        </p>
                    </div>
                </div>
                <div class="kutija">
                    <div class="naslov_kutije">
                        <h2 id="2">2. Opis projektnog rješenja</h2>
                    </div>
                    <div class="sadrzaj">
                        <p> 
                            U projektnom zadatku su realizirane neke opcije i mogućnosti. Sustav omogućava registraciju i prijavu korisnika.
                            Postoji validacija formi na stranici prijavaRegistracija.php sa strane klijenta i servera. Neregistrirani korisnik 
                            kada dođe na stranicu vidi oglase te navigacijski meni pomoću kojeg se može prijaviti ili registrirati ako već nije 
                            do sada. Neregistrirani korisnik vidi popis svih objavljenih nesreća te može i sam prijaviti nesreću ako želi. Također,
                            korisnik vidi popis svih ustanova, te može odabrati ustanovu za pregled najnovijih nesreća ovisno o ustanovi. Neregistrirani 
                            korisnik vidi i stranicu sa uzbunama gdje može vidjeti trenutno objavljene uzbune za svaki grad. Kada se korisnik registrira/prijavi
                            on postaje registrirani korisnik i dobiva nove pristupe na web mjestu. Registrirani korisnik ima novu opciju na izborniku: "Oglasi"
                            gdje vidi vrste oglasa te može poslati zahtjev za kreiranjem vlastitog oglasa. Nakon kreiranja oglasa može pogledati status svojih oglasa
                            u desnom kutu ekrana na gumbu "Vaši oglasi". Ako administrator istom korisnik dodijeli prava moderatora on ima neke nove mogućnosti na stranici 
                            "Nesreće". Prilikom stiska na gumb "Moderiranje" moderator vidi pristigle zahtjeve za prijavu nesreće (njih prvih 4) te popis država i gradova 
                            sa najviše prijavljenih nesreća. Na stranici "Uzbune" moderator dobiva mogućnost kreiranja nove uzbune za neki grad.


                        </p>
                    </div>
                </div>
                <div class="kutija">
                    <div class="naslov_kutije">
                        <h2 id="3">3.Navigacijski dijagram</h2>
                    </div>
                    <div class="sadrzaj">
                        <p> 
                            <a href="slike_baza/dokumentacija/navigacijski.png" target="_blank"><img class="img-fluid" src="slike_baza/dokumentacija/navigacijski.png"></a>
                        </p>
                    </div>
                </div>
                <div class="kutija">
                    <div class="naslov_kutije">
                        <h2 id="4">4.ERA model</h2>
                    </div>
                    <div class="sadrzaj">
                        <p> 
                            <a href="slike_baza/dokumentacija/era.png" target="_blank"><img class="img-fluid" src="slike_baza/dokumentacija/era.png"></a>
                        </p>
                    </div>
                </div>
                <div class="kutija">
                    <div class="naslov_kutije">
                        <h2 id="5">5.Popis skripti i datoteka</h2>
                    </div>
                    <div class="sadrzaj"> 
                        <ul>
                            <li><strong>css</strong></li>
                            <ul>
                                <li><strong>lidsalope.css</strong></li>
                                <p>-CSS dokument u kojem se nalazi stilsko uređenje web mjesta.</p>
                                <li><strong>lidsalope_mobitel.css</strong></li>
                                <p>-CSS dokument za responzivnost web mjesta za mobilne uređaje, minimalna širina do 450px.</p>
                            </ul>
                            <li><strong>js</strong></li>
                            <ul>
                                <li><strong>datatables_moje.js</strong></li>
                                <p>-JQuery dokument u kojem se nalaze funkcija za određivanje broja stranica, 
                                    isključivanje mogućnosti sortiranja kod dodatka DataTables.</p>
                                <li><strong>kolacic.js</strong></li>
                                <p>-JavaScript dokument u kojem se nalaze tri funkcije: funkcija procitajCookie()
                                    koja čita kolačić, funkcija kreirajCookie() koja kreira kolačić, te funkcija 
                                    pocetna() koja provjerava da li postoji kolačić i ako ne postoji kreira ga.</p>
                                <li><strong>lidsalope.js</strong></li>
                                <p>-JQuery dokument u kojem se nalazi funkcija za sakrivanje i otkrivanje četvrtog stupca tablice. </p>
                                <li><strong>provjeraDostupnosti.js</strong></li>
                                <p>-jQuery dokument sa funkcijom provjeraDostupnosti() koja pomoću AJAX-a provjerava postoji li korisničko ime u bazi.</p>
                                <li><strong>validacija.js</strong></li>
                                <p>-JavaScript dokument za korisničku validaciju forme za registraciju.</p>
                                <li><strong>validacija_jquery.js</strong></li>
                                <p>-JQuery dokument za korisničku validaciju forme za registraciju.</p>
                            </ul>
                            <li><strong>pomphp</strong></li>
                            <ul>
                                <li><strong>baza.class.php</strong></li>
                                <p>-Klasa za povezivanje na bazu podataka.</p>
                                <li><strong>sesija.class.php</strong></li>
                                <p>-Klasa za upravljanje sa sesijama.</p>
                                <li><strong>validacija.php</strong></li>
                                <p>-PHP dokument za serversku validaciju forme za registraciju</p>
                                <li><strong>provjeraDostupnosti.php</strong></li>
                                <p>-PHP dokument koji vrši provjeru za dostupnost korisničkog imena </p>
                            </ul>
                            <li><strong>slike_baza</strong></li>
                            <ul>
                                <p>-datoteka sa slikama iz baze.</p>
                                <li><strong>dokumentacija</strong></li>
                                <p>-slike iz dokumentacije: era, navigacijski dijagram</p>
                            </ul>
                            <li><strong>dokumentacija.php</strong></li>
                            <p>-stranica za dokumentaciju</p>
                            <li><strong>index.php</strong></li>
                            <p>-početna stranica</p>
                            <li><strong>kreiraj_uzbunu.php</strong></li>
                            <p>-stranica za kreiranje uzbune</p>
                            <li><strong>lista_zzo.php</strong></li>
                            <p>-stranica sa listom zahtjeva za oglase</p>
                            <li><strong>nesrece.php</strong></li>
                            <p>-stranica za nesrece</p>
                            <li><strong>nesrece_moderator.php</strong></li>
                            <p>-stranica za moderiranje nesreca</p>
                            <li><strong>oglasi.php</strong></li>
                            <p>-stranica za oglase</p>
                            <li><strong>prijavaRegistracija.php</strong></li>
                            <p>-stranica za prijavu i registraciju</p>
                            <li><strong>prijava_nesrece.php</strong></li>
                            <p>-stranica za prijavu nesreće</p>
                            <li><strong>ustanove.php</strong></li>
                            <p>-stranica za ustanove</p>
                            <li><strong>uzbune.php</strong></li>
                            <p>-stranica za uzbune</p>
                        </ul>
                    </div>
                </div>
                
                <div class="kutija">
                    <div class="naslov_kutije">
                        <h2 id="6">6.Popis vanjskih izvora</h2>
                    </div>
                    <div class="sadrzaj">
                        <ul>
                            <li>www.yourwebskills.com/mysqldropdown.php</li>
                            <li>www.w3schools.com/php/func_http_setcookie.asp</li>
                            <li>www.formget.com/php-select-option-and-php-radio-button/</li>
                            <li>www.sitepoint.com/how-to-deal-with-cookies-in-javascript/</li>
                            <li>www.devshed.com/c/a/PHP/Website-Database-Basics-With-PHP-and-MySQL/</li>
                            <li>paletton.com</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <footer>

        </footer>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/kolacic.js"></script>


    </body>
</html>