@layout('_layout/admin/index')

@section('title')Data Pembelian@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Pembelian
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
      <div class="box-header with-border" align="right">
        <a class="btn btn-app" data-toggle="modal" data-target="#modal-default">
          <span class="badge bg-purple" style="font-size: 25px;">{{$jumlah_transfer}}</span>
          <i class="fa fa-bullhorn"></i> Konfirmasi Transfer Pelanggan
        </a>
      </div>
        <div class="box-body">
          <div class="row">
            <div class="col-lg-6 col-md-6">
                <form class="form-inline" action="{{site_url('admin/'.$page.'/search')}}" method="get">

                  <div class="form-group">
                    <input type="text" value="{{(isset($search_data['keyword']))?$search_data['keyword']:''}}" name="keyword" class="form-control" id="keyword" placeholder="Cari Berdasarkan Kode Pembelian" style="margin-right: 10px" autofocus="autofocus">
                  </div>
                  <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Cari</button>

            </div>
            <div class="col-lg-6 col-md-6" align="right">
                <div class="form-inline">
                  <div class="form-group">
                    <select name="sort" id="sort" class="form-control" onchange="this.form.submit();">
                        <option value="">Tampilkan Berdasarkan</option>
                        <option {{(isset($search_data['sort'])&& $search_data['sort'] == '1')?'selected':''}} value="1">Data Terbaru</option>
                        <option {{(isset($search_data['sort'])&& $search_data['sort'] == '2')?'selected':''}} value="2">Data Lama</option>
                    </select>
                  </div>
                </div>
                </form>
            </div>
        </div>
          <table class="table table-hover table-striped">
              <thead>
                <th style="width: 3%">No.</th>
                <th style="width: 20%">Kode Pembelian</th>
                <th style="width: 30%">Nama Pelanggan</th>
                <th style="width: 20%">Status</th>
                <th style="width: 30%">Aksi</th>
              </thead>
              <?php if(empty($data)): ?>
                  <tr>
                      <td colspan="6" align="center">Tidak ada Data</td>
                  </tr>
              <?php else: ?>
                  <?php $start+= 1 ?>
                  @foreach($data as $row)
                  <tr>
                    <td>{{$start++}}.</td>
                    <td>{{$row->kode_pembelian}}</td>
                    <td>{{$row->nama_penerima}}</td>
                    <td>
                      {{($row->status == '2')?'<span class="label label-warning">Menunggu Resi</span>':''}}
                      {{($row->status == '3')?'<span class="label label-success">Resi Terkirim</span>':''}}
                    </td>
                    <td>  
                       
                      <a href="{{site_url('admin/'.$page.'/view/'.$row->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> Detail</a>
                      <a href="{{site_url('admin/'.$page.'/delete/'.$row->id)}}" onclick="return confirm('apakah anda yakin?')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</a>
                    </td>
                  </tr>
                  @endforeach
              <?php endif ?>
            </table>
        </div>
        <div class="box-footer clearfix">
          {{$pagination}}
        </div>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection

@section('modal')
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="kode">OR-2222</h4>
      </div>
      <div class="modal-body">
        <form action="{{site_url('admin/purchase/kirim_resi')}}" method="post">
          {{$csrf}}
          <input type="hidden" name="id" id="idP" value="">
          <div class="form-group">
            <label for="no_resi">No. Resi</label>
            <input type="text" name="no_resi" class="form-control" id="no_resi">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Kirim</button>
      </div>
    </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-default">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-money"></i> Validasi Bukti Transfer</h4>
      </div>
      <div class="modal-body">
        <table class="table table-striped table-hover">
          <thead>
            <th>No.</th>
            <th>Nama Rekening</th>
            <th>Nomor Rekening</th>
            <th>Jumlah Bayar</th>
            <th>Bukti</th>
            <th>Aksi</th>
          </thead>
          <tbody>
          <?php if(empty($validasi_transfer)): ?>
              <tr>
                  <td colspan="6" align="center">Tidak ada Data</td>
              </tr>
          <?php else: ?>
              <?php $no = 1 ?>
                @foreach($validasi_transfer as $val)
                <tr>
                  <td>{{$no++}}.</td>
                  <td>{{$val->nama_rek}}</td>
                  <td>{{$val->no_rek}}</td>
                  <td>{{money($val->pembelian->jumlah_bayar + $val->pembelian->biaya_kirim)}}</td>
                  <td><a target="_blank" href="{{site_url('uploads/bukti-transfer/'.$val->foto)}}" class="btn btn-warning btn-sm"><i class="fa fa-file-image-o"></i> Foto</a></td>
                  <td>
                    <a href="{{site_url('admin/purchase/valid/'.$val->id)}}" class="btn btn-primary btn-sm" onclick="return confirm('Apakah anda yakin?');"><i class="fa fa-check-circle-o"></i> Valid</a>
                    <a href="{{site_url('admin/purchase/unvalid/'.$val->id)}}" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin?');"><i class="fa fa-times-circle"></i> Tidak Valid</a>
                  </td>
                </tr>
                @endforeach
            <?php endif ?>
          </tbody>
        </table>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endsection

@section('script')
    <script>
        $(document).on("click", ".open-kirimResiDialog", function () {
             var id = $(this).data('id');
             var kode = $(this).data('kode');
             document.getElementById("kode").innerHTML = "<b>Kirim Resi #"+kode+"</b>";
             $(".modal-body #idP").val( id );
        });
    </script>
@endsection
