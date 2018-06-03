@layout('_layout/admin/index') 

@section('title')Data Ongkos Kirim @endsection

@section('style')
  <!-- Select2 -->
  <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/select2/dist/css/select2.min.css">
@endsection
 
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Data Ongkos Kirim
  </h1>
</section>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="box box-success">
    <div class="box-header with-border">
      <h2 class="box-title"><i class="fa fa-plus-square-o"></i> Tambah Data</h2>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-sm-12 col-lg-12">
          <!-- form alert -->
          @if (!empty(validation_errors()))
          <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <h4><strong>Peringatan</strong></h4>
            <p>{{validation_errors()}}</p>
          </div>
          @endif
        </div>
        <!-- end form alert -->
      </div>
      <form class="form-horizontal" action="{{site_url('admin/kurir/ongkir/save')}}" method="post">
        {{$csrf}} 
        <div class="form-group">
          <label for="id_kurir" class="col-sm-2 control-label">Kurir</label>
          <div class="col-sm-6">
            <select name="id_kurir" id="id_kurir" class="form-control" style="width: 100%;">
              <option selected="selected">== Pilih Kurir ==</option>

              @foreach ($kurir as $value)
                <option value="{{$value->id}}">{{$value->nama_kurir}}</option>                   
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="id_provinsi" class="col-sm-2 control-label">Provinsi</label>
          <div class="col-sm-6">
            <select name="id_provinsi" id="id_provinsi" class="form-control select2" style="width: 100%;">
              <option selected="selected">== Pilih Provinsi ==</option>

              @foreach ($provinsi as $value)
                <option value="{{$value->id}}">{{$value->name}}</option>                   
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="id_kabupaten" class="col-sm-2 control-label">Kabupaten</label>
          <div class="col-sm-6">
            <select name="id_kabupaten" id="id_kabupaten" class="form-control select2" style="width: 100%;"> 
 
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="id_kecamatan" class="col-sm-2 control-label">Kecamatan</label>
          <div class="col-sm-6">
            <select name="id_kecamatan" id="id_kecamatan" class="form-control select2" style="width: 100%;"> 
 
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="biaya" class="col-sm-2 control-label">Biaya</label>
          <div class="col-sm-6">
            <input type="text" name="biaya" class="form-control" value="{{set_value('biaya')}}" id="biaya">
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!-- /.box -->

</section>
<!-- /.content -->
@endsection
 
@section('script')
<script src="{{base_url('assets/js/money.js')}}"></script>
<!-- Select2 -->
<script src="https://adminlte.io/themes/AdminLTE/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- Page script -->
<script>
$(function () {
  //Initialize Select2 Elements
  $('.select2').select2() 
})
</script>

<script src="https://d19m59y37dris4.cloudfront.net/hub/1-3-0/vendor/jquery.cookie/jquery.cookie.js">
</script>

<script> 
$(document).ready(function(){

  $.ajaxSetup({
      data: {
          csrf_test_name: $.cookie('csrf_cookie_name')
      }
  });

  $('#id_provinsi').change(function(){
    //Mengambil value dari option select provinsi kemudian parameternya dikirim menggunakan ajax
    var prov = $('#id_provinsi').val();
    $.LoadingOverlay("show");
    console.log(prov); 
    

    $.ajax({
        type : 'GET',
        url : '<?php echo base_url('checkout2/address/getKabupaten'); ?>',
        data :  'prov_id=' + prov,
        success: function (data) {
        $.LoadingOverlay("hide");
        //jika data berhasil didapatkan, tampilkan ke dalam option select kabupaten
        $("#id_kabupaten").html(data);
      }
    });
  });

  $('#id_kabupaten').change(function(){
    //Mengambil value dari option select provinsi kemudian parameternya dikirim menggunakan ajax
    var kab = $('#id_kabupaten').val();
    $.LoadingOverlay("show");  
    $.ajax({
        type : 'GET',
        url : '<?php echo base_url('checkout2/address/getKecamatan'); ?>',
        data :  'kab_id=' + kab,
        success: function (data) {
        $.LoadingOverlay("hide");
        //jika data berhasil didapatkan, tampilkan ke dalam option select kabupaten
        $("#id_kecamatan").html(data);
      }
    });
  });
});
</script>
@endsection