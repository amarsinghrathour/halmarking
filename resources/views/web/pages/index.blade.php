@extends('web.layout.master')
@section('css')
<meta name="title" content="{{ $pageDetail->meta_title }}"/>
<meta name="description" content="{{ $pageDetail->meta_description}}"/>
      <meta name="keywords" content="{{ $pageDetail->meta_key_word}}"/>
@endsection
@section('content')

<!--wrapper-->
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
                    <!-- section-->
                    <section class="parallax-section dark-bg sec-half parallax-sec-half-right" data-scrollax-parent="true">
                        <div class="bg par-elem"  data-bg="{{asset('web/assets/images/bg/28.jpg')}}" data-scrollax="properties: { translateY: '30%' }"></div>
                        <div class="overlay"></div>
                        <div class="pattern-bg"></div>
                        <div class="container">
                            <div class="section-title">
                                <h2>{{$pageDetail->title}}</h2>
                                <p> {{$pageDetail->description}} </p>
                                <div class="horizonral-subtitle"><span>{{$menu_detail->name}}</span></div>
                            </div>
                        </div>
                        <a href="{{url()->current()}}#sec1" class="custom-scroll-link hero-start-link"><span>Let's Start</span> <i class="fal fa-long-arrow-down"></i></a>
                    </section>
                    <!-- section end-->
                    <!-- section --> 
                    <section data-scrollax-parent="true" id="sec1">
                        <div class="section-subtitle left-pos"  data-scrollax="properties: { translateY: '-250px' }" ><span>//</span>Post title</div>
                        <div class="container">
                            <!-- blog-container  -->
                            <div class="fl-wrap post-container">
                                <div class="row">
                                        <div class="col-md-12">
                                        
                                        <!-- post -->
                                        <div class="post fl-wrap fw-post">
                                            <h2><a href="{{url($pageDetail->slug)}}"><span>{{$pageDetail->title}}</span></a></h2>
                                            <div class="parallax-header"> 
                                                <a href="{{url($pageDetail->slug)}}">{{$pageDetail->created_at->format('d M Y')}}</a>
                                              </div>
                                            @if(!empty($pageDetail->image))
                                            <!-- blog media -->
                                            <div class="blog-media fl-wrap nomar-bottom">
                                                <div class="single-slider-wrap slider-carousel-wrap ">
                                                    <div class="single-slider cur_carousel-slider-container fl-wrap"  >
                                                        <div class="slick-slide-item"><img src="{{asset($pageDetail->image)}}" alt=""></div>
                                                    </div>
                                                    <div class="sp-cont   sp-cont-prev"><i class="fal fa-long-arrow-left"></i></div>
                                                    <div class="sp-cont   sp-cont-next"><i class="fal fa-long-arrow-right"></i></div>
                                                </div>
                                            </div>
                                            <!-- blog media end -->
                                            @endif
                                            
                                            
                                            <div class="blog-text fl-wrap">
                                                <div class="clearfix"></div>
                                                {!!$pageDetail->description!!}
                                               
                                            </div>
                                        </div>
                                        <!-- post end-->
                                        
                                       
                                    </div>
                                    
                                    <div class="limit-box fl-wrap"></div>
                                </div>
                                 
                            </div>
                            <!-- blog-container end    -->
                        </div>
                        <div class="bg-parallax-module" data-position-top="50"  data-position-left="20" data-scrollax="properties: { translateY: '-250px' }"></div>
                        <div class="bg-parallax-module" data-position-top="40"  data-position-left="70" data-scrollax="properties: { translateY: '150px' }"></div>
                        <div class="bg-parallax-module" data-position-top="80"  data-position-left="80" data-scrollax="properties: { translateY: '350px' }"></div>
                        <div class="bg-parallax-module" data-position-top="95"  data-position-left="40" data-scrollax="properties: { translateY: '-550px' }"></div>
                        <div class="sec-lines"></div>
                    </section>
                    <!-- section end-->              
                    
                </div>
                <!-- Content end -->



@endsection