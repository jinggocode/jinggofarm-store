@layout('_layout/admin/index')

@section('title')Data Produk@endsection

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Data Produk
  </h1>
</section>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="box box-success">
  <div class="box-header with-border">
  <h2 class="box-title"><i class="fa fa-plus-square-o"></i> Edit Data</h2>
  </div>
    <div class="box-body">
      <div class="row">
        <div class="col-sm-6 col-lg-12">
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
      <form class="form-horizontal" action="{{site_url('admin/product/update')}}" method="post" enctype="multipart/form-data">
      {{$csrf}}
      {{form_hidden('id', $data->id)}}
        <div class="form-group">
          <label for="nama" class="col-sm-2 control-label">Nama</label>
          <div class="col-sm-6">
            <input type="text" name="nama" class="form-control" value="{{$data->nama}}" id="nama">
          </div>
        </div>
        <div class="form-group">
          <label for="no_telp" class="col-sm-2 control-label">Kategori</label>
          <div class="col-sm-4">
            <select name="id_kategori" id="id_kategori" class="form-control">
              <option value="">--Pilih Kategori Produk--</option>
              @foreach ($category as $row)
                <option {{($row->id == $data->id_kategori)?'selected':''}} value="{{$row->id}}">{{$row->nama}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="deskripsi" class="col-sm-2 control-label">Deskripsi</label>
          <div class="col-sm-8">
            <textarea name="deskripsi" class="form-control" id="deskripsi">{{$data->deskripsi}}</textarea>
          </div>
        </div>
        <div class="form-group">
          <label for="berat" class="col-sm-2 control-label">Berat</label>
          <div class="col-sm-3">
            <input type="text" name="berat" class="form-control" value="{{$data->berat}}" id="berat">
          </div>
        </div>
        <div class="form-group">
          <label for="harga_produksi" class="col-sm-2 control-label">Harga Produksi</label>
          <div class="col-sm-3">
            <input type="text" name="harga_produksi" class="form-control" value="{{rupiah($data->harga_produksi)}}" id="harga_produksi" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
          </div>
        </div>
        <div class="form-group">
          <label for="harga_jual" class="col-sm-2 control-label">Harga Jual</label>
          <div class="col-sm-3">
            <input type="text" name="harga_jual" class="form-control" value="{{rupiah($data->harga_jual)}}" id="harga_jual" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
          </div>
        </div>

        <div class="form-group">
          <label for="stok" class="col-sm-2 control-label">Stok</label>
          <div class="col-sm-3">
            <input type="number" name="stok" class="form-control" value="{{$data->stok}}" id="stok">
          </div>
        </div>
        <div class="form-group">
          <label for="sisa_stok" class="col-sm-2 control-label">Sisa Stok</label>
          <div class="col-sm-3">
            <input type="number" name="sisa_stok" class="form-control" value="{{$data->sisa_stok}}" id="sisa_stok">
          </div>
        </div>
        <div class="form-group">
          <label for="foto" class="col-sm-2 control-label">Foto</label>
          <div class="col-sm-6">
            <input type="file" name="foto" class="form-control" value="{{$data->foto}}" id="foto">
            <?php $img = isset($data->foto) ? $data->foto : 'default.png';?>
            <img style="margin-top: 10px" width="300" height="1000" src="{{base_url('uploads/product/'.$img)}}" class="image-preview img-responsive" alt="">
          </div>
        </div>
        <div class="form-group">
          <label for="opsi_kirim" class="col-sm-2 control-label">Pilihan Pengiriman</label>
          <div class="col-sm-6">
            <label>
              <input type="radio" name="opsi_kirim" id="opsi_kirim" value="0" {{($data->opsi_kirim == '0')?'checked':''}}>
              Pengiriman Umum (JNE, POS, dll.)
            </label><br>
            <label>
              <input type="radio" name="opsi_kirim" id="opsi_kirim" value="1" {{($data->opsi_kirim == '1')?'checked':''}}>
              Pengiriman Lokal
            </label>
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
<script>
var photo = (function(){
    // bind events
    $("[type='file']").on('change', eventPreviewGambar);

    init();

    // Events
    function eventPreviewGambar(event){
        readURL(event.target);
    }

    function readURL(input){
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.image-preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

})();
</script>
@endsection
