@layout('_layout/admin/index') 
@section('title')Laporan Produk berdasarkan Tanggal
@endsection
 
@section('style')
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
@endsection
 
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Laporan Produk 
    </h1>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-lg-6 col-md-6">
            <form class="form-inline" action="{{site_url('admin/'.$page.'/product/index')}}" method="get" autocomplete="off">
                <div class="form-group">
                    <select name="category" id="category" class="form-control">
                        <option value="0">:: Semua Kategori Produk ::</option>
                        @foreach ($category_product as $val)
                            <option {{($category_select == $val->id)?'selected':''}} value="{{$val->id}}">{{$val->nama}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <input value="{{(isset($date))?$date:''}}" name="date" type="text" class="form-control pull-right" id="datepicker" data-date-format='dd-mm-yyyy' required>
                </div>
                <button type="submit" name="action" value="submit" class="btn btn-info"><i class="fa fa-eye"></i> Lihat</button>
            
            </form>
        </div>
        <div class="col-lg-6 col-md-6" align="right">
            <a href="{{site_url('admin/report/product/cetak?category='.$category_select.'&date='.$date)}}" target="_BLANK" class="btn btn-primary"><i class="fa fa-print"></i> Cetak</a>
        </div>
    </div>

    <br> @if ($action == "") @else

    <h4>{{dateFormatBulan(4, $newDateFormat)}}</h4>
    <div class="box">
        <!-- Table Styles Block -->
        <div class="block">

            <!-- Table Styles Content -->
            <div class="table-responsive">
                <!--
                Available Table Classes:
                    'table'             - basic table
                    'table-bordered'    - table with full borders
                    'table-borderless'  - table with no borders
                    'table-striped'     - striped table
                    'table-condensed'   - table with smaller top and bottom cell padding
                    'table-hover'       - rows highlighted on mouse hover
                    'table-vcenter'     - middle align content vertically
                -->
                <table id="general-table" class="table table-striped table-borderless table-vcenter">
                    <thead>
                        <tr>
                            <!-- <th style="width: 500px;">Judul</th>   -->
                            <th>No.</th>
                            <th>Nama Produk</th>
                            <th>Jumlah Terjual</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($data)): ?>
                        <tr>
                            <td colspan="6" align="center">Tidak ada Data</td>
                        </tr>
                        <?php else: ?>
                        <?php $no = 1 ?> @foreach($data as $row)
                        <tr>
                            <td>{{$no++}}.</td>
                            <td>{{$row->nama}}</td>
                            <td>{{$row->jumlah}}</td>
                        </tr>
                        @endforeach
                        <?php endif ?>
                        <tr>
                            <td colspan="2" align="right">TOTAL PENJUALAN</td>
                            <td><b>{{$total->total}}</b></td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <!-- END Table Styles Content -->
        </div>
        <!-- END Table Styles Block -->
    </div>

    @endif
    </div>
</section>
@endsection
 
@section('script')
<!-- bootstrap datepicker -->
<script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script>
    $(function () {
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true,
      dateFormat: 'yy-mm-dd'
    })
  })

</script>
@endsection