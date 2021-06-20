
  <footer>
    <div class="container-flued bg-primary fixed-bottom p-1 px-4 text-right text-white">
      Copyright © 2021 Reel Yazılım
    </div>
  </footer>

     <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    

    
  
  <script>

    $(document).ready( function () {
      $(function() {
        $('nav a[href^="' + location.pathname.split("panel/")[1] + '"]').addClass('active');

        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const durum = urlParams.get('durum');
        if(durum=="ok"){
          sweetAlert('Başarılı',"İşlem Başarılı","success");
        }else if(durum=="no"){
          sweetAlert('Hata',"Bir hata oluştu","error");
        }else if(durum=="sipariş"){
          sweetAlert('Başarılı',"Siparişiniz Başarılı","success");
        }else if(durum=="alım"){
          sweetAlert('Başarılı',"Siparişinizin alım işlemi gerçekleşmiştir","success");
        }else if(durum=="satım"){
          sweetAlert('Başarılı',"Satışınız yapılmıştır","success");
        }
      });
    });

  </script>



</body>
</html>