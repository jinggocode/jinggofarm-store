@layout('_layout/front/index')

@section('title'){{$data->judul}} @endsection

@section('content') 
    <!-- Hero Section-->
    <section class="hero hero-page gray-bg padding-small">
      <div class="container">
        <div class="row d-flex">
          <div class="col-lg-9 order-2 order-lg-1">
            <h1>{{$data->judul}}</h1><p class="author-date-top">By <a href="#">{{$data->user->first_name}}</a> |  {{dateFormatBulan(3, $data->created_at)}}</p>
          </div>
          <div class="col-lg-3 text-right order-1 order-lg-2">
            <ul class="breadcrumb justify-content-lg-end">
              <li class="breadcrumb-item"><a href="{{site_url()}}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{site_url('article')}}">Blog</a></li>
              <li class="breadcrumb-item active">{{$data->judul}}</li>
            </ul>
          </div>
        </div>
      </div>
    </section>
    <section class="padding-small">
      <div class="container">
        <div class="row">
          <div class="col-xl-8 col-lg-10">      
            <div class="text-content"> 
              <p><img src="{{base_url('uploads/article/'.$data->foto)}}" alt="Example blog post alt" class="img-fluid"></p>
              {{$data->isi}}
            </div>
          </div>
          <div class="col-xl-4 col-lg-2"> 
            <h3>Daftar Produk</h3><hr>

            @foreach ($product as $row) 
            <div class="col-xl-12" style="display: flex; padding: 20px">
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