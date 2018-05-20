@layout('_layout/admin/index')

@section('title')Edit Data Ternak@endsection 

@section('content')
<div id="page-content">
    <!-- Blank Header -->
    <div class="content-header"> 
        <div class="row">
            <div class="col-sm-6">
                <div class="header-section">
                    <h1><a href="{{site_url('admin/cattle')}}"><i class="fa fa-arrow-left"></i></a> Edit Data Ternak</h1>
                </div>
            </div> 
        </div>  

    </div>
    <!-- END Blank Header -->
 
<br>
    <div class="row">
        <div class="col-sm-6 col-lg-12">
            <!-- Form Alert -->
            @if (!empty(validation_errors()))
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><strong>Peringatan</strong></h4>
                <p>{{validation_errors()}}</p>
            </div>
            @endif
            <!-- END Form Alert -->
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form Block -->
            <div class="block"> 

                <form action="{{site_url('admin/'.$page.'/update')}}" method="post" class="form-horizontal form-bordered" enctype="multipart/form-data">
                {{$csrf}}  
                {{form_hidden('id_kt', 1);}}
                {{form_hidden('id', $data->id);}}
                
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="nama">Nama Ternak</label>
                        <div class="col-md-4">
                            <input value="{{$data->nama}}" type="text" id="nama" name="nama" class="form-control"> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="nama">Kategori Ternak</label>
                        <div class="col-md-4">
                            <select name="id_kategori" id="id_kategori" class="form-control"> 
                                @foreach ($category as $val)
                                    <option {{($data->id_kategori == $val->id)?'selected':''}} value="{{$val->id}}">{{$val->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="deskripsi">Deskripsi</label>
                        <div class="col-md-6">
                            <textarea id="deskripsi" name="deskripsi" class="form-control">{{$data->deskripsi}}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="biaya">Biaya</label>
                        <div class="col-md-3">
                            <input value="{{rupiah($data->biaya)}}" type="text" id="biaya" name="biaya" class="form-control" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="jumlah_sapi">Jumlah Sapi</label>
                        <div class="col-md-2">
                            <input value="{{$data->jumlah_sapi}}" type="number" id="jumlah_sapi" name="jumlah_sapi" class="form-control"> 
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="biaya_operasional">Biaya Operasional (Pakan, dll.)</label>
                        <div class="col-md-3">
                            <input value="{{rupiah($data->biaya_operasional)}}" type="text" id="biaya_operasional" name="biaya_operasional" class="form-control" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="jumlah_unit">Jumlah Unit</label>
                        <div class="col-md-2">
                            <input value="{{$data->jumlah_unit}}" type="number" id="jumlah_unit" name="jumlah_unit" class="form-control"> 
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="lama_periode">Lama Periode</label>
                        <div class="col-md-2">
                            <input value="{{$data->lama_periode}}" type="number" id="lama_periode" name="lama_periode" class="form-control">
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="foto">Foto</label>
                        <div class="col-md-9">
                            <div class="row" id="foto-list"> 
                            </div>
                            <div class="dropzone" id="upload">

                              <div class="dz-message">
                               <h3> Klik atau Drop gambar disini</h3>
                              </div>

                            </div>    

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="file">File Pendukung</label>
                        <div class="col-md-5">
                            <input type="file" name="file" class="form-control">   
                        </div>
                    </div><hr>

                    <h3 style="padding-left: 40px">Pembagian Keuntungan (%)</h3>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="bghasil_peternak">Peternak</label>
                        <div class="col-md-2">
                            <input value="{{$data->bghasil_peternak}}" type="text" id="bghasil_peternak" name="bghasil_peternak" class="form-control">
                        </div>
                    </div>  
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="bghasil_investor">Investor</label>
                        <div class="col-md-2">
                            <input value="{{$data->bghasil_investor}}" type="text" id="bghasil_investor" name="bghasil_investor" class="form-control">
                        </div>
                    </div> 

                    <div class="form-group form-actions">
                        <div class="col-md-9 col-md-offset-3">
                            <button type="submit" class="btn btn-effect-ripple btn-primary" style="overflow: hidden; position: relative;"><i class="fa fa-pencil"></i> Ubah</button>
                            <button type="reset" class="btn btn-effect-ripple btn-danger" style="overflow: hidden; position: relative;"><i class="fa fa-refresh"></i> Reset</button>
                            <a href="{{site_url($page)}}" class="btn btn-effect-ripple btn-warning" style="overflow: hidden; position: relative;"><i class="fa fa-chevron-left"></i> Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
            <!-- END Horizontal Form Block --> 
        </div> 
    </div>
</div>
@endsection 

@section('script')  
     <!-- ckeditor.js, load it only in the page you would like to use CKEditor (it's a heavy plugin to include it with the others!) --> 
    
    <script src="{{base_url('assets/admin/')}}js/money.js"></script>
    <script src="{{base_url()}}assets/vendor/dropzone/dropzone.min.js"></script> 

    <script src="{{base_url('assets/admin/')}}js/pages/formsComponents.js"></script> 
    <script type="text/javascript" src="{{base_url('assets/admin/js/plugins/datetime/jquery.datetimepicker.min.js')}}"></script>
    <script type="text/javascript" src="{{base_url('assets/admin/js/plugins/datetime/jquery.datetimepicker.full.min.js')}}"></script>
    <script type="text/javascript">
        $(function(){
            $("[type='date']").prop('type', 'text').datetimepicker();
        });
    </script>
    <script>$(function(){ FormsComponents.init(); });</script> 
    <script type="text/javascript">
    var articles = (function(){ 
        // bind events 
        $("[type='file']").on('change', eventPreviewGambar); 
  
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
 
<script type="text/javascript"> 
    Dropzone.autoDiscover = false; 

    var foto_upload= new Dropzone(".dropzone",{

    url: "<?php echo base_url('admin/cattle/upload_foto') ?>",
    maxFilesize: 2,
    method:"post",
    acceptedFiles:"image/*",
    paramName:"foto",
    dictInvalidFileType:"Type file ini tidak dizinkan",
    addRemoveLinks:true, 
    success: function(){  
        $.LoadingOverlay("show"); 
        $.LoadingOverlay("hide");
    } 
    });
    

    //Event ketika Memulai mengupload
    foto_upload.on("sending",function(a,b,c){
        a.token=Math.random();
        c.append("token_foto",a.token); //Menmpersiapkan token untuk masing masing foto
    });

    //Event ketika foto dihapus
    foto_upload.on("removedfile",function(a){
        $.LoadingOverlay("show"); 
        var token=a.token;
        $.ajax({
            type:"post",
            data:{token:token},
            url:"<?php echo base_url('admin/cattle/remove_foto') ?>",
            cache:false,
            dataType: 'json',
            success: function(){ 
                $.LoadingOverlay("hide");
            },
            error: function(){
                console.log("Error");
            }
        });
    });

    $(window).bind('beforeunload', function(){ 
      return 'Sebelum meninggalkan halaman, pastikan upload foto kosong!';
    }); 

    $('#foto-list').load("<?php echo site_url('admin/cattle/list_foto/'.$data->id);?>"); 
    $.LoadingOverlay("hide");

    $(document).on('click','#delete_foto',function(){ 
        var r = confirm("Apakah anda Yakin?");
        if (r == true) {

          var token = $(this).data("id");
          $.LoadingOverlay("show"); 
          $.ajax({
              url : "<?php echo site_url('admin/cattle/remove_foto');?>",
              method : "POST",
              data : {token : token},  
              success: function(data){  
                    $('#foto-list').load("<?php echo site_url('admin/cattle/list_foto/'.$data->id);?>"); 
                    $.LoadingOverlay("hide");
              } 
          });
        } else {  
        }  
    });


</script>
@endsection