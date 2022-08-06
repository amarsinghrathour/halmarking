@extends('web.layout.master')
@section('css')
@endsection
@section('content')


<div id="wrapper" class="single-page-wrap">
                <!-- Content-->
                <div class="content">
                    
                    <!-- section-->
                    <section class="parallax-section dark-bg sec-half parallax-sec-half-right" data-scrollax-parent="true">
                        <div class="bg par-elem"  data-bg="{{asset('web/assets/images/bg/27.jpg')}}" data-scrollax="properties: { translateY: '30%' }"></div>
                        <div class="overlay"></div>
                        <div class="pattern-bg"></div>
                        <div class="container">
                            <div class="section-title">
                                <h2>Blogs</h2>
                            </div>
                        <a href="{{url()->current()}}#sec1" class="custom-scroll-link hero-start-link"><span>Let's Start</span> <i class="fal fa-long-arrow-down"></i></a>
                        </div>
                    </section>
                    <!-- section end-->
                    <div class="single-page-decor"></div>
                    @include('web.partials.blog_top_nav_searchbar')
                    <!-- section end-->  
                    <!-- section end-->  
                    <section data-scrollax-parent="true" id="sec1">
                        <div class="section-subtitle right-pos"  data-scrollax="properties: { translateY: '-250px' }"><span>//</span>Project Title</div>
                        <div class="container">
                           @forelse($blogList as $value)
                            <!-- team-box   --> 
                            <div class="team-box">
                                @if(!empty($value->image))
                                <div class="team-photo">
                                    <div class="overlay"></div>
                                    <a href="{{url($value->url)}}">Deatils</a>
                                    <img src="{{asset($value->image)}}" alt="" class="respimg"> 										
                                </div>
                                @endif
                                <a href="{{url($value->url)}}">
                                <div class="team-info">
                                    <h4>{!! Str::limit($value->title, 20, $end='.......') !!}</h4>
                                    <p>{!!Str::limit($value->description, 50, $end='.......')!!}  </p>
                                </div>
                                </a>
                            </div>
                            <!-- team-box end --> 
                            @empty
                    
                           @endforelse  
                           <!-- content-nav -->
                        @if (count($blogList) > 0)
                         <div class="content-nav">
                             {{$blogList->appends(request()->except('page'))->links('vendor.pagination.front')}}
                         </div>
                         @endif
                          <!-- content-nav end--> 
                                                           
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