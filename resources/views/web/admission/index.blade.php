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
<section id="blogsingle" class="section-padding">
         <div class="auto-container">
            <div class="row mb-lg-5 mb-0">
                @php
                $sidebarArray = array();
                if(!empty($pageDetail->sidebar)){
                $sidebarArray = explode(',',$pageDetail->sidebar);
                }
                @endphp
                @if(!empty($sidebarArray) && count($sidebarArray) > 0)
              <div class="col-lg-8 col-md-8 col-12">
                  @else
                  <div class="col-lg-12 col-md-12 col-12">
                  @endif
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
                  @if(!empty($sidebarArray) && count($sidebarArray) > 0)
                   <!-- end col -->
               <div class="col-lg-4 col-md-4 col-12 mt-lg-0 mt-md-0 mt-5 pl-lg-5 pl-md-5 pl-0">
                  @forelse($sidebarArray as $value)
                  @include("web.sidebar.$value")
                  @empty
                  @endforelse
               </div>
               <!-- end col -->
                  @endif
              
            </div>
         </div>
      </section>
@endsection