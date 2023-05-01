<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<nav class="navbar navbar-expand-lg">
    <div class="container py-2 px-4">
        <div class="d-flex align-items-center">
        <div class="bg-light rounded p-2" style="width: min-content">
            <img
            src="https://www.bulsu-cict.com/CICT.png"
            alt=""
            class="img-fluid"
            style="max-width: 50px"
            />
        </div>
        <div class="ms-2">
            <span class="h5">Bulacan State University</span>
            <br />
            <span class="text-light">College of Information and Technology</span>
        </div>
        </div>
    </div>
    </nav>

  <main class="100vh">
    <div class="row container mx-auto g-4 align-items-center">
      <div class="col-md-6 rounded-4 border img-wrapper d-none d-md-block">
        <img
          src="https://pia.gov.ph/uploads/2022/10/216526d932cb76aaaa3344f01d0ce9f7-800-1200.jpeg"
          alt=""
          class="img-fluid rounded-4"
          style="transform: rotate(3deg)"
        />
      </div>
      <div class="p-3 col-md-6">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3 class="etch3">
                    CICT<span>
                      Curriculum<br />
                      Management System</span
                    >   
                  </h3>
              @if(!session()->has('success'))
      
                <div class="">
                    <div class="card-header h5">{{ __('Reset Password') }}</div>
                    
                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
      
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-group">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email Address') }}</label>
      
                                <div class="">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
      
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
      
                                <div class="">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
      
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
      
                                <div class="">
                                    <input id="password-confirm" type="password" class="form-control w-100" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
      
                            <div class="form-group my-2">
                                <button type="submit" class="btn text-light w-100 rounded-pill my-1">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @endif
      
                @if(session()->has('success'))
                    <div class="alert alert-success">
                      <h2>Password Change Successfully</h2>
                    </div>
                @endif
            </div>
        </div>
      </div>
    </div>
  </main>
  
{{-- <div class="container">
  <div class="row justify-content-center">
      <div class="col-md-8">
        @if(!session()->has('success'))

          <div class="card">
              <div class="card-header">{{ __('Reset Password') }}</div>

              <div class="card-body">
                  <form method="POST" action="{{ route('password.update') }}">
                      @csrf

                      <input type="hidden" name="token" value="{{ $token }}">

                      <div class="form-group row">
                          <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email Address') }}</label>

                          <div class="col-md-6">
                              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                              @error('email')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                          <div class="col-md-6">
                              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                              @error('password')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                          <div class="col-md-6">
                              <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                          </div>
                      </div>

                      <div class="form-group row mb-0">
                          <div class="col-md-6 offset-md-4">
                              <button type="submit" class="btn btn-primary">
                                  {{ __('Reset Password') }}
                              </button>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
          @endif

          @if(session()->has('success'))
              <div class="alert alert-success">
                <h2>Password Change Successfully</h2>
              </div>
          @endif
      </div>
  </div>
</div> --}}

<style>
    main {
      margin-top: 5rem;
    }
    nav {
      background-color: #d05834;
    }
    .title {
      font-size: 4rem;
      font-weight: 900;
      color: #d05834;
    }
    .title-sub {
      font-size: 2rem;
      font-weight: 900;
    }
    .img-wrapper {
      border-color: #d05834 !important;
    }

    .bg{
    background-image: url('./img/bg.png');
    background-attachment: fixed;
    background-repeat: no-repeat;
    background-size: cover;
    min-height: 100vh;
}
.container{

    /* background-color: white;
    width: 500px;
    height: 100vh;
    float: left; */
}
.etch3{
    margin-top: 20px;
    font-size: 30px;
    font-family: 'century gothic';
    font-weight: bold;
}
.etch3 span{
    font-family: 'century gothic';
    font-weight: 100;
}
.inputs{
    width: 335px;

}
.logos{
    width: 100px;
}
.button{
    border-width: 0px;
    width: 100%;

    background-color: #D05834 !important;
    color: white;
    font-family: 'century gothic';
    font-weight: bold;
}

button{
    background-color: #D05834 !important
}

  </style>