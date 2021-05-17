<?php
include "baglan.php";

$urun_arr = array();

$urunSor=$db->prepare("SELECT * FROM urun");
$urunSor->execute(array());

while($urunCek=$urunSor->fetch(PDO::FETCH_ASSOC)) {

    $urunId = $urunCek['urunId'];
    $urunAd = $urunCek['urunAd'];
    
    $urun_arr[] = array("id" => $urunId, "name" => $urunAd);
}

// encoding array to json format
echo json_encode($urun_arr);