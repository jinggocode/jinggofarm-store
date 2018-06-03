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
  <a href="{{site_url('admin/'.$page)}}" class="btn btn-warning btn-sm"><i class="fa fa-chevron-left"></i> Kembali</a>  
  </div>
    <div class="box-body"> 
      <div class="row" style="padding-bottom: 10px">
        <div class="col-md-5">
          <img src="{{base_url('uploads/product/'.$data->foto)}}" class="img-responsive" alt="">
        </div>
        <div class="col-md-7">
          <table class="table table-striped">
            <tr>
              <td style="width: 30%">Nama</td>
              <td>{{$data->nama}}</td>
            </tr>
            <tr>
              <td>Deskripsi</td>
              <td>{{$data->deskripsi}}</td>
            </tr>
            <tr>
              <td>Berat</td>
              <td>{{$data->berat}} Gram</td>
            </tr>
            <tr>
              <td>Harga Produksi</td>
              <td>{{money($data->harga_produksi)}}</td>
            </tr>
            <tr>
              <td>Harga Jual</td>
              <td>{{money($data->harga_jual)}}</td>
            </tr>
            <tr>
              <td>Total Stok</td>
              <td>{{$data->stok}}</td>
            </tr>
            <tr>
              <td>Sisa Stok</td>
              <td>{{$data->sisa_stok}}</td>
            </tr>
            <tr>
              <td>Opsi Kirim</td>
            <td>{{($data->opsi_kirim == '0')?'Pengiriman Umum':'Pengiriman Lokal'}}</td>
            </tr>
          </table>
          <a href="{{site_url('admin/product/edit/'.$data->id)}}" class="btn btn-warning btn-sm"><i class="fa fa-pencil-square-o"></i> Edit</a>
          <a href="{{site_url('admin/product/delete/'.$data->id)}}" onclick="return confirm('apakah anda yakin?')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</a>
        </div>
      </div>  
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