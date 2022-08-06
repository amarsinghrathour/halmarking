@extends('web.layout.master')
@section('css')
<meta name="title" content="{{ $pageDetail->meta_title }}"/>
<meta name="description" content="{{ $pageDetail->meta_description}}"/>
      <meta name="keywords" content="{{ $pageDetail->meta_key_word}}"/>
@endsection
@section('content')
@php
                $albumsArray = \App\Models\WebAlbum::where('status','!=','DELETED')->orderBy('sort_order')->orderBy('id','desc')->get();
                @endphp
            <div id="wrapper" class="single-page-wrap">
                <!-- Content-->
                <div class="content">
                    <div class="single-page-decor"></div>
                    <div class="fsp-filter">
                        <div class="filter-title"><i class="fal fa-filter"></i><span>{{ $pageDetail->title }} Filter</span></div>
                        <div class="gallery-filters">
                            <a href="{{url()->current()}}#" class="gallery-filter  gallery-filter-active" data-filter="*">All</a>
                            @forelse($albumsArray as $value)
                            <a href="{{url()->current()}}#" class="gallery-filter" data-filter=".{{$value->url}}">{{$value->title}}</a>
                            @empty
                            @endforelse
                        </div>
                        <div class="folio-counter">
                            <div class="num-album"></div>
                            <div class="all-album"></div>
                        </div>
                    </div>
                    <section class="no-padding dark-bg">
                        <!-- portfolio start -->
                        <div class="gallery-items min-pad   four-column vis-box-det">
                             @forelse($albumsArray as $value)
                            <!-- gallery-item-->
                            <div class="gallery-item {{$value->url}}">
                                <div class="grid-item-holder">
                                    <a href="{{asset($value->image)}}" class="fet_pr-carousel-box-media-zoom   image-popup"><i class="fal fa-search"></i></a>
                                    <a href="{{route('web.gallery.view',['slug'=>$value->url])}}">
                                    <img  src="{{asset($value->image)}}"    alt="">
                                    </a>
                                    <div class="box-item hd-box">
                                        <div class=" fl-wrap full-height">
                                            <div class="hd-box-wrap">
                                                <h2><a href="{{route('web.gallery.view',['slug'=>$value->url])}}">{{$value->title}}</a></h2>
                                                <p><a href="{{route('web.gallery.view',['slug'=>$value->url])}}">{{ Illuminate\Support\Str::limit(strip_tags($value->description), 50, ' ...') }}</a> </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- gallery-item end-->
                            @empty
                            @endforelse
                        </div>
                        </div>




@endsection