<header class="header">

  <nav class="navbar fixed-top navbar-expand-lg">
    <div class="search-area">
      <div class="search-area-inner d-flex align-items-center justify-content-center">
        <div class="close-btn"><i class="icon-close"></i></div>
        <form action="#">
          <div class="form-group">
            <input type="search" name="search" id="search" placeholder="What are you looking for?">
            <button type="submit" class="submit"><i class="icon-search"></i></button>
          </div>
        </form>
      </div>
    </div>
    <div class="container-fluid">
      <!-- Navbar Header  -->
      <a href="{{site_url()}}" class="navbar-brand"><img width="200" class="img-fluid" src="{{base_url('assets/image/logo.png')}}" alt="..."></a>
      <button type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler navbar-toggler-right"><i class="fa fa-bars"></i></button>
      <!-- Navbar Collapse -->
      <?php $page = $this->uri->segment(1); ?>
      <div id="navbarCollapse" class="collapse navbar-collapse">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item"><a href="{{site_url()}}" class="nav-link {{($page == '')?'active':''}}">Beranda</a>
          </li>
          <li class="nav-item"><a href="{{site_url('product')}}" class="nav-link {{($page == 'product')?'active':''}}">Daftar Produk</a>
          </li>
          <li class="nav-item"><a href="{{site_url('article')}}" class="nav-link {{($page == 'article')?'active':''}}">Edukasi</a>
          </li>

          @if (!$this->ion_auth->logged_in())
            <li class="nav-item"><a href="{{site_url('purchase/check')}}" class="nav-link {{($page == 'purchase')?'active':''}}">Cek Pembelian</a></li>
          @else
            <li class="nav-item"><a href="{{site_url('user/order')}}" class="nav-link {{($page == 'purchase')?'active':''}}">Daftar Pembelian</a>
          @endif

          <li class="nav-item"><a href="{{site_url('about')}}" class="nav-link {{($page == 'about')?'active':''}}">Tentang Kami</a>
          </li>
        </ul>
        <div class="right-col d-flex align-items-lg-center flex-column flex-lg-row">

          <!-- User Not Logged - link to login page-->
          @if (!$this->ion_auth->logged_in())
            <div class="user"> <a href="{{site_url('auth/sign_in')}}" id="userdetails" href="{{site_url('auth/login')}}" class="user-link"><i class="icon-profile"></i> Masuk</a></div>
          @else
            <?php $user = $this->ion_auth->user()->row(); ?>
            <div class="user">
              <a href="{{site_url('user/order')}}" id="userdetails" class="user-link"><i class="icon-profile"></i> {{$user->first_name}}</a>
            </div>
          @endif
          <!-- Cart Dropdown-->


          @yield('cart')
        </div>
      </div>
    </div>
  </nav>
  <div class="mb-4"></div><br><br><br>
</header>
