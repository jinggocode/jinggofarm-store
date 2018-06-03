@layout('_layout/admin/index')

@section('title') Data Pelanggan@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Pelanggan
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
      <div class="box-header with-border">
      <h3>Tambah Data</h3>
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
          <form class="form-horizontal" action="{{site_url('admin/pelanggan/save')}}" method="post">
          {{$csrf}}
            <div class="form-group">
              <label for="nama" class="col-sm-2 control-label">Nama</label>
              <div class="col-sm-10">
                <input type="text" name="nama" class="form-control" value="{{set_value('nama')}}" id="nama" placeholder="Nama">
              </div>
            </div>
            <div class="form-group">
              <label for="email" class="col-sm-2 control-label">Email</label>
              <div class="col-sm-10">
                <input type="email" name="email" class="form-control" value="{{set_value('email')}}" id="email" placeholder="Email">
              </div>
            </div>
            <div class="form-group">
              <label for="password" class="col-sm-2 control-label">Password</label>
              <div class="col-sm-10">
                <input type="password" name="password" class="form-control" value="{{set_value('password')}}" id="password" placeholder="Password">
              </div>
            </div>
            <div class="form-group">
              <label for="no_telp" class="col-sm-2 control-label">Nomor Telp</label>
              <div class="col-sm-10">
                <input type="tel" name="no_telp" class="form-control" value="{{set_value('no_telp')}}" id="no_telp" placeholder="Nomor telp">
              </div>
            </div>
              <div class="form-group">
              <label for="alamat" class="col-sm-2 control-label">Alamat</label>
              <div class="col-sm-10">
                <textarea name="alamat" class="form-control" id="alamat">{{set_value('alamat')}}</textarea>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Simpan</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection