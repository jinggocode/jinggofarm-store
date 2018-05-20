@layout('_layout/front/index')

@section('title')Transaksi @endsection

@section('content')
<section class="padding-small">
  <div class="container">
    <div class="row">
      <!-- Customer Sidebar-->
      @include('_layout/front/sidebar')

      <div class="col-lg-8 col-xl-9 pl-lg-3">

        <div class="block-header mb-5">
          <h5>Daftar Pembelian</h5>
        </div>
        <table class="table table-hover table-responsive-md">
          <thead>
            <tr>
              <th>Kode Order</th>
              <th>Tanggal</th>
              <th>Jumlah</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if(empty($data)): ?>
                <tr>
                    <td colspan="6" align="center">Tidak ada Data</td>
                </tr>
            <?php else: ?>
                @foreach($data as $row)
                <tr>
                  <td>{{$row->kode_pembelian}}</td>
                  <td>{{dateFormatBulan(3,$row->created_at)}}</td>
                  <td>{{money($row->jumlah_bayar)}}</td>
                  <td>
                    {{($row->status == '0')?'<span class="badge badge-warning">Segera Lakukan Pembayaran</span>':''}}
                    {{($row->status == '1')?'<span class="badge badge-warning">Validasi Transfer</span>':''}}
                    {{($row->status == '2')?'<span class="badge badge-primary">Menunggu Resi</span>':''}}
                    {{($row->status == '3')?'<span class="badge badge-success">Pengiriman</span>':''}}
                    {{($row->status == '4')?'<span class="badge badge-danger">Transaksi Gagal</span>':''}}
                  </td>
                  <td>
                    @if ($row->status == '0')
                      <a href="{{site_url('checkout/payment/'.$row->id)}}" class="btn btn-outline-warning btn-sm bg-warning text-white"><i class="fa fa-eye"></i> Bayar</a>
                    @else
                      <a href="{{site_url('purchase/detail/'.$row->id)}}" class="btn btn-outline-primary btn-sm bg-primary text-white"><i class="fa fa-eye"></i> Lihat</a>
                    @endif
                  </td>
                </tr>
                @endforeach
            <?php endif ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection

@section('cart')
<div class="cart dropdown show">
  <a id="cartdetails" href="https://example.com" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="icon-cart"></i>
  <div class="cart-no" id="cart-count-row"></div>
  </a>
  <a href="{{site_url('cart')}}" class="text-primary view-cart">Keranjang Belanja</a>
  <div aria-labelledby="cartdetails" class="dropdown-menu" id="cart-item">

  </div>
</div>
@endsection
@section('script')
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
