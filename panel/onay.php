<?php
  include("header.php");

  $bakiyeSor=$db->prepare("SELECT * FROM bakiye
  LEFT JOIN kullanici ON bakiye.kullaniciId=kullanici.kullaniciId
  WHERE bakiyeOnay='0'");
  $bakiyeSor->execute(array());

  $kullaniciUrunSor=$db->prepare("SELECT * FROM kullaniciurun
  LEFT JOIN kullanici ON kullaniciurun.kullaniciId=kullanici.kullaniciId
  LEFT JOIN urun ON kullaniciurun.urunId=urun.urunId
  WHERE kullaniciurunOnay='0'");
  $kullaniciUrunSor->execute(array());
?>

  <div class="container-flued m-5">
    <div class="row">
      <div class="col-12 content-div p-3">
        <h4 class="baslik">Onay</h4>

        <br>
        <hr>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">İşlem</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <?php
                $say=0;
                while($bakiyeCek=$bakiyeSor->fetch(PDO::FETCH_ASSOC)) { $say++; ?>
                    <tr>
                    <th scope="row"><?php echo $say ?></th>
                    <td><?php echo $bakiyeCek['kullaniciTakmaAd']." Adlı kullanıcı ".$bakiyeCek['bakiyePara']."TL bakiye talep ediyor." ?></td>
                    <td><center>
                        <a href="../netting/islem.php?bakiyeId=<?php echo $bakiyeCek['bakiyeId']; ?>&bakiyeOnayla=ok&kullaniciId=<?php echo $bakiyeCek['kullaniciId']; ?>"><button class="btn btn-success btn-s">Onayla</button></a>
                        <a href="../netting/islem.php?bakiyeId=<?php echo $bakiyeCek['bakiyeId']; ?>&bakiyeOnayla=no&kullaniciId=<?php echo $bakiyeCek['kullaniciId']; ?>"><button class="btn btn-danger btn-s">Sil</button></a>
                    </center></td>
                    </tr>
                <?php } ?>

            <?php
                while($kullaniciUrunCek=$kullaniciUrunSor->fetch(PDO::FETCH_ASSOC)) { $say++; ?>
                    <tr>
                    <th scope="row"><?php echo $say ?></th>
                    <td><?php echo $kullaniciUrunCek['kullaniciTakmaAd']." adlı kullanıcı ".$kullaniciUrunCek['urunAd']." ürününü ".$kullaniciUrunCek['kullaniciurunMiktar']." tane ".$kullaniciUrunCek['kullaniciurunFiyat']."TL fiyattan satmak istiyor." ?></td>
                    <td><center>
                        <a href="../netting/islem.php?kullaniciurunId=<?php echo $kullaniciUrunCek['kullaniciurunId']; ?>&kullaniciurunOnayla=ok"><button class="btn btn-success btn-s">Onayla</button></a>
                        <a href="../netting/islem.php?kullaniciurunId=<?php echo $kullaniciUrunCek['kullaniciurunId']; ?>&kullaniciurunOnayla=no"><button class="btn btn-danger btn-s">Sil</button></a>
                    </center></td>
                    </tr>
            <?php } ?>
          </tbody>
        </table>
        
      </div>
    </div>
  </div>

<?php
  include("footer.php");
?>