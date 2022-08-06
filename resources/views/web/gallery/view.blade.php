@extends('web.layout.master')
@section('css')
<meta name="title" content="{{ $album->title }}"/>
<meta name="description" content="{{ $album->description}}"/>
      <meta name="keywords" content=""/>
@endsection
@section('content')

<div id="wrapper" class="single-page-wrap">
                <!-- Content-->
                <div class="content">
                    <div class="single-page-decor"></div>
                    <div class="fsp-filter">
                        <div class="filter-title"><i class="fal fa-filter"></i><span>{{ $album->title }} Filter</span></div>
                        <div class="gallery-filters">
                            <a href="{{url()->current()}}#" class="gallery-filter  gallery-filter-active" data-filter="*">All</a>
                            <a href="{{url()->current()}}#" class="gallery-filter" data-filter=".{{$album->url}}">{{$album->title}}</a>
                        </div>
                        <div class="folio-counter">
                            <div class="num-album"></div>
                            <div class="all-album"></div>
                        </div>
                    </div>
                    <section class="no-padding dark-bg">
                        <!-- portfolio start -->
                        <div class="gallery-items min-pad   four-column vis-box-det">
                             @forelse($albumsImageArray as $value)
                            <!-- gallery-item-->
                            <div class="gallery-item {{$album->url}}">
                                <div class="grid-item-holder">
                                    <a href="{{asset($value->image)}}" class="fet_pr-carousel-box-media-zoom   image-popup"><i class="fal fa-search"></i></a>
                                    <img  src="{{asset($value->image)}}"    alt="">
                                    <div class="box-item hd-box">
                                        <div class=" fl-wrap full-height">
                                            <div class="hd-box-wrap">
                                                <h2><a href="#">{{$value->title}}</a></h2>
                                                {!! $value->description !!}</a> </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- gallery-item end-->
                            @empty
                            <p>Coming Soon</p>
                            @endforelse
                        </div>
                        </div>


@endsection