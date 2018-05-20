@layout('_layout/front/index')

@section('title')Cek Pembelian@endsection

@section('content')
<section class="hero hero-page gray-bg padding-small">
  <div class="container">
    <div class="row d-flex">
      <div class="col-lg-12 order-2 order-lg-1">
        <h1>{{$pembelian->kode_pembelian}}</h1>
        <p class="lead">
          Pembelian {{$pembelian->kode_pembelian}} yang dilakukan pada tanggal <strong>{{dateFormatBulan(3, $pembelian->created_at)}}</strong> <br>

            {{($pembelian->status == '1')?'<span class="badge badge-warning">Validasi Transfer</span>':''}}
            {{($pembelian->status == '2')?'<span class="badge badge-primary">Persiapan Kirim</span>':''}}
            {{($pembelian->status == '3')?'<span class="badge badge-success">Pengiriman</span> No. Resi <b>'.$pembelian->no_resi.'</b>':''}}
            {{($pembelian->status == '4')?'<span class="badge badge-danger">Transfer Tidak Valid</span>':''}}
            <br>
            <span class="pt-3">{{($pembelian->status == '3')?'<a href="#list" class="btn btn-primary text-white"><i class="fa fa-pencil-square"></i> Beri Testimoni</a>':''}}</span>
        </p>
        <p class="text-muted">Jika anda memiliki pertanyaan silahkan menghubungi admin di 082246512362</p>
      </div>
    </div>
  </div>
</section>
<section class="padding-small" id="list">
  <div class="container">
    <div class="row">

      <div class="col-lg-12 col-xl-12 pl-lg-3">
        <div class="basket basket-customer-order">
          <div class="basket-holder">
            <div class="basket-header">
              <div class="row">
                <div class="col-6">Produk</div>
                <div class="col-2">Harga</div>
                <div class="col-2">Kuantitas</div>
                <div class="col-2 text-right">Total</div>
              </div>
            </div>
            <div class="basket-body">
              <!-- Product-->
              @foreach ($list_pembelian as $value)
              <div class="item">
                <div class="row d-flex align-items-center">
                  <div class="col-6">
                    <div class="d-flex align-items-center"><img src="{{base_url('uploads/product/'.$value->product->foto)}}" class="img-fluid">
                      <div class="title">
                        <a><h5>{{$value->product->nama}}</h5></a> <br>
                        {{($pembelian->status == '3' && $value->status_testimoni == '0')?'<a id="testimoni" data-id="'.$value->id.'" data-id_produk="'.$value->product->id.'" data-name="'.$value->product->nama.'" class="btn btn-light text-white btn-sm" data-toggle="modal" data-target=".bd-testimoniModal"><i class="fa fa-pencil-square"></i> Beri Testimoni</a>':'<span class="badge badge-light"><i class="fa fa-check"></i> Sudah diulas</span>'}}
                      </div>
                    </div>
                  </div>
                  <div class="col-2"><span>{{money($value->product->harga_jual)}}</span></div>
                  <div class="col-2">{{$value->qty}}</div>
                  <div class="col-2 text-right"><span>{{money($value->subtotal)}}</span></div>
                </div>
              </div>
              @endforeach

            </div>
            <div class="basket-footer">
              <div class="item">
                <div class="row">
                  <div class="offset-md-6 col-4"> <strong>Pembelian subtotal</strong></div>
                  <div class="col-2 text-right"><strong>{{money($pembelian->jumlah_bayar)}}</strong></div>
                </div>
              </div>
              <div class="item">
                <div class="row">
                  <div class="offset-md-6 col-4"> <strong>Ongkos Kirim</strong></div>
                  <div class="col-2 text-right"><strong>{{money($pembelian->biaya_kirim)}}</strong></div>
                </div>
              </div>
              <div class="item">
                <div class="row">
                  <div class="offset-md-6 col-4"> <strong>Total</strong></div>
                  <div class="col-2 text-right"><strong>{{money($pembelian->jumlah_bayar + $pembelian->biaya_kirim)}}</strong></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row addresses">
          <div class="col-sm-12">
            <div class="block-header">
              <h6 class="text-uppercase">Alamat Pengiriman</h6>
            </div>
            <div class="block-body">
              <p>{{$kabupaten['city_name']}}, {{$provinsi}} <br>{{$pembelian->detail_alamat}} <br>{{$kabupaten['postal_code']}}</p>
            </div>
          </div>
        </div>
        <!-- /.addresses                           -->
      </div>
    </div>
  </div>
</section>
@endsection

@section('modal')
  <div class="modal fade bd-testimoniModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Testimoni </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Silahkan berikan ulasan mengenai produk <b><span id="nama"></span></b> yang anda beli!</p>
          <form action="{{site_url('purchase/testimoni')}}" method="post">
            {{$csrf}}
            <input type="hidden" name="id" id="id" value="">
            <input type="hidden" name="id_produk" id="id_produk" value="">
            <input type="hidden" name="id_pembelian" value="{{$pembelian->id}}">
            <input type="hidden" name="nama_pelanggan" value="{{$pembelian->nama_penerima}}">

            <div class="form-group">
              <textarea name="ulasan" rows="8" cols="80" class="form-control" placeholder="Isi Ulasan"></textarea>
            </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"><i class="fa fa-send-o"></i> Kirim</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </div>
      </form>
      </div>
    </div>
  </div>
@endsection

@section('cart')
@endsection

@section('script')
<script type="text/javascript">
$(document).on('click','#testimoni',function(){
    var id        = $(this).data("id");
    var id_produk = $(this).data("id_produk");
    var nama = $(this).data("name");
    console.log(nama);

    $.LoadingOverlay("show");
    document.getElementById("nama").innerHTML = nama;
    $(".modal-body #id").val( id );
    $(".modal-body #id_produk").val( id_produk );
    $.LoadingOverlay("hide");
});
</script>
<script type="text/javascript">
    $(document).ready(function(){
      // this bit needs to be loaded on every page where an ajax POST may happen
      $.ajaxSetup({
          data: {
              csrf_test_name: $.cookie('csrf_cookie_name')
          }
      });

        $('#cart-item').load("<?php echo site_url('product/load_cart');?>");
        $('#cart-count-row').load("<?php echo site_url('product/count_cart');?>");

        $(document).on('click','.delete_cart',function(){
            var r = confirm("Apakah anda Yakin?");
            if (r == true) {
              var row_id=$(this).attr("id");
              $.ajax({
                  url : "<?php echo site_url('product/delete_cart');?>",
                  method : "POST",
                  data : {row_id : row_id},
                  success: function(data){
                      $('#cart-item').html(data);
                      $('#cart-count-row').load("<?php echo site_url('product/count_cart');?>");
                      sweet("Berhasil", "Dihapus dari Keranjang", "warning");
                  }
              });
            } else {
            }

        });

        function sweet(tipe, pesan, icon){
          swal(tipe, pesan, icon);
        }
        window.onload = sweet;
    });
</script>
@endsection
