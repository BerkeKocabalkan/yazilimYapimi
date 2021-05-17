<!doctype html>
<html class="fixed">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

        <title>Giris</title>

		<meta name="keywords" content="HTML5 Admin Template" />
		<meta name="description" content="Porto Admin - Responsive HTML5 Template">
		<meta name="author" content="okler.net">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="assets/vendor/magnific-popup/magnific-popup.css" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="assets/stylesheets/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme-custom.css">

		<!-- Head Libs -->
		<script src="assets/vendor/modernizr/modernizr.js"></script>

	</head>
	<body>
		<!-- start: page -->
		<section class="body-sign">
			<div class="center-sign" style="padding-bottom:5px;">

				<div class="panel panel-sign">
					<div class="panel-title-sign mt-xl text-right">
						<h2 class="title text-uppercase text-bold m-none"><i class="fa fa-user mr-xs"></i>Giriş</h2>
					</div>
					<div class="panel-body">
						<form action="../netting/islem.php" method="POST">
							<div class="form-group mb-lg">
								<label>Kullanıcı Mail</label>
								<div class="input-group input-group-icon">
									<input name="kullaniciMail" type="text" class="form-control input-lg" />
									<span class="input-group-addon">
										<span class="icon icon-lg">
											<i class="fa fa-user"></i>
										</span>
									</span>
								</div>
							</div>

							<div class="form-group mb-lg">
								<div class="clearfix">
                                    <label class="pull-left">Şifre</label>
                                    <!--
                                    <a href="pages-recover-password.html" class="pull-right">Şifremi Unuttum</a>
                                    -->
								</div>
								<div class="input-group input-group-icon">
									<input name="kullaniciPass" type="password" class="form-control input-lg" />
									<span class="input-group-addon">
										<span class="icon icon-lg">
											<i class="fa fa-lock"></i>
										</span>
									</span>
								</div>
							</div>
                        
							<div class="row" style="padding-bottom:5px;">
								<div class="col-sm-12 text-right">
									<button type="submit" name="adminGiris" class="btn btn-primary hidden-xs float-right">Giriş</button>
									<a href="kayit.php" class="btn btn-primary hidden-xs">Kayıt Ol</a>
									<button type="submit" name="adminGiris" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Giriş</button>
									<a href="kayit.php" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Kayıt Ol</a>
								</div>
							</div>

                            <p class="text-center" style="color: red;">
                                
                                <?php 
                                if(isset($_GET['durum']))
                                {
                                    if(($_GET['durum'])=="no")
									{
										echo ("Hatalı mail yada şifre");
									}
                                }	
								?>
                            </p>

							<p class="text-center" style="color: green;">
                                
                                <?php 
                                if(isset($_GET['durum']))
                                {
                                    if(($_GET['durum'])=="ok")
									{
										echo ("Hesap Açıldı");
									}
                                }	
								?>
                            </p>
                            
						</form>
					</div>
				</div>
                <!--
                <p class="text-center text-muted mt-md mb-md">&copy; Copyright 2018. All rights reserved. Template by <a href="https://colorlib.com">Colorlib</a>.</p>
                --> 
			</div>
		</section>
		<!-- end: page -->

		<!-- Vendor -->
		<script src="assets/vendor/jquery/jquery.js"></script>
		<script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="assets/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
		

	</body>
</html>