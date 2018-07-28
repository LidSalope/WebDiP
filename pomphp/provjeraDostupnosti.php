<?php

require_once 'baza.class.php';

$veza = new baza();
$veza->spojiDB();

if(!empty($_POST["korisme"])){
    $korisme = $_POST['korisme'];
    $sql = "SELECT * FROM Korisnik WHERE korime='$korisme'";
    $rezultati = $veza->selectDB($sql);
    if(mysqli_num_rows($rezultati) > 0){
        echo "<span class='status-false'>Korisničko ime nije slobodno.</span>";
    }else{
        echo "<span class='status-true'>Korisničko ime je slobodno.</span>";
    }
    $veza->zatvoriDB();
}
