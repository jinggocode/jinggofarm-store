@layout('_layout/front/index')

@section('title')Daftar Produk@endsection

@section('content')
<!-- Hero Section-->
<section class="hero hero-page gray-bg padding-small">
  <div class="container">
    <div class="row d-flex">
      <div class="col-lg-9 order-2 order-lg-1">
        <h1>Daftar Produk</h1><p class="lead text-muted">Produk ini di produksi oleh <strong>Kelompok Ternak Sapi Perah Sumber Lumintu</strong></p>
      </div>
      <div class="col-lg-3 text-right order-1 order-lg-2">
        <ul class="breadcrumb justify-content-lg-end">
          <li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
          <li class="breadcrumb-item active">Produk</li>
        </ul>
      </div>
    </div>
  </div>
</section>
<main>
  <div class="container">
    <div class="row">
      <!-- Grid -->
      <div class="products-grid col-12 sidebar-none">
        <header class="d-flex justify-content-between align-items-start"><span class="visible-items">Menampilkan <strong>1-10 </strong>dari <strong>{{$total_rows}} </strong>data</span>

          <form action="{{site_url('product/search')}}">
             
            <input type="hidden" name="keyword">
            <select id="kategori" name="category" class="bs-select" onchange="this.form.submit();">
              <option value="">-Semua Kategori-</option>
              @foreach ($category as $value) 
                <option {{(isset($search_data['category'])&& $search_data['category'] == $value->id)?'selected':''}} value="{{$value->id}}">{{$value->nama}}</option> 
              @endforeach
            </select>
            <select id="sorting" name="sort" class="bs-select" onchange="this.form.submit();">
              <option {{(isset($search_data['sort'])&& $search_data['sort'] == '1')?'selected':''}} value="1">Terbaru</option>
              <option {{(isset($search_data['sort'])&& $search_data['sort'] == '2')?'selected':''}} value="2">Terlama</option>
              <option {{(isset($search_data['sort'])&& $search_data['sort'] == '3')?'selected':''}} value="3">Harga Terendah</option>
              <option {{(isset($search_data['sort'])&& $search_data['sort'] == '4')?'selected':''}} value="4">Harga Tinggi</option>
            </select>
          </form>
        </header>
        <div class="row">

          @foreach ($data as $row) 
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

        </div>
        <nav aria-label="page navigation example" class="d-flex justify-content-center">
          {{$pagination}} 
        </nav>
      </div>
      <!-- / Grid End-->
    </div>
  </div>
</main>
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