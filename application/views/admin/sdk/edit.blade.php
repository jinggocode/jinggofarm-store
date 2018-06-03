@layout('_layout/admin/index')

@section('title') Data Pelanggan@endsection

@section('content')
<h1>Edit Data Barang</h1>
<hr>
<a href="{{site_url('admin/pelanggan')}}" class="btn btn-primary">Kembali</a>
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
<form class="form-horizontal" action="{{site_url('admin/pelanggan/update')}}" method="post">
{{$csrf}}
{{form_hidden('id', $data->id);}}
  <div class="form-group">
    <label for="nama" class="col-sm-2 control-label">Nama</label>
    <div class="col-sm-10">
      <input type="text" name="nama" class="form-control" value="{{$data->nama}}" id="nama" placeholder="Nama">
    </div>
  </div>
  <div class="form-group">
    <label for="email" class="col-sm-2 control-label">Email</label>
    <div class="col-sm-10">
      <input type="email" name="email" class="form-control" value="{{$data->email}}" id="email" placeholder="Email">
    </div>
  </div>
  <div class="form-group">
    <label for="password" class="col-sm-2 control-label">Password</label>
    <div class="col-sm-10">
      <input type="password" name="password" class="form-control" value="{{$data->password}}" id="password" placeholder="Password">
    </div>
  </div>
  <div class="form-group">
    <label for="no_telp" class="col-sm-2 control-label">Nomor Telp</label>
    <div class="col-sm-10">
      <input type="tel" name="no_telp" class="form-control" value="{{$data->no_telp}}" id="no_telp" placeholder="Nomor telp">
    </div>
  </div>
  <div class="form-group">
    <label for="alamat" class="col-sm-2 control-label">Alamat</label>
    <div class="col-sm-10">
      <textarea name="alamat" class="form-control" id="alamat">{{$data->alamat}}</textarea>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Simpan</button>
    </div>
  </div>
</form>
@endsection