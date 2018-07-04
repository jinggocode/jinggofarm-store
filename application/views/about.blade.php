@layout('_layout/front/index')

@section('title')Tentang Kami @endsection

@section('content')
<section class="hero hero-page gray-bg padding-small">
  <div class="container">
    <div class="row d-flex">
      <div class="col-lg-9 order-2 order-lg-1">
        <h1>Tentang Kami</h1>
      </div>
      <div class="col-lg-3 text-right order-1 order-lg-2">
        <ul class="breadcrumb justify-content-lg-end">
          <li class="breadcrumb-item"><a href="{{site_url()}}">Home</a></li>
          <li class="breadcrumb-item active">Tentang</li>
        </ul>
      </div>
    </div>
  </div>
</section>
<main class="contact-page">
  <!-- Contact page-->
  <section class="contact">
    <div class="container">
      <header>
        <p class="lead">
          Dikelola oleh Kelompok Ternak Sumber Lumintu yang merupakan salah satu kelompok ternak sapi perah yang berada di Kabupaten Banyuwangi. Terletak di Desa Kaligondo, Kecamatan Genteng, kelompok ternak Sumber Lumintu telah berdiri sejak tahun 2011. Ketua dan selaku pendiri kelompok ternak ini yaitu Bapak Nur Fathoni. Terdapat 12 anggota yang rutin mengirimkan susu per hari. Dalam 2 hari, kelompok ternak Sumber Lumintu dapat mengumpulkan susu sebanyak 400 liter.
        </p>
      </header>
      <div class="row">
        <div class="col-md-4">
          <div class="contact-icon">
            <div class="icon icon-street-map"></div>
          </div>
          <h3>Address</h3>
          <p>Desa Kaligondo<br>Kecamatan Genteng<br>Banyuwangi</p>
        </div>
        <div class="col-md-4">
          <div class="contact-icon">
            <div class="icon icon-support"></div>
          </div>
          <h3>Call center</h3>
          <p>Pertanyaan atau pun kritik dan saran dapat menghubungi:</p>
          <p><strong>082244213171</strong></p>
        </div>
        <div class="col-md-4">
          <div class="contact-icon">
            <div class="icon icon-envelope"></div>
          </div>
          <h3>Electronic support</h3>
          <p>Please feel free to write an email to us or to use our electronic ticketing system.</p>
          <ul class="list-style-none">
            <li><strong><a href="mailto:">info@labkode.org</a></strong></li> 
          </ul>
        </div>
      </div>
    </div>
  </section>
@endsection 

@section('cart')
<div class="cart dropdown show">
  <a id="cartdetails" href="https://example.com" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="icon-cart"></i>
  <div class="cart-no" id="cart-count-row"></div>
  </a>
  <a href="{{site_url('cart')}}" class="text-primary view-cart">Keranjang Belanja</a>
  <div aria-labelledby="cartdetails" class="dropdown-menu" id="cart-item">
    
  </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function(){ 
      // this bit needs to be loaded on every page where an ajax POST may happen
      $.ajaxSetup({
          data: {
              csrf_test_name: $.cookie('csrf_cookie_name')
          }
      }); 
         
        $('#cart-item').load("<?php echo site_url('product/load_cart');?>");
        $('#cart-count-row').load("<?php echo site_url('product/count_cart');?>");
 
        $(document).on('click','.delete_cart',function(){ 
            var r = confirm("Apakah anda Yakin?");
            if (r == true) {
              var row_id=$(this).attr("id"); 
              $.ajax({
                  url : "<?php echo site_url('product/delete_cart');?>",
                  method : "POST",
                  data : {row_id : row_id},  
                  success: function(data){
                      $('#cart-item').html(data);
                      $('#cart-count-row').load("<?php echo site_url('product/count_cart');?>");
                      sweet("Berhasil", "Dihapus dari Keranjang", "warning");
                  } 
              });
            } else { 
            }  

        });

        function sweet(tipe, pesan, icon){
          swal(tipe, pesan, icon);
        } 
        window.onload = sweet;
    });
</script>
@endsection

