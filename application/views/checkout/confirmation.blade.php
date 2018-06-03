@layout('_layout/front/index')

@section('title')Konfirmasi Pembayaran@endsection

@section('content')   
<!-- Hero Section-->
<section class="hero hero-page gray-bg padding-small">
  <div class="container">
    <div class="row d-flex">
      <div class="col-lg-9 order-2 order-lg-1">
        <h1>Konfirmasi Pembayaran</h1><p class="lead">Kirim bukti transfer yang valid</p>
      </div>
      <div class="col-lg-3 text-right order-1 order-lg-2">
        <ul class="breadcrumb justify-content-lg-end">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Checkout</li>
        </ul>
      </div>
    </div>
  </div>
</section>
<!-- Checkout Forms-->
<section class="checkout">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <ul class="nav nav-pills">
          <li class="nav-item" style="width: 30% !important"><a href="checkout1.html" class="nav-link disabled">Alamat</a></li> 
          <li class="nav-item" style="width: 31% !important"><a href="#" class="nav-link disabled">Pilihan Pembayaran </a></li>
          <li class="nav-item" style="width: 39% !important"><a href="#" class="nav-link active">Konfirmasi Pembayaran</a></li>
        </ul>
        <div class="tab-content">
          <div id="payment-method" class="tab-block">
            <div id="accordion" role="tablist" aria-multiselectable="true">
              <div class="card">
                <div id="headingOne" role="tab" class="card-header">
                  <h6><a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Bukti Transfer</a></h6>
                </div>
                <div id="collapseOne" role="tabpanel" aria-labelledby="headingOne" class="collapse show">
                  <div class="card-body" style="margin-left: -20px">
                    <form action="{{site_url('checkout/proses_confirm')}}" method="post" enctype="multipart/form-data"> 
                    {{$csrf}}
                    {{form_hidden('id_pembelian', $pembelian->id);}}
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group col-md-12">
                            <label for="nama_rek" class="form-label">Atas Nama</label>
                            <input required="required" value="{{set_value('nama_rek')}}" id="nama_rek" type="text" name="nama_rek" placeholder="Nama Rekening" class="form-control">
                          </div>
                          <div class="form-group col-md-12">
                            <label for="no_rek" class="form-label">Nomor Rekening</label>
                            <input required="required" value="{{set_value('no_rek')}}" id="no_rek" type="text" name="no_rek" placeholder="Nomor Rekening" class="form-control">
                          </div>
                          <div class="form-group col-md-12">
                            <label for="foto" class="form-label">Foto Bukti (.png atau .jpg)</label>
                            <input type="file" required="required" value="{{set_value('email')}}" id="foto" type="text" name="foto" class="form-control">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <img src="{{base_url('assets/image/default.png')}}" style="max-width: 100%" class="img-fluid image-preview" alt="">
                        </div>
                      </div>
                  </div>
                </div>
              </div>  
            </div>
            <div class="CTAs d-flex justify-content-between flex-column flex-lg-row">
              <i>Pastikan bukti yang dikirim valid</i>
              <button type="submit" class="btn btn-template wide next">Kirim Bukti<i class="fa fa-angle-right"></i></button>
            </div>
            </form>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="block-body order-summary" style="position: sticky; top: 120px">
          <h6 class="text-uppercase">Ringkasan Pembelian</h6> 

          <div>
            <table class="table">
              
              @foreach ($detail_pembelian as $value) 
              <tr>
                <td class="text-left" style="font-size: 17px; width: 50%">{{$value->product->nama}} <br> <span style="font-size: 14px">Jumlah: <b>{{$value->qty}}</b></span></td>
                <td class="text-right">{{money($value->product->harga_jual)}}</td>
              </tr> 
              @endforeach

            </table>
          </div>
          <div id="total">
            <ul class="order-menu list-unstyled">
              <li class="d-flex justify-content-between"><span>Subtotal </span><strong>{{money($pembelian->jumlah_bayar)}}</strong></li>
              <li class="d-flex justify-content-between"><span>Ongkos Kirim</span><strong>{{money($pembelian->biaya_kirim)}}</strong></li> 
              <li class="d-flex justify-content-between"><span>Total</span><strong class="text-primary price-total">{{money($pembelian->jumlah_bayar + $pembelian->biaya_kirim)}}</strong></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection 

@section('script')
<script>
$(document).ready(function(){

  $.ajaxSetup({
      data: {
          csrf_test_name: $.cookie('csrf_cookie_name')
      }
  }); 

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
}); 
</script>
@endsection