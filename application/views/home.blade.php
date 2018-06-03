@layout('_layout/front/index')

@section('title')Selamat Datang@endsection

@section('content')
<!-- Hero Section-->
<section class="hero hero-home no-padding">
  <!-- Hero Slider-->
  <div class="owl-carousel owl-theme hero-slider">
    <div style="background: url({{base_url('assets/image/sabun.jpg')}});" class="item d-flex align-items-center has-pattern">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <h1>Sabun Susu</h1>
            <ul class="lead"> 
              <li><strong class="text-primary">Susu Murni</strong> Sapi atau Kambing</li>
              <li>Membantu <strong>Melembabkan</strong> Kulit</li>
              <li>Menghilangkan<strong> Jerawat</strong> </li>
              <li>Menjadikan<strong> Kulit</strong> Terlihat<strong> Cantik Alami</strong></li>
            </ul><a href="{{site_url('product')}}" class="btn btn-template wide shop-now">Shop Now<i class="icon-bag"> </i></a>
          </div> 
        </div>
      </div>
    </div> 
  </div>
</section> 
<!-- Men's Collection -->
<section class="men-collection white-bg"> 
  <div class="container">
    <header class="text-center">
      <h2 class="text-uppercase"><small>Daftar</small>Produk</h2>
    </header>
    <!-- Products Slider-->
    <div class="row">
      <!-- item-->
      @foreach ($product as $row) 
        <div class="col-xl-3 col-lg-4 col-md-6" style="display: flex; padding: 20px">
          <div class="card card-hover" style="width: 18rem; cursor: pointer;" onclick="window.location.href='{{site_url('product/detail/'.$row->id.'/'.$row->slug)}}'"> 
            <img class="card-img-top" src="{{base_url('uploads/product/'.$row->foto)}}" alt="Card image cap">
            <div class="card-body">
              <label style="font-size: 13px; margin-bottom: -2px">{{$row->kategori->nama}}</label>
              <h5 class="card-title" style="margin-bottom: -2px">{{$row->nama}}</h5>
              <span class="badge badge-primary" style="margin-bottom: 13px">Tersedia</span>
              <p class="card-text" style="font-size: 20px">{{money($row->harga_jual)}}</p>
            </div> 
          </div>
        </div>
        @endforeach 
      <div class="col-lg-12 text-center CTAs"><a href="{{site_url('product')}}" class="btn btn-template btn-lg wide">Lihat Semua Produk<i class="fa fa-long-arrow-right"></i></a></div>
    </div>
  </div>
</section>
<!-- Blog Section-->
<section class="blog gray-bg">
  <div class="container">
    <header class="text-center">
      <h2 class="text-uppercase"><small>Artikel</small>Edukasi</h2>
    </header>
    <div class="row"> 
      @foreach($article as $value) 
      <div class="col-lg-6">
        <div class="post post-gray d-flex align-items-center flex-md-row flex-column card-hover" style="cursor: pointer;" onclick="window.location.href='{{site_url('article/detail/'.$value->id.'/'.$value->slug)}}'">
          <div class="thumbnail d-flex-align-items-center justify-content-center"><img src="{{base_url('uploads/article/'.$value->foto)}}" alt="..."></div>
          <div class="info"> 
            <h4 class="h5"> <a href="{{site_url('article/detail/'.$value->id.'/'.$value->slug)}}">{{$value->judul}}</a></h4><span class="date"><i class="fa fa-clock-o"></i>{{dateFormatBulan(3, $value->created_at)}}</span>
            <p>{{cutText($value->isi, 100, 2)}}</p><a href="{{site_url('article/detail/'.$value->id.'/'.$value->slug)}}" class="read-more">Baca Selengkapnya<i class="fa fa-long-arrow-right"></i></a>
          </div>
        </div>
      </div>
      @endforeach
      <div class="col-lg-12 text-center CTAs"><a href="{{site_url('article')}}" class="btn btn-template btn-lg wide">Lihat Semua Artikel<i class="fa fa-long-arrow-right"></i></a></div>

    </div>
  </div>
</section>

<!-- Divider Section-->
<section style="background: url({{base_url('assets/image/sapi.jpg')}});" class="divider">
  <div class="container"> 
    <div class="row">
      <div class="col-lg-6">
        <p>Old Collection</p>
        <h2 class="h1 text-uppercase no-margin">Huge Sales</h2>
        <p>At our outlet stores</p><a href="#" class="btn btn-template wide shop-now">Shop Now<i class="icon-bag"></i></a>
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

