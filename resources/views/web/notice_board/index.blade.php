@extends('web.layout.master')
@section('css')
<meta name="title" content="{{ $pageDetail->meta_title }}"/>
<meta name="description" content="{{ $pageDetail->meta_description}}"/>
      <meta name="keywords" content="{{ $pageDetail->meta_key_word}}"/>
@endsection
@section('content')
<!--wrapper-->
@php
            $dataArray = \App\Models\NoticeBoard::where('status','ACTIVE')->orderBy('sort_order')->orderBy('id','desc')->get();
            
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
                    <!-- section end-->  
                    <!-- section --> 
                    <section data-scrollax-parent="true" id="sec1">
                        <div class="section-subtitle left-pos"  data-scrollax="properties: { translateY: '-250px' }" ><span>//</span>{{$pageDetail->title}}</div>
                        <div class="container">
                            <!-- blog-container  -->
                            <div class="fl-wrap post-container">
                                <div class="row">
                                    
                                        <div class="col-md-12">
                                        
                                        <!-- post -->
                                        <div class="post fl-wrap fw-post">
                                            <h2><a href="{{url($pageDetail->url)}}"><span>{{$pageDetail->title}}</span></a></h2>
                                            
                                            
                                            
                                            <div class="blog-text fl-wrap">
                                                <div class="clearfix"></div>
                                                <div class="widget">
                        <div class="inner">
                           
                            <div class="follow-us">
                                <div class="half">
                                    <div class="inner-left-border">

                                        <marquee direction="up" behavior="scroll" truespeed="truespeed" scrollamount="3" scrolldelay="70" onmouseover="this.stop();" onmouseout="this.start();" style="min-height:440px; max-height:440px;">

                                            <div class="tab-content">

                                                <div id="tab1" class="tab-pane active">
                                                    <ul>

                                                        @if(count($dataArray) > 0)
                                                        @foreach($dataArray as $value)	   

                                                        <li>
                                                            <a title="" href="{{route('web.notice.view',['slug'=>$value->url])}}" target="_blank">
                                                                <figure>
                                                                    <img src="{{asset('web/assets/images/sample-tab01.jpg')}}" alt="">
                                                                </figure>
                                                                <p>{{$value->title}}
                                                                    <span> {{$value->created_at->format('M d, Y')}} </span></p>
                                                            </a>
                                                        </li>
                                                        @endforeach
                                                        @endif  
                                                    </ul></div></div>
                                        </marquee>
                                    </div> 




                                </div>                            

                            </div>
                        </div>
                    </div>
                                                
                                               
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