@layout('_layout/admin/index') 
@section('title')Laporan Keuntungan Penjualan
@endsection
 
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Laporan Keuntungan Penjualan
    </h1>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-lg-6 col-md-6">
            <form class="form-inline" action="{{site_url('admin/'.$page.'/profit/index')}}" method="get">
                <div class="form-group">
                    <select name="month" required="required" id="month" class="form-control">
                    <option value="">-- Bulan --</option>
                    <option {{(isset($search_data['month']) && $search_data['month'] == '01')?'selected':''}} value="01">Januari</option>
                    <option {{(isset($search_data['month']) && $search_data['month'] == '02')?'selected':''}} value="02">Februari</option>
                    <option {{(isset($search_data['month']) && $search_data['month'] == '03')?'selected':''}} value="03">Maret</option>
                    <option {{(isset($search_data['month']) && $search_data['month'] == '04')?'selected':''}} value="04">April</option>
                    <option {{(isset($search_data['month']) && $search_data['month'] == '05')?'selected':''}} value="05">Mei</option>
                    <option {{(isset($search_data['month']) && $search_data['month'] == '06')?'selected':''}} value="06">Juni</option>
                    <option {{(isset($search_data['month']) && $search_data['month'] == '07')?'selected':''}} value="07">Juli</option>
                    <option {{(isset($search_data['month']) && $search_data['month'] == '08')?'selected':''}} value="08">Agustus</option>
                </select>
                </div>
                <div class="form-group" style="margin-right: 10px">
                    <select name="year" required="required" id="year" class="form-control">
                    <option value="">-- Tahun --</option>
                    <option {{(isset($search_data['year']) && $search_data['year'] == '2018')?'selected':''}} value="2018">2018</option>
                    <option {{(isset($search_data['year']) && $search_data['year'] == '2019')?'selected':''}} value="2018">2019</option>
                    <option {{(isset($search_data['year']) && $search_data['year'] == '2020')?'selected':''}} value="2018">2020</option>
                    <option {{(isset($search_data['year']) && $search_data['year'] == '2021')?'selected':''}} value="2018">2021</option>
                </select>
                </div>
                <button type="submit" name="action" value="submit" class="btn btn-info"><i class="fa fa-eye"></i> Lihat</button>
        </div>
        <div class="col-lg-6 col-md-6" align="right">
            </form>
        </div>
    </div>

    <br> @if ($action == "") @else
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
                            <th>Kode Pembelian</th>
                            <th>waktu</th>
                            <th>Jumlah</th>
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
                            <td>{{$row->kode_pembelian}}</td>
                            <td>{{dateFormatBulan(4, $row->created_at)}}</td>
                            <td>{{money($row->jumlah_bayar)}}</td>
                        </tr>
                        @endforeach
                        <?php endif ?>
                        <tr>
                            <td colspan="3" align="right">TOTAL PENJUALAN</td>
                            <td><b>{{money($total->jumlah)}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="right">TOTAL KEUNTUNGAN</td>
                            <td><b>{{money($total_profit->biaya_jual - $total_profit->biaya_produksi)}}</b></td>
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