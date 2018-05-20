  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{base_url()}}assets/admin/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <?php $user = $this->ion_auth->user()->row(); ?>
        <div class="pull-left info">
          <p>{{$user->first_name}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Administrator</a>
        </div>
      </div> 

      <?php $page = $this->uri->segment(2); ?>
      <?php $sub_page = $this->uri->segment(3); ?>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">DAFTAR MENU</li>
        <li class="{{($page == '' || $page == 'homepage')?'active':''}}"><a href="{{site_url('admin/homepage')}}"><i class="fa fa-book"></i> <span>Beranda</span></a></li>
        <li class="{{($page == 'product')?'active':''}}"><a href="{{site_url('admin/product')}}"><i class="fa fa-tag"></i> <span>Data Produk</span></a></li>
        <li class="{{($page == 'purchase')?'active':''}}"><a href="{{site_url('admin/purchase')}}"><i class="fa fa-shopping-bag"></i> <span>Pembelian</span></a></li>
        <li class="{{($page == 'article')?'active':''}}"><a href="{{site_url('admin/article')}}"><i class="fa fa-newspaper-o"></i> <span>Data Artikel Edukasi</span></a></li>
        <li class="{{($page == 'user')?'active':''}}"><a href="{{site_url('admin/user')}}"><i class="fa fa-users"></i> <span>Data Admin</span></a></li>
        <li class="{{($page == 'report')?'active':''}}"><a href="{{site_url('admin/report/profit')}}"><i class="fa fa-file"></i> <span>Laporan Keuntungan</span></a></li>
        <li class="treeview {{($page == 'kurir')?'active':''}}">
          <a href="#">
            <i class="fa fa-truck"></i> <span>Data Kurir</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{($sub_page == 'ongkir')?'active':''}}"><a href="{{site_url('admin/kurir/ongkir')}}"><i class="fa fa-circle-o"></i> Data Ongkos Pengiriman</a></li> 
            <li class="{{($sub_page == 'lists')?'active':''}}"><a href="{{site_url('admin/kurir/lists')}}"><i class="fa fa-circle-o"></i> Daftar Kurir</a></li> 
          </ul>
        </li> 
        <li class="treeview {{($page == 'categoryp' || $page == 'categoryar')?'active':''}}">
          <a href="#">
            <i class="fa fa-database"></i> <span>Data Master</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{($page == 'categoryp')?'active':''}}"><a href="{{site_url('admin/categoryp')}}"><i class="fa fa-circle-o"></i> Data Kategori Produk</a></li> 
            <li class="{{($page == 'categoryar')?'active':''}}"><a href="{{site_url('admin/categoryar')}}"><i class="fa fa-circle-o"></i> Data Kategori Artikel</a></li> 
          </ul>
        </li> 
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>