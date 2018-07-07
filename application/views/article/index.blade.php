@layout('_layout/front/index')

@section('title')Artikel Edukasi@endsection

@section('content')
<!-- Hero Section-->
<section class="hero hero-page gray-bg padding-small">
  <div class="container">
    <div class="row d-flex">
      <div class="col-lg-9 order-2 order-lg-1">
        <h1>Artikel Edukasi</h1>
      </div>
      <div class="col-lg-3 text-right order-1 order-lg-2">
        <ul class="breadcrumb justify-content-lg-end">
          <li class="breadcrumb-item"><a href="{{site_url()}}">Home</a></li>
          <li class="breadcrumb-item active">Edukasi</li>
        </ul>
      </div>
    </div>
  </div>
</section>
<section class="blog">
  <div class="container">

    <form action="{{site_url('article/search')}}">
      <div class="row pb-3">
        
        <!-- form Pencarian -->
        <div class="col-md-4">

        </div>
        <div class="col-md-8 text-right">
          <select id="kategori" name="category" class="bs-select" onchange="this.form.submit();">
            <option value="">-Semua Kategori-</option>
            @foreach ($category as $value) 
              <option {{(isset($search_data['category'])&& $search_data['category'] == $value->id)?'selected':''}} value="{{$value->id}}">{{$value->nama}}</option> 
            @endforeach
          </select>
          <select id="sorting" name="sort" class="bs-select" onchange="this.form.submit();">
            <option {{(isset($search_data['sort'])&& $search_data['sort'] == '1')?'selected':''}} value="1">Terbaru</option>
            <option {{(isset($search_data['sort'])&& $search_data['sort'] == '2')?'selected':''}} value="2">Terlama</option> 
          </select>
        </div>

      </div> 
    </form>
      
    <div class="row">

      <!-- post-->
      @foreach ($data as $value) 
      <div class="col-lg-6">
        <div class="post post-gray d-flex align-items-center flex-md-row flex-column" style="cursor: pointer;" onclick="window.location.href='{{site_url('article/detail/'.$value->id.'/'.$value->slug)}}'">
          <div class="thumbnail d-flex-align-items-center justify-content-center"><img src="{{base_url('uploads/article/'.$value->foto)}}" alt="..."></div>
          <div class="info"> 
            <h4 class="h5"> <a href="{{site_url('article/detail/'.$value->id.'/'.$value->slug)}}">{{$value->judul}}</a></h4><span class="date"><i class="fa fa-clock-o"></i>{{dateFormatBulan(3, $value->created_at)}}</span>
            <p>{{cutText($value->isi, 100, 2)}}</p><a href="{{site_url('article/detail/'.$value->id.'/'.$value->slug)}}" class="read-more">Baca Selengkapnya<i class="fa fa-long-arrow-right"></i></a>
          </div>
        </div>
      </div>
      @endforeach
      <!-- /end post--> 
      
    </div>
    <!-- Pagination -->
    <nav aria-label="..." class="d-block w-100">
      {{$pagination}}
    </nav>
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