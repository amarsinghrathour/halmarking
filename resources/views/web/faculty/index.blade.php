@extends('web.layout.master')

@section('content')
<div class="page-banner page-banner-overlay" data-background="{{asset('web/assets/img/bg/banner-bg.jpg')}}" style="background-image: url(&quot;assets/img/bg/banner-bg.jpg&quot;);">
         <div class="container h-100">
            <div class="row h-100">
               <div class="col-lg-12 my-auto">
                  <div class="page-banner-content text-center">
                     <h2 class="page-banner-title">{{$pageDetail->title}}</h2>
                     <div class="page-banner-breadcrumb">
                        <p><a href="{{route('home1')}}">Home</a> {{$menu_detail->name}}</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="page-banner-shape"></div>
      </div>
<section id="teachers" class="section-padding pt-0">
         <div class="auto-container">
            <div class="row">
               <div class="col-12 text-left">
                  <div class="section-title section-title-left">
                     <h6 class="theme-color">We love what we do</h6>
                     <h2>Meet Our Experts Teachers</h2>
                  </div>
               </div>
            </div>
            <!-- end section title -->
            <div class="row">
                @if(!empty($pageDetail->description))
            <div class="col-lg-12 col-md-12 col-12 mb-3">
                <div class="blog-single single-blog-post">
                    <div class="single-blog-post-wrap">
                        <div class="single-blog-post-content">
                            <h4 class="single-blog-post-title">
                                <a href="#">{{$pageDetail->title}}</a>
                            </h4>



                            <div class="blog-single-des mt-4">
                                {!!$pageDetail->description!!}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            @endif
            @php
            $sidebarArray = array();
            $dataArray = \App\Models\Faculty::where('status','ACTIVE')->orderBy('id','desc')->get();
            if(!empty($pageDetail->sidebar)){
            $sidebarArray = explode(',',$pageDetail->sidebar);
            }
            @endphp
            @if(!empty($sidebarArray) && count($sidebarArray) > 0)
            <div class="col-lg-8 col-md-8 col-12">
                @else
                <div class="col-lg-12 col-md-12 col-12">
                    @endif
                    <div class="row">
                        @forelse($dataArray as $value)
               <div class="col-lg-3 col-md-4 col-12 mb-4">
                  <div class="single-team-wrapper">
                     <div class="single-team-member">
                         <img class="img-fluid" src="{{asset($value->image)}}" alt="">
                        <div class="single-team-member-content">
                           <ul class="single-team-member-social">
                              <li><a href="mailto:{{$value->email}}"><i class="icofont-email"></i></a></li>
                              <li><a href="tel:{{$value->mobile}}"><i class="icofont-phone"></i></a></li>
                              
                           </ul>
                           <div class="single-team-member-text">
                              <h4>{{$value->name}}</h4>
                              <p>{{$value->designation}}</p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
                    @empty
                    
                    @endforelse    
                    </div>
              @if(!empty($sidebarArray) && count($sidebarArray) > 0)
            </div>
                <!-- end col -->
                <div class="col-lg-4 col-md-4 col-12 mt-lg-0 mt-md-0 mt-5 pl-lg-5 pl-md-5 pl-0">
                    @forelse($sidebarArray as $value)
                    @if(!empty($value))
                  @include("web.sidebar.$value")
                  @endif
                    @empty
                    @endforelse
                </div>
                <!-- end col -->
                @endif
            </div>
         </div>
      </section>

@endsection