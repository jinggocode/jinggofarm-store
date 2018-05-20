@layout('_layout/admin/index')

@section('title')Data Artikel Edukasi@endsection

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Data Artikel Edukasi
  </h1>
</section>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="box box-success">
  <div class="box-header with-border">
  <a href="{{site_url('admin/'.$page)}}" class="btn btn-info btn-sm"><i class="fa fa-chevron-left"></i> Kembali</a>  
  <h1 style="margin-bottom: -1px" style="font-weight: 500">{{$data->judul}}</h1>
  <span class="badge badge-default">{{$data->kategori->nama}}</span>
  </div>
    <div class="box-body"> 
      <div class="row" style="padding-bottom: 10px">
        <div class="col-md-5">
          <img src="{{base_url('uploads/article/'.$data->foto)}}" class="img-responsive" alt="" style="padding-bottom: 10px">
          <div style="font-size: 20px">{{$data->isi}}</div>
        </div>
        <div class="col-md-5"> 
          <table class="table table-striped">
            <tr>
              <td style="width: 20%">Ditulis oleh </td>
              <td><b>{{$data->user->first_name}}</b></td>
            </tr>
            <tr>
              <td style="width: 20%">Waktu </td>
              <td><b>{{dateFormatBulan(3, $data->created_at)}}</b></td>
            </tr>
          </table>
          
          <a href="{{site_url('admin/'.$page.'/edit/'.$data->id)}}" class="btn btn-warning btn-sm"><i class="fa fa-pencil-square-o"></i> Edit</a>
          <a href="{{site_url('admin/'.$page.'/delete/'.$data->id)}}" onclick="return confirm('apakah anda yakin?')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</a>
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