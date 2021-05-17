<?php
include "baglan.php";

$urunId = $_POST['urunId'];

$urunBilgi = array();

$urunBilgiSor=$db->prepare("SELECT * FROM urun WHERE urunId=:urunId");
$urunBilgiSor->execute(array(
    'urunId'=> $urunId
));

$urunBilgiCek=$urunBilgiSor->fetch(PDO::FETCH_ASSOC);   

    $urunResim = $urunBilgiCek['urunResim'];
    $urunStokKod = $urunBilgiCek['urunStokKod'];
    $urunPSF = $urunBilgiCek['urunPSF'];
    $urunKoli = $urunBilgiCek['urunKoli'];

    
    $urunBilgi = array("urunResim" => $urunResim, "urunStokKod" => $urunStokKod, "urunPSF" => $urunPSF, "urunKoli" => $urunKoli);


// encoding array to json format
echo json_encode($urunBilgi);