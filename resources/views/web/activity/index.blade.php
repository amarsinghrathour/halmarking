@extends('web.layout.master')
@section('css')
<meta name="title" content="{{ $pageDetail->meta_title }}"/>
<meta name="description" content="{{ $pageDetail->meta_description}}"/>
      <meta name="keywords" content="{{ $pageDetail->meta_key_word}}"/>
@endsection
@section('content')
<!--wrapper-->
@php
            $dataArray = \App\Models\RecentActivity::where('status','ACTIVE')->orderBy('sort_order')->orderBy('id','desc')->get();
            
            @endphp
            <div id="wrapper" class="single-page-wrap">
                <!-- Content-->
                <div class="content">
                    <div class="single-page-decor"></div>
                     <div class="single-page-fixed-row">
                        <div class="scroll-down-wrap">
                            <div class="mousey">
                                <div class="scroller"></div>
                            </div>
                            <span>Scroll Down</span>
                        </div>
                        <a href="{{route('home1')}}" class="single-page-fixed-row-link"><i class="fal fa-arrow-left"></i> <span>Back to home</span></a>
                    </div>
                    <section class="parallax-section dark-bg sec-half parallax-sec-half-right" data-scrollax-parent="true">
                        <div class="bg par-elem" data-bg="{{asset('web/assets/images/bg/2.jpg')}}" data-scrollax="properties: { translateY: '30%' }" style="transform: translateZ(0px) translateY(17.6151%); background-image: url(&quot;{{asset('web/assets/images/bg/27.jpg')}}&quot;);"></div>
                        <div class="overlay"></div>
                        <div class="pattern-bg"></div>
                        <div class="container">
                            <div class="section-title">
                                <h2>{{ $pageDetail->title }}</h2>
                                <p> {!! $pageDetail->description !!}</p>
                                <div class="horizonral-subtitle"><span>{{ $pageDetail->meta_title }}</span></div>
                            </div>
                            <a href="{{url()->current()}}#sec1" class="custom-scroll-link hero-start-link"><span>Let's Start</span> <i class="fal fa-long-arrow-down"></i></a>
                        </div>
                    </section>
                    <!-- section end-->  
                    <section data-scrollax-parent="true" id="sec1">
                        <div class="section-subtitle right-pos" data-scrollax="properties: { translateY: '-250px' }" style="font-size: 135.176px; transform: translateZ(0px) translateY(51.6529px);"><span>//</span>Project Title</div>
                        <div class="container">
                             @if(count($dataArray) > 0)
                             @foreach($dataArray as $value)	 
                            <!-- team-box   --> 
                            <div class="team-box" style="height: 497px;">
                                <div class="team-photo">
                                    <div class="overlay"></div>
                                    <a href="{{route('web.recent_activity.view',['slug'=>$value->url])}}">{{$value->title}}</a>
                                    @if(!empty($value->image))
                                    <img class="img img-responsive" width="50%" src="{{asset($value->image)}}" alt="{{$value->title}}">
                                    @endif
                                </div>
                                <div class="team-info">
                                    <h3>{{$value->title}}</h3>
                                    <h4>{{$value->activity_date->format('M d, Y')}}</h4>
                                    <p>{!!Str::limit($value->description, 150, $end='.......')!!}  </p>
                                </div>
                            </div>
                            <!-- team-box end --> 
                          
                           @endforeach
                            @endif
                        </div>
                        <div class="bg-parallax-module" data-position-top="50" data-position-left="20" data-scrollax="properties: { translateY: '-250px' }" style="top: 50%; left: 20%; transform: translateZ(0px) translateY(51.6529px);"></div>
                        <div class="bg-parallax-module" data-position-top="40" data-position-left="70" data-scrollax="properties: { translateY: '150px' }" style="top: 40%; left: 70%; transform: translateZ(0px) translateY(-30.9917px);"></div>
                        <div class="bg-parallax-module" data-position-top="80" data-position-left="80" data-scrollax="properties: { translateY: '350px' }" style="top: 80%; left: 80%; transform: translateZ(0px) translateY(-72.314px);"></div>
                        <div class="bg-parallax-module" data-position-top="95" data-position-left="40" data-scrollax="properties: { translateY: '-550px' }" style="top: 95%; left: 40%; transform: translateZ(0px) translateY(113.636px);"></div>
                        <div class="sec-lines"><div class="container full-height"><div class="line-item"></div><div class="line-item"></div><div class="line-item"></div><div class="line-item"></div><div class="line-item"></div></div></div>
                    </section>
                </div>
                <!-- Content end -->



               
@endsection