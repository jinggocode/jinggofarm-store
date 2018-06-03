@layout('_layout/front/index')

@section('title')Keranjang Belanja@endsection

@section('content')
<!-- Hero Section-->
<section class="hero hero-page gray-bg padding-small">
  <div class="container">
    <div class="row d-flex">
      <div class="col-lg-9 order-2 order-lg-1">
        <h1>Keranjang Belanja</h1><p class="lead text-muted">Segera lakukan Pembayaran sebelum kehabisan stok!</p>
      </div>
      <div class="col-lg-3 text-right order-1 order-lg-2">
        <ul class="breadcrumb justify-content-lg-end">
          <li class="breadcrumb-item"><a href="{{site_url()}}">Home</a></li>
          <li class="breadcrumb-item active">Keranjang Belanja</li>
        </ul>
      </div>
    </div>
  </div>
</section>
<!-- Shopping Cart Section-->
<section class="shopping-cart">
  <div class="container">
    <div class="basket">
      <div class="basket-holder">
        <div class="basket-header">
          <div class="row">
            <div class="col-5">Produk</div>
            <div class="col-2">Harga</div>
            <div class="col-2">Kuantitas</div>
            <div class="col-2">Jumlah</div>
            <div class="col-1 text-center">Aksi</div>
          </div>
        </div>
        <div class="basket-body list-cart" id="cart-list">

        </div>
      </div>
    </div>
  </div>

  <div class="container pt-5" >
    <div class="row">
      <div class="col-lg-6">
      </div>
      <div class="col-lg-6">
        <div class="block">
          <div class="block-header">
            <h6 class="text-uppercase">Ringkasan Order</h6>
          </div>
          <div class="block-body">
            <p>Total dibawah ini Belum termasuk ongkos kirim</p>
            <ul class="order-menu list-unstyled">
              <li class="d-flex justify-content-between"><span>Jumlah Bayar</span><strong class="text-primary price-total" id="total" style="font-size: 30px">$400.00</strong></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-lg-12 text-center CTAs"><a href="{{site_url('checkout/address')}}" class="btn btn-template btn-lg wide">Proses Pembelian<i class="fa fa-long-arrow-right"></i></a></div>
    </div>
  </div>
</section>
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

        $(document).on('change','.update_cart',function(){
            var rowid    = $(this).data("rowid");
            var max      = $(this).data("max");
            var price    = $(this).data("price");
            var weight_product = parseInt($(this).data("weight"));
            var input    = 'input[name='+rowid+']'; 
            var qty      = parseInt($(input).val());
            var weight   = weight_product * qty; 

            $.LoadingOverlay("show");
            if (qty <= max) {
              $.ajax({
                  url : "<?php echo site_url('cart/update_cart');?>",
                  method : "POST",
                  data : {rowid : rowid, price: price, qty : qty, weight: weight},
                  success: function(data){
                      $('#total').load("<?php echo site_url('cart/total_pay');?>");
                      $('#cart-list').load("<?php echo site_url('cart/show_cart');?>");
                      sweet("Berhasil", "Kuantitas Berhasil di Ubah!", "success");
                  }
              });
              $.LoadingOverlay("hide");
            } else {
              $.LoadingOverlay("hide");
              sweet("Gagal", "Kuantitas yang anda masukkan melebihi stok yang tersedia!", "error");
            }

        });

        $.LoadingOverlay("show");
        $('#total').load("<?php echo site_url('cart/total_pay');?>", function() {
          $('#cart-list').load("<?php echo site_url('cart/show_cart');?>");
          $.LoadingOverlay("hide");
        });

        $(document).on('click','.delete_cart',function(){
            var r = confirm("Apakah anda Yakin?");
            if (r == true) {
              var row_id=$(this).attr("id");
              $.LoadingOverlay("show");
              $.ajax({
                  url : "<?php echo site_url('product/delete_cart');?>",
                  method : "POST",
                  data : {row_id : row_id},
                  success: function(data){
                      $('#total').load("<?php echo site_url('cart/total_pay');?>");
                      $('#cart-list').load("<?php echo site_url('cart/show_cart');?>");
                      $('#cart-count-row').load("<?php echo site_url('product/count_cart');?>");
                      sweet("Berhasil", "Dihapus dari Keranjang", "warning");
                      $.LoadingOverlay("hide");
                  }
              });
            } else {
            }
        });
        $('.update_cart').keypress(function(){
            var id    = $(this).data("id");
            console.log(id)
        });


        function sweet(tipe, pesan, icon){
          swal(tipe, pesan, icon);
        }
        window.onload = sweet;
    });
</script>
@endsection
