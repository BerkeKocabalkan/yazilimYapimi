<?php 
    ob_start();
    session_start();
    include '../netting/baglan.php';

    error_reporting(0);

    $otorumSor=$db->prepare("SELECT * FROM kullanici where kullaniciId=:kullaniciId");
    $otorumSor->execute(array(
      'kullaniciId' => $_SESSION['oturumId']
    ));

    $say=$otorumSor->rowCount();
    $oturumCek=$otorumSor->fetch(PDO::FETCH_ASSOC);
    
    if ($say==0) {
      Header("Location:login.php?durum=izinsiz");
      exit;
    }

    

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anasayfa</title>

    <!-- Bootstrap CND -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
    
    <link rel="stylesheet" href="style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <!-- Data Table CND -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
  
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>

    <!-- Sweet Alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>



</head>
<body>
<form>
<input id="kullaniciId" type="hidden" value="<?php echo $_SESSION['oturumId'] ?>">
</form>
    <header class="section-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 col-6 pt-2"><h3>Yazılım Yapımı Proje</h3></div>
                <div class="col-md-9 col-6 py-2">
                    <div class="dropdown float-right">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <?php 
                          
                            echo $oturumCek['kullaniciTakmaAd'];

                           ?>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="logout.php">Çıkış</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     

    <div class="container-flued">

        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
          <a class="navbar-brand" href="#"></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="main_nav">
            <ul class="navbar-nav">
                <li class="nav-item"> <a class="nav-link" href="index.php"> Ana Sayfa </a> </li>
                
                <?php if ($oturumCek['kullaniciYetki']=="1") {
                  echo('<li class="nav-item"> <a class="nav-link" href="onay.php"> Onay </a> </li>');
                 } ?>

                <li class="nav-item"> 
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalUrunEkle">
                    Ürün Ekle
                  </button>

                  <!-- Modal -->
                  <div class="modal fade" id="exampleModalUrunEkle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Ürün Ekle</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form>
                            <div class="form-group">
                              <label>Ürün Seç</label>
                              <select class="form-control" name="urunId1" id="urunId1">
                              </select>
                            </div> 
                            <div class="form-group">
                              <label>Miktar</label>
                              <input type="number" class="form-control" id="kullaniciurunMiktar" placeholder="Miktar Girin">
                            </div>          
                            <div class="form-group">
                              <label>Fiyat</label>
                              <input type="number" class="form-control" id="kullaniciurunFiyat" placeholder="Fiyat Girin">
                            </div>             
                          </form>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                          <button id="kullaniciUrunEkleBtn" type="button" class="btn btn-primary">Ekle</button>
                        </div>
                      </div>
                    </div>
                  </div> 
                </li>

                <li class="nav-item"> 
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalBakiyeEkle">
                    Bakiye Ekle
                  </button>

                  <!-- Modal -->
                  <div class="modal fade" id="exampleModalBakiyeEkle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Bakiye Ekle</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form>
                            <div class="form-group">
                              <label>Para</label>
                              <input type="number" class="form-control" id="bakiyePara" placeholder="Miktar Girin">
                            </div>                   
                          </form>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                          <button id="bakiyeEkleBtn" type="button" class="btn btn-primary">Ekle</button>
                        </div>
                      </div>
                    </div>
                  </div> 
                </li>

                <li class="nav-item"> 
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalYeniUrunEkle">
                    Yeni Ürün
                  </button>

                  <!-- Modal -->
                  <div class="modal fade" id="exampleModalYeniUrunEkle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Yeni Ürün Ekle</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form>
                            <div class="form-group">
                              <label>Ürun Adı</label>
                              <input type="email" class="form-control" id="urunAd" placeholder="Ürün Adı Gir">
                            </div>                   
                          </form>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                          <button id="urunEkleBtn" type="button" class="btn btn-primary">Ekle</button>
                        </div>
                      </div>
                    </div>
                  </div> 
                </li>
                
            </ul>
           
          </div> <!-- navbar-collapse.// -->
        </div>
        </nav>
    </div>
  </header>

  <script>
  $( document ).ready(function() {
      $('#urunEkleBtn').on('click', function() {
          var urunAd = $('#urunAd').val();
          $.ajax({
            url: "../netting/islem.php",
            type: "POST",
            data: {
              urunAd: urunAd,
              urunEkle: "1"
            },
            success : function(guncelle){
              if (guncelle.trim() == "hata") {
                sweetAlert('Hata',"Bir hata oluştu","error");
              }else if(guncelle.trim() == "ok") {
                $('.modal').modal("hide");
                sweetAlert('Başarılı',"İşlem Başarılı","success");
                urunCek();
              }
            }
          });
	    });

      $('#bakiyeEkleBtn').on('click', function() {kullaniciId
          var bakiyePara = $('#bakiyePara').val();
          var kullaniciId = $('#kullaniciId').val();
          $.ajax({
            url: "../netting/islem.php",
            type: "POST",
            data: {
              bakiyePara: bakiyePara,
              kullaniciId: kullaniciId,
              bakiyeEkle: "1"
            },
            success : function(guncelle){
              if (guncelle.trim() == "hata") {
                sweetAlert('Hata',"Bir hata oluştu","error");
              }else if(guncelle.trim() == "ok") {
                $('.modal').modal("hide");
                sweetAlert('Başarılı',"İşlem Başarılı","success");
              }
            }
          });
	    });

      $('#kullaniciUrunEkleBtn').on('click', function() {kullaniciId
          var urunId = $('#urunId1').val();
          var kullaniciId = $('#kullaniciId').val();
          var kullaniciurunMiktar = $('#kullaniciurunMiktar').val();
          var kullaniciurunFiyat = $('#kullaniciurunFiyat').val();
          $.ajax({
            url: "../netting/islem.php",
            type: "POST",
            data: {
              urunId: urunId,
              kullaniciId: kullaniciId,
              kullaniciurunMiktar: kullaniciurunMiktar,
              kullaniciurunFiyat: kullaniciurunFiyat,
              kullaniciUrunEkle: "1"
            },
            success : function(guncelle){
              if (guncelle.trim() == "hata") {
                sweetAlert('Hata',"Bir hata oluştu","error");
              }else if(guncelle.trim() == "ok") {
                $('.modal').modal("hide");
                sweetAlert('Başarılı',"İşlem Başarılı","success");
              }
            }
          });
	    });

      function urunCek() {

          $("#urunId1").empty();
          $("#urunId2").empty();
          $.ajax({
            url: '../netting/geturun.php',
            type: 'post',
            data: {},
            dataType: 'json',
            success:function(response){
              var len = response.length;

              for( var i = 0; i<len; i++){

                var id = response[i]['id'];
                var name = response[i]['name'];

                $("#urunId1").append("<option value='"+id+"'>"+name+"</option>");
                $("#urunId2").append("<option value='"+id+"'>"+name+"</option>");

              }
          }
                    
        });

      }

      urunCek();
  });
  </script>
