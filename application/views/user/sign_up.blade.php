@layout('_layout/front/index')

@section('title')Pendaftaran Pelanggan @endsection

@section('content')
<section class="padding-small">
  <div class="container">
    <div class="row">
      <div class="col-lg-3"></div>
      <div class="col-lg-6 col-sm-12 col-md-12">
        <div class="block">
          <p class="text-center">Sudah punya akun? Silahkan <a href="{{site_url('auth/sign_in')}}" class="btn btn-primary">Login</a></p>
          <div class="block-header">
            <h5>Pendaftaran Pelanggan</h5>
          </div>
          <div class="block-body">
            <form action="{{site_url('user/save')}}" method="post">
              {{$csrf}}

              @if (!empty(validation_errors()))
              <div class="alert alert-danger" role="alert">
                <p>{{validation_errors()}}</p>
              </div>
              @endif

              <div class="form-group">
                <label for="first_name" class="form-label">Nama</label>
                <input value="{{set_value('first_name')}}" id="first_name" name="first_name" type="text" class="form-control">
              </div>
              <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input value="{{set_value('email')}}" id="email" name="email" type="text" class="form-control">
              </div>
              <div class="form-group">
                <label for="phone" class="form-label">Nomor Telepon</label>
                <input value="{{set_value('phone')}}" id="phone" name="phone" type="text" class="form-control">
              </div>
              <div class="form-group">
                <label for="provinsi" class="form-label">Provinsi </label>
                <select required="required" name="provinsi_id" id="provinsi" class="form-control" style="padding: 0.2rem 0.5rem;">
                  <option value=""></option>

                  <?php for ($i=0; $i < count($provinsi['rajaongkir']['results']); $i++) { ?>
                  <option value="<?php echo $provinsi['rajaongkir']['results'][$i]['province_id']; ?>"><?php echo $provinsi['rajaongkir']['results'][$i]['province']; ?></option>
                  <?php }?>
                </select>
              </div>
              <div class="form-group">
                <label for="kabupaten" class="form-label">Kota / Kabupaten</label>
                <select required="required" name="kabupaten_id" id="kabupaten" class="form-control" style="padding: 0.2rem 0.5rem;">

                </select>
              </div>
              <div class="form-group">
                <label for="detail_alamat" class="form-label">Detail Alamat</label>
                <textarea required="required" name="detail_alamat" id="detail_alamat" cols="30" rows="3" class="form-control">{{set_value('detail_alamat')}}</textarea>
              </div>
              <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input value="{{set_value('password')}}" id="password" name="password" type="password" class="form-control">
              </div>
              <div class="form-group">
                <label for="reenter_password" class="form-label">Ulangi Password</label>
                <input value="{{set_value('reenter_password')}}" id="reenter_password" name="reenter_password" type="password" class="form-control">
              </div>
              <div class="form-group text-center">
                <button type="submit" class="btn btn-primary"><i class="icon-profile"></i> Daftar                                    </button>
              </div>
            </form>
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
 
});
</script>
@endsection
