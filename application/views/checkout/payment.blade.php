@layout('_layout/front/index')

@section('title')Metode Pembayaran@endsection

@section('content')
<!-- Hero Section-->
<section class="hero hero-page gray-bg padding-small">
  <div class="container">
    <div class="row d-flex">
      <div class="col-lg-9 order-2 order-lg-1">
        <h1>Metode Pembayaran</h1><p class="lead">Segera lakukan pembayaran agar produk segera di kirim</p>
      </div>
    </div>
  </div>
</section>
<!-- Checkout Forms-->
<section class="checkout">
  <div class="container">

    <div class="alert alert-danger">
      <span>Segera lakukan pembayaran sebelum <b>{{dateFormatBulan(3, $pembelian->batas_bayar)}}</b></span>
    </div>

    <div class="py-3" align="center">
        <div class="alert alert-primary">
          <h4>Kode Order : {{$pembelian->kode_pembelian}}</h4>
        </div>
    </div>

    <div class="row">
      <div class="col-lg-8">
        <ul class="nav nav-pills">
          <li class="nav-item" style="width: 30% !important"><a href="checkout1.html" class="nav-link disabled">Alamat</a></li>
          <li class="nav-item" style="width: 31% !important"><a href="#" class="nav-link active">Pilihan Pembayaran </a></li>
          <li class="nav-item" style="width: 39% !important"><a href="#" class="nav-link disabled">Konfirmasi Pembayaran</a></li>
        </ul>
        <div class="tab-content">
          <div id="payment-method" class="tab-block">
            <div id="accordion" role="tablist" aria-multiselectable="true">
              <div class="card">
                <div id="headingOne" role="tab" class="card-header">
                  <h6><a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Transfer</a></h6>
                </div>
                <div id="collapseOne" role="tabpanel" aria-labelledby="headingOne" class="collapse show">
                  <div class="card-body">
                    <h3>Bank Mandiri</h3>
                    <p>Atas Nama <b>Sumber Lumintu</b> <br> 142-26265641-01</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="CTAs d-flex justify-content-between flex-column">
              <span class="pb-3">Sudah melakukan Pembayaran?</span>
              <a href="{{site_url('checkout/confirm/'.$pembelian->id)}}" class="btn btn-template wide next">Konfirmasi<i class="fa fa-angle-right"></i></a>
              <a href="{{site_url('checkout/cancel/'.$pembelian->id)}}" class="btn btn-danger text-white wide" onclick="return confirm('Apakah anda Yakin?')">Batalkan Pembelian<i class="fa fa-times"></i></a>
            </div>
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

});
</script>
@endsection
