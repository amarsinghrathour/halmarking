@extends('web.layout.master')

@section('content')
<div class="page-banner page-banner-overlay" data-background="{{asset('web/assets/img/bg/banner-bg.jpg')}}" style="background-image: url(&quot;assets/img/bg/banner-bg.jpg&quot;);">
    <div class="container h-100">
        <div class="row h-100">
            <div class="col-lg-12 my-auto">
                <div class="page-banner-content text-center">
                    <h2 class="page-banner-title">{{$title}}</h2>
                    <div class="page-banner-breadcrumb">
                        <p><a href="{{route('home1')}}">Home</a> {{$title}}</p>
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

            <div class="col-lg-12 col-md-12 col-12">
                <div class="blog-single single-blog-post">
                    <div class="single-blog-post-wrap">
                        <div class="single-blog-post-content">
                            <h4 class="single-blog-post-title">
                                <a href="#">{{$data->student_name}}</a>
                            </h4>



                            <div class="blog-single-des mt-4">
                                <embed src="{{asset($data->tc)}}" width="100%" height="750px"></embed>
                            </div>
                        </div>
                    </div>



                </div>
            </div>


        </div>
    </div>
</section>
@endsection