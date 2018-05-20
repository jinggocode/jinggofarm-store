@layout('_layout/front/index')

@section('title')Metode Pembayaran@endsection

@section('content')   
<!-- Hero Section-->
<section class="hero hero-page gray-bg padding-small">
  <div class="container">
    <div class="row d-flex">
      <div class="col-lg-12 order-2 order-lg-1 text-center">
        <h1>Cek Status Pembelian</h1> 
      </div> 
    </div>
  </div>
</section>
<!-- Checkout Forms-->
<section class="checkout">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 offset-3"> 
          <form class="form-inline" action="{{site_url('purchase/detail')}}"> 
            <div class="form-group mx-sm-3 mb-2">
              <label for="kode" class="sr-only">Kode Pembelian</label>
              <input required="required" autofocus="autofocus" type="text" class="form-control" name="kode" id="kode" placeholder="Kode Pembelian">
            </div>
            <button type="submit" class="btn btn-primary mb-2">Cek Pembelian</button>
          </form>
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