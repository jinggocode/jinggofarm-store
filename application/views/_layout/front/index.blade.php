
<?php
$page     = $this->uri->segment(1);
$sub_page = $this->uri->segment(2);
if ($page == 'user' && $sub_page != "sign_up") {
  if (!$this->ion_auth->logged_in())
  {
    // redirect them to the login page
    redirect('auth/sign_in', 'refresh');
  }
}
?>

<!DOCTYPE html>
<html lang="en"> 
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') | Jinggofarm Store - Susu Segar dan Produk Olahan Susu</title>
    <meta name="description" content="Toko Online Peternakan, Susu murni, Fresh Milk, Produk Olahan Susu">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="https://d19m59y37dris4.cloudfront.net/hub/1-3-0/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="https://d19m59y37dris4.cloudfront.net/hub/1-3-0/vendor/font-awesome/css/font-awesome.min.css">
    <!-- Bootstrap Select-->
    <link rel="stylesheet" href="https://d19m59y37dris4.cloudfront.net/hub/1-3-0/vendor/bootstrap-select/css/bootstrap-select.min.css">
    <!-- Price Slider Stylesheets -->
    <link rel="stylesheet" href="https://d19m59y37dris4.cloudfront.net/hub/1-3-0/vendor/nouislider/nouislider.css"> 
    <!-- Custom font icons-->
    <link rel="stylesheet" href="https://d19m59y37dris4.cloudfront.net/hub/1-3-0/css/custom-fonticons.css">
    <!-- Sweet Alert-->
    <script src="{{base_url()}}assets/vendor/sweetalert/sweetalert.min.js"></script>
    <!-- Google fonts - Poppins-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,700">
    <!-- owl carousel-->
    <link rel="stylesheet" href="https://d19m59y37dris4.cloudfront.net/hub/1-3-0/vendor/owl.carousel/assets/owl.carousel.css">
    <link rel="stylesheet" href="https://d19m59y37dris4.cloudfront.net/hub/1-3-0/vendor/owl.carousel/assets/owl.theme.default.css">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="https://d19m59y37dris4.cloudfront.net/hub/1-3-0/css/style.green.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{base_url('assets/pelanggan/')}}css/custom.css"> 

    <!-- Favicon-->
    <link rel="shortcut icon" href="{{base_url('assets/image/logo1.png')}}">
    <!-- Modernizr-->
    <script src="https://d19m59y37dris4.cloudfront.net/hub/1-3-0/js/modernizr.custom.79639.js"></script>
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
  <body>
    <!-- navbar-->
    @include('_layout/front/header')

    @yield('content')

    <div id="scrollTop"><i class="fa fa-long-arrow-up"></i></div>

    <!-- Footer-->
    <footer class="main-footer">
      <!-- Service Block-->
      <div class="services-block">
        <div class="container">
          <div class="row">
            <div class="col-lg-4 d-flex justify-content-center justify-content-lg-start">
              <div class="item d-flex align-items-center">
                <div class="icon"><i class="icon-truck"></i></div>
                <div class="text">
                  <h6 class="no-margin text-uppercase">Pengiriman Cepat</h6><span>Melalui Ekspedisi Terpercaya</span>
                </div>
              </div>
            </div>
            <div class="col-lg-4 d-flex justify-content-center">
              <div class="item d-flex align-items-center">
                <div class="icon"><i class="icon-coin"></i></div>
                <div class="text">
                  <h6 class="no-margin text-uppercase">Garansi Uang Kembali</h6><span>Uang Kembali bila Produk tidak sesuai</span>
                </div>
              </div>
            </div>
            <div class="col-lg-4 d-flex justify-content-center">
              <div class="item d-flex align-items-center">
                <div class="icon"><i class="icon-headphones"></i></div>
                <div class="text">
                  <h6 class="no-margin text-uppercase">081-135-813-44</h6><span>24/7 Kami siap membantu!</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Main Block -->
      <div class="main-block">
        <div class="container">
          <div class="row">
            <div class="info col-lg-4">
              <div class="logo"><img src="{{base_url('assets/image/logo-white.png')}}" width="200" alt="..."></div>
              <p>Dikelola oleh Kelompok Ternak Sumber Lumintu <br> Kecamatan Genteng, Kabupaten Banyuwangi</p>
              <ul class="social-menu list-inline">
                <li class="list-inline-item"><a href="#" target="_blank" title="twitter"><i class="fa fa-twitter"></i></a></li>
                <li class="list-inline-item"><a href="#" target="_blank" title="facebook"><i class="fa fa-facebook"></i></a></li>
                <li class="list-inline-item"><a href="#" target="_blank" title="instagram"><i class="fa fa-instagram"></i></a></li>
                <li class="list-inline-item"><a href="#" target="_blank" title="pinterest"><i class="fa fa-pinterest"></i></a></li>
                <li class="list-inline-item"><a href="#" target="_blank" title="vimeo"><i class="fa fa-vimeo"></i></a></li>
              </ul>
            </div>
            <div class="site-links col-lg-2 col-md-6">
            </div>
            <div class="site-links col-lg-2 col-md-6">
              <h5 class="text-uppercase">Kategori Artikel</h5>
              <ul class="list-unstyled">
                <li> <a href="#">Umum</a></li>
                <li> <a href="#">Kesehatan</a></li>
                <li> <a href="#">Resep</a></li> 
              </ul>
            </div>
            <div class="site-links col-lg-2 col-md-6">
              <h5 class="text-uppercase">Kategori Produk</h5>
              <ul class="list-unstyled">
                <li> <a href="#">Makanan</a></li>
                <li> <a href="#">Kesehatan</a></li>
                <li> <a href="#">Kerajinan</a></li> 
              </ul>
            </div>
            <div class="site-links col-lg-2 col-md-6">
              <h5 class="text-uppercase">Link Cepat</h5>
              <ul class="list-unstyled">
                <li> <a href="#">Login</a></li>
                <li> <a href="#">Daftar</a></li>
                <li> <a href="#">Daftar Produk</a></li>
                <li> <a href="#">Cara Pemesanan</a></li>
                <li> <a href="#">Tentang Kami</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="copyrights">
        <div class="container">
          <div class="row d-flex align-items-center">
            <div class="text col-md-6">
              <p>&copy; 2017 <a href="https://ondrejsvestka.cz" target="_blank">PoliwangiDev </a> All rights reserved.</p>
            </div>
            <div class="payment col-md-6 clearfix">
              <ul class="payment-list list-inline-item pull-right">
                <li class="list-inline-item"><img src="https://d19m59y37dris4.cloudfront.net/hub/1-3-0/img/visa.svg" alt="..."></li>
                <li class="list-inline-item"><img src="https://d19m59y37dris4.cloudfront.net/hub/1-3-0/img/mastercard.svg" alt="..."></li>
                <li class="list-inline-item"><img src="https://d19m59y37dris4.cloudfront.net/hub/1-3-0/img/paypal.svg" alt="..."></li>
                <li class="list-inline-item"><img src="https://d19m59y37dris4.cloudfront.net/hub/1-3-0/img/western-union.svg" alt="..."></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </footer> 

    @yield('modal')

    <!-- Javascript files-->
    <script src="https://d19m59y37dris4.cloudfront.net/hub/1-3-0/vendor/jquery/jquery.min.js"></script>
    <script src="https://d19m59y37dris4.cloudfront.net/hub/1-3-0/vendor/popper.js/umd/popper.min.js"> </script>
    <script src="https://d19m59y37dris4.cloudfront.net/hub/1-3-0/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://d19m59y37dris4.cloudfront.net/hub/1-3-0/vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="https://d19m59y37dris4.cloudfront.net/hub/1-3-0/vendor/owl.carousel/owl.carousel.min.js"></script>
    <script src="https://d19m59y37dris4.cloudfront.net/hub/1-3-0/vendor/owl.carousel2.thumbs/owl.carousel2.thumbs.min.js"></script>
    <script src="https://d19m59y37dris4.cloudfront.net/hub/1-3-0/vendor/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="https://d19m59y37dris4.cloudfront.net/hub/1-3-0/vendor/nouislider/nouislider.min.js"></script>
    <script src="https://d19m59y37dris4.cloudfront.net/hub/1-3-0/js/front.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/randomcolor/0.4.2/randomColor.min.js"></script>
    <script src="{{base_url('assets/vendor/jquery-loading/')}}dist/loadingoverlay.min.js"></script>

    <script> 
    @if($this->session->userdata('message')) 
      <?php $message = $this->session->userdata('message');?>
      function sweet(){
        swal("Informasi", "{{ $message[0] }}", "{{ $message[1] }}");
      } 
      window.onload = sweet;
    @endif 
      function faseDevelopment() {
        swal("Whoops Maaf, Masih dalam tahap pengembangan", "Doakan yaa :)", "success"); 
      }
    </script>
    
    @yield('script')
  </body>
</html>