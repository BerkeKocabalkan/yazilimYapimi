<?php
  include("header.php");

  $urunSor=$db->prepare("SELECT * FROM kullaniciurun
  LEFT JOIN urun ON urun.urunId=kullaniciurun.urunId
  WHERE kullaniciurunMiktar>0 and kullaniciurunOnay='1'");
  $urunSor->execute(array());

  $siparisSor=$db->prepare("SELECT * FROM siparis
  LEFT JOIN urun ON urun.urunId=siparis.urunId
  WHERE siparisDurum='0'");
  $siparisSor->execute(array());
?>

  <div class="container-flued m-5">
    <div class="row">
      <div class="col-12 content-div p-3">
        <h4 class="baslik">Bakiye: <?php echo $oturumCek['kullaniciPara']; ?></h4>


                  <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModalUrunAl">
                    Satın Al
                  </button>

                  <!-- Modal -->
                  <form action="../netting/islem.php" method="POST">
                  <div class="modal fade" id="exampleModalUrunAl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Ürün Al</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          
                            <div class="form-group">
                              <label>Ürün Seç</label>
                              <select class="form-control" name="urunId" id="urunId2">
                              </select>
                            </div> 
                            <div class="form-group">
                              <label>Miktar</label>
                              <input type="number" class="form-control" name="urunMiktar" required placeholder="Miktar Girin">
                            </div>           
                            <div class="form-group">
                              <label>Miktar</label>
                              <input type="number" class="form-control" name="urunFiyat" required placeholder="Miktar Girin">
                            </div>             
                          
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                          <button name="urunSatınAl" type="submit" class="btn btn-primary">Al</button>
                        </div>
                      </div>
                    </div>
                  </div> 
                  </form>
        <br>
        <br>
        <hr>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Ürün Adı</th>
              <th scope="col">Miktar</th>
              <th scope="col">Fiyat</th>
            </tr>
          </thead>
          <tbody>
            <?php
                $say=0;
                while($urunCek=$urunSor->fetch(PDO::FETCH_ASSOC)) { $say++; ?>
            <tr>
              <th scope="row"><?php echo $say ?></th>
              <td><?php echo $urunCek['urunAd'] ?></td>
              <td><?php echo $urunCek['kullaniciurunMiktar'] ?></td>
              <td><?php echo $urunCek['kullaniciurunFiyat'] ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        
      </div>
    </div>
  </div>

  <div class="container-flued m-5">
    <div class="row">
      <div class="col-12 content-div p-3">
        <h4 class="baslik">Aktif Siparişler</h4>
        <br>
        <hr>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Ürün Adı</th>
              <th scope="col">Miktar</th>
              <th scope="col">Fiyat</th>
            </tr>
          </thead>
          <tbody>
            <?php
                $say=0;
                while($siparisCek=$siparisSor->fetch(PDO::FETCH_ASSOC)) { $say++; ?>
            <tr>
              <th scope="row"><?php echo $say ?></th>
              <td><?php echo $siparisCek['urunAd'] ?></td>
              <td><?php echo $siparisCek['kullaniciurunMiktar'] ?></td>
              <td><?php echo $siparisCek['kullaniciurunFiyat'] ?></td>
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