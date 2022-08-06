<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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
                        <h2 class="title">Login Here</h2>
                        @include('web.layout.feedback')
                        <form method="POST" action="{{ route('login.process') }}">
                          @csrf
                            <div class="input-group">
                                <input class="input--style-2 @error('email') is-invalid @enderror" type="text" placeholder="Email" name="email">
                                @error('email')
                                <span class="tagline" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>                         
                            <div class="input-group">
                                <input class="input--style-2 @error('password') is-invalid @enderror" type="password" placeholder="Password" name="password">                     
                                @error('password')
                                <span class="tagline" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                            <div class="p-t-30">
                                <button class="btn btn--radius btn--green" type="submit">Sign In</button>
                                <span>Don't have an account Sign Up <a href="{{ route('web.register') }}">here</a></span>
                            </div>
                          </form>
                            <div class="clearfix">&nbsp;</div>
                            <div class="clearfix">&nbsp;</div>
                            <div class="hr-word">
                                <span class="word">OR</span>
                            </div>
                            <div class="my-div">
                                <ul class="social">
                                    <li class="sub-nav"><a href="{{url('/login/facebook')}}" class="btn-face m-b-20"><i class="fa fa-facebook-official"></i>
                                        </a> </li>
                                    <li class="sub-nav"> <a href="{{url('/login/google')}}" class="btn-google m-b-20">
                                            <img src="{{url('website/assets/icon-google.png')}}"></a> </li>
                                    <li class="sub-nav"><a href="#" class="btn-face m-b-20"><i class="fa fa-linkedin-square"></i>
                                        </a></li>

                                </ul>
                              
                            </div>
                            
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