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
        bakiyePara=:bakiyePara
    ");

    $insert=$bakiyeEkle->execute(array(
        'kullaniciId' => $_POST['kullaniciId'],
        'bakiyePara' => $_POST['bakiyePara']
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
        'kullaniciId' => $_POST['kullaniciId'],
        'urunId' => $_POST['urunId'],
        'kullaniciurunMiktar' => $_POST['kullaniciurunMiktar'],
        'kullaniciurunFiyat' => $_POST['kullaniciurunFiyat']
    ));

    if ($insert) {

		echo "ok";

	} else {

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

            $yeniBakiye = $bakiyeCek["kullaniciPara"]+$bakiyeCek["bakiyePara"];


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

    $adet=$_POST['urunAdet'];

    while ($adet!=0) {

        $otorumSor=$db->prepare("SELECT * FROM kullanici where kullaniciId=:kullaniciId");
        $otorumSor->execute(array(
            'kullaniciId' => $_SESSION['oturumId']
        ));

        $oturumCek=$otorumSor->fetch(PDO::FETCH_ASSOC);

        $urunSor=$db->prepare("SELECT * FROM kullaniciurun
        LEFT JOIN kullanici ON kullaniciurun.kullaniciId=kullanici.kullaniciId
        WHERE urunId=:urunId AND kullaniciurunMiktar>0
        ORDER BY kullaniciurunFiyat ASC");
        $urunSor->execute(array(
            'urunId'=> $_POST['urunId']
        ));
        $urunCek=$urunSor->fetch(PDO::FETCH_ASSOC);  
        $say=$urunSor->rowCount();
        $odenen=0;
        if ($say>0) {

            $alınabilirAdet=floor($oturumCek['kullaniciPara']/$urunCek['kullaniciurunFiyat']);
            if ($alınabilirAdet<1) {
                header("Location:../panel/index.php?durum=yetersiz");
                break;       
            }elseif ($alınabilirAdet>$adet) {

                if ($urunCek['kullaniciurunMiktar']>=$adet) {
                    $sonMiktar=$urunCek['kullaniciurunMiktar']-$adet;
                    $odenen=$adet*$urunCek['kullaniciurunFiyat'];
                    $adet=0;
                }else {
                    $adet=$adet-$urunCek['kullaniciurunMiktar'];
                    $odenen=$urunCek['kullaniciurunMiktar']*$urunCek['kullaniciurunFiyat'];
                    $sonMiktar=0;
                }

            }else {
                if ($urunCek['kullaniciurunMiktar']>=$alınabilirAdet) {
                    $sonMiktar=$urunCek['kullaniciurunMiktar']-$alınabilirAdet;
                    $odenen=$alınabilirAdet*$urunCek['kullaniciurunFiyat'];
                    $adet=0;
                }else {
                    $adet=$alınabilirAdet-$urunCek['kullaniciurunMiktar'];
                    $odenen=$urunCek['kullaniciurunMiktar']*$urunCek['kullaniciurunFiyat'];
                    $sonMiktar=0;
                }
            }

            $duzenle=$db->prepare("UPDATE kullaniciurun SET
                kullaniciurunMiktar=:kullaniciurunMiktar
                WHERE kullaniciurunId={$urunCek['kullaniciurunId']}"
            );
        
            $islem=$duzenle->execute(array(
                'kullaniciurunMiktar' => $sonMiktar
            ));

            if ($islem) {

                $aliciPara=$oturumCek['kullaniciPara'];
                $saticiPara=$urunCek['kullaniciPara'];

                $sonAliciPara=$aliciPara-$odenen;
                $sonSaticiPara=$saticiPara+$odenen;
                
                $duzenle2=$db->prepare("UPDATE kullanici SET
                    kullaniciPara=:kullaniciPara
                    WHERE kullaniciId={$oturumCek['kullaniciId']}"
                );
            
                $islem2=$duzenle2->execute(array(
                    'kullaniciPara' => $sonAliciPara
                ));

                $duzenle3=$db->prepare("UPDATE kullanici SET
                    kullaniciPara=:kullaniciPara
                    WHERE kullaniciId={$urunCek['kullaniciId']}"
                );
            
                $islem3=$duzenle3->execute(array(
                    'kullaniciPara' => $sonSaticiPara
                ));

            }else {
                header("Location:../panel/index.php?durum=no");
            }
            

            

        }else {

            header("Location:../panel/index.php?durum=yetersiz");
            break;        
        }

        
         
    }

    if($islem3){
        header("Location:../panel/index.php?durum=ok");
    } else {
        header("Location:../panel/index.php?durum=no");
    }

}

//Satın Alma Bitiş