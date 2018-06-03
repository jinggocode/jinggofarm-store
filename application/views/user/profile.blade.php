@layout('_layout/front/index')

@section('title')Profil @endsection

@section('content')
<section class="padding-small">
  <div class="container">
    <div class="row">
      <!-- Customer Sidebar-->
      @include('_layout/front/sidebar')

      <div class="col-lg-8 col-xl-9 pl-lg-3">

        <div class="block-header mb-4">
          <h5>Informasi Profil</h5>
        </div>
        <form class="content-block" action="{{site_url('user/update')}}" method="post">
        {{$csrf}}
        {{form_hidden('id', $user->id)}}

        @if (!empty(validation_errors()))
        <div class="alert alert-danger" role="alert">
          <p>{{validation_errors()}}</p>
        </div>
        @endif

          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="first_name" class="form-label">Nama</label>
                <input value="{{$user->first_name}}" id="first_name" name="first_name" type="text" class="form-control">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="phone" class="form-label">Nomor Telepon</label>
                <input value="{{$user->phone}}" name="phone" id="phone" type="text" class="form-control">
              </div>
            </div>
          </div>
          <!-- /.row-->
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input value="{{$user->email}}" name="email" id="email" type="text" class="form-control">
              </div>
            </div>
          </div>
          <!-- /.row-->

          <div class="block-header mb-4 mt-3">
            <h5>Alamat</h5>
          </div>
          <div class="row">

            <div class="col-sm-6">
              <div class="form-group">
                <label for="provinsi" class="form-label">Provinsi </label>
                <select required="required" name="provinsi_id" id="provinsi" class="form-control" style="padding: 0.2rem 0.5rem;">
                  <option value=""></option>

                  <?php for ($i=0; $i < count($provinsi['rajaongkir']['results']); $i++) { ?>
                  <option {{($provinsi['rajaongkir']['results'][$i]['province_id'] == $user->provinsi_id)?'selected':''}} value="<?php echo $provinsi['rajaongkir']['results'][$i]['province_id']; ?>"><?php echo $provinsi['rajaongkir']['results'][$i]['province']; ?></option>
                  <?php }?>
                </select>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="kabupaten" class="form-label">Kota / Kabupaten</label>
                <select required="required" name="kabupaten_id" id="kabupaten" class="form-control" style="padding: 0.2rem 0.5rem;">

                </select>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="detail_alamat" class="form-label">Detail Alamat</label>
                <textarea required="required" name="detail_alamat" id="detail_alamat" cols="30" rows="3" class="form-control">{{$user->detail_alamat}}</textarea>
              </div>
            </div>
            <div class="col-md-12">
              <button type="submit" class="btn btn-primary" name="button"><i class="fa fa-pencil-square-o"></i> Ubah Profil</button>
            </div>

        </form>

      </div>
    </div>
  </div>
</section>
@endsection


@section('script')
<script>
$(document).ready(function(){

  $.ajaxSetup({
      data: {
          csrf_test_name: $.cookie('csrf_cookie_name')
      }
  });


  $('#total').load("<?php echo site_url('checkout/total');?>");


  $('#layanan').change(function(){
    //Mengambil value dari option select provinsi kemudian parameternya dikirim menggunakan ajax
    var layanan = $('#layanan').val();
    var ongkir  = layanan.split('.');
    $.LoadingOverlay("show");

    $.ajax({
        type : 'POST',
        url : '<?php echo base_url('checkout/total'); ?>',
        data : {ongkir: ongkir[1]},
        success: function (data) {
        $.LoadingOverlay("hide");
        //jika data berhasil didapatkan, tampilkan ke dalam option select kabupaten
        $("#total").html(data);
      }
    });
  });

  var prov = $('#provinsi').val();
  var kab  = <?php echo $user->kabupaten_id; ?>;
  if (prov != '') {
      $.ajax({
          type : 'GET',
          url : '<?php echo base_url('user/profile/getKabupaten'); ?>',
          data :  {'prov_id': prov, 'kab_id': kab},
          success: function (data) {
          $.LoadingOverlay("hide");
          //jika data berhasil didapatkan, tampilkan ke dalam option select kabupaten
          $("#kabupaten").html(data);
        }
      });
  }

  $('#provinsi').change(function(){
    //Mengambil value dari option select provinsi kemudian parameternya dikirim menggunakan ajax
    var prov = $('#provinsi').val();
    $.LoadingOverlay("show");

    $.ajax({
        type : 'GET',
        url : '<?php echo base_url('checkout/address/getKabupaten'); ?>',
        data :  'prov_id=' + prov,
        success: function (data) {
        $.LoadingOverlay("hide");
        //jika data berhasil didapatkan, tampilkan ke dalam option select kabupaten
        $("#kabupaten").html(data);
      }
    });
  });


  $("#kurir").change(function(){
    //Mengambil value dari option select provinsi asal, kabupaten, kurir, berat kemudian parameternya dikirim menggunakan ajax
    var asal  = 42;
    var kab   = $('#kabupaten').val();
    var kurir = $('#kurir').val();
    var berat = 500;
    $.LoadingOverlay("show");

    $.ajax({
        type : 'POST',
        url : '<?php echo base_url('checkout/address/getOngkir'); ?>',
        data :  {'kab_id' : kab, 'kurir' : kurir, 'asal' : asal, 'berat' : berat},
        success: function (data) {

        $.LoadingOverlay("hide");
        //jika data berhasil didapatkan, tampilkan ke dalam element div ongkir
        $("#layanan").html(data);
      }
    });
  });

});
</script>
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
