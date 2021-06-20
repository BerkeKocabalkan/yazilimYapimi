<?php
ob_start();
session_start();

include 'baglan.php';

//Giriş Başlangıç

if (isset($_POST['adminGiris'])) {

    $adminPass=sha1(md5($_POST['kullaniciPass']));
    $kısaPass=mb_substr($adminPass,0,32,"utf8");

    $kullaniciSor=$db->prepare("SELECT * FROM kullanici where kullaniciMail=:mail and kullaniciSifre=:parola");
    $kullaniciSor->execute(array(
        'mail' => $_POST['kullaniciMail'],
        'parola' => $kısaPass
    ));

    $kullaniciCek=$kullaniciSor->fetch(PDO::FETCH_ASSOC);
    $say1=$kullaniciSor->rowCount();

    if ($say1==1) {

        $_SESSION['oturumId']=$kullaniciCek['kullaniciId'];
        header("Location:../panel/index.php");
        exit;

    } else {

        header("Location:../panel/login.php?durum=no");
        exit;

    }
}

//Giriş Bitiş

//Kullanıcı Ekle Başlangıç

if(isset($_POST['kullaniciEkle'])){

    $adminPass=sha1(md5($_POST['kullaniciSifre']));
    $kisaPass=mb_substr($adminPass,0,32,"utf8");

    $kullaniciEkle=$db->prepare("INSERT INTO kullanici SET
        kullaniciAd=:kullaniciAd,
        kullaniciSoyad=:kullaniciSoyad,
        kullaniciTakmaAd=:kullaniciTakmaAd,
        kullaniciMail=:kullaniciMail,
        kullaniciSifre=:kullaniciSifre,
        kullaniciTC=:kullaniciTC,
        kullaniciTelefon=:kullaniciTelefon,
        kullaniciAdres=:kullaniciAdres
    ");

    $insert=$kullaniciEkle->execute(array(
        'kullaniciAd' => $_POST['kullaniciAd'],
        'kullaniciSoyad' => $_POST['kullaniciSoyad'],
        'kullaniciTakmaAd' => $_POST['kullaniciTakmaAd'],
        'kullaniciMail' => $_POST['kullaniciMail'],
        'kullaniciTC' => $_POST['kullaniciTC'],
        'kullaniciTelefon' => $_POST['kullaniciTelefon'],
        'kullaniciAdres' => $_POST['kullaniciAdres'],
        'kullaniciSifre' => $kisaPass
    ));

    if($insert) {
        header("Location:../panel/login.php?durum=ok");
    } else {
        header("Location:../panel/login.php?durum=no");
    }
}

//Kullanıcı Ekle Bitiş


//Urun Ekle Başlangıç

if(isset($_POST['urunEkle'])){

    $urunEkle=$db->prepare("INSERT INTO urun SET
        urunAd=:urunAd
    ");

    $insert=$urunEkle->execute(array(
        'urunAd' => $_POST['urunAd']
    ));

    if ($insert) {

		echo "ok";

	} else {

		echo "hata";
	}
}

//Urun Ekle Bitiş


//Bakiye Ekle Başlangıç

if(isset($_POST['bakiyeEkle'])){

    $bakiyeEkle=$db->prepare("INSERT INTO bakiye SET
        kullaniciId=:kullaniciId,
        bakiyePara=:bakiyePara,
        bakiyeKur=:bakiyeKur
    ");

    $insert=$bakiyeEkle->execute(array(
        'kullaniciId' => $_POST['kullaniciId'],
        'bakiyePara' => $_POST['bakiyePara'],
        'bakiyeKur' => $_POST['bakiyeKur']
    ));

    if ($insert) {

		echo "ok";

	} else {

		echo "hata";
	}
}

//Bakiye Ekle Bitiş

//Kullanıcı Ürün Ekle Başlangıç

if(isset($_POST['kullaniciUrunEkle'])){

    $bakiyeEkle=$db->prepare("INSERT INTO kullaniciurun SET
        kullaniciId=:kullaniciId,
        urunId=:urunId,
        kullaniciurunMiktar=:kullaniciurunMiktar,
        kullaniciurunFiyat=:kullaniciurunFiyat
    ");

    $insert=$bakiyeEkle->execute(array(
        'kullaniciId' => $_SESSION['oturumId'],
        'urunId' => $_POST['urunId'],
        'kullaniciurunMiktar' => $_POST['kullaniciurunMiktar'],
        'kullaniciurunFiyat' => $_POST['kullaniciurunFiyat']
    ));

    if ($insert) {
        echo "ok";  
    }else {
        echo "hata";
    } 

}

//Kullanıcı Ürün Ekle Bitiş

//Bakiye Onay Başlangıç

if (isset($_GET['bakiyeOnayla'])) {

    if($_GET['bakiyeOnayla']=="ok") {
        
        $kaydet=$db->prepare("UPDATE bakiye SET
        bakiyeOnay=:bakiyeOnay
        WHERE bakiyeId={$_GET['bakiyeId']}");

        $update=$kaydet->execute(array(
            'bakiyeOnay' => 1
        ));

        if ($update) {
            $bakiyeSor=$db->prepare("SELECT * FROM bakiye 
                JOIN kullanici ON bakiye.kullaniciId=kullanici.kullaniciId 
                WHERE bakiyeId=:bakiyeId"
            );
            $bakiyeSor->execute(array(
                'bakiyeId'=> $_GET['bakiyeId']
            ));
            $bakiyeCek=$bakiyeSor->fetch(PDO::FETCH_ASSOC);  

            $connect_web = simplexml_load_file('http://www.tcmb.gov.tr/kurlar/today.xml');

            if ($bakiyeCek["bakiyeKur"]==1) {
                $kur = $connect_web->Currency[0]->BanknoteBuying;
            }elseif ($bakiyeCek["bakiyeKur"]==2) {
                $kur = $connect_web->Currency[3]->BanknoteBuying;
            }elseif ($bakiyeCek["bakiyeKur"]==3) {
                $kur = $connect_web->Currency[5]->BanknoteBuying;
            }elseif ($bakiyeCek["bakiyeKur"]==0) {
                $kur = 1;
            }

            $yeniBakiye = $bakiyeCek["kullaniciPara"]+($bakiyeCek["bakiyePara"]*$kur);


            $bakiyeDuzenle=$db->prepare("UPDATE kullanici SET
                kullaniciPara=:kullaniciPara
                WHERE kullaniciId={$bakiyeCek['kullaniciId']}
            ");

            $islem=$bakiyeDuzenle->execute(array(
                'kullaniciPara' => $yeniBakiye
            ));

        }else {
            header("Location:../panel/onay.php?durum=no");
        }
    
        
    }elseif ($_GET['bakiyeOnayla']=="no") {
        $bakiyeId=$_GET['bakiyeId'];
    
        $bakiyeSil=$db->prepare("DELETE FROM bakiye WHERE bakiyeId={$bakiyeId}");
        $islem=$bakiyeSil->execute();
    }

    if($islem){
        header("Location:../panel/onay.php?durum=ok");
    } else {
        header("Location:../panel/onay.php?durum=no");
    }

}

//Bakiye Onay Bitiş

//Kullanici Ürün Onay Başlangıç

if (isset($_GET['kullaniciurunOnayla'])) {

    $kullaniciurunId=$_GET['kullaniciurunId'];

    if($_GET['kullaniciurunOnayla']=="ok") {
        
        $kaydet=$db->prepare("UPDATE kullaniciurun SET
        kullaniciurunOnay=:kullaniciurunOnay
        WHERE kullaniciurunId={$kullaniciurunId}");

        $islem=$kaydet->execute(array(
            'kullaniciurunOnay' => 1
        )); 

        $urunSor=$db->prepare("SELECT * FROM kullaniciurun
        LEFT JOIN kullanici ON kullaniciurun.kullaniciId=kullanici.kullaniciId
        WHERE kullaniciurunId=:kullaniciurunId");
        $urunSor->execute(array(
            'kullaniciurunId'=> $kullaniciurunId
        ));

        $urunCek=$urunSor->fetch(PDO::FETCH_ASSOC);


        $siparisSor=$db->prepare("SELECT * FROM siparis
            LEFT JOIN kullanici ON siparis.kullaniciId=kullanici.kullaniciId
            WHERE urunId=:urunId AND kullaniciurunMiktar<=:kullaniciurunMiktar AND kullaniciurunFiyat=:kullaniciurunFiyat AND siparisDurum=:siparisDurum
            ORDER BY kullaniciurunFiyat ASC"
        );

        $siparisSor->execute(array(
            'urunId'=> $urunCek['urunId'],
            'kullaniciurunMiktar'=> $urunCek['kullaniciurunMiktar'],
            'kullaniciurunFiyat'=> $urunCek['kullaniciurunFiyat'],
            'siparisDurum'=> 0
        ));

        $siparisCek=$siparisSor->fetch(PDO::FETCH_ASSOC);  
        $say=$siparisSor->rowCount();
        $adet=$siparisCek['kullaniciurunMiktar'];
        $odenen=0;
        if ($say>0) {

            $sonMiktar=$urunCek['kullaniciurunMiktar']-$adet;
            $odenen=$adet*$urunCek['kullaniciurunFiyat'];
            $adet=0;


            $duzenle=$db->prepare("UPDATE kullaniciurun SET
                kullaniciurunMiktar=:kullaniciurunMiktar
                WHERE kullaniciurunId={$urunCek['kullaniciurunId']}"
            );
            
            $islem=$duzenle->execute(array(
                'kullaniciurunMiktar' => $sonMiktar
            ));

            $duzenle2=$db->prepare("UPDATE siparis SET
                siparisDurum=:siparisDurum
                WHERE siparisId={$siparisCek['siparisId']}"
            );
            
            $islem2=$duzenle2->execute(array(
                'siparisDurum' => 1
            ));

            if ($islem2) {

                $aliciPara=$siparisCek['kullaniciPara'];
                $saticiPara=$urunCek['kullaniciPara'];

                $sonAliciPara=$aliciPara-$odenen;
                $sonSaticiPara=$saticiPara+$odenen;
                    
                $duzenle3=$db->prepare("UPDATE kullanici SET
                    kullaniciPara=:kullaniciPara
                    WHERE kullaniciId={$siparisCek['kullaniciId']}"
                );
                
                $islem3=$duzenle3->execute(array(
                    'kullaniciPara' => $sonAliciPara
                ));

                $duzenle4=$db->prepare("UPDATE kullanici SET
                    kullaniciPara=:kullaniciPara
                    WHERE kullaniciId={$urunCek['kullaniciId']}"
                );
                
                $islem4=$duzenle4->execute(array(
                    'kullaniciPara' => $sonSaticiPara
                ));

                if($islem4){
                    header("Location:../panel/onay.php?durum=ok");
                } else {
                    header("Location:../panel/onay.php?durum=no");
                }

            }else {
                header("Location:../panel/onay.php?durum=no");
            }      
        }
    }elseif ($_GET['kullaniciurunOnayla']=="no") {
        
        $kullaniciurunSil=$db->prepare("DELETE FROM kullaniciurun WHERE kullaniciurunId={$kullaniciurunId}");
        $islem=$kullaniciurunSil->execute();

    }

    if($islem){
        header("Location:../panel/onay.php?durum=ok");
    } else {
        header("Location:../panel/onay.php?durum=no");
    }

    
}

//Kullanici Ürün Onay Bitiş


//Satın Alma Başlangıç

if (isset($_POST['urunSatınAl'])) {

    $siparisEkle=$db->prepare("INSERT INTO siparis SET
        kullaniciId=:kullaniciId,
        urunId=:urunId,
        kullaniciurunMiktar=:urunMiktar,
        kullaniciurunFiyat=:urunFiyat
    ");

    $insert=$siparisEkle->execute(array(
        'kullaniciId' => $_SESSION['oturumId'],
        'urunId' => $_POST['urunId'],
        'urunMiktar' => $_POST['urunMiktar'],
        'urunFiyat' => $_POST['urunFiyat']
    ));

    $siparisSor=$db->prepare("SELECT * FROM siparis WHERE kullaniciId=:kullaniciId");
    $siparisSor->execute(array(
        'kullaniciId'=> $_SESSION['oturumId']
    ));

    $siparisCek=$siparisSor->fetch(PDO::FETCH_ASSOC);

    $adet=$_POST['urunMiktar'];


    $otorumSor=$db->prepare("SELECT * FROM kullanici where kullaniciId=:kullaniciId");
    $otorumSor->execute(array(
        'kullaniciId' => $_SESSION['oturumId']
    ));

    $oturumCek=$otorumSor->fetch(PDO::FETCH_ASSOC);

    $urunSor=$db->prepare("SELECT * FROM kullaniciurun
        LEFT JOIN kullanici ON kullaniciurun.kullaniciId=kullanici.kullaniciId
        WHERE urunId=:urunId AND kullaniciurunMiktar>=:urunMiktar AND kullaniciurunFiyat=:urunFiyat
        ORDER BY kullaniciurunFiyat ASC"
    );
    $urunSor->execute(array(
        'urunId'=> $_POST['urunId'],
        'urunMiktar'=> $adet,
        'urunFiyat'=> $_POST['urunFiyat']
    ));
    $urunCek=$urunSor->fetch(PDO::FETCH_ASSOC);  
    $say=$urunSor->rowCount();
    $odenen=0;
    if ($say>0) {

        $sonMiktar=$urunCek['kullaniciurunMiktar']-$adet;
        $odenen=$adet*$urunCek['kullaniciurunFiyat'];
        $adet=0;


        $duzenle=$db->prepare("UPDATE kullaniciurun SET
            kullaniciurunMiktar=:kullaniciurunMiktar
            WHERE kullaniciurunId={$urunCek['kullaniciurunId']}"
        );
        
        $islem=$duzenle->execute(array(
            'kullaniciurunMiktar' => $sonMiktar
        ));

        $duzenle2=$db->prepare("UPDATE siparis SET
            siparisDurum=:siparisDurum
            WHERE siparisId={$siparisCek['siparisId']}"
        );
        
        $islem2=$duzenle2->execute(array(
            'siparisDurum' => 1
        ));

        if ($islem2) {
            $muhasebeSor=$db->prepare("SELECT * FROM kullanici where kullaniciYetki=:kullaniciYetki");
            $muhasebeSor->execute(array(
                'kullaniciYetki' => 2
            ));
            $muhasebeCek=$muhasebeSor->fetch(PDO::FETCH_ASSOC);

            $aliciPara=$oturumCek['kullaniciPara'];
            $saticiPara=$urunCek['kullaniciPara'];
            $muhasebePara=$muhasebeCek['kullaniciPara'];

            $muhasebeOneden=($odenen*1/100);

            $sonAliciPara=$aliciPara-$odenen-$muhasebeOneden;
            $sonSaticiPara=$saticiPara+$odenen;
            $sonMuhasebePara=$muhasebePara+$muhasebeOneden;
                
            $duzenle3=$db->prepare("UPDATE kullanici SET
                kullaniciPara=:kullaniciPara
                WHERE kullaniciId={$oturumCek['kullaniciId']}"
            );
            
            $islem3=$duzenle3->execute(array(
                'kullaniciPara' => $sonAliciPara
            ));

            $duzenle4=$db->prepare("UPDATE kullanici SET
                kullaniciPara=:kullaniciPara
                WHERE kullaniciId={$urunCek['kullaniciId']}"
            );
            
            $islem4=$duzenle4->execute(array(
                'kullaniciPara' => $sonSaticiPara
            ));

            $duzenle5=$db->prepare("UPDATE kullanici SET
                kullaniciPara=:kullaniciPara
                WHERE kullaniciYetki='2'"
            );
            
            $islem5=$duzenle5->execute(array(
                'kullaniciPara' => $sonMuhasebePara
            ));

            if($islem5){
                header("Location:../panel/index.php?durum=alım");
            } else {
                header("Location:../panel/index.php?durum=no");
            }

        }else {
            header("Location:../panel/index.php?durum=no");
        }      

    }else {
        header("Location:../panel/index.php?durum=sipariş");      
    }

}

//Satın Alma Bitiş