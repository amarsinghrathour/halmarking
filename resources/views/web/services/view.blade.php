@extends('web.layout.master')
@section('css')
<meta name="title" content="{{ $data->meta_title }}"/>
<meta name="description" content="{{ $data->meta_description}}"/>
      <meta name="keywords" content="{{ $data->meta_key_word}}"/>
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
                    <!-- section --> 
                    <section data-scrollax-parent="true" id="sec1">
                        <div class="section-subtitle left-pos"  data-scrollax="properties: { translateY: '-250px' }" ><span>//</span>{{$data->title}}</div>
                        <div class="container">
                            <!-- blog-container  -->
                            <div class="fl-wrap post-container">
                                <div class="row">
                                        <div class="col-md-12">
                                        <!-- post -->
                                        <div class="post fl-wrap fw-post">
                                            <h2><a href="{{url($data->url)}}"><span>{{$data->title}}</span></a></h2>
                                            <div class="parallax-header"> <a href="{{url($data->url)}}">{{$data->activity_date->format('d M Y')}}</a>
                                                
                                                </div>
                                            @if(!empty($data->image))
                                            <!-- blog media -->
                                            <div class="blog-media fl-wrap nomar-bottom">
                                                <div class="single-slider-wrap slider-carousel-wrap ">
                                                    <div class="single-slider cur_carousel-slider-container fl-wrap"  >
                                                        <div class="slick-slide-item"><img src="{{asset($data->image)}}" alt=""></div>
                                                    </div>
                                                    <div class="sp-cont   sp-cont-prev"><i class="fal fa-long-arrow-left"></i></div>
                                                    <div class="sp-cont   sp-cont-next"><i class="fal fa-long-arrow-right"></i></div>
                                                </div>
                                            </div>
                                            <!-- blog media end -->
                                            @endif
                                            
                                            {{--
                                            <div class="parallax-header fl-wrap"><span>Tags : </span><a href="blog-single.html#">Branding</a> <a href="blog-single.html#">Video</a>  <a href="blog-single.html#">Design</a></div>
                                            --}}
                                            <div class="blog-text fl-wrap">
                                                <div class="clearfix"></div>
                                                {!!$data->description!!}
                                               {{-- <ul class="post-counter single-post-counter">
                                                    <li><i class="fa fa-eye"></i><span>687</span></li>
                                                    <li><i class="fal fa-comments-alt"></i><span>10</span></li>
                                                </ul>--}}
                                            </div>
                                        </div>
                                        <!-- post end-->
                                        {{--
                                        <!-- post-author-->                                   
                                        <div class="post-author">
                                            <div class="author-img">
                                                <img alt='' src="images/team/8.jpg">	
                                            </div>
                                            <div class="author-content">
                                                <h5><a href="blog-single.html#">Martin Solonick</a></h5>
                                                <p>At one extremity the rope was unstranded, and the separate spread yarns were all braided and woven round the socket of the harpoon; the pole was then driven hard up into the socket; from the lower end the rope was traced half-way along the pole�s length, and firmly secured so, with intertwistings of twine.</p>
                                                <div class="team-single-social fl-wrap">
                                                    <span>Follow : </span>
                                                    <ul>
                                                        <li><a href="blog-single.html#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                                        <li><a href="blog-single.html#" target="_blank"><i class="fab fa-instagram"></i></a></li>
                                                        <li><a href="blog-single.html#" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                                        <li><a href="blog-single.html#" target="_blank"><i class="fab fa-vk"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <!--post-author end-->
                                       --}}
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