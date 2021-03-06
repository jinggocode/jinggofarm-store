@layout('_layout/front/index')

@section('title')Proses Pembelian@endsection

@section('content')
<!-- Hero Section-->
<section class="hero hero-page gray-bg padding-small">
  <div class="container">
    <div class="row d-flex">
      <div class="col-lg-9 order-2 order-lg-1">
        <h1>Proses Pembelian</h1><p class="lead"></p>
      </div>
      <div class="col-lg-3 text-right order-1 order-lg-2">
        <ul class="breadcrumb justify-content-lg-end">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Checkout</li>
        </ul>
      </div>
    </div>
  </div>
</section>
<!-- Checkout Forms-->
<section class="checkout">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <ul class="nav nav-pills">
          <li class="nav-item" style="width: 30% !important"><a href="checkout1.html" class="nav-link active">Detail Pembeli</a></li>
          <li class="nav-item"><a href="#" class="nav-link disabled">Pilihan Pembayaran </a></li>
          <li class="nav-item" style="width: 39% !important"><a href="#" class="nav-link disabled">Konfirmasi Pembayaran</a></li>
        </ul>
        <div class="tab-content">
          <div id="address" class="active tab-block">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Beli tanpa Daftar</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Login / Daftar</a>
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">


                @if (!empty(validation_errors()))
                <div class="alert alert-danger" role="alert">
                  {{validation_errors()}}
                </div>
                @endif

                <form action="{{site_url('checkout/proses_detail')}}" method="post">
                  {{$csrf}}
                  <div class="row">
                    <div class="form-group col-md-12 pl-4 ml-2">
                      <h4>Identitas</h4>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="first_name" class="form-label">Nama</label>
                      <input required="required" value="{{set_value('first_name')}}" id="first_name" type="text" name="first_name" placeholder="Masukkan nama anda" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="phone" class="form-label">Nomor Telepon</label>
                      <input required="required" value="{{set_value('phone')}}" id="phone" type="text" name="phone" placeholder="Nomor Telepon" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="email" class="form-label">Email</label>
                      <input required="required" value="{{set_value('email')}}" id="email" type="text" name="email" placeholder="Email yang valid" class="form-control">
                    </div>

                    <div class="form-group col-md-12 pl-4 ml-2 pt-3">
                      <h4>Alamat</h4>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="provinsi" class="form-label">Provinsi </label>
                      <select required="required" name="provinsi" id="provinsi" class="form-control" style="padding: 0.2rem 0.5rem;">
                        <option value=""></option>

                        <?php for ($i=0; $i < count($provinsi['rajaongkir']['results']); $i++) { ?>
                        <option value="<?php echo $provinsi['rajaongkir']['results'][$i]['province_id']; ?>"><?php echo $provinsi['rajaongkir']['results'][$i]['province']; ?></option>
                        <?php }?>
                      </select>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="kabupaten" class="form-label">Kota / Kabupaten</label>
                      <select required="required" name="kabupaten" id="kabupaten" class="form-control" style="padding: 0.2rem 0.5rem;">

                      </select>
                    </div>
                    <div class="form-group col-md-12">
                      <label for="detail_alamat" class="form-label">Detail Alamat</label>
                      <textarea required="required" name="detail_alamat" id="detail_alamat" cols="30" rows="3" class="form-control">{{set_value('detail_alamat')}}</textarea>
                    </div>

                    <div class="form-group col-md-12 pl-4 ml-2 pt-3">
                      <h4>Pilihan Pengiriman</h4>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="street" class="form-label">Ekspedisi</label>
                      <select required="required" name="kurir" id="kurir" style="padding: 0.2rem 0.5rem;" class="form-control">
                        <option value=""></option>
                        <option value="jne">JNE</option>
                        <option value="pos">POS Indonesia</option>
                        <option value="tiki">TIKI</option>
                      </select>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="city" class="form-label">Layanan</label>
                      <select required="required" name="layanan" id="layanan" style="padding: 0.2rem 0.5rem;" class="form-control">

                      </select>
                    </div>

                    <div class="form-group col-md-12 pl-4 ml-2 pt-3">
                      <h4>Informasi Tambahan</h4>
                    </div>
                    <div class="form-group col-md-12">
                      <label for="catatan" class="form-label">Catatan</label>
                      <textarea required="required" name="catatan" id="catatan" cols="30" rows="3" class="form-control">{{set_value('catatan')}}</textarea>
                    </div>
                  </div>
                  <!-- /Invoice Address-->
                  <div class="CTAs d-flex justify-content-between flex-column flex-lg-row"><a href="{{site_url('cart')}}" class="btn btn-template-outlined wide prev"> <i class="fa fa-angle-left"></i>Kembali ke Keranjang</a><button type="submit" class="btn btn-template wide next">Lanjut ke Pembayaran<i class="fa fa-angle-right"></i></button></div>
                </form>
              </div>

              <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                <form action="{{site_url('auth/sign_in')}}" method="post">
                  {{$csrf}}
                  <div class="row">
                    <div class="form-group col-md-12 pl-4 ml-2">
                      <h4>Silahkan Masuk</h4>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="email" class="form-label">Email</label>
                      <input required="required" value="{{set_value('email')}}" id="email" type="text" name="identity" placeholder="Email" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="password" class="form-label">Password</label>
                      <input required="required" value="{{set_value('password')}}" id="password" type="password" name="password" placeholder="Password" class="form-control">
                    </div>
                    <div class="form-group col-md-12 text-center">
                      <button type="submit" class="btn btn-primary">Masuk</button>
                    </div>
                    <div class="form-group col-md-12 text-center">
                      <p>Belum punya akun? Silahkan <a href="{{site_url('auth/create_user')}}" class="btn btn-primary text-primary">Daftar</a></p>
                    </div>
                  </div>
                </form>
              </div>
              <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="block-body order-summary" style="position: sticky; top: 120px">
          <h6 class="text-uppercase">Ringkasan Pembelian</h6>

          <div>
            <table class="table">

              @foreach ($cart as $value)
              <tr>
                <td class="text-left" style="font-size: 17px; width: 50%">{{$value['name']}} <br> <span style="font-size: 14px">Jumlah: <b>{{$value['qty']}}</b></span></td>
                <td class="text-right">{{money($value['price'])}}</td>
              </tr>
              @endforeach

            </table>
          </div>
          <div id="total">

          </div>
        </div>
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
    var berat = <?php echo $totalWeight;?>;
    console.log(berat);
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
