@extends('web.layout.master')

@section('content')
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
                    <!-- section end-->  
                    <!-- section --> 
                    <section data-scrollax-parent="true" id="sec1">
                        <div class="section-subtitle left-pos"  data-scrollax="properties: { translateY: '-250px' }" ><span>//</span>{{$noticeView->title}}</div>
                        <div class="container">
                            <!-- blog-container  -->
                            <div class="fl-wrap post-container">
                                <div class="row">
                                        <div class="col-md-12">
                                        
                                        <!-- post -->
                                        <div class="post fl-wrap fw-post">
                                            <h2><a href="{{url($noticeView->url)}}"><span>{{$noticeView->title}}</span></a></h2>
                                            <div class="parallax-header"> <a href="{{url($noticeView->url)}}">{{$noticeView->created_at->format('d M Y')}}</a>
                                                </div>
                                           
                                            
                                           
                                            <div class="blog-text fl-wrap">
                                                <div class="clearfix"></div>
                                                {!!$noticeView->description!!}
                                               
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