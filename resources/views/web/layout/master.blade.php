<!DOCTYPE HTML>
<html lang="en">
    <head>
        <!--=============== basic  ===============-->
        <meta charset="UTF-8">
          <meta name="csrf-token" content="{{ csrf_token() }}">
     <title>{{ $title ?? '' }} | {{SetttingValue('buisness_name') ?? config('app.app_name') }}</title>
     
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="robots" content="index, follow"/>
        <meta name="keywords" content=""/>
        <meta name="description" content=""/>
        <!--=============== css  ===============-->
        <link type="text/css" rel="stylesheet" href="{{asset('web/assets/css/reset.css') }}">
        <link type="text/css" rel="stylesheet" href="{{asset('web/assets/css/plugins.css') }}">
        <link type="text/css" rel="stylesheet" href="{{asset('web/assets/css/style.css') }}">
        <link type="text/css" rel="stylesheet" href="{{asset('web/assets/css/color.css') }}">
        <!--=============== favicons ===============-->
        <link rel="shortcut icon" href="{{asset(SetttingValue('favicon')) ?? asset('web/assets/img/favicon.ico')}}">

        {{-- Select2 plugin --}}
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
      {{-- Swal plugin --}}
  <script src="{{asset('sweet-alert/dist/sweetalert.js')}}"></script>
  <link href="{{asset('sweet-alert/dist/sweetalert.css')}}" rel="stylesheet" />
  

  @yield('css')
  {!!SetttingValue('custom_css_codes')!!}
</head>
<body>
 <div id="main">
@include('web.partials.loader')
{{--header section start --}}
{{-- Top Header Menu --}}
@include('web.partials.top_header')
{{-- page content --}}

@yield('content')

{{-- footer --}}
@include('web.partials.footer')
 </div>
<!-- Wrapper end -->
<!-- share-wrapper -->
<div class="share-wrapper isShare">
    <div class="share-title"><span>Share</span></div>
    <div class="close-share soa"><span>Close</span><i class="fal fa-times"></i></div>
    <div class="share-inner soa">
        <div class="share-container"></div>
    </div>
</div>
<!-- share-wrapper end -->
</div>
 <!-- Main end -->
        
{{-- js script --}}
<!--=============== scripts  ===============-->
        <script type="text/javascript" src="{{asset('web/assets/js/jquery.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('web/assets/js/plugins.js')}}"></script>
        <script type="text/javascript" src="{{asset('web/assets/js/scripts.js')}}"></script>
     
  
@yield('js')
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script>
    window.setTimeout(function () {
      $(".alert-success").fadeTo(2000, 0).slideUp(2000, function () {
          $(this).remove();
      });
      $(".alert-danger").fadeTo(2000, 0).slideUp(2000, function () {
          $(this).remove();
      });
      $(".alert-warning").fadeTo(1200, 0).slideUp(1200, function () {
          $(this).remove();
      });
      $(".alert-info").fadeTo(1200, 0).slideUp(1200, function () {
          $(this).remove();
      });
  }, 5000);
  
  @if(!empty(SetttingValue('whatsapp')))
     (function () {
        var options = {
            whatsapp: "{{SetttingValue('whatsapp')}}", // WhatsApp number
            call_to_action: "Message us", // Call to action
            position: "left", // Position may be 'right' or 'left'
        };
        var proto = document.location.protocol, host = "getbutton.io", url = proto + "//static." + host;
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
        s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
        var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
    })();
  
  @endif
  
  //function to active menu
  $(function () {
        var url = '{{url()->current()}}';
        var activePage = url.substring(url.lastIndexOf('/') + 1);
        $('#menu a').each(function () {
            var linkPage = this.href.substring(this.href.lastIndexOf('/') + 1);
            //console.log('active '+activePage);
            //console.log('link '+linkPage);
            if (activePage == linkPage) {
                
                $(this).addClass("act-link");
            }
        });
    });
  

$(".select2Model").select2({
    dropdownParent: $('#searchModel')
    
});
    
if ($("#twitts-container").length > 0) {
        var config1 = {
            "profile": {
                "screenName": '{!!SetttingValue('twitter_screen_name') ? SetttingValue('twitter_screen_name') :  'AMARSIN31891159'!!}'
            },
            "domId": 'twitts-container',
            "maxTweets": {!!SetttingValue('twitter_max_tweets') ? SetttingValue('twitter_max_tweets') :  '2'!!},
            "enableLinks": true,
            "showImages": true
        };
        twitterFetcher.fetch(config1);
    }

</script>

{{SetttingValue('custom_js_codes')}}
</body>
</html>
