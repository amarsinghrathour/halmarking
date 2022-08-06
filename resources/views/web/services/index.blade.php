@extends('web.layout.master')
@section('css')
<meta name="title" content="{{ $pageDetail->meta_title }}"/>
<meta name="description" content="{{ $pageDetail->meta_description}}"/>
      <meta name="keywords" content="{{ $pageDetail->meta_key_word}}"/>
@endsection
@section('content')
<!--wrapper-->
@php
            $dataArray = \App\Models\Service::where('status','ACTIVE')->orderBy('id','desc')->get();
            
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
                   
                    
                    <section class="dark-bg no-padding">
                           <div class="hidden-info-wrap-bg scroll-to-fixed-fixed" style="z-index: 12; position: fixed; top: 80px; height: 283px; margin-left: 0px; width: 381px; left: 80px;">
                            
                            <div class="bg-ser">
                            <div class="bg active" style="background-image: url(&quot;{{asset('web/assets/images/bg/long/2.jpg')}}&quot;);"></div><div class="bg" style="background-image: url(&quot;{{asset('web/assets/images/bg/long/1.jpg')}}&quot;);"></div><div class="bg"></div><div class="bg"></div></div>
                            <div class="overlay"></div>
                        </div>
                        <!--   hidden-info-wrap -->
                        <div class="hidden-info-wrap">
                            <div class="hidden-info fl-wrap">
                                <div class="hidden-info-title">My Services</div>
                                <div class="hidden-works-list fl-wrap">
                                    @if(count($dataArray) > 0)
                                    @php $i=0; @endphp
                                    @foreach($dataArray as $value)
                                    <!--   hidden-works-item -->
                                    @php $i++; @endphp
                                    <div class="hidden-works-item  serv-works-item fl-wrap act-index" data-bgscr="{{asset('web/assets/images/bg/long/2.jpg')}}">
                                        <div class="hidden-works-item-text">
                                            <h3>{{$value->title}}</h3>
                                            {!!$value->description!!}
                                            <div class="clearfix"></div>
                                            <div class="serv-price">{{$value->price_range}}</div>
                                            <span class="serv-number">{{$i}}.</span>
                                            @if(!empty($value->icon))
                                            <div class="serv-icon">
                                    <img class="img img-responsive" width="30%" src="{{asset($value->icon)}}" alt="{{$value->title}}">
                                    </div>@endif
                                        </div>
                                        <div class="hidden-works-item-dec"><i class="fal fa-arrow-left"></i></div></div>
                                    <!--   hidden-works-item end -->
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- hidden-info-wrap end -->
                        <div class="fl-wrap limit-box"></div>
                    </section>
                    
                </div>
                <!-- Content end -->



               
@endsection