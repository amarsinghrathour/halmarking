@extends('web.layout.master')
@section('css')
<meta name="title" content="{{ $pageDetail->meta_title }}"/>
<meta name="description" content="{{ $pageDetail->meta_description}}"/>
      <meta name="keywords" content="{{ $pageDetail->meta_key_word}}"/>
@endsection
@section('content')
            <!-- wrapper-->
            <div id="wrapper">
                <!-- scroll-nav-wrap-->
                <div class="scroll-nav-wrap fl-wrap">
                    <div class="scroll-down-wrap">
                        <div class="mousey">
                            <div class="scroller"></div>
                        </div>
                        <span>Scroll Down</span>
                    </div>
                    <nav class="scroll-nav scroll-init">
                        <ul>
                            <li><a class="scroll-link act-link" href="{{url()->current()}}#sec1">Slider</a></li>
                            <li><a class="scroll-link" href="{{url()->current()}}#sec2">About</a></li>
                            <li><a class="scroll-link" href="{{url()->current()}}#sec3">Counter</a></li>
                            <li><a class="scroll-link" href="{{url()->current()}}#sec4">Video</a></li>
                        </ul>
                    </nav>
                </div>
                <!-- scroll-nav-wrap end-->
{{-- home page Slider --}}

@include('web.partials.home_page_slider')
<div class="content">
@if(!empty(SetttingValue('home_about_section')) && SetttingValue('home_about_section') == 'Y')
 @include('web.partials.home_about_section')
@endif
@if(!empty(SetttingValue('home_counter_section')) && SetttingValue('home_counter_section') == 'Y')
 @include('web.partials.home_counter_section')
@endif
     
@if(!empty(SetttingValue('home_video_section')) && SetttingValue('home_video_section') == 'Y')
 @include('web.partials.home_video_section')
@endif
                   
                    
                    
                   
                </div>

@endsection
