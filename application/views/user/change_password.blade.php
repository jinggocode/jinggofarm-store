@layout('_layout/front/index')

@section('title')Ubah Password @endsection

@section('content')
<section class="padding-small">
  <div class="container">
    <div class="row">
      <!-- Customer Sidebar-->
      @include('_layout/front/sidebar')

      <div class="col-lg-8 col-xl-9 pl-lg-3">

        <div class="block-header mb-4">
          <h5>Ubah Password</h5>
        </div>
        <form class="content-block" action="{{site_url('user/change_password')}}" method="post">
          {{$csrf}}
            @if (!empty(validation_errors()))
            <div class="alert alert-danger" role="alert">
              <p>{{validation_errors()}}</p>
            </div>
            @endif
          <div class="row">

            <div class="col-sm-6">
              <div class="form-group">
                <label for="password" class="form-label">Password Baru</label>
                <input id="password" name="password" type="password" class="form-control">
              </div>
            </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="reenter_password" class="form-label">Ulangi Password</label>
                  <input id="reenter_password" name="reenter_password" type="password" class="form-control">
                </div>
              </div>
          </div>
          <!-- /.row-->
          <div class="row">
            <div class="col-md-12">
              <button type="submit" class="btn btn-primary" name="button"><i class="fa fa-pencil-square-o"></i>Ubah </button>
            </div>
          </div>
          <!-- /.row-->

        </form>

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
