@layout('_layout/admin/index')

@section('title')Data Produk@endsection

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Detail Pembelian
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
        <div class="col-md-4">
          <table class="table table-striped">
            <tr>
              <td style="width: 30%">Nama Pembeli</td>
              <td>{{$data->nama_penerima}}</td>
            </tr>
            <tr>
              <td>Alamat</td>
              <td>{{$data->detail_alamat}}</td>
            </tr>
            <tr>
              <td>Kurir</td>
              <td>{{(empty($data->kurir))?'Bali Prima':''}}</td>
            </tr>
            <tr>
              <td>Biaya Kirim</td>
              <td>{{money($data->biaya_kirim)}}</td>
            </tr> 
            <tr>
              <td>Aksi</td>
              <td><a data-id="{{$data->id}}" data-kode="{{$data->kode_pembelian}}" class="open-kirimResiDialog btn btn-warning btn-sm" data-toggle="modal" data-target=".bs-example-modal-sm"><i class="fa fa-pencil-square-o"></i> Kirim Resi</a></td>
            </tr> 
          </table> 
        </div>
        <div class="col-md-8">
          <h2>Produk yang dibeli</h2>
          <table class="table table-striped">
            <thead>
              <th>No.</th>
              <th>Produk</th>
              <th>Harga</th>
              <th>Kuantitas</th>
              <th>Total</th>
            </thead>
            <tbody> 
              <?php $no = 1; ?>
              @foreach ($list_pembelian as $value)
                <tr>
                  <td>{{$no}}</td> 
                  <td>{{$value->product->nama}}</td> 
                  <td>{{money($value->product->harga_jual)}}</td> 
                  <td>{{$value->qty}}</td> 
                  <td>{{money($value->subtotal)}}</td> 
                </tr> 
                <tr>
                  <td colspan="4" align="right"><B>PEMBELIAN SUBTOTAL</B></td>
                  <td colspan="3"><B>{{money($data->jumlah_bayar)}}</B></td>
                </tr>
                <tr>
                  <td colspan="4" align="right"><B>BIAYA KIRIM</B></td>
                  <td colspan="3"><B>{{money($data->biaya_kirim)}}</B></td>
                </tr>
                <tr>
                  <td colspan="4" align="right"><B>TOTAL</B></td>
                  <td colspan="3"><B>{{money($data->jumlah_bayar + $data->biaya_kirim)}}</B></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>  
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