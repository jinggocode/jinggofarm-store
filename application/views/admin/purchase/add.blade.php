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
  <h2 class="box-title"><i class="fa fa-plus-square-o"></i> Tambah Data</h2>
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
      <form class="form-horizontal" action="{{site_url('admin/product/save')}}" method="post" enctype="multipart/form-data">
      {{$csrf}}
        <div class="form-group">
          <label for="nama" class="col-sm-2 control-label">Nama</label>
          <div class="col-sm-6">
            <input type="text" name="nama" class="form-control" value="{{set_value('nama')}}" id="nama">
          </div>
        </div>
        <div class="form-group">
          <label for="no_telp" class="col-sm-2 control-label">Kategori</label>
          <div class="col-sm-4">
            <select name="id_kategori" id="id_kategori" class="form-control">
              <option value="">--Pilih Kategori Produk--</option>
              @foreach ($category as $row)
                <option {{($row->id == set_value('id_kategori')?'selected':'')}} value="{{$row->id}}">{{$row->nama}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="deskripsi" class="col-sm-2 control-label">Deskripsi</label>
          <div class="col-sm-8">
            <textarea name="deskripsi" class="form-control" id="deskripsi">{{set_value('deskripsi')}}</textarea>
          </div>
        </div>
        <div class="form-group">
          <label for="berat" class="col-sm-2 control-label">Berat</label>
          <div class="col-sm-3">
            <input type="text" name="berat" class="form-control" value="{{set_value('berat')}}" id="berat">
          </div>
        </div>
        <div class="form-group">
          <label for="harga_jual" class="col-sm-2 control-label">Harga Jual</label>
          <div class="col-sm-3">
            <input type="text" name="harga_jual" class="form-control" value="{{set_value('harga_jual')}}" id="harga_jual" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
          </div>
        </div>
        <div class="form-group">
          <label for="stok" class="col-sm-2 control-label">Stok</label>
          <div class="col-sm-3">
            <input type="number" name="stok" class="form-control" value="{{set_value('stok')}}" id="stok">
          </div>
        </div>
        <div class="form-group">
          <label for="foto" class="col-sm-2 control-label">Foto</label>
          <div class="col-sm-6">
            <input type="file" name="foto" class="form-control" value="{{set_value('foto')}}" id="foto">
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
@endsection