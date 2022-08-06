
<!-- header-->
            <header class="main-header">
                <a class="logo-holder" href="{{route('home1')}}">
                @if(!empty(SetttingValue('header_logo_diamond')))
            <img src="{{asset(SetttingValue('header_logo_diamond'))}}" alt="logo">
            @else
            <img src="{{asset('web/assets/images/logo.png')}}" alt="logo">
            @endif
               </a>
                
                <!-- nav-button-wrap-->
                <div class="nav-button but-hol">
                    <span  class="nos"></span>
                    <span class="ncs"></span>
                    <span class="nbs"></span>
                    <div class="menu-button-text">Menu</div>
                </div>
                <!-- nav-button-wrap end-->
                <div class="header-social">
                    <ul>
                        @if(!empty(SetttingValue('facebook')))
                        <li><a href="{{SetttingValue('facebook')}}#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                        @endif
                        @if(!empty(SetttingValue('instagram')))
                        <li><a href="{{SetttingValue('instagram')}}#" target="_blank"><i class="fab fa-instagram"></i></a></li>
                        @endif
                        @if(!empty(SetttingValue('twitter')))
                        <li><a href="{{SetttingValue('twitter')}}#" target="_blank"><i class="fab fa-twitter"></i></a></li>
                        @endif
                        @if(!empty(SetttingValue('youtube')))
                        <li><a href="{{SetttingValue('youtube')}}#" target="_blank"><i class="fab fa-youtube"></i></a></li>
                        @endif
                        @if(!empty(SetttingValue('linkedin')))
                        <li><a href="{{SetttingValue('linkedin')}}#" target="_blank"><i class="fab fa-linkedin"></i></a></li>
                        @endif
                    </ul>
                </div>
                <!--  showshare -->
                <div class="show-share showshare">
                    <i class="fal fa-retweet"></i>
                    <span>Share This</span>
                </div>
                <!--  showshare end -->
            </header>
            <!--  header end -->
            <!--  navigation bar -->
            <div class="nav-overlay">
                <div class="tooltip color-bg">Close Menu</div>
            </div>
            <div class="nav-holder">
                 <a class="header-logo" href="{{route('home1')}}">
                @if(!empty(SetttingValue('header_logo')))
            <img src="{{asset(SetttingValue('header_logo'))}}" alt="logo">
            @else
            <img src="{{asset('web/assets/images/logo2.png')}}" alt="logo">
            @endif
               </a>
                <div class="nav-title"><span>Menu</span></div>
                <div class="nav-inner-wrap">
                    <nav class="nav-inner sound-nav" id="menu">
                        <ul>
                            @php 
                            $menuHeaderRecursive = \App\Services\Web\MenuService::menusRecursive();
                            @endphp
                            {!! $menuHeaderRecursive !!}
                        </ul>
                    </nav>
                </div>
            </div>
            <!--  navigation bar end -->


