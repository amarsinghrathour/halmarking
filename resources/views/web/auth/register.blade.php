<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>{{ $title ?? ''}}</title>
        <meta name="robots" content="noindex, follow" />
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{asset('website/assets/images/favicon.png')}}">

        <!-- Icons font CSS-->
        <link href="{{asset('website/assets/login/vendor/mdi-font/css/material-design-iconic-font.min.css')}}" rel="stylesheet" media="all">
        <link href="{{asset('website/assets/login/vendor/font-awesome-4.7/css/font-awesome.min.css')}}" rel="stylesheet" media="all">
        <!-- Font special for pages-->
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

        <!-- Vendor CSS-->
        <link href="{{asset('website/assets/login/vendor/select2/select2.min.css')}}" rel="stylesheet" media="all">
        <link href="{{asset('website/assets/login/vendor/datepicker/daterangepicker.css')}}" rel="stylesheet" media="all">

        <!-- Main CSS-->
        <link href="{{asset('website/assets/login/css/main.css')}}" rel="stylesheet" media="all">
        <link href="{{asset('website/assets/login/css/custom.css')}}" rel="stylesheet" media="all">
        
    </head>

    <body>

        <div class="page-wrapper bg-red p-t-180 p-b-100 font-robo">
            <div class="wrapper wrapper--w960">
           

                <div class="card card-2">
                    <div class="card-heading"></div>
                    <div class="card-body">
                        <h2 class="title">Sign Up Here</h2>
                         @include('web.layout.feedback')
                        <form method="POST" action="{{ route('register.process') }}">
                        @csrf
                            <div class="input-group">
                                <input class="input--style-2 @error('name') is-invalid @enderror" type="text" placeholder="Name" name="name" required="">
                                @error('name')
                                            <span class="tagline" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                            </div>
                            <div class="input-group">
                                <input class="input--style-2 @error('email') is-invalid @enderror" type="email" placeholder="Email" name="email" required="">
                                @error('email')
                                            <span class="tagline" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                            </div>
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group">
                                        <input class="input--style-2 js-datepicker @error('dob') is-invalid @enderror" type="text" placeholder="Birthdate" name="dob" required="">
                                        <i class="zmdi zmdi-calendar-note input-icon js-btn-calendar"></i>
                                    </div>
                                    @error('dob')
                                            <span class="tagline" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                </div>
                                <div class="col-2">
                                    <div class="input-group">
                                        <div class="rs-select2 js-select-simple select--no-search">
                                            <select name="gender" required=""class="@error('gender') is-invalid @enderror">
                                                <option value="" selected="selected">Gender</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Other">Other</option>
                                            </select>
                                            <div class="select-dropdown"></div>
                                            @error('gender')
                                            <span class="tagline" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="input-group">
                            <input class="input--style-2 @error('password') is-invalid @enderror" type="password" minlength="6" placeholder="Password" name="password" required="">
                            @error('password')
                            <span class="tagline" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="input-group">
                            <input class="input--style-2 @error('password_confirmation') is-invalid @enderror" type="password" minlength="6" placeholder="Confirm Password" name="password_confirmation" required="">
                            @error('password_confirmation')
                            <span class="tagline" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>                     

                            <div class="p-t-30">
                                <button class="btn btn--radius btn--green" type="submit">Sign Up</button>
                                <span>Already has account Sign In <a href="{{ route('web.login') }}">here</a></span>
                            </div>
                              
                        </form>
                        
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Jquery JS-->
    <script src="{{asset('website/assets/login/vendor/jquery/jquery.min.js')}}"></script>
    <!-- Vendor JS-->
    <script src="{{asset('website/assets/login/vendor/select2/select2.min.js')}}"></script>
    <script src="{{asset('website/assets/login/vendor/datepicker/moment.min.js')}}"></script>
    <script src="{{asset('website/assets/login/vendor/datepicker/daterangepicker.js')}}"></script>

    <!-- Main JS-->
    <script src="{{asset('website/assets/login/js/global.js')}}"></script>

</body>


</html>