@layout('_layout/front/index')

@section('title'){{$data->kategori->nama.' - '.$data->nama}}@endsection

@section('content')
<!-- Hero Section-->
<section class="hero hero-page gray-bg padding-small">
  <div class="container">
    <div class="row d-flex">
      <div class="col-lg-9 order-2 order-lg-1">
        <h1>{{$data->nama}}</h1>
      </div>
      <div class="col-lg-3 text-right order-1 order-lg-2">
        <ul class="breadcrumb justify-content-lg-end">
          <li class="breadcrumb-item"><a href="{{site_url()}}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{site_url('product')}}">Produk</a></li>
          <li class="breadcrumb-item active">{{$data->nama}}</li>
        </ul>
      </div>
    </div>
  </div>
</section>
<section class="product-details" style="padding-top: 40px; padding-bottom: 0px">
  <div class="container">
    <div class="row">
      <div class="product-images col-lg-4">
        @if (cek_stok($data->id) == '0')
            <div class="ribbon-danger text-uppercase">Stok Habis</div>
        @else
            <div class="ribbon-primary text-uppercase">Tersedia</div>
        @endif

        <div class="item-slider" style="padding: 0px;"> 
          <div class="items">
            <img src="{{base_url('uploads/product/'.$data->foto)}}" width="350" alt="shirt">
          </div> 
        </div> 
      </div>
      <div class="details col-lg-8">
        <div class="d-flex align-items-center justify-content-between flex-column flex-sm-row mb-4">
          <ul class="price list-inline no-margin">
            <li class="list-inline-item current" style="font-size: 40px">{{money($data->harga_jual)}}</li> {{($data->nama == "Susu Segar")?'per Liter':''}}
            <li class="list-item">Tersedia <b>{{cek_stok($data->id)}}</b> {{($data->nama == "Susu Segar")?'Liter':'Buah'}}</li>
          </ul>
        </div>

        @if (cek_stok($data->id) == '0')

        @else
          @if ($data->opsi_kirim == '0')
            <div class="d-flex align-items-center justify-content-between flex-column flex-sm-row mb-4">
              <ul class="price list-inline no-margin">
                <li class="list-inline-item current" style="font-size: 40px">
                  <input id="qty" class="form-control col-12" type="number" value="1" min="1" max="{{cek_stok($data->id)}}">
                </li>
                <li class="list-inline-item">
                  <button data-productid="{{$data->id}}" data-productname="{{$data->nama}}" data-productprice="{{$data->harga_jual}}" data-weight="{{$data->berat}}" data-image="{{base_url('uploads/product/'.$data->foto)}}" class="btn btn-template wide add_cart"> <i class="icon-cart"></i>Beli</button>
                </li>
              </ul>
            </div> 
          @else
            <div class="d-flex align-items-center justify-content-between flex-column flex-sm-row mb-4">
              <form action="{{site_url('checkout2/address')}}" method="post">
                {{$csrf}}
                {{form_hidden('id_produk', $data->id)}}

                <ul class="price list-inline no-margin">
                  <li class="list-inline-item current" style="font-size: 40px">
                    <input name="qty" class="form-control col-12" type="number" value="5" min="5" max="{{cek_stok($data->id)}}">
                  </li> <span class="mr-4">Liter</span>
                  <li class="list-inline-item">
                    <button type="submit" class="btn btn-template wide"> <i class="icon-cart"></i>Pesan Sekarang</button>
                  </li>
                </ul>
              </form>  
            </div>  
          @endif

        @endif

        <section class="product-description no-padding">
          <div class="container">
            <ul role="tablist" class="nav nav-tabs">
              <li class="nav-item"><a data-toggle="tab" href="#description" role="tab" class="nav-link active">Deskripsi</a></li>
              <li class="nav-item"><a data-toggle="tab" href="#additional-information" role="tab" class="nav-link">Testimoni Pelanggan</a></li>
            </ul>
            <div class="tab-content">
              <div id="description" role="tabpanel" class="tab-pane active" style="text-align: justify;">
                {{$data->deskripsi}}
              </div>
              <div id="additional-information" role="tabpanel" class="tab-pane">
                <table class="table">
                <?php if(empty($testimoni)): ?>
                    <tr>
                        <td colspan="2" align="center">Belum ada</td>
                    </tr>
                <?php else: ?>
                    @foreach ($testimoni as $value)
                    <tr>
                      <td style="width: 30%"><b>{{$value->nama_pelanggan}}</b></td>
                      <td>{{$value->ulasan}}</td>
                    </tr>
                    @endforeach
                <?php endif ?>

                </table>
              </div>
            </div>
          </div>
        </section>

      </div>
    </div>
  </div>
</section>
<section class="product-description no-padding">
  <div class="container-fluid">
    <div class="share-product gray-bg d-flex align-items-center justify-content-center flex-column flex-md-row"><strong class="text-uppercase">Ayo Bagikan Produk ini di</strong>
      <ul class="list-inline text-center">
        <li class="list-inline-item"><a href="#" target="_blank" title="twitter"><i class="fa fa-twitter"></i></a></li>
        <li class="list-inline-item"><a href="#" target="_blank" title="facebook"><i class="fa fa-facebook"></i></a></li>
        <li class="list-inline-item"><a href="#" target="_blank" title="instagram"><i class="fa fa-instagram"></i></a></li>
        <li class="list-inline-item"><a href="#" target="_blank" title="pinterest"><i class="fa fa-pinterest"></i></a></li>
        <li class="list-inline-item"><a href="#" target="_blank" title="vimeo"><i class="fa fa-vimeo"></i></a></li>
      </ul>
    </div>
  </div>
</section>
<section class="related-products">
  <div class="container">
    <header class="text-center">
      <h2><small>Produk Lain dari</small>Kategori {{$data->kategori->nama}}</h2>
    </header>
    <div class="row">

      <?php if(empty($produk_lainnya)): ?>
        <div class="col-md-12 text-center">
          <p>--Belum ada produk lain dari kategori ini--</p>
        </div>
      <?php else: ?>
        <!-- item-->
        @foreach ($produk_lainnya as $row)
        <div class="item col-lg-3">
            <div class="card card-hover" style="  cursor: pointer;" onclick="window.location.href='{{site_url('product/detail/'.$row->id.'/'.$row->slug)}}'">
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
      <?php endif ?>

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
        $('.add_cart').click(function(){
            var product_id    = $(this).data("productid");
            var product_name  = $(this).data("productname");
            var product_price = $(this).data("productprice");
            var image         = $(this).data("image");
            var weight_product= parseInt($(this).data("weight"));
            var quantity      = parseInt($("#qty").val());
            var weight        = weight_product * quantity;
            var sisa_stok     = <?php echo cek_stok($data->id); ?>;

            if (parseInt(sisa_stok) < parseInt(quantity)) {
              alert('Kesalahan memasukkan jumlah pembelian!');
            } else {
              $.ajax({
                  url : "<?php echo site_url('product/add_to_cart');?>",
                  method : "POST",
                  data : {product_id: product_id, product_name: product_name, product_price: product_price, quantity: quantity, image: image, weight: weight},
                  success: function(data){
                      $('#cart-item').html(data);
                      $('#cart-count-row').load("<?php echo site_url('product/count_cart');?>");
                      sweet("Berhasil", "Ditambahkan ke dalam Cart", "success");
                  }
              });
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
