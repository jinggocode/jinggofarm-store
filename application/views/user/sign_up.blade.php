@layout('_layout/front/index')

@section('title')Pendaftaran Pelanggan @endsection

@section('content')
<section class="padding-small">
  <div class="container">
    <div class="row">
      <div class="col-lg-3"></div>
      <div class="col-lg-6 col-sm-12 col-md-12">
        <div class="block">
          <p class="text-center">Sudah punya akun? Silahkan <a href="{{site_url('auth/sign_in')}}" class="btn btn-primary">Login</a></p>
          <div class="block-header">
            <h5>Pendaftaran Pelanggan</h5>
          </div>
          <div class="block-body">
            <form action="{{site_url('user/save')}}" method="post">
              {{$csrf}}

              @if (!empty(validation_errors()))
              <div class="alert alert-danger" role="alert">
                <p>{{validation_errors()}}</p>
              </div>
              @endif

              <div class="form-group">
                <label for="first_name" class="form-label">Nama</label>
                <input id="first_name" name="first_name" type="text" class="form-control">
              </div>
              <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input id="email" name="email" type="text" class="form-control">
              </div>
              <div class="form-group">
                <label for="phone" class="form-label">Nomor Telepon</label>
                <input id="phone" name="phone" type="text" class="form-control">
              </div>
              <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input id="password" name="password" type="password" class="form-control">
              </div>
              <div class="form-group">
                <label for="reenter_password" class="form-label">Ulangi Password</label>
                <input id="reenter_password" name="reenter_password" type="password" class="form-control">
              </div>
              <div class="form-group text-center">
                <button type="submit" class="btn btn-primary"><i class="icon-profile"></i> Daftar                                    </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
