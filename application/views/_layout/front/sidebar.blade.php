
<?php
$user = $this->ion_auth->user()->row();
$page = $this->uri->segment(2);
?>

<div class="customer-sidebar col-xl-3 col-lg-4 mb-md-5">
  <div class="customer-profile"><a href="#" class="d-inline-block">
    <img src="https://static.change.org/profile-img/default-user-profile.svg" class="img-fluid rounded-circle customer-image"></a>
    <h5>{{$user->first_name}}</h5>
    <p class="text-muted text-small">Pelanggan</p>
  </div>
  <nav class="list-group customer-nav">
      <a href="{{site_url('user/order')}}" class="{{($page == "order")?'active':''}} list-group-item d-flex justify-content-between align-items-center">
        <span><span class="icon icon-bag"></span>Pembelian</span> 
      </a>
      <a href="{{site_url('user/profile')}}" class="{{($page == "profile")?'active':''}} list-group-item d-flex justify-content-between align-items-center">
        <span><span class="icon icon-profile"></span>Profil</span>
      </a>
      <a href="{{site_url('user/change_password')}}" class="{{($page == "change_password")?'active':''}} list-group-item d-flex justify-content-between align-items-center">
        <span><span class="icon icon-map"></span>Ubah Password</span>
      </a>
      <a href="{{site_url('auth/logout')}}" class="{{($page == "logout")?'active':''}} list-group-item d-flex justify-content-between align-items-center"><span><span class="fa fa-sign-out"></span>Keluar</span>
      </a>
  </nav>
</div>
