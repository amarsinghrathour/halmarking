@extends('layouts.web')
@section('content')
    <!-- Login / Registration start -->
    <section class="banner login-registration">
      <div class="vector-img">
        <img src="{{ asset('website/images/vector.png') }}" alt="">
      </div>
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="content-box">
              <h2>Login Account</h2>
            </div>
            <form method="POST" action="{{ route('login') }}" class="sl-form">
                @csrf
              <div class="form-group">
                <label>E-Mail Address</label>
                <input type="email" name="email" class="@error('email') is-invalid @enderror" placeholder="example@gmail.com" value="{{ old('email') }}" required autocomplete="email" autofocus >
                @error('email')
                    <span class="tagline" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div class="form-group">
                <label>Password</label>
                <input type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                @error('password')
                    <span class="tagline" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label">{{ __('Remember Me') }}</label>
              </div>
                <button class="btn btn-filled btn-round"><span class="bh"></span> <span><i class="fas fa-key">&nbsp;</i>{{ __('Login') }}</span></button>
              <p class="notice">Don’t have an account? <a href="{{ url('/signup') }}">Signup Now</a></p>
            </form>
          </div>          
        </div>
      </div>      
    </section>
    <!-- Login / Registration end -->
@endsection