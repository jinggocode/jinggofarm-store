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
      <form class="form-horizontal" action="{{site_url('admin/'.$page.'/update')}}" method="post" enctype="multipart/form-data">
      {{$csrf}}
      {{form_hidden('id', $data->id);}}

        <div class="form-group">
          <label for="judul" class="col-sm-2 control-label">Judul</label>
          <div class="col-sm-6">
            <input autofocus="autofocus" type="text" name="judul" class="form-control" value="{{$data->judul}}" id="judul">
          </div>
        </div>
        <div class="form-group">
          <label for="isi" class="col-sm-2 control-label">Konten</label>
          <div class="col-sm-9"> 
            <textarea id="isi" name="isi" rows="10" cols="80"> {{$data->isi}}
            </textarea>
          </div>
        </div>
        <div class="form-group">
          <label for="no_telp" class="col-sm-2 control-label">Kategori</label>
          <div class="col-sm-4">
            <select name="id_kategori" id="id_kategori" class="form-control">
              <option value="">--Pilih Kategori Artikel--</option>
              @foreach ($category as $row)
                <option {{($row->id == $data->id_kategori)?'selected':''}} value="{{$row->id}}">{{$row->nama}}</option>
              @endforeach
            </select>
          </div>
        </div> 
        <div class="form-group">
          <label for="foto" class="col-sm-2 control-label">Foto Sampul</label>
          <div class="col-sm-6">
            <input type="file" name="foto" class="form-control" value="{{set_value('foto')}}" id="foto"><br><?php $img = isset($data->foto) ? $data->foto : 'default.png';?> 
            <img width="300" height="1000" src="{{base_url('uploads/article/'.$img)}}" class="image-preview img-responsive" alt=""> 
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
<!-- CK Editor -->
<script src="{{base_url('assets/admin/')}}bower_components/ckeditor/ckeditor.js"></script>
<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('isi')
    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5()
  })
</script>
<script type="text/javascript">
var articles = (function(){ 
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